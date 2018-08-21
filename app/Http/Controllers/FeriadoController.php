<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Feriado;


class FeriadoController extends Controller 
{
    public function feriados(){
       return view('feriados', ['feriados' => Feriado::all()]);	         
    }

    public function feriados_add($id = null){
       	if($id)
       		return view('feriados_add', ['datos' => Feriado::datos($id)]);
       	else
       		return view('feriados_add');	         
    }

    public function feriados_add_db(Request $request){
       	$feriado = Feriado::guardar(['id_feriado' => $request->id_feriado],
       	['descripcion' => $request->descripcion,
       	 'fecha' => $request->fecha,
       	 'repeticion' => $request->repeticion]);

       	if($feriado){
       		if($request->id_feriado)
       			return Redirect('feriados')->with('data', 'success');   
       		else
       			return Redirect('feriados_add')->with('data', 'success');
       	} else {
       		if($request->id_feriado)
       			return Redirect('feriados')->with('data', 'error');   
       		else
       			return Redirect('feriados_add')->with('data', 'error');
       	}
    }

    public function eliminar(Request $request){
       return Feriado::destroy($request->id_feriado);
    }
}