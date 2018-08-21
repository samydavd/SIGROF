<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Nivele;
use App\Mapa;
use Session;


class NivelController extends Controller 
{

    public function niveles(){
      $datos = Nivele::listado();
      return view('niveles', ['datos' => $datos]); 
    }

    public function niveles_add($id = null){
      if($id){
        $nivel = Nivele::especifico($id);
        $mapas = Mapa::datos();
        return view('niveles_add', ['nivel' => $nivel, 'mapas' => $mapas]);
      }

      else{
        $mapas = Mapa::datos();
        return view('niveles_add', ['mapas' => $mapas]);
      } 
    }

     public function niveles_add_db(Request $request){
      $nivel = Nivele::guardar(['id_nivel' => $request->id_nivel],
        ['nombre_nivel' => $request->nombre,
        'mapa_acceso' => $request->mapa]);
      if($nivel){
        if($request->id_nivel)
          return Redirect::back()->with('data', 'El nivel usuario ha sido actualizado exitosamente'); 
        else
          return Redirect::back()->with('data', 'El nivel usuario ha sido creado exitosamente'); 
      }
      else
        return Redirect::back()->with('data', 'error');
    }
}