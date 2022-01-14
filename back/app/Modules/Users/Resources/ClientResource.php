<?php

declare(strict_types=1);

namespace App\Modules\Users\Resources;

use App\Base\Resources\AbstractResource;
use App\Modules\Users\Models\Client;
use Illuminate\Http\Request;

class ClientResource extends AbstractResource
{
    /**
     * @var Client $resource
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
            'user_id' => $this->resource->user_id,
            'name' => $this->resource->name,
            'user_name' => $this->resource->user_name,
            'password' => $this->resource->password,
            'ntrip_version' => $this->resource->ntrip_version,
            'is_encrypted' => !!$this->resource->is_encrypted,
            'disabled' => true
        ];
    }
}
