<?php

declare(strict_types=1);

namespace App\Modules\Settings\Services;

use App\Base\Services\AbstractService;
use App\Modules\Settings\Models\FooterBlock;
use App\Modules\Settings\Models\HeaderBlock;
use App\Modules\Settings\Models\NetworkMapBlock;
use App\Modules\Settings\Models\Page;
use App\Modules\Settings\Models\Setting;
use App\Modules\Settings\Models\TextBlock;
use App\Modules\Settings\Repositories\SettingsRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SettingsService extends AbstractService
{
    private SettingsRepository $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    /**
     * @return Setting
     */
    public function getSettings(): Setting
    {
        return Setting::firstOrFail();
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function updateSettings(array $data): Setting
    {
        /** @var Setting $settings */
        $settings = Setting::firstOrFail();
        $settings->update($data);

        return $settings;
    }

    /**
     * @return Page[]|Collection
     */
    public function getPages()
    {
        $pages = $this->settingsRepository->getPages()->toArray();
        foreach ($pages as &$page) {
            $page['blocks'] = [];
            foreach (Page::BLOCKS as $block) {
                $page['blocks'] = array_merge($page['blocks'], array_map(function (&$item) {
                    $item['type'] = data_get($item, 'pivot.block_type');
                    $item['sort'] = data_get($item, 'pivot.sort');
                    unset ($item['pivot']);
                    return $item;
                }, $page[$block] ?? []));
                unset ($page[$block]);
            }
            usort($page['blocks'], fn($a, $b) => $a['sort'] <=> $b['sort']);
        }
        usort($pages, fn($a, $b) => $a['sort'] <=> $b['sort']);

        return $pages;
    }

    /**
     * @return array
     */
    public function getPageHeader(): array
    {
        /** @var Page $page */
        $page = Page::query()->where('is_deletable', false)->firstOrFail();

        return $page->headerBlocks()->firstOrFail()->toArray();
    }

    /**
     * @return array
     */
    public function getPageFooter(): array
    {
        /** @var Page $page */
        $page = Page::query()->where('is_deletable', false)->firstOrFail();

        return $page->footerBlocks()->firstOrFail()->toArray();
    }

    public function getNavigation(): array
    {
        return array_map(function ($item) {
            return [
              'title' => $item['title'],
              'slug' => $item['slug'],
            ];
        }, $this->settingsRepository->getPages()->toArray());
    }

    /**
     * @param int $pageId
     *
     * @return void
     */
    public function deletePage(int $pageId)
    {
        /** @var Page $page */
        $page = Page::findOrFail($pageId);
        $this->detachAllBlocks($page);
        $page->delete();
    }

    /**
     * @param array $pages
     *
     * @return void
     */
    public function savePages(array $pages)
    {
        foreach ($pages as $pageInd => &$page) {
            $page['sort'] = $pageInd;
            /** @var Page $pageObj */
            $pageObj = Page::query()->updateOrCreate(['id' => $page['id'] ?? null], [
                'title' => $page['title'] ?? '',
                'description' => $page['description'] ?? '',
                'slug' => $this->resolveSlug($page, $pageInd),
                'sort' => $page['sort']
            ]);
            $this->detachAllBlocks($pageObj);

            foreach ($page['blocks'] as $blockInd => &$block) {
                $block['sort'] = $blockInd;
                if ($block['type'] === Page::GOOGLE_MAP_BLOCK) {
                    $itemBlock = NetworkMapBlock::query()->updateOrCreate(['id' => $block['id'] ?? null], [
                        'title' => $block['title'] ?? '',
                        'text' => $block['text'] ?? '',
                        'longitude' => $block['longitude'] ?? '',
                        'latitude' => $block['latitude'] ?? '',
                        'zoom' => $block['zoom'] ?? 0,
                    ]);
                    $pageObj->networkMapBlocks()->attach($itemBlock, ['sort' => $blockInd]);
                    continue;
                }
                if ($block['type'] === Page::TEXT_BLOCK) {
                    $itemBlock = TextBlock::query()->updateOrCreate(['id' => $block['id'] ?? null], [
                        'title' => $block['title'] ?? '',
                        'text' => $block['text'] ?? '',
                    ]);
                    $pageObj->textBlocks()->attach($itemBlock, ['sort' => $blockInd]);
                    continue;
                }
                if ($block['type'] === Page::HEADER_BLOCK) {
                    $itemBlock = HeaderBlock::query()->updateOrCreate(['id' => $block['id'] ?? null], [
                        'title' => $block['title'] ?? '',
                        'logo' => $block['logo'] ?? '',
                    ]);
                    $pageObj->headerBlocks()->attach($itemBlock, ['sort' => $blockInd]);
                    continue;
                }
                if ($block['type'] === Page::FOOTER_BLOCK) {
                    $itemBlock = FooterBlock::query()->updateOrCreate(['id' => $block['id'] ?? null], [
                        'address' => $block['address'] ?? '',
                        'phone' => $block['phone'] ?? '',
                        'email' => $block['email'] ?? '',
                    ]);
                    $pageObj->footerBlocks()->attach($itemBlock, ['sort' => $blockInd]);
                    continue;
                }
                throw new \RuntimeException('Unknown block type');
            }
        }
    }

    private function detachAllBlocks(Page $page)
    {
        $page->footerBlocks()->detach();
        $page->networkMapBlocks()->detach();
        $page->textBlocks()->detach();
        $page->headerBlocks()->detach();
    }

    /**
     * @param array $pageData
     * @param int  $pageInd
     *
     * @return int|string
     */
    private function resolveSlug(array $pageData, int $pageInd)
    {
        if (!$pageData['is_deletable']) {
            return '';
        }
        return $pageData['slug'] ?? $pageInd;
    }
}
