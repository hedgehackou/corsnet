<?php

declare(strict_types=1);

namespace App\Modules\Installation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueEmailRule implements Rule
{
    /**
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        try {
            DB::connection()->getPdo();
            return !DB::connection()->table('users')->where('email', $value)->exists();
        } catch (\Exception $exception) {
            return true;
        }
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('validation.unique');
    }
}
