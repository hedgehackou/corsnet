<?php

declare(strict_types=1);

namespace App\Modules\Invite\Requests;

use App\Base\Requests\AbstractFormRequest;

class AcceptInviteRequest extends AbstractFormRequest
{
    public function authorize()
    {
        return $this->user()->isUser();
    }

    public function rules()
    {
        return [
            'token' => ['required', 'string', 'email', 'max:255', 'exists:invites,token'],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:6'],
        ];
    }
}
