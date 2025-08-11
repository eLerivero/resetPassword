<?php

namespace App\Mail\Sinea;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UsersDuplicados extends Mailable
{
    use Queueable, SerializesModels;

    public $cedula;
    public $correo;

    public function __construct($cedula, $correo)
    {
        $this->cedula = $cedula;
        $this->correo = $correo;
    }

    public function build()
    {
        return $this->subject('Verificación de Cédula Duplicada')
            ->with([
                'cedula' => $this->cedula,
                'correo' => $this->correo
            ])
            ->view('mails.sinea.usersDuplicados');
    }
}
