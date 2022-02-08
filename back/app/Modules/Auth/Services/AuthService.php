<?php

declare(strict_types=1);

namespace App\Modules\Auth\Services;

use App\Base\Services\AbstractService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService extends AbstractService
{
    public function signUp(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'is_admin' => false,
            'password' => Hash::make($data['password'])
        ]);
    }
}
