<?php

declare(strict_types=1);

namespace App\Modules\Casters\Services;

use App\Base\Services\AbstractService;
use App\Modules\Casters\Models\Caster;
use App\Modules\Casters\Models\CasterEvent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

class CasterService extends AbstractService
{
    /**
     * @param array $data
     *
     * @return Caster
     */
    public function createCaster(array $data): Caster
    {
        /** @var Caster $caster */
        $caster = Caster::create($data);
        File::makeDirectory("/var/instances/" . $caster->id . '/log', 0775, true, true);
        File::put("/var/instances/" . $caster->id . '/log/caster.log', "");
        File::put("/var/instances/" . $caster->id . '/caster.yml', "");
        $this->updateCasterConfig($caster);
        exec("systemctl enable --now caster@" . $caster->id);

        return $caster;
    }

    /**
     * @param int $casterId
     *
     * @return void
     */
    public function restartCaster(int $casterId): void
    {
        /** @var Caster $caster */
        $caster = Caster::findOrFail($casterId);
        exec( "rm /var/instances/" . $caster->id . "/caster.yml");
        $this->updateCasterConfig($caster);
        exec("systemctl restart caster@" . $caster->id);
    }

    /**
     * @param array $casterEvents
     * @param int   $casterId
     *
     * @return void
     */
    public function handleCasterEvents(array $casterEvents, int $casterId)
    {
        foreach ($casterEvents as $casterEvent) {
            if (empty($casterEvent['name'])) {
                continue;
            }
            CasterEvent::create([
                'name' => $casterEvent['name'],
                'caster_id' => $casterId,
                'timestamp' => Carbon::parse($casterEvent['timestamp']),
                'data' => $casterEvent['data'],
            ]);
        }
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
        $this->updateCasterConfig($caster);

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
        exec("systemctl disable --now caster@" . $caster->id);
        exec("rm -rf /var/instances/" . $caster->id);

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

    /**
     * @param int $casterId
     *
     * @return LengthAwarePaginator
     */
    public function getEventList(int $casterId): LengthAwarePaginator
    {
        return CasterEvent::query()
            ->where('caster_id',$casterId)
            ->paginate($this->getPerPage(), ['*'], $this->getPageName(), $this->getPage());
    }

    /**
     * @param Caster $caster
     *
     * @return void
     */
    private function updateCasterConfig(Caster $caster)
    {
        $data = [
            'caster' => [
                'host' => $caster->host,
                'address' => ":" . $caster->port,
                'identifier' => $caster->name,
                'operator' => $caster->operator,
                'nmea' => (int) $caster->nmea,
                'country' => $caster->country->alpha_2,
                'latitude' => $caster->latitude,
                'longitude' => $caster->longitude,
                'fallback_host' => $caster->fallback_host,
                'fallback_port' => $caster->fallback_port,
                'misc' => $caster->misc,
            ],
            'configuration' => [
                [
                    'type' => 'http',
                    'options' => [
                        'url' => "api.youcors.com/v1/session",
                        'secret' => "super_secret",
                        'interval' => 1000,
                        'limit' => 100,
                        'types' => [
                            'caster-ready',
                            'caster-terminate',
                            'connection-accepted',
                            'connection-terminated',
                            'ntrip-request-accepted',
                            'ntrip-request-rejected',
                            'ntrip-session-started',
                            'ntrip-session-ended',
                        ]
                    ]
                ],
            ],
            'license-key' => ""
        ];

        File::put("/var/instances/" . $caster->id . '/caster.yml', Yaml::dump($data, 6, 2));
    }
}
