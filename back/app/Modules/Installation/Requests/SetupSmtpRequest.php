<?php

declare(strict_types=1);

namespace App\Modules\Installation\Requests;

use App\Base\Requests\AbstractFormRequest;

class SetupSmtpRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'host' => ['required', 'string'],
            'port' => ['required', 'string'],
            'login' => ['required', 'string'],
            'encryption' => ['nullable', 'string'],
            'password' => ['required', 'string'],
        ];
    }
}
