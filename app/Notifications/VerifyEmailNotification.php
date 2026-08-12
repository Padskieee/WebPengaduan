<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends VerifyEmail
{
    /**
     * Override URL agar pakai route 'user.verification.verify'
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'user.verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id'   => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    /**
     * Override tampilan email dengan branding Ogek Wali
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        $nama = $notifiable->nama ?? 'Pengguna';

        return (new MailMessage)
            ->subject('Verifikasi Email Akun Ogek Wali')
            ->view('emails.verify-email', [
                'url'  => $verificationUrl,
                'nama' => $nama,
            ]);
    }
}
