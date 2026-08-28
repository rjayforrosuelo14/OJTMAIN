<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends ResetPasswordNotification
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return (new MailMessage)
            ->subject('Reset Password - OJT Management System')
            ->greeting('Hello!')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->line('This password reset link will expire in 60 minutes.')
            ->action('Reset Password', url(config('app.url') . route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false)))
            ->line('If you did not request a password reset, no further action is required.')
            ->line('For security reasons, this link can only be used once.')
            ->salutation('Best regards, OJT Management System Team');
    }
}
