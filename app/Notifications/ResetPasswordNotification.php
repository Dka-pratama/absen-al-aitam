<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $url = url('/reset-password/' . $this->token . '?email=' . $notifiable->email);

        return (new MailMessage())->subject('Reset Password Akun Absensi')->view('email.reset-password', [
            'url' => $url,
            'nama' => $notifiable->name,
        ]);
    }
}
