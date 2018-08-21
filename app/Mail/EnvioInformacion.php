<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnvioInformacion extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $asunto;
    private $contenido;

    public function __construct($asunto, $contenido = null)
    {
        $this->asunto = $asunto;
        $this->contenido = $contenido;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(session('usuario').'@gmail.com', session('nombre'))->subject($this->asunto)->view('enviar_correo', ['contenido' => $this->contenido]);
    }
}
