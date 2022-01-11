<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Controllers;

use App\Base\Controllers\AbstractController;
use App\Modules\BaseStations\Requests\MountPoint\CreateMountPointRequest;
use App\Modules\BaseStations\Requests\MountPoint\DeleteMountPointRequest;
use App\Modules\BaseStations\Requests\MountPoint\GetMountPointListRequest;
use App\Modules\BaseStations\Requests\MountPoint\GetMountPointRequest;
use App\Modules\BaseStations\Requests\MountPoint\UpdateMountPointRequest;
use App\Modules\BaseStations\Resources\MountPointResource;
use App\Modules\BaseStations\Services\MountPointService;
use Illuminate\Http\JsonResponse;

class MountPointsController extends AbstractController
{
    /**
     * @var MountPointService
     */
    private MountPointService $mountPointService;

    /**
     * @param MountPointService $mountPointService
     */
    public function __construct(MountPointService $mountPointService)
    {
        $this->mountPointService = $mountPointService;
    }

    /**
     * @param CreateMountPointRequest $request
     * @param int                  $baseStationId
     *
     * @return JsonResponse
     */
    public function createMountPoint(CreateMountPointRequest $request, int $baseStationId): JsonResponse
    {
        $mountPoint = $this->mountPointService->createMountPoint($request->validated());

        return response()->json([
            'data' => new MountPointResource($mountPoint)
        ], 201);
    }

    /**
     * @param GetMountPointListRequest $request
     * @param int                      $baseStationId
     *
     * @return JsonResponse
     */
    public function getMountPointList(GetMountPointListRequest $request, int $baseStationId): JsonResponse
    {
        $list = $this->mountPointService->getMountPointList($baseStationId);

        return response()->json([
            'list' => MountPointResource::collection($list)
        ]);
    }

    /**
     * @param UpdateMountPointRequest $request
     * @param int                     $baseStationId
     * @param int                     $mountPointId
     *
     * @return JsonResponse
     */
    public function updateMountPoint(UpdateMountPointRequest $request, int $baseStationId, int $mountPointId): JsonResponse
    {
        $receiver = $this->mountPointService->updateMountPoint($mountPointId, $request->validated());

        return response()->json([
            'data' => new MountPointResource($receiver)
        ]);
    }

    /**
     * @param GetMountPointRequest $request
     * @param int                  $baseStationId
     * @param int                  $mountPointId
     *
     * @return JsonResponse
     */
    public function getMountPoint(GetMountPointRequest $request, int $baseStationId, int $mountPointId): JsonResponse
    {
        $mountPoint = $this->mountPointService->getMountPoint($mountPointId);

        return response()->json([
            'data' => new MountPointResource($mountPoint)
        ]);
    }

    /**
     * @param DeleteMountPointRequest $request
     * @param int                     $baseStationId
     * @param int                     $mountPointId
     *
     * @return JsonResponse
     */
    public function deleteMountPoint(DeleteMountPointRequest $request, int $baseStationId, int $mountPointId): JsonResponse
    {
        $this->mountPointService->deleteMountPoint($mountPointId);

        return response()->json([], 204);
    }
}
