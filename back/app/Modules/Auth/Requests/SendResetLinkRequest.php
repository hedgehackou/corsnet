<?php

declare(strict_types=1);

namespace App\Modules\Auth\Requests;

use App\Base\Requests\AbstractFormRequest;

class SendResetLinkRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
        ];
    }
}
