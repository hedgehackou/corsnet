<?php

declare(strict_types=1);

namespace App\Modules\Installation\Controllers;

use App\Base\Controllers\AbstractController;
use App\Modules\Installation\Requests\ConnectToDatabaseRequest;
use App\Modules\Installation\Requests\SetupSmtpRequest;
use App\Modules\Installation\Services\InstallationService;
use Illuminate\Http\JsonResponse;

class InstallationController extends AbstractController
{
    /**
     * @var InstallationService  $installationService
     */
    private InstallationService $installationService;

    public function __construct(InstallationService $installationService)
    {
        $this->installationService = $installationService;
    }

    /**
     * @param ConnectToDatabaseRequest $request
     *
     * @return JsonResponse
     */
    public function connectToDatabase(ConnectToDatabaseRequest $request): JsonResponse
    {
        $status = $this->installationService->connectToDatabase($request->validated());

        return response()->json([
            'data' => ['status' => $status]
        ]);
    }

    /**
     * @param SetupSmtpRequest $request
     *
     * @return JsonResponse
     */
    public function setupSmtp(SetupSmtpRequest $request): JsonResponse
    {
        $status = $this->installationService->connectToDatabase($request->validated());

        return response()->json([
            'data' => ['status' => $status]
        ]);
    }
}
