<?php

declare(strict_types=1);

namespace App\Modules\Casters\Requests;

use App\Base\Requests\AbstractFormRequest;

class RestartCasterRequest extends AbstractFormRequest
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
            'caster_id' => ['required', 'exists:casters,id', 'integer']
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $this->merge(['caster_id' => $this->route('casterId')]);
    }
}
