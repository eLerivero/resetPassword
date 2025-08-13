<?php

namespace App\Mail\Sinea;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UsersDuplicados extends Mailable
{
    use Queueable, SerializesModels;

    public $rif;
    public $correo;

    public function __construct($rif, $correo)
    {
        $this->rif = $rif;
        $this->correo = $correo;
    }

    public function build()
    {
        return $this->subject('Reporte de Duplicidad de Cédula')
            ->with([
                'rif' => $this->rif,
                'correo' => $this->correo
            ])
            ->view('mails.sinea.usersDuplicados');
    }
}
