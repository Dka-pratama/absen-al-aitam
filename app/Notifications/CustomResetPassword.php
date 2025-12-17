<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class CustomResetPassword extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    // ❌ jangan pakai mail channel
    public function via(object $notifiable): array
    {
        return [];
    }

    // ✅ kita handle kirim manual
    public function send($notifiable): void
    {
        $url = url('/reset-password/' . $this->token . '?email=' . $notifiable->email);

        Http::withHeaders([
            'api-key' => env('BREVO_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name' => 'Absensi App',
                'email' => 'andikarama800@gmail.com',
            ],
            'to' => [['email' => $notifiable->email]],
            'subject' => 'Reset Password Absensi App',
            'htmlContent' => view('email.reset-password', [
                'url' => $url,
                'nama' => $notifiable->name,
            ])->render(),
        ]);
    }
}
