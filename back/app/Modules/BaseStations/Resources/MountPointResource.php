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
            'disabled' => true
        ];
    }
}
