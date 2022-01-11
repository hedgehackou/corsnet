<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Services;

use App\Base\Services\AbstractService;
use App\Modules\BaseStations\Models\Antenna;

class AntennaService extends AbstractService
{
    /**
     * @param array $data
     *
     * @return Antenna
     */
    public function createAntenna(array $data): Antenna
    {
        /** @var Antenna $antenna */
        $antenna = Antenna::create($data);

        return $antenna;
    }

    /**
     * @param int   $antennaId
     * @param array $data
     *
     * @return Antenna
     */
    public function updateAntenna(int $antennaId, array $data): Antenna
    {
        /** @var Antenna $antenna */
        $antenna = Antenna::findOrFail($antennaId);
        $antenna->update($data);

        return $antenna;
    }

    /**
     * @param int $antennaId
     *
     * @return void
     */
    public function deleteAntenna(int $antennaId)
    {
        /** @var Antenna $antenna */
        $antenna = Antenna::findOrFail($antennaId);
        $antenna->delete();
    }

    /**
     * @param int $antennaId
     *
     * @return Antenna
     */
    public function getAntenna(int $antennaId): Antenna
    {
        /** @var Antenna $receiver */
        $antenna = Antenna::findOrFail($antennaId);

        return $antenna;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAntennaList(int $baseStationId)
    {
        return Antenna::query()->where('base_id', $baseStationId)->get();
    }
}
