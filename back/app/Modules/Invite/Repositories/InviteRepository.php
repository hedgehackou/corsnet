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

    /**
     * @param string $token
     *
     * @return mixed
     */
    public function getInviteByToken(string $token)
    {
        return Invite::where('token', $token)->firstOrFail();
    }
}
