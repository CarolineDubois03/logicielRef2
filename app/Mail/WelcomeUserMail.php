<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $temporaryPassword;

    public function __construct($user, $temporaryPassword)
    {
        $this->user = $user;
        $this->temporaryPassword = $temporaryPassword;
    }

    public function build()
    {
        return $this->subject('Bienvenue sur la plateforme')
            ->view('emails.welcome-user')
            ->with([
                'user' => $this->user,
                'temporaryPassword' => $this->temporaryPassword
            ]);
    }
}
