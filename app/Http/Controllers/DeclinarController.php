<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;

use App\Asignacione;
use App\Comentario;
use App\Declinada;
use App\Novedade;
use App\Requerimiento;
use Auth;
use Session;

class DeclinarController extends Controller
{

    public function requerimiento_declinar(Request $request){
        $requisicion = $request->id_req;

        $declinada = Declinada::create([
            'razon' => $request->razon,
            'observacion' => $request->obs,
            'confirmacion' => 0, 
            'requerimiento' => $requisicion,
            'usuario' => session('id_usuario')
        ]);
        $novedad = Novedade::create([
            'requerimiento' => $requisicion,
            'novedad' => "Requerimiento declinado",
            'req_estatus' => 'SDE',
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
        $estado = Requerimiento::cambiar_estado($requisicion, 'SDE');
        if($estado)
            return Redirect::back()->with('data', 'El requerimiento #'.$requisicion.' ha sido declinado exitosamente');
        else
            return Redirect::back()->with('data', 'error');   
    }

    public function declinadas(){
        $declinadas = Declinada::listado();
        $drequerimiento = Requerimiento::solicitudes_declinadas($declinadas);
        $datos = Asignacione::buscar($drequerimiento);
        //dd($datos);
        return view('declinadas', ['datos' => $datos]);
    }

    public function confirmar(Request $request){
        $requisicion = $request->id_req;
        $id_declinada = $request->id_dec;
        $declinada = new Declinada();

        $confirmar = $declinada->confirmacion($id_declinada);

        if($confirmar)
            $novedad = Novedade::create([
                'requerimiento' => $requisicion,
                'novedad' => "Declinación confirmada",
                'req_estatus' => 'SDE',
                'usuario' => session('id_usuario'),
                'fnovedad' => 'now()'
            ])->id_novedad;

        return $confirmar;
    }

    public function reactivar(Request $request){ //Al reactivar siempre cae en proceso (problema)
        $requisicion = $request->id_req;
        $id_declinada = $request->id_dec;
        $declinada = new Declinada();

        $reactivar = $declinada->reactivacion($id_declinada);

        if($reactivar){
            $estado = Requerimiento::cambiar_estado($requisicion, 'SEP');
            $novedad = Novedade::create([
                'requerimiento' => $requisicion,
                'novedad' => "Requerimiento reactivado"),
                'req_estatus' => 'SEP',
                'usuario' => session('id_usuario'),
                'fnovedad' => 'now()'
            ])->id_novedad;
        }

        return $reactivar;
    }
}