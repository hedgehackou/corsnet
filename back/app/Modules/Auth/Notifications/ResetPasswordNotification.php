<?php

declare(strict_types=1);

namespace App\Modules\Auth\Notifications;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  User  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        if (static::$createUrlCallback) {
            $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        } else {
            $url = rtrim(env('APP_URL'), '/') . route('password.reset', [
                    'lang' => app()->getLocale(),
                    'token' => $this->token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ], false);
        }

        return $this->buildMailMessage($url);
    }
}
