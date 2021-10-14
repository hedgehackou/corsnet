<?php

declare(strict_types=1);

namespace App\Modules\Installation\Requests;

use App\Base\Requests\AbstractFormRequest;

class ConnectToDatabaseRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'host' => ['required', 'string'],
            'database' => ['required', 'string'],
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }
}
