<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Resources;

use App\Base\Resources\AbstractResource;
use App\Models\User;
use App\Modules\BaseStations\Models\BaseStation;
use App\Modules\Settings\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BaseStationResource extends AbstractResource
{
    /**
     * @var BaseStation $resource
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
            'city' => $this->resource->city,
            'latitude' => $this->resource->latitude,
            'longitude' => $this->resource->longitude,
            'height' => $this->resource->height,
            'is_online' => $this->resource->is_online,
            'status' => array_flip(BaseStation::STATUSES)[$this->resource->status_id],
            'created_at' => Carbon::parse($this->resource->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->resource->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
