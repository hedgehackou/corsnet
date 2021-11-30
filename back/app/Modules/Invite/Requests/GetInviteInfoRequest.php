<?php

declare(strict_types=1);

namespace App\Modules\Invite\Requests;

use App\Base\Requests\AbstractFormRequest;
use App\Modules\Invite\Rules\AcceptedTokenRule;

class GetInviteInfoRequest extends AbstractFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'token' => ['required', 'string', 'exists:invites,token', new AcceptedTokenRule()]
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $this->merge(['token' => $this->route('token')]);
    }
}
