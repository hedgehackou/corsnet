<?php

declare(strict_types=1);

namespace App\Modules\Settings\Resources;

use App\Base\Resources\AbstractResource;
use App\Modules\Settings\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettingsResource extends AbstractResource
{
    /**
     * @var Setting $resource
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
            'lang' => $this->resource->lang,
            'network_name' => $this->resource->network_name,
            'google_map_key' => $this->resource->google_map_key,
        ];
    }
}
