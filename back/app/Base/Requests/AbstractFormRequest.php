<?php

declare(strict_types=1);

namespace App\Base\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

abstract class AbstractFormRequest extends FormRequest
{
    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $lang = request()->header('accept-language', 'en');
        if (!in_array($lang, ['en', 'ru'])) {
            $lang = 'en';
        }

        app()->setLocale($lang);

        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

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
