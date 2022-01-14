<?php

declare(strict_types=1);

namespace App\Modules\Casters\Services;

use App\Base\Services\AbstractService;
use App\Modules\Casters\Models\Caster;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CasterService extends AbstractService
{
    /**
     * @param array $data
     *
     * @return Caster
     */
    public function createCaster(array $data): Caster
    {
        return Caster::create($data);
    }

    /**
     * @param int   $casterId
     * @param array $data
     *
     * @return Caster
     */
    public function updateCaster(int $casterId, array $data): Caster
    {
        /** @var Caster $mountPoint */
        $caster = Caster::findOrFail($casterId);
        $caster->update($data);

        return $caster;
    }

    /**
     * @param int $casterId
     *
     * @return void
     */
    public function deleteCaster(int $casterId)
    {
        /** @var Caster $caster */
        $caster = Caster::findOrFail($casterId);
        $caster->delete();
    }

    /**
     * @param int $casterId
     *
     * @return Caster
     */
    public function getCaster(int $casterId): Caster
    {
        return Caster::findOrFail($casterId);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getCasterList(): LengthAwarePaginator
    {
        return Caster::query()->paginate($this->getPerPage(), ['*'], $this->getPageName(), $this->getPage());
    }
}
