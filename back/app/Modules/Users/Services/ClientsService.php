<?php

declare(strict_types=1);

namespace App\Modules\Users\Services;

use App\Base\Services\AbstractService;
use App\Modules\Users\Models\Client;

class ClientsService extends AbstractService
{
    /**
     * @param array $data
     *
     * @return Client
     */
    public function createClient(array $data): Client
    {
        return Client::create($data);
    }

    /**
     * @param int   $clientId
     * @param array $data
     *
     * @return Client
     */
    public function updateClient(int $clientId, array $data): Client
    {
        /** @var Client $client */
        $client = Client::findOrFail($clientId);
        $client->update($data);

        return $client;
    }

    /**
     * @param int $clientId
     *
     * @return void
     */
    public function deleteClient(int $clientId)
    {
        /** @var Client $client */
        $client = Client::findOrFail($clientId);
        $client->delete();
    }

    /**
     * @param int $clientId
     *
     * @return Client
     */
    public function getClient(int $clientId): Client
    {
        return Client::findOrFail($clientId);
    }

    /**
     * @param int $userId
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getClientList(int $userId)
    {
        return Client::query()->where('user_id', $userId)->get();
    }
}
