<?php

declare(strict_types=1);

namespace App\Base\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

abstract class AbstractFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    protected function prepareForValidation()
    {
        $requestData = $this->all();
        foreach ($requestData as $key => $item) {
            $requestData[Str::snake($key)] = $item;
        }
        $this->replace($requestData);
    }
}
