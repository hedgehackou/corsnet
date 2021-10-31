<?php

declare(strict_types=1);

namespace App\Modules\Auth\Controllers;

use App\Base\Controllers\AbstractController;
use App\Models\User;
use App\Modules\Auth\Requests\FetchProfileRequest;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Requests\ResetPasswordRequest;
use App\Modules\Auth\Requests\SendResetLinkRequest;
use App\Modules\Auth\Resources\UserResources;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
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

    /**
     * @param SendResetLinkRequest $request
     *
     * @return JsonResponse
     */
    public function sendResetLink(SendResetLinkRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::where('email', $request->get('email'))->firstOrFail();
        $user->sendPasswordResetNotification(Password::createToken($user));

        return response()->json();
    }

    /**
     * @param ResetPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $status = Password::reset(
            $request->validated(),
            function (User $user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                $user->setRememberToken(Str::random(60));

                event(new PasswordReset($user));
            }
        );
        if ($status === Password::PASSWORD_RESET) {
            return response()->json([]);
        }
        return response()->json(409);
    }
}
