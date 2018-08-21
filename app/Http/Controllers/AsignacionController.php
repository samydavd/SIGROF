<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Analista;
use App\Requerimiento;
use App\Novedade;
use App\Comentario;


class AsignacionController extends Controller 
{
    public function asignar(Request $request){

      $analista1 = explode(",", $request->analista1);
      if(isset($request->analista2))
        $analista2 = explode(",", $request->analista2);
      else 
        $analista2 = null;
      $requisicion = $request->input('id_requerimiento');
      $actualizar = Requerimiento::cambiar_estado($requisicion, 'SAA');

      if($request->analista1)
        $asignar = Analista::guardar([
         'id_analista' => $analista1[0],
         'requerimiento' => $requisicion, 
         'tipo' => 'P',
         'fasignacion' => 'NOW()'
        ]);

      if(isset($request->analista2))  
        $asignar = Analista::guardar([
         'id_analista' => $analista2[0],
         'requerimiento' => $requisicion, 
         'tipo' => 'S',
         'fasignacion' => 'NOW()'
        ]);

      if($analista1)
        $novedad = Novedade::create([
          'requerimiento' => $requisicion,
           'novedad' => "Asignado ". $analista1[1] ." como analista principal",
           'req_estatus' => 'SAA',
           'usuario' => session('id_usuario'),
           'fnovedad' => 'now()'
        ])->id_novedad;

      if($analista2)
        $novedad = Novedade::create([
           'requerimiento' => $requisicion,
           'novedad' => "Asignado ". $analista2[1] ." como analista de apoyo",
           'req_estatus' => 'SAA',
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

      if($asignar)
            return Redirect::back()->with('data', 'success'); 
        else
            return Redirect::back()->with('data', 'error'); 
    }
}