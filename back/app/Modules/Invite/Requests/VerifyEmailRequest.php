<?php

declare(strict_types=1);

namespace App\Modules\Invite\Requests;

use App\Base\Requests\AbstractFormRequest;

class VerifyEmailRequest extends AbstractFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'token' => ['required', 'string', 'max:255', 'exists:users,email_verification_token'],
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $this->merge(['token' => $this->route('token')]);
    }
}
