<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use App\Requerimiento;
use App\Novedade;
use App\Comentario;
use App\Entrega;
use App\Asignacione;


class EntregaController extends Controller 
{
	public function registrar(Request $request){
        $requisicion = $request->id_req;
        $id_nde = $request->id_nde; 
        $estatus = $request->estatus;
        $tipo_nde = $request->tipo;

        $nde = Entrega::guardar([
        'id_nde' => $id_nde,
        'requerimiento' => $requisicion,
        'tipo' => $tipo_nde,
        'usuario' => session('id_usuario'),
        'fnde' => $request->fnde,
        'fregistro' => 'now()']);

        if($estatus == 'OEP' || $estatus == 'NEP' || $estatus == 'ENP'){ //Solo aplica cuando para requerimientos con
            if($estatus == 'OEP' && $tipo_nde == 'P') //ordenes en proceso y NDE o entregas parciales
                $estatus = 'NEP';
            else if($tipo_nde == 'T')
                $estatus = 'NET';
            $estado = Requerimiento::cambiar_estado($requisicion, $estatus);
        }

        $novedad = Novedade::create([
        'requerimiento' => $requisicion,
        'novedad' => 'Registrada NDE #'. $id_nde,
        'req_estatus' => $estatus,
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

        return $nde;        
    }

    public function modificar(Request $request){
    	$entrega = new Entrega();
    	$requisicion = $request->input('id_req');
        $id_nde = $request->input('id_nde'); 
        $estatus = $request->estatus;
        $fentrega = $request->fentrega;
        $lugar = $request->lugar;
        $tipo_nde = $request->tnde;

        if($request->hasFile('adjunto')){
            $file = $request->file('adjunto');
            $nombre = explode(".", $file->getClientOriginalName());
            $ext = end($nombre);
            $archivo = 'NDE'.$id_nde.'-'.$requisicion;
            if(Storage::exists('public/nde/'.$archivo.'.'.$ext)){
                $sig = 1;
                $archivo = 'NDE'.$id_nde.'-'.$requisicion.'-'.$sig;
                while (Storage::exists('public/nde/'.$archivo.'.'.$ext)){
                    $sig++;
                    $archivo = 'NDE'.$id_nde.'-'.$requisicion.'-'.$sig;
                } 
            }
            $archivo .= '.'.$ext;
            $file->storeAs('public/nde', $archivo);         
        } else
            $archivo = null;

        //if($lugar) // Buscar mejor método
        	$nde = $entrega->actualizar($id_nde, 
        	['lugar' => $lugar,
        	'fentrega' => $fentrega,
        	'adjunto' => $archivo]);
        //else

        if($estatus == 'NEP' || $estatus == 'NET'){ //Solo aplica cuando para requerimientos con
            if($tipo_nde == 'P') //NDE parciales o con NDE totales
                $estatus = 'ENP';
            else if($tipo_nde == 'T')
                $estatus = 'ENT';
            $estado = Requerimiento::cambiar_estado($requisicion, $estatus);
        }

        $novedad = Novedade::create([
        'requerimiento' => $requisicion,
        'novedad' => 'NDE #'. $id_nde .' marcada como entregada',
        'req_estatus' => $estatus,
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
        if($nde)
            return Redirect::back()->with('data', 'La nota de entrega #'. $id_nde .' del requerimiento #'.$requisicion.' ha sido modificada exitosamente');  
        else
            return Redirect::back()->with('data', 'error');  
    }

    public function por_facturar(){
        $requerimientos = Requerimiento::listado_general(1);
        $entregas = Entrega::listado_pendientes($requerimientos, 1);
        $datos = Asignacione::buscar($entregas);
        return view('entregas_por_facturar', ['datos' => $datos]);
       
    }

    public function pendientes(){
        $requerimientos = Requerimiento::listado_general(0); 
        $entregas = Entrega::listado_pendientes($requerimientos, 0);
        $datos = Asignacione::buscar($entregas);
        return view('entregas_por_entregar', ['datos' => $datos]);
    }

}