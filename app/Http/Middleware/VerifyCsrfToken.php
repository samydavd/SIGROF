<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = ['alertas', 'notificaciones', 'asignar', 'procesar', 'cotizar', 'datos_mas_informacion', 'respuesta_recibida_db', 'comprador', 'enviar_solicitud', 'departamento_limite'
        //
    ];
}
