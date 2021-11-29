<?php

declare(strict_types=1);

namespace App\Modules\Invite\Requests;

use App\Base\Requests\AbstractFormRequest;
use Illuminate\Validation\Rule;

class CreateInviteRequest extends AbstractFormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'string', Rule::in(['user', 'admin'])],
        ];
    }
}
