<?php

declare(strict_types=1);

namespace App\Modules\Casters\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class HostRule implements Rule
{
    public function passes($attribute, $value)
    {
        if (empty($value)) {
            return true;
        }

        $urlValidator = Validator::make(['host' => $value], ['host' => 'url']);
        $ipValidator = Validator::make(['host' => $value], ['host' => 'ip']);

        return !$urlValidator->fails() || !$ipValidator->fails();
    }

    public function message()
    {
        return __('validation.url_or_ip');
    }
}
