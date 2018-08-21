<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnvioInformacion;
use App\Http\Requests;
use App\Asignacione;
use App\Contacto;
use App\Consulta;
use App\Requerimiento;
use App\Novedade;
use App\Comentario;
use Config;


class ConsultaController extends Controller 
{
	public function mas_informacion(Request $request){
        $requisicion = $request->id_req;
        $estado = Requerimiento::cambiar_estado($requisicion, 'SMI');
        $consulta = Consulta::guardar([
            'duda' => $request->obs, 
            'requerimiento' => $requisicion, 
            'usuario' => session('id_usuario'), 
            'enviada' => 0,
            'fregistro' => 'now()'
        ])->id_consulta;
        $novedad = Novedade::create([
            'requerimiento' => $requisicion,
            'novedad' => 'Aclaratoria solicitada al cliente',
            'req_estatus' => 'SMI',
            'usuario' => session('id_usuario'),
            'fnovedad' => 'now()'
        ])->id_novedad;
        if($request->obs)
            $comentario = Comentario::guardar([
                'requerimiento' => $requisicion,
                'comentario' => $request->obs,
                'usuario' => session('id_usuario'), 
                'fcomentario' => 'now()'
            ]);
        if($estado)    
            return Redirect::back()->with('data', 'Solicitud para mas información ha sido efectuada exitosamente');
        else
            return Redirect::back()->with('data', 'error');
    }

    public function listado_mas_informacion(){
        $informacion = Requerimiento::solicitudes_mas_informacion('SMI');
        $consulta = Consulta::listado($informacion, 0);
        $datos = Asignacione::buscar($consulta);

        return view('solicitud_informacion',['datos' => $datos]);
    }

    public function datos_mas_informacion(Request $request){
        $requisicion = $request->id_req;
        $consulta = Consulta::where('enviada', 1)->whereNotExists(function($query)
                             {
                                $query->from('respuestas')
                                      ->whereRaw('id_consulta = consulta');
                             })
                            ->first();
        return $consulta;
    }


    public function enviar_solicitud(Request $request){
        $consulta = new Consulta();
        $requisicion = $request->id_requerimiento;
        $estatus = 'MIC';
        $asunto = $request->asunto;
        $contenido = $request->contenido;
        $enviado = $consulta->actualizar($requisicion, 1);
        Config::set('mail.username', 'samydavd@gmail.com');
        Config::set('mail.password', 'kiwpflyxrrmwfznu');

        /*$config = array(
                    'driver'     => $mail->driver,
                    'host'       => $mail->host,
                    'port'       => $mail->port,
                    'from'       => array('address' => $mail->from_address, 'name' => $mail->from_name),
                    'encryption' => $mail->encryption,
                    'username'   => $mail->username,
                    'password'   => $mail->password,
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                );
                Config::set('mail', $config);
        dd(Config::get('mail'));
        //echo storage_path()\;
        
        $email = Mail::to($request->destino)->send(new EnvioInformacion($asunto, $contenido)); // Deshabilitado envio de emails

        */

        $novedad = Novedade::create([
            'requerimiento' => $requisicion,
            'novedad' => "Solicitud para más información del requerimiento #". $requisicion. " ha sido enviada por " . session('nombre'),
            'req_estatus' => $estatus,
            'usuario' => session('id_usuario'),
            'fnovedad' => 'now()'
        ])->id_novedad;

        $estado = Requerimiento::cambiar_estado($requisicion, $estatus);

        if($estado) // Definir condicion si el envio del mensaje fue correcto
            return 1; 
    }
}