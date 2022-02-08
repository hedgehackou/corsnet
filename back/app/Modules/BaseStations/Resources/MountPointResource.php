<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Resources;

use App\Base\Resources\AbstractResource;
use App\Modules\BaseStations\Models\MountPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MountPointResource extends AbstractResource
{
    /**
     * @var MountPoint $resource
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     * @throws \Exception
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'base_id' => $this->resource->base_id,
            'name' => $this->resource->name,
            'user_name' => $this->resource->user_name,
            'password' => $this->resource->password,
            'ntrip_version' => $this->resource->ntrip_version,
            'is_encrypted' => !!$this->resource->is_encrypted,
            'disabled' => true,
            //description fields
            'mountpoint' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->mountpoint : '',
            'identifier' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->identifier : '',
            'format' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->format : '',
            'format_details' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->format_details : '',
            'carrier' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->carrier : 0,
            'nav_system' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->nav_system : '',
            'network' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->network : '',
            'country' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->country : 'AF',
            'latitude' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->latitude : 0,
            'longitude' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->longitude : 0,
            'nmea' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->nmea : 0,
            'solution' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->solution : 0,
            'generator' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->generator : '',
            'compr_encryp' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->compr_encryp : 'none',
            'authentication' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->authentication : 'B',
            'fee' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->fee : 'N',
            'bitrate' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->bitrate : 0,
            'misc' => $this->resource->mountPointDescription ? $this->resource->mountPointDescription->misc : '',
        ];
    }
}
