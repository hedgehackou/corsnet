<?php

declare(strict_types=1);

namespace App\Modules\Auth\Services;

use App\Base\Services\AbstractService;
use App\Models\User;
use App\Modules\Invite\Mail\VerificationMail;
use App\Modules\Settings\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;

class AuthService extends AbstractService
{
    /**
     * @param array $data
     *
     * @return User
     */
    public function signUp(array $data): User
    {
        $token = Uuid::uuid4();
        /** @var User $user */
        $user = User::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'is_admin' => false,
            'password' => Hash::make($data['password']),
            'email_verification_token' => $token->toString()
        ]);

        $url = rtrim(env('APP_URL'), '/') . route('email.verify', [
                'emailVerificationToken' => $token->toString(),
            ], false);

        $networkName = Setting::firstOrFail()->network_name;

        Mail::to($data['email'])->send(new VerificationMail($url, $networkName));

        return $user;
    }
}
