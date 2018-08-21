<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Session;

class EnvioCotizacion extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $asunto;
    private $contenido;
    private $cotizacion;

    public function __construct($asunto, $contenido, $cotizacion)
    {
        $this->asunto = $asunto;
        $this->contenido = $contenido;
        $this->cotizacion = asset('storage/cotizaciones/'.$cotizacion);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->attach($this->cotizacion)->from(session('usuario').'@gmail.com', session('nombre'))->subject($this->asunto)->view('enviar_correo', ['contenido' => $this->contenido]);
    }
}
