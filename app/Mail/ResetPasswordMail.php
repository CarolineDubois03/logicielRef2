<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $resetUrl;

    public function __construct($user, $resetUrl)
    {
        $this->user = $user;
        $this->resetUrl = $resetUrl;
    }

    public function build()
    {
        return $this->subject('Réinitialisation de votre mot de passe')
            ->view('emails.reset-password')
            ->with([
                'user' => $this->user,
                'resetUrl' => $this->resetUrl
            ]);
    }
}
