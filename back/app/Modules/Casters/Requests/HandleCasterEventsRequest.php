<?php

declare(strict_types=1);

namespace App\Modules\Casters\Requests;

use App\Base\Requests\AbstractFormRequest;
use App\Modules\Casters\Models\Caster;
use Symfony\Component\HttpKernel\Exception\HttpException;

class HandleCasterEventsRequest extends AbstractFormRequest
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
            '*.name' => ['required', 'string'],
            '*.timestamp' => ['required', 'integer'],
            '*.data' => ['required', 'array'],
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();
        try {
            Caster::findOrFail($this->route('casterId'));
        } catch (\Exception $exception) {
            throw new HttpException(400, "Invalid caster id");
        }
    }
}
