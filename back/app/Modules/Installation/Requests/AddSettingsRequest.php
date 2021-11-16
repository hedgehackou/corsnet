<?php

declare(strict_types=1);

namespace App\Modules\Installation\Requests;

use App\Base\Requests\AbstractFormRequest;
use Illuminate\Validation\Rule;

class AddSettingsRequest extends AbstractFormRequest
{
    /**
     * @return \string[][]
     */
    public function rules(): array
    {
        return [
            'network_name' => ['required', 'string'],
            'lang' => ['required', 'string', Rule::in(['ru', 'en'])],
        ];
    }
}
