<?php

declare(strict_types=1);

namespace App\Modules\Users\Requests\Client;

use App\Base\Requests\AbstractFormRequest;

class GetClientRequest extends AbstractFormRequest
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
            'client_id' => ['required', 'exists:clients,id', 'integer']
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $this->merge(['client_id' => $this->route('clientId')]);
    }
}
