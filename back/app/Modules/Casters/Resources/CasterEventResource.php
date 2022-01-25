<?php

declare(strict_types=1);

namespace App\Modules\Casters\Resources;

use App\Base\Resources\AbstractResource;
use App\Modules\Casters\Models\CasterEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CasterEventResource extends AbstractResource
{
    /**
     * @var CasterEvent $resource
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
            'name' => $this->resource->name,
            'caster_id' => $this->resource->caster_id,
            'timestamp' => Carbon::parse($this->resource->timestamp)->format('Y-m-d H:i:s'),
            'data' => $this->resource->data,
        ];
    }
}
