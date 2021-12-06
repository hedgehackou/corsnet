<?php

declare(strict_types=1);

namespace App\Modules\Users\Repositories;

use App\Base\Repositories\AbstractRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends AbstractRepository
{
    /**
     * @return Builder
     */
    public function getUserList(): Builder
    {
        return User::query();
    }
}
