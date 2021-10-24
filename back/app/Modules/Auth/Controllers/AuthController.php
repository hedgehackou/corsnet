<?php

declare(strict_types=1);

namespace App\Modules\Auth\Controllers;

use App\Base\Controllers\AbstractController;
use App\Models\User;
use App\Modules\Auth\Requests\FetchProfileRequest;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Resources\UserResources;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends AbstractController
{
    /**
     * @param FetchProfileRequest $request
     *
     * @return UserResources
     */
    public function fetchProfile(FetchProfileRequest $request): UserResources
    {
        return new UserResources(Auth::user());
    }

    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => [__('auth.credentials_incorrect')],
            ]);
        }

        /** @var User $user */
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('auth', [
            'is_admin' => $user->isAdmin(),
        ]);

        return response()->json([
            'token' => $token->plainTextToken,
            'abilities' => $token->accessToken->abilities
        ]);
    }
}
