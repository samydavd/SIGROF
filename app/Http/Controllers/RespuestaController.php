<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Consulta;
use App\Requerimiento;
use App\Novedade;
use App\Comentario;
use App\Respuesta;
use App\Asignacione;

class RespuestaController extends Controller 
{
	public function respuesta_db(Request $request){
        $id_consulta = $request->id_consulta;
        $requisicion = $request->id_req;
        $respuesta = Respuesta::guardar([
            'respuesta' => $request->res, 
            'consulta' => $id_consulta, 
            'usuario' => session('id_usuario'), 
            'recibido' => 0,
            'fregistro' => 'now()'
        ])->id_respuesta;

        $novedad = Novedade::create([
            'requerimiento' => $requisicion,
            'novedad' => session('nombre'). " ha registrado la respuesta a la solicitud de aclaratoria del requerimiento #".$requisicion,
            'req_estatus' => 'MIR',
            'usuario' => session('id_usuario'),
            'fnovedad' => 'now()'
        ])->id_novedad;

        if($request->res)
            $comentario = Comentario::guardar([
                'seguimiento' => $novedad,
                'comentario' => $request->res,
                'usuario' => session('id_usuario'), 
                'fcomentario' => 'now()'
            ]);

        $estado = Requerimiento::cambiar_estado($requisicion, 'MIR');

        if($respuesta)    
            return Redirect::back()->with('data', 'La respuesta otorgada por el cliente ha sido registrada exitosamente');
        else
            return Redirect::back()->with('data', 'error');
    }

    public function listado_respuestas(){
        $informacion = Requerimiento::solicitudes_mas_informacion('MIR');
        $consulta = Consulta::listado($informacion, 1);
        $respuesta = Respuesta::listado($consulta);
        $datos = Asignacione::buscar($informacion);

        return view('solicitud_respuesta',['datos' => $datos]);
    }

    /*public function datos_mas_informacion(Request $request){
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

        /*return Mail::send('emails.reminder', function ($m) {
            $m->from('samydavd@gmail.com', 'Laravel');

            $m->to('samydavd@gmail.com', 'Samy')->subject('Your Reminder!');
        });*/
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
        
        $email = Mail::to($request->destino)->send(new EnvioInformacion($asunto, $contenido));

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
    }*/
}