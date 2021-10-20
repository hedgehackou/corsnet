<?php

declare(strict_types=1);

namespace App\Modules\Installation\Requests;

use App\Base\Requests\AbstractFormRequest;

class InstallationRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'network_name' => ['required', 'string'],
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'max:16', 'string', 'confirmed'],
        ];
    }
}
