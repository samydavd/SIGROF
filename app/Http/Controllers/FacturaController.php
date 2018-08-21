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
use App\Factura;
use App\Ordene;


class FacturaController extends Controller 
{
	public function registrar(Request $request){
        $entrega = new Entrega();
        $orden = new Ordene();
        $requisicion = $request->id_req;
        $id_fac = $request->id_fac; 
        $estatus = $request->estatus;
        $nde = $request->notas_facturar;
        $moneda = $request->moneda;
        $monto = $request->monto;

        if($request->hasFile('adjunto')){
            $file = $request->file('adjunto');
            $nombre = explode(".", $file->getClientOriginalName());
            $ext = end($nombre);
            $archivo = 'FAC'.$id_fac.'-'.$requisicion;
            if(Storage::exists('public/facturas/'.$archivo.'.'.$ext)){
                $sig = 1;
                $archivo = 'FAC'.$id_fac.'-'.$requisicion.'-'.$sig;
                while (Storage::exists('public/facturas/'.$archivo.'.'.$ext)){
                    $sig++;
                    $archivo = 'FAC'.$id_fac.'-'.$requisicion.'-'.$sig;
                } 
            }
            $archivo .= '.'.$ext;
            $file->storeAs('public/facturas', $archivo);         
        } else
            $archivo = null;

        $factura = Factura::guardar([
        'nfactura' => $id_fac,
        'requerimiento' => $requisicion,
        'adjunto' => $archivo,
        'monto' => $monto,
        'moneda' => $moneda,
        'usuario' => session('id_usuario'),
        'ndes' => implode(',', $nde),
        'ffactura' => $request->ffac,
        'fregistro' => 'now()']);

        $fnde = $entrega->facturar($nde, $factura);

        $nde_facturados = $entrega->facturado($requisicion);
        $nde_totales = $entrega->cantidad($requisicion);
        $cierre_orden = $orden->ver_cierre($requisicion);

        if($cierre_orden->cierre)
            $nde_total = true;
        else {
            $nde_total = false;
            foreach($nde_facturados as $nf) {
                if($nf->tipo == 'T'){
                    $nde_total = true;
                    break;
                }
            }
        }

        if(count($nde_facturados) == $nde_totales && $nde_total){ // Solo aplica si todas las notas de entrega han sido facturadas
            $estatus = 'FAC';                              // y si además una de esas NDE es de tipo Total.
            $tfactura = 'totalmente';
        }
        else{
            $estatus = 'FAP';
            $tfactura = 'parcialmente';
        }
        $estado = Requerimiento::cambiar_estado($requisicion, $estatus);

        $novedad = Novedade::create([
        'requerimiento' => $requisicion,
        'novedad' => 'Facturado '.$tfactura.' el requerimiento',
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

        if($factura)
            return Redirect::back()->with('data', 'La factura #'. $factura .' del requerimiento #'.$requisicion.' ha registrada exitosamente');  
        else
            return Redirect::back()->with('data', 'error');     
    }

    public function pagar(Request $request){
        $factura = new Factura();
        $requisicion = $request->id_req;
        $id_fac = $request->id_fac; 
        $estatus = $request->estatus;
        $cancelado = $request->cancelado;

        $factura->pagar($id_fac, $cancelado);

        $fac_pagos = $factura->total_pagado($requisicion);
        $fac_por_pagar = $factura->total_a_pagar($requisicion);

        if($fac_pagos == $fac_por_pagar && ($estatus == 'FAC' || $estatus == 'PAP')){ //Pendiente cambios de estatus
            $estatus = 'PAG';
            $tcancelado = 'total';
        }
        else{
            $estatus = 'PAP';
            $tcancelado = 'parcial';
        }

        $estado = Requerimiento::cambiar_estado($requisicion, $estatus);

        $novedad = Novedade::create([
            'requerimiento' => $requisicion,
            'novedad' => 'Pago '.$tcancelado.' de la factura #'. $id_fac,
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

        if($factura)
            return Redirect::back()->with('data', 'El pago de la factura #'. $id_fac .' del requerimiento #'.$requisicion.' ha sido registrada exitosamente');  
        else
            return Redirect::back()->with('data', 'error');

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
        'novedad' => session('nombre'). ' ha marcado como entregada la NDE #'. $id_nde .' del requerimiento #'. $requisicion, //REVISAR INCOHERENCIA
        'req_estatus' => $estatus,
        'usuario' => session('id_usuario'),
        'fnovedad' => 'now()'
        ])->id_novedad;

        if($request->obs)
            $comentario = Comentario::guardar([
            'seguimiento' => $novedad,
            'comentario' => $request->obs,
            'usuario' => session('id_usuario'), 
            'fcomentario' => 'now()'
        ]);
        if($nde)
            return Redirect::back()->with('data', 'La nota de entrega #'. $id_nde .' del requerimiento #'.$requisicion.' ha sido modificada exitosamente');  
        else
            return Redirect::back()->with('data', 'error');  
    }
}