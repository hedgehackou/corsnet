<?php

declare(strict_types=1);

namespace App\Modules\Installation\Requests;

use App\Base\Requests\AbstractFormRequest;
use App\Modules\Installation\Rules\UniqueEmailRule;
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
            'email' => ['required', 'string', 'email', new UniqueEmailRule()],
            'lang' => ['required', 'string', Rule::in(['ru', 'en'])],
            'password' => ['required', 'min:6', 'max:16', 'string', 'confirmed'],
        ];
    }
}
