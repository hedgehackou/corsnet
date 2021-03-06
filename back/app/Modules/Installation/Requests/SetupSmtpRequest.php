<?php

declare(strict_types=1);

namespace App\Modules\Installation\Requests;

use App\Base\Requests\AbstractFormRequest;

class SetupSmtpRequest extends AbstractFormRequest
{
    /**
     * @return array
     */
    public function rules(): array
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
