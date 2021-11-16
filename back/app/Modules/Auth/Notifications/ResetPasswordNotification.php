<?php

declare(strict_types=1);

namespace App\Modules\Auth\Notifications;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

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
            $url = rtrim(env('FRONTEND_URL'), '/') . route('password.reset', [
                    'lang' => app()->getLocale(),
                    'token' => $this->token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ], false);
        }

        return $this->buildMailMessage($url);
    }

    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(__('mail.reset_password_notification'))
            ->line(__('mail.reason'))
            ->action(__('mail.reset_password'), $url)
            ->line(__('mail.password_will_expire', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(__('mail.mistake'));
    }
}
