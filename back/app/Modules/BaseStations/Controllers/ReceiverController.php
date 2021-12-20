<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Controllers;

use App\Base\Controllers\AbstractController;
use App\Modules\BaseStations\Requests\Receiver\CreateReceiverRequest;
use App\Modules\BaseStations\Requests\Receiver\DeleteReceiverRequest;
use App\Modules\BaseStations\Requests\Receiver\GetReceiverListRequest;
use App\Modules\BaseStations\Requests\Receiver\GetReceiverRequest;
use App\Modules\BaseStations\Requests\Receiver\GetSatelliteSystemListRequest;
use App\Modules\BaseStations\Requests\Receiver\UpdateReceiverRequest;
use App\Modules\BaseStations\Resources\BaseStationResource;
use App\Modules\BaseStations\Resources\ReceiverResource;
use App\Modules\BaseStations\Services\ReceiverService;
use Illuminate\Http\JsonResponse;

class ReceiverController extends AbstractController
{
    /**
     * @var ReceiverService $receiverService
     */
    private ReceiverService $receiverService;

    /**
     * @param ReceiverService $receiverService
     */
    public function __construct(ReceiverService $receiverService)
    {
        $this->receiverService = $receiverService;
    }

    /**
     * @param CreateReceiverRequest $request
     *
     * @return JsonResponse
     */
    public function createReceiver(CreateReceiverRequest $request): JsonResponse
    {
        $baseStation = $this->receiverService->createReceiver($request->validated());

        return response()->json([
            'data' => new ReceiverResource($baseStation)
        ], 201);
    }

    /**
     * @param GetReceiverListRequest $request
     *
     * @return JsonResponse
     */
    public function getReceiverList(GetReceiverListRequest $request): JsonResponse
    {
        $list = $this->receiverService->getReceiverList();

        return response()->json([
            'list' => ReceiverResource::collection($list)
        ]);
    }

    /**
     * @param UpdateReceiverRequest $request
     * @param int                   $baseStationId
     * @param int                   $receiverId
     *
     * @return JsonResponse
     */
    public function updateReceiver(UpdateReceiverRequest $request, int $baseStationId, int $receiverId): JsonResponse
    {
        $receiver = $this->receiverService->updateReceiver($receiverId, $request->validated());

        return response()->json([
            'data' => new ReceiverResource($receiver)
        ]);
    }

    /**
     * @param GetReceiverRequest $request
     * @param int                $receiverId
     *
     * @return JsonResponse
     */
    public function getReceiver(GetReceiverRequest $request, int $receiverId): JsonResponse
    {
        $baseStation = $this->receiverService->getReceiver($receiverId);

        return response()->json([
            'data' => new ReceiverResource($baseStation)
        ]);
    }

    /**
     * @param DeleteReceiverRequest $request
     * @param int                   $baseStationId
     * @param int                   $receiverId
     *
     * @return JsonResponse
     */
    public function deleteReceiver(DeleteReceiverRequest $request, int $baseStationId, int $receiverId): JsonResponse
    {
        $this->receiverService->deleteReceiver($receiverId);

        return response()->json([], 204);
    }

    /**
     * @param GetSatelliteSystemListRequest $request
     *
     * @return JsonResponse
     */
    public function getSatelliteSystemList(GetSatelliteSystemListRequest $request): JsonResponse
    {
        return response()->json([
            'list' => $this->receiverService->getSatelliteSystemList()
        ]);
    }
}
