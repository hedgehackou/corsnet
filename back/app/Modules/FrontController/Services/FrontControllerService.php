<?php

declare(strict_types=1);

namespace App\Modules\FrontController\Services;

use App\Base\Services\AbstractService;
use App\Modules\Settings\Models\Page;
use App\Modules\Settings\Repositories\SettingsRepository;
use App\Modules\Settings\Services\SettingsService;

class FrontControllerService extends AbstractService
{
    private SettingsService $settingsService;

    /**
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * @param Page $page
     *
     * @return array
     */
    public function getPageData(Page $page): array
    {
        foreach ($this->settingsService->getPages() as $pageData) {
            if ($pageData['id'] === $page->id) {
                $pageData['blocks'] = array_values(array_filter($pageData['blocks'], function ($item) {
                    return $item['type'] !== Page::HEADER_BLOCK && $item['type'] !== Page::FOOTER_BLOCK;
                }));
                return $pageData;
            }
        }
        return [];
    }
}
