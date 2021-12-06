<?php

declare(strict_types=1);

namespace App\Modules\Users\Controllers;

use App\Base\Controllers\AbstractController;
use App\Modules\Users\Requests\GetUserListRequest;
use App\Modules\Users\Resources\UserListResource;
use App\Modules\Users\Services\UsersService;
use Illuminate\Http\JsonResponse;

class UsersController extends AbstractController
{
    /**
     * @var UsersService $usersService
     */
    private UsersService $usersService;

    /**
     * @param UsersService $usersService
     */
    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function getUserList(GetUserListRequest $request): JsonResponse
    {
        $list = $this->usersService->getUserList();

        return response()->json([
            'current_page' => $list->currentPage(),
            'per_page' => $list->perPage(),
            'total' => $list->total(),
            'list' => UserListResource::collection($list),
        ]);
    }
}
