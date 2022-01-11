<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Services;

use App\Base\Services\AbstractService;
use App\Modules\BaseStations\Models\MountPoint;

class MountPointService extends AbstractService
{
    /**
     * @param array $data
     *
     * @return MountPoint
     */
    public function createMountPoint(array $data): MountPoint
    {
        return MountPoint::create($data);
    }

    /**
     * @param int   $mountPointId
     * @param array $data
     *
     * @return MountPoint
     */
    public function updateMountPoint(int $mountPointId, array $data): MountPoint
    {
        /** @var MountPoint $mountPoint */
        $mountPoint = MountPoint::findOrFail($mountPointId);
        $mountPoint->update($data);

        return $mountPoint;
    }

    /**
     * @param int $mountPointId
     *
     * @return void
     */
    public function deleteMountPoint(int $mountPointId)
    {
        /** @var MountPoint $mountPoint */
        $mountPoint = MountPoint::findOrFail($mountPointId);
        $mountPoint->delete();
    }

    /**
     * @param int $mountPointId
     *
     * @return MountPoint
     */
    public function getMountPoint(int $mountPointId): MountPoint
    {
        return MountPoint::findOrFail($mountPointId);
    }

    /**
     * @param int $baseStationId
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getMountPointList(int $baseStationId)
    {
        return MountPoint::query()->where('base_id', $baseStationId)->get();
    }
}
