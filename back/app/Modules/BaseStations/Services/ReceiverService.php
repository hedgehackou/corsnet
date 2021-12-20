<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Services;

use App\Base\Services\AbstractService;
use App\Modules\BaseStations\Models\Receiver;
use App\Modules\BaseStations\Models\SatelliteSystem;

class ReceiverService extends AbstractService
{
    /**
     * @param array $data
     *
     * @return Receiver
     */
    public function createReceiver(array $data): Receiver
    {
        /** @var Receiver $receiver */
        $receiver = Receiver::create($data);
        $receiver->satellites()->attach($data['satellites']);

        return $receiver;
    }

    /**
     * @param int   $receiverId
     * @param array $data
     *
     * @return Receiver
     */
    public function updateReceiver(int $receiverId, array $data): Receiver
    {
        /** @var Receiver $receiver */
        $receiver = Receiver::findOrFail($receiverId);
        $receiver->update($data);
        $receiver->satellites()->attach($data['satellites']);

        return $receiver;
    }

    /**
     * @param int $receiverId
     *
     * @return void
     */
    public function deleteReceiver(int $receiverId)
    {
        /** @var Receiver $receiver */
        $receiver = Receiver::findOrFail($receiverId);
        $receiver->delete();
    }

    /**
     * @param int $receiverId
     *
     * @return Receiver
     */
    public function getReceiver(int $receiverId): Receiver
    {
        /** @var Receiver $receiver */
        $receiver = Receiver::findOrFail($receiverId);

        return $receiver;
    }

    /**
     * @return Receiver[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getReceiverList()
    {
        return Receiver::all();
    }

    /**
     * @return array
     */
    public function getSatelliteSystemList(): array
    {
        return SatelliteSystem::all()->toArray();
    }
}
