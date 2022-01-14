<?php

declare(strict_types=1);

namespace App\Modules\Casters\Requests;

use App\Base\Requests\AbstractFormRequest;
use App\Modules\Casters\Rules\HostRule;
use Illuminate\Validation\Rule;

class CreateCasterRequest extends AbstractFormRequest
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
            'name' => ['string', 'required'],
            'host' => ['bail', 'required', new HostRule()],
            'port' => ['integer', 'required', 'min:0', 'max:65535'],
            'operator' => ['required', 'string'],
            'nmea' => ['boolean'],
            'country_id' => ['required', 'exists:countries,id', 'integer'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'fallback_host' => ['bail', 'nullable', new HostRule()],
            'fallback_port' => ['bail', 'nullable', 'integer', 'min:0', 'max:65535'],
            'misc' => ['string', 'nullable']
        ];
    }
}
