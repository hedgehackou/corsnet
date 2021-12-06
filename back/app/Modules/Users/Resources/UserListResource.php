<?php

declare(strict_types=1);

namespace App\Modules\Users\Resources;

use Illuminate\Http\Request;
use App\Base\Resources\AbstractResource;
use App\Models\User;

class UserListResource extends AbstractResource
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
        return [
            'id' => $this->resource->id,
            'is_admin' => $this->resource->is_admin,
            'email' => $this->resource->email,
        ];
    }
}
