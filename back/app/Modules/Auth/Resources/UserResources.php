<?php

declare(strict_types=1);

namespace App\Modules\Auth\Resources;

use App\Base\Resources\AbstractResource;
use App\Models\User;
use App\Modules\Settings\Models\Setting;
use Illuminate\Http\Request;

class UserResources extends AbstractResource
{
    /**
     * @var User $resource
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
        $lang = 'en';
        /** @var Setting $setting */
        if ($setting = Setting::query()->first()) {
            $lang = $setting->lang;
        }

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'is_admin' => !!$this->resource->is_admin,
            'lang' => $lang
        ];
    }
}
