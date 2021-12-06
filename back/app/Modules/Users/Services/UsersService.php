<?php

declare(strict_types=1);

namespace App\Modules\Users\Services;

use App\Base\Services\AbstractService;
use App\Modules\Users\Repositories\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UsersService extends AbstractService
{
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getUserList(): LengthAwarePaginator
    {
        return $this->userRepository
            ->getUserList()
            ->paginate($this->getPerPage(), ['*'], $this->getPageName(), $this->getPage());
    }
}
