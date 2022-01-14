<?php

declare(strict_types=1);

namespace App\Modules\Casters\Requests;

use App\Base\Requests\AbstractFormRequest;
use App\Modules\Casters\Rules\HostRule;
use Illuminate\Validation\Rule;

class UpdateCasterRequest extends CreateCasterRequest
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
        return array_merge([
            'id' => ['required', 'exists:casters,id', 'integer'],
        ], parent::rules());
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();
        $this->merge(['id' => $this->route('casterId')]);
    }
}
