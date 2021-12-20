<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Resources;

use App\Base\Resources\AbstractResource;
use App\Modules\BaseStations\Models\BaseStation;
use App\Modules\BaseStations\Models\Receiver;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReceiverResource extends AbstractResource
{
    /**
     * @var Receiver $resource
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
            'base_station_id' => $this->resource->base_id,
            'model' => $this->resource->model,
            'serial_number' => $this->resource->serial_number,
            'firmware_version' => $this->resource->firmware_version,
            'satellites' => $this->resource->satellites()->pluck('id'),
            'cutoff' => $this->resource->cutoff,
            'installed_at' => $this->resource->installed_at,
            'removed_at' => $this->resource->removed_at,
            'created_at' => Carbon::parse($this->resource->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->resource->updated_at)->format('Y-m-d H:i:s'),
            'disabled' => true
        ];
    }
}
