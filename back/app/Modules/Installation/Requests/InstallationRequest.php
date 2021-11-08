<?php

declare(strict_types=1);

namespace App\Modules\Installation\Requests;

use App\Base\Requests\AbstractFormRequest;
use Illuminate\Validation\Rule;

class InstallationRequest extends AbstractFormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'network_name' => ['required', 'string'],
            'name' => ['required', 'string'],
            'lang' => ['required', 'string', Rule::in(['ru', 'en'])],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'max:16', 'string', 'confirmed'],
        ];
    }
}
