<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Controllers;

use App\Base\Controllers\AbstractController;
use App\Modules\BaseStations\Requests\BaseStation\CreateBaseStationRequest;
use App\Modules\BaseStations\Requests\BaseStation\DeleteBaseStationRequest;
use App\Modules\BaseStations\Requests\BaseStation\GetBaseStationListRequest;
use App\Modules\BaseStations\Requests\BaseStation\GetBaseStationRequest;
use App\Modules\BaseStations\Requests\BaseStation\UpdateBaseStationRequest;
use App\Modules\BaseStations\Resources\BaseStationResource;
use App\Modules\BaseStations\Services\BaseStationService;
use Illuminate\Http\JsonResponse;

class BaseStationsController extends AbstractController
{
    /**
     * @var BaseStationService $baseStationService
     */
    private BaseStationService $baseStationService;

    /**
     * @param BaseStationService $baseStationService
     */
    public function __construct(BaseStationService $baseStationService)
    {
        $this->baseStationService = $baseStationService;
    }

    /**
     * @param CreateBaseStationRequest $request
     *
     * @return JsonResponse
     */
    public function createBaseStation(CreateBaseStationRequest $request): JsonResponse
    {
        $baseStation = $this->baseStationService->create($request->validated());

        return response()->json([
            'data' => new BaseStationResource($baseStation)
        ], 201);
    }

    /**
     * @param GetBaseStationListRequest $request
     *
     * @return JsonResponse
     */
    public function getBaseStationList(GetBaseStationListRequest $request): JsonResponse
    {
        $list = $this->baseStationService->getList();

        return response()->json([
            'list' => BaseStationResource::collection($list),
            'current_page' => $list->currentPage(),
            'per_page' => $list->perPage(),
            'total' => $list->total(),
        ]);
    }

    /**
     * @param UpdateBaseStationRequest $request
     * @param int                      $baseStationId
     *
     * @return JsonResponse
     */
    public function updateBaseStation(UpdateBaseStationRequest $request, int $baseStationId): JsonResponse
    {
        $baseStation = $this->baseStationService->update($baseStationId, $request->validated());

        return response()->json([
            'data' => new BaseStationResource($baseStation)
        ]);
    }

    /**
     * @param GetBaseStationRequest $request
     * @param int                   $baseStationId
     *
     * @return JsonResponse
     */
    public function getBaseStation(GetBaseStationRequest $request, int $baseStationId): JsonResponse
    {
        $baseStation = $this->baseStationService->getById($baseStationId);

        return response()->json([
            'data' => new BaseStationResource($baseStation)
        ]);
    }

    /**
     * @param DeleteBaseStationRequest $request
     * @param int                      $baseStationId
     *
     * @return JsonResponse
     */
    public function deleteBaseStation(DeleteBaseStationRequest $request, int $baseStationId): JsonResponse
    {
        $this->baseStationService->delete($baseStationId);

        return response()->json([], 204);
    }
}
