<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use App\Requerimiento;
use App\Novedade;
use App\Comentario;
use App\Factura;
use App\Pago;


class PagoController extends Controller 
{

    public function pagar(Request $request){
        $pago = new Pago();
        $factura = new Factura();
        $requisicion = $request->id_req;
        $id_fac = $request->id_fac; 
        $estatus = $request->estatus;
        $cancelado = $request->cancelado;

        $pago->pagar([
         'id_factura' => $id_fac, 
         'monto' => $cancelado,
         'fpago' => 'now()'
        ]);

        $fac_pagos = $pago->total_pagado($requisicion);

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
        'novedad' => session('nombre'). ' ha registrado un pago '.$tcancelado.' del requerimiento #'. $requisicion,
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
}