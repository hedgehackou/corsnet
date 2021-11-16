<?php

declare(strict_types=1);

namespace App\Modules\Auth\Requests;

use App\Base\Requests\AbstractFormRequest;

class LoginRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:6', 'max:16'],
        ];
    }
}
