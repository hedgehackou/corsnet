<?php

declare(strict_types=1);

namespace App\Modules\Invite\Resources;

use App\Base\Resources\AbstractResource;
use App\Modules\Invite\Models\Invite;
use Illuminate\Http\Request;

class InviteListResource extends AbstractResource
{
    /**
     * @var Invite $resource
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
            'is_accepted' => $this->resource->is_accepted,
        ];
    }
}
