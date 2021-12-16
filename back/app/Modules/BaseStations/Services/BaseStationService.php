<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Services;

use App\Base\Services\AbstractService;
use App\Modules\BaseStations\Models\BaseStation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BaseStationService extends AbstractService
{
    /**
     * @param array $data
     *
     * @return BaseStation
     */
    public function create(array $data): BaseStation
    {
        return BaseStation::create($data);
    }

    /**
     * @param int   $baseStationId
     * @param array $data
     *
     * @return BaseStation
     */
    public function update(int $baseStationId, array $data): BaseStation
    {
        /** @var BaseStation $baseStation */
        $baseStation = BaseStation::findOrFail($baseStationId);
        $baseStation->update($data);

        return $baseStation;
    }

    /**
     * @param int $baseStationId
     *
     * @return BaseStation
     */
    public function getById(int $baseStationId): BaseStation
    {
        return BaseStation::findOrFail($baseStationId);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getList()
    {
        return BaseStation::query()->paginate($this->getPerPage(), ['*'], $this->getPageName(), $this->getPage());
    }

    /**
     * @param int $baseStationId
     *
     * @return void
     */
    public function delete(int $baseStationId)
    {
        /** @var  BaseStation $baseStation */
        $baseStation = BaseStation::findOrFail($baseStationId);
        $baseStation->delete();
    }
}
