<?php

declare(strict_types=1);

namespace App\Modules\Invite\Repositories;

use App\Base\Repositories\AbstractRepository;
use App\Modules\Invite\Models\Invite;
use Illuminate\Database\Eloquent\Builder;

class InviteRepository extends AbstractRepository
{
    /**
     * @return Builder
     */
    public function getInviteList(): Builder
    {
        return Invite::query();
    }
}
