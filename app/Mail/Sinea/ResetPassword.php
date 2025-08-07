<?php

namespace App\Mail\Sinea;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $newPassword;
    public $login;

    public function __construct($newPassword, $login)
    {
        $this->newPassword = $newPassword;
        $this->login = $login;
    }

    public function build()
    {
        return $this->view('mails.sinea.ResetPassword')
        ->subject('Reestablecimiento de contraseña SINEA')
            ->with([
                'newPassword' => $this->newPassword,
                'login' => $this->login,
            ]);
    }
}
