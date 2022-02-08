<?php

declare(strict_types=1);

namespace App\Modules\Auth\Requests;

use App\Base\Requests\AbstractFormRequest;
use App\Modules\Installation\Rules\UniqueEmailRule;

class SignUpRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', new UniqueEmailRule()],
            'password' => ['required', 'min:6', 'max:16', 'string', 'confirmed'],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
