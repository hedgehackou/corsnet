<?php

declare(strict_types=1);

namespace App\Modules\Settings\Requests;

use App\Base\Requests\AbstractFormRequest;
use Illuminate\Validation\Rule;

class UpdateSettingsRequest extends AbstractFormRequest
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
            'network_name' => ['required', 'string'],
            'lang' => ['required', 'string', Rule::in(['ru', 'en'])],
            'google_map_key' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();
        $this->merge([
            'nmea' => !!$this->get('nmea')
        ]);
    }
}
