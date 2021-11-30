<?php

declare(strict_types=1);

namespace App\Modules\Invite\Rules;

use App\Modules\Invite\Models\Invite;
use Illuminate\Contracts\Validation\Rule;

class AcceptedTokenRule implements Rule
{
    public function passes($attribute, $value)
    {
        try {
            /** @var Invite $invite */
            $invite = Invite::where('token', $value)->firstOrFail();

            return !$invite->is_accepted;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function message()
    {
        return __('auth.invite_accepted');
    }
}
