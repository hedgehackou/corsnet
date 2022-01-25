<?php

declare(strict_types=1);

namespace App\Modules\Settings\Controllers;

use App\Base\Controllers\AbstractController;
use App\Modules\Settings\Requests\GetSettingsRequest;
use App\Modules\Settings\Requests\UpdateSettingsRequest;
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
}
