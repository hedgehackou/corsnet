<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Services;

use App\Base\Services\AbstractService;
use App\Modules\BaseStations\Models\MountPoint;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class MountPointService extends AbstractService
{
    /**
     * @param array $data
     *
     * @return MountPoint
     */
    public function createMountPoint(array $data): MountPoint
    {
        /** @var MountPoint $mountPoint */
        $mountPoint = MountPoint::create($data);
        $mountPoint->mountPointDescription()->updateOrCreate(['mount_point_id' => $mountPoint->id], $data);

        return $mountPoint;
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
        $mountPoint->mountPointDescription()->updateOrCreate(['mount_point_id' => $mountPointId], $data);

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
        $mountPoint->mountPointDescription()->delete();
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
     * @return Builder[]|Collection
     */
    public function getMountPointList(int $baseStationId)
    {
        return MountPoint::query()->where('base_id', $baseStationId)->get();
    }
}
