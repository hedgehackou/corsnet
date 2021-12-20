<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Controllers;

use App\Base\Controllers\AbstractController;
use App\Modules\BaseStations\Requests\Antenna\CreateAntennaRequest;
use App\Modules\BaseStations\Requests\Antenna\DeleteAntennaRequest;
use App\Modules\BaseStations\Requests\Antenna\GetAntennaListRequest;
use App\Modules\BaseStations\Requests\Antenna\GetAntennaRequest;
use App\Modules\BaseStations\Requests\Antenna\UpdateAntennaRequest;
use App\Modules\BaseStations\Resources\AntennaResource;
use App\Modules\BaseStations\Services\AntennaService;
use Illuminate\Http\JsonResponse;

class AntennaController extends AbstractController
{
    /**
     * @var AntennaService $antennaService
     */
    private AntennaService $antennaService;

    /**
     * @param AntennaService $antennaService
     */
    public function __construct(AntennaService $antennaService)
    {
        $this->antennaService = $antennaService;
    }

    /**
     * @param CreateAntennaRequest $request
     * @param int                  $baseStationId
     *
     * @return JsonResponse
     */
    public function createAntenna(CreateAntennaRequest $request, int $baseStationId): JsonResponse
    {
        $antenna = $this->antennaService->createAntenna($request->validated());

        return response()->json([
            'data' => new AntennaResource($antenna)
        ], 201);
    }

    /**
     * @param GetAntennaListRequest $request
     * @param int                   $baseStationId
     *
     * @return JsonResponse
     */
    public function getAntennaList(GetAntennaListRequest $request, int $baseStationId): JsonResponse
    {
        $list = $this->antennaService->getAntennaList();

        return response()->json([
            'list' => AntennaResource::collection($list)
        ]);
    }

    /**
     * @param UpdateAntennaRequest $request
     * @param int                  $baseStationId
     * @param int                  $antennaId
     *
     * @return JsonResponse
     */
    public function updateAntenna(UpdateAntennaRequest $request, int $baseStationId, int $antennaId): JsonResponse
    {
        $receiver = $this->antennaService->updateAntenna($antennaId, $request->validated());

        return response()->json([
            'data' => new AntennaResource($receiver)
        ]);
    }

    /**
     * @param GetAntennaRequest $request
     * @param int               $baseStationId
     * @param int               $antennaId
     *
     * @return JsonResponse
     */
    public function getAntenna(GetAntennaRequest $request, int $baseStationId, int $antennaId): JsonResponse
    {
        $antenna = $this->antennaService->getAntenna($antennaId);

        return response()->json([
            'data' => new AntennaResource($antenna)
        ]);
    }

    /**
     * @param DeleteAntennaRequest $request
     * @param int                  $baseStationId
     * @param int                  $antennaId
     *
     * @return JsonResponse
     */
    public function deleteAntenna(DeleteAntennaRequest $request, int $baseStationId, int $antennaId): JsonResponse
    {
        $this->antennaService->deleteAntenna($antennaId);

        return response()->json([], 204);
    }
}
