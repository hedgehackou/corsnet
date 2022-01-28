<?php

declare(strict_types=1);

namespace App\Modules\Settings\Controllers;

use App\Base\Controllers\AbstractController;
use App\Modules\Settings\Requests\DeleteBlockRequest;
use App\Modules\Settings\Requests\DeletePageRequest;
use App\Modules\Settings\Requests\GetPagesRequest;
use App\Modules\Settings\Requests\GetSettingsRequest;
use App\Modules\Settings\Requests\SavePagesRequest;
use App\Modules\Settings\Requests\UpdateSettingsRequest;
use App\Modules\Settings\Resources\PageResource;
use App\Modules\Settings\Resources\SettingsResource;
use App\Modules\Settings\Services\SettingsService;
use Illuminate\Http\JsonResponse;

class SettingsController extends AbstractController
{
    /**
     * @var SettingsService
     */
    private SettingsService $settingsService;

    /**
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * @param GetSettingsRequest $request
     *
     * @return JsonResponse
     */
    public function getSettings(GetSettingsRequest $request): JsonResponse
    {
        $settings = $this->settingsService->getSettings();

        return response()->json([
            'data' => new SettingsResource($settings)
        ]);
    }

    /**
     * @param UpdateSettingsRequest $request
     *
     * @return JsonResponse
     */
    public function updateSettings(UpdateSettingsRequest $request): JsonResponse
    {
        $settings = $this->settingsService->updateSettings($request->validated());

        return response()->json([
            'data' => new SettingsResource($settings)
        ]);
    }

    /**
     * @param GetPagesRequest $request
     *
     * @return JsonResponse
     */
    public function getPages(GetPagesRequest $request): JsonResponse
    {
        $pages = $this->settingsService->getPages();

        return response()->json([
            'list' => PageResource::collection($pages)
        ]);
    }

    /**
     * @param SavePagesRequest $request
     *
     * @return JsonResponse
     */
    public function savePages(SavePagesRequest $request): JsonResponse
    {
        $this->settingsService->savePages($request->validated());

        return response()->json();
    }

    /**
     * @param DeletePageRequest $request
     * @param int               $pageId
     *
     * @return JsonResponse
     */
    public function deletePage(DeletePageRequest $request, int $pageId): JsonResponse
    {
        $this->settingsService->deletePage($pageId);

        return response()->json();
    }

    /**
     * @param DeleteBlockRequest $request
     * @param int                $pageId
     * @param int                $blockId
     *
     * @return JsonResponse
     */
    public function deleteBlock(DeleteBlockRequest $request, int $pageId, int $blockId): JsonResponse
    {
        return response()->json();
    }
}
