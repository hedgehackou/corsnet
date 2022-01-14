<?php

declare(strict_types=1);

namespace App\Modules\Users\Controllers;

use App\Base\Controllers\AbstractController;
use App\Modules\Users\Requests\Client\CreateClientRequest;
use App\Modules\Users\Requests\Client\DeleteClientRequest;
use App\Modules\Users\Requests\Client\GetClientListRequest;
use App\Modules\Users\Requests\Client\GetClientRequest;
use App\Modules\Users\Requests\Client\UpdateClientRequest;
use App\Modules\Users\Resources\ClientResource;
use App\Modules\Users\Services\ClientsService;
use Illuminate\Http\JsonResponse;

class ClientsController extends AbstractController
{
    /**
     * @var ClientsService
     */
    private ClientsService $clientsService;

    /**
     * @param ClientsService $clientsService
     */
    public function __construct(ClientsService $clientsService)
    {
        $this->clientsService = $clientsService;
    }

    /**
     * @param CreateClientRequest $request
     * @param int                 $userId
     *
     * @return JsonResponse
     */
    public function createClient(CreateClientRequest $request, int $userId): JsonResponse
    {
        $client = $this->clientsService->createClient($request->validated());

        return response()->json([
            'data' => new ClientResource($client)
        ], 201);
    }

    /**
     * @param GetClientListRequest $request
     * @param int                  $userId
     *
     * @return JsonResponse
     */
    public function getClientList(GetClientListRequest $request, int $userId): JsonResponse
    {
        $list = $this->clientsService->getClientList($userId);

        return response()->json([
            'list' => ClientResource::collection($list)
        ]);
    }

    /**
     * @param UpdateClientRequest $request
     * @param int                 $userId
     * @param int                 $clientId
     *
     * @return JsonResponse
     */
    public function updateClient(UpdateClientRequest $request, int $userId, int $clientId): JsonResponse
    {
        $receiver = $this->clientsService->updateClient($clientId, $request->validated());

        return response()->json([
            'data' => new ClientResource($receiver)
        ]);
    }

    /**
     * @param GetClientRequest $request
     * @param int              $userId
     * @param int              $clientId
     *
     * @return JsonResponse
     */
    public function getMountPoint(GetClientRequest $request, int $userId, int $clientId): JsonResponse
    {
        $client = $this->clientsService->getClient($clientId);

        return response()->json([
            'data' => new ClientResource($client)
        ]);
    }

    /**
     * @param DeleteClientRequest $request
     * @param int                 $userId
     * @param int                 $clientId
     *
     * @return JsonResponse
     */
    public function deleteClient(DeleteClientRequest $request, int $userId, int $clientId): JsonResponse
    {
        $this->clientsService->deleteClient($clientId);

        return response()->json([], 204);
    }
}
