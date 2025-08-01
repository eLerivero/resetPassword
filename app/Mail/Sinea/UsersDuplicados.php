<?php

namespace App\Mail\Sinea;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UsersDuplicados extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitante;

    public function __construct($solicitante)
    {
        $this->solicitante = $solicitante;
    }

    public function build()
    {
        return $this->subject('Verificación de Cédula Duplicada')
                    ->view('mails.sinea.usersDuplicados');
    }
}
