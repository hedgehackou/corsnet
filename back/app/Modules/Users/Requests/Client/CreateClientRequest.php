<?php

declare(strict_types=1);

namespace App\Modules\Users\Requests\Client;

use App\Base\Requests\AbstractFormRequest;
use App\Modules\Users\Models\Client;
use Illuminate\Validation\Rule;

class CreateClientRequest extends AbstractFormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => ['integer', 'required', 'exists:users,id'],
            'name' => ['string', 'required'],
            'user_name' => ['string', 'required'],
            'password' => ['string', 'required'],
            'ntrip_version' => ['string', Rule::in(Client::NTRIP_VERSIONS)],
            'is_encrypted' => ['boolean'],
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();
        $this->merge([
            'user_id' => $this->route('userId')
        ]);
    }
}
