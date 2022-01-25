<?php

declare(strict_types=1);

namespace App\Modules\Casters\Controllers;

use App\Base\Controllers\AbstractController;
use App\Modules\Casters\Requests\GetCasterEventListRequest;
use App\Modules\Casters\Requests\HandleCasterEventsRequest;
use App\Modules\Casters\Requests\CreateCasterRequest;
use App\Modules\Casters\Requests\DeleteCasterRequest;
use App\Modules\Casters\Requests\GetCasterListRequest;
use App\Modules\Casters\Requests\GetCasterRequest;
use App\Modules\Casters\Requests\RestartCasterRequest;
use App\Modules\Casters\Requests\UpdateCasterRequest;
use App\Modules\Casters\Resources\CasterEventResource;
use App\Modules\Casters\Resources\CasterResource;
use App\Modules\Casters\Services\CasterService;
use Illuminate\Http\JsonResponse;

class CasterController extends AbstractController
{
    /**
     * @var CasterService
     */
    private CasterService $casterService;

    /**
     * @param CasterService $casterService
     */
    public function __construct(CasterService $casterService)
    {
        $this->casterService = $casterService;
    }

    /**
     * @param CreateCasterRequest $request
     *
     * @return JsonResponse
     */
    public function createCaster(CreateCasterRequest $request): JsonResponse
    {
        $client = $this->casterService->createCaster($request->validated());

        return response()->json([
            'data' => new CasterResource($client)
        ], 201);
    }

    /**
     * @param RestartCasterRequest $request
     * @param int                  $casterId
     *
     * @return JsonResponse
     */
    public function restartCaster(RestartCasterRequest $request, int $casterId): JsonResponse
    {
        $this->casterService->restartCaster($casterId);

        return response()->json();
    }

    /**
     * @param HandleCasterEventsRequest $request
     * @param int                       $casterId
     *
     * @return JsonResponse
     */
    public function handleCasterEvents(HandleCasterEventsRequest $request, int $casterId): JsonResponse
    {
        $this->casterService->handleCasterEvents($request->validated(), $casterId);

        return response()->json();
    }

    /**
     * @param GetCasterListRequest $request
     *
     * @return JsonResponse
     */
    public function getCasterList(GetCasterListRequest $request): JsonResponse
    {
        $list = $this->casterService->getCasterList();

        return response()->json([
            'current_page' => $list->currentPage(),
            'per_page' => $list->perPage(),
            'total' => $list->total(),
            'list' => CasterResource::collection($list),
        ]);
    }

    /**
     * @param GetCasterEventListRequest $request
     * @param int                       $casterId
     *
     * @return JsonResponse
     */
    public function getEventList(GetCasterEventListRequest $request, int $casterId): JsonResponse
    {
        $list = $this->casterService->getEventList($casterId);

        return response()->json([
            'current_page' => $list->currentPage(),
            'per_page' => $list->perPage(),
            'total' => $list->total(),
            'list' => CasterEventResource::collection($list),
        ]);
    }

    /**
     * @param UpdateCasterRequest $request
     * @param int                 $casterId
     *
     * @return JsonResponse
     */
    public function updateCaster(UpdateCasterRequest $request, int $casterId): JsonResponse
    {
        $caster = $this->casterService->updateCaster($casterId, $request->validated());

        return response()->json([
            'data' => new CasterResource($caster)
        ]);
    }

    /**
     * @param GetCasterRequest $request
     * @param int              $casterId
     *
     * @return JsonResponse
     */
    public function getCaster(GetCasterRequest $request, int $casterId): JsonResponse
    {
        $caster = $this->casterService->getCaster($casterId);

        return response()->json([
            'data' => new CasterResource($caster)
        ]);
    }

    /**
     * @param DeleteCasterRequest $request
     * @param int                 $casterId
     *
     * @return JsonResponse
     */
    public function deleteCaster(DeleteCasterRequest $request, int $casterId): JsonResponse
    {
        $this->casterService->deleteCaster($casterId);

        return response()->json([], 204);
    }
}
