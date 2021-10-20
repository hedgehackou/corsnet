<?php

declare(strict_types=1);

namespace App\Modules\Installation\Requests;

use App\Base\Requests\AbstractFormRequest;

class AddSettingsRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'network_name' => ['required', 'string'],
        ];
    }
}
