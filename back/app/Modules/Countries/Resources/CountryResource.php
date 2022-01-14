<?php

declare(strict_types=1);

namespace App\Modules\Countries\Resources;

use App\Base\Resources\AbstractResource;
use App\Modules\Countries\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CountryResource extends AbstractResource
{
    /**
     * @var Country $resource
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
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'alpha_2' => $this->resource->alpha_2,
            'country_code' => $this->resource->country_code,
        ];
    }
}
