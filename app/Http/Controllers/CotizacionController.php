<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnvioCotizacion;
use App\Http\Requests;
use App\Requerimiento;
use App\Novedade;
use App\Comentario;
use App\Cotizacione;
use App\Asignacione;
use Config;

class CotizacionController extends Controller 
{
	public function cotizaciones(){
        $cotizaciones = Requerimiento::cotizaciones_listado();
        $datos = Asignacione::buscar($cotizaciones);
        return view('cotizaciones', ['datos' => $datos]);
    }

    public function cotizaciones_liberacion(){
        $cotizaciones = Requerimiento::cotizaciones_listado_liberacion();
        $datos = Asignacione::buscar($cotizaciones);
        return view('cotizaciones', ['datos' => $datos]);
    }

    public function cotizaciones_aprobadas(){
        $cotizaciones = Requerimiento::cotizaciones_listado_aprobadas();
        $datos = Asignacione::buscar($cotizaciones);
        return view('cotizaciones', ['datos' => $datos]);
    }

    public function cotizar(Request $request){
        $requisicion = $request->id_requerimiento;

        if($request->hasFile('file')){
            $file = $request->file('file'); 
            $nombre = explode(".", $file->getClientOriginalName());
            $ext = end($nombre);
            $archivo = 'CO'.$requisicion;
            if(Storage::exists('public/cotizaciones/'.$archivo.'.'.$ext)){
                $sig = 1;
                $archivo = 'CO'.$requisicion.'-'.$sig;
                while (Storage::exists('public/cotizaciones/'.$archivo.'.'.$ext)){
                    $sig++;
                    $archivo = 'CO'.$requisicion.'-'.$sig;
                }
            }
            $archivo .= '.'.$ext;
            $file->storeAs('public/cotizaciones', $archivo);            
        } else
            $archivo = null;

        $cotizacion = Cotizacione::guardar([
        'profit' => $request->profit,
        'cotizacion' => $archivo,
        'monto' => $request->monto,
        'moneda' => $request->moneda,
        'estado' => 'P',
        'factor' => $request->factor,
        'descuento' =>$request->descuento,
        'tercerizado' => $request->tercerizado,
        'validez' => $request->validez,
        'fcotizacion' => 'now()',
        'requerimiento' => $requisicion,
        'usuario' => session('id_usuario'),
        'ic' => $request->ic]);

        $novedad = Novedade::create([
            'requerimiento' => $requisicion,
            'novedad' => "Cotización cargada",
            'req_estatus' => 'COC',
            'usuario' => session('id_usuario'),
            'fnovedad' => 'now()'
        ])->id_novedad;

        if($request->obs){
            $comentario = Comentario::guardar([
                'seguimiento' => $novedad,
                'comentario' => $request->obs,
                'usuario' => session('id_usuario'), 
                'fcomentario' => 'now()'
            ]);    
            $alerta = (new AlertaController)->guardar($requisicion);
        }

        $estado = Requerimiento::cambiar_estado($requisicion, 'COC');

         if($cotizacion)
            return Redirect::back()->with('data', 'Cotización cargada exitosamente');
        else
            return Redirect::back()->with('data', 'error');
    }

    public function aprobacion(Request $request){
        $requisicion = $request->id_requerimiento;
        $cotizacion = $request->id_cot;
        $accion = $request->accion;
        $observacion = $request->obs;
        
        $cot_estado = Cotizacione::cambiar_estado($cotizacion, $accion);

        if($accion == 'B'){
            $estatus = 'CPA';
            $mensaje = "Pre-aprobada";
        }
        else if($accion == 'L'){
            $estatus = 'CPL';
            $mensaje = "Solicitada liberación de";
        }
        else if($accion == 'A'){
            $estatus = 'COA';
            $mensaje = "Aprobada";
        }
        else{
            $estatus = 'SEP';
            $mensaje = "Rechazada";
        }

        $novedad = Novedade::create([
            'requerimiento' => $requisicion,
            'novedad' => $mensaje. " la cotización cargada",
            'req_estatus' => $estatus,
            'usuario' => session('id_usuario'),
            'fnovedad' => 'now()'
        ])->id_novedad;

        if($observacion){ //RV
            $comentario = Comentario::guardar([
                'seguimiento' => $novedad,
                'comentario' => $observacion,
                'usuario' => session('id_usuario'), 
                'fcomentario' => 'now()'
            ]);    
            $alerta = (new AlertaController)->guardar($requisicion);
        }

        $estado = Requerimiento::cambiar_estado($requisicion, $estatus);

        if($estado)
            return 1;
        else
            return 0;
    }

    public function enviar(Request $request){
        $requisicion = $request->id_requerimiento;
        $estatus = 'CEC';
        $asunto = $request->asunto;
        $contenido = $request->contenido;
        $cotizacion = $request->cotizacion;
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
        dd(Config::get('mail'));*/
        //echo storage_path()\;
        
        //$email = Mail::to($request->destino)->send(new EnvioCotizacion($asunto, $contenido, $cotizacion)); //Deshabilitado envio de emails

        $novedad = Novedade::create([
            'requerimiento' => $requisicion,
            'novedad' => "Cotización enviada",
            'req_estatus' => $estatus,
            'usuario' => session('id_usuario'),
            'fnovedad' => 'now()'
        ])->id_novedad;

        $estado = Requerimiento::cambiar_estado($requisicion, $estatus);

        if($estado) // Definir condicion si el envio del mensaje fue correcto
            return 1; 
    }
}