<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Comentario;
use Session;


class ComentarioController extends Controller 
{
    public function comentarios_add(Request $request){
      $requisicion = $request->id_req;
  	  $alerta = (new AlertaController)->guardar($requisicion);
  	  
      return Comentario::guardar([
        'requerimiento' => $requisicion,
        'comentario' => $request->mensaje,
        'usuario' => session('id_usuario'), 
        'fcomentario' => 'now()'
      ]);    
    }
}