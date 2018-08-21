<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Alerta;
use App\Analista;
use App\Asignacione;
use App\Usuario;
use App\Novedade;
use App\Requerimiento;

class AlertaController extends Controller 
{
    public function cargar(Request $request){
      $id_usuario = $request->id_usuario;

      $al = new Alerta();
      $req = new requerimiento();
      $usu = new usuario();

      $alertas = $al->cargar($id_usuario);
      return $alertas;
    }

    public function guardar($requisicion){
      $encargado = Requerimiento::encargado($requisicion);
      $analistas = Analista::datos($requisicion);
      $asignaciones = Asignacione::especifico($requisicion);

        foreach($asignaciones as $as){
            if($as->tipo == 'P')
                $dep1 = $as;
            else
                $dep2 = $as;
        }

      $gerente1 = Usuario::gerente($dep1->id);

      if(isset($dep2)){
      	$gerente2 = Usuario::gerente($dep2->id);
      	$id_ge2 = $gerente2->id_usuario;
      } 
      else
      	$id_ge2 = 0;
        

      if(session('id_usuario') != $encargado->encargados)
      	$alerta = Alerta::guardar([
      	'requerimiento' => $requisicion,
  	  	'usuario_emisor' => session('id_usuario'), 
  	  	'usuario_destino' => $encargado->encargados,
  	  	'tipo' => 'C']);

      if(session('id_usuario') != $gerente1->id_usuario)
  	  	$alerta = Alerta::guardar([
      	'requerimiento' => $requisicion,
  	  	'usuario_emisor' => session('id_usuario'), 
  	  	'usuario_destino' => $gerente1->id_usuario,
  	  	'tipo' => 'C']);

  	  if(isset($gerente2))
  	  	if(session('id_usuario') != $gerente2->id_usuario)
  	  		$alerta = Alerta::guardar([
      		'requerimiento' => $requisicion,
  	  		'usuario_emisor' => session('id_usuario'), 
  	  		'usuario_destino' => $gerente2->id_usuario,
  	  		'tipo' => 'C']);

  	  foreach($analistas as $as){
  	  	if(session('id_usuario') != $as->id_analista && $gerente1->id_usuario != $as->id_analista && $id_ge2 != $as->id_analista)
  	  		$alerta = Alerta::guardar([
  	  		'requerimiento' => $requisicion,
  	  		'usuario_emisor' => session('id_usuario'), 
  	  		'usuario_destino' => $as->id_analista,
  	  		'tipo' => 'C']);
  	  }
    }
}