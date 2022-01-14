<?php

declare(strict_types=1);

namespace App\Modules\Casters\Resources;

use App\Base\Resources\AbstractResource;
use App\Modules\Casters\Models\Caster;
use Illuminate\Http\Request;

class CasterResource extends AbstractResource
{
    /**
     * @var Caster $resource
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
            'name' => $this->resource->name,
            'host' => $this->resource->host,
            'port' => $this->resource->port,
            'operator' => $this->resource->operator,
            'nmea' => $this->resource->nmea,
            'country_id' => $this->resource->country_id,
            'latitude' => $this->resource->latitude,
            'longitude' => $this->resource->longitude,
            'fallback_host' => $this->resource->fallback_host,
            'fallback_port' => $this->resource->fallback_port,
            'misc' => $this->resource->misc,
            'disabled' => true
        ];
    }
}
