<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Departamento;
use App\Empresa;


class DepartamentoController extends Controller 
{
	public function departamentos() {
        return view('departamentos',['departamentos' => Departamento::join('empresas', 'departamentos.empresa','=','id_empresa')->select('id','nombre_dep', 'nombre_emp', 'tipo_dep', 'limitebs', 'limitedol')->where('activo_dep', '1')->orderBy('nombre_dep','ASC')->get()]);
        }

        public function departamentos_add($id = null){
        if($id){
            return view('departamento_add', ['empresas' => Empresa::where('activo', '1')->get()],
                                            ['datos' => Departamento::where('id', $id)->first()]);
        }
        else
            return view('departamento_add', ['empresas' => Empresa::where('activo', '1')->get()]);
        }

        public function departamentos_add_db(Request $request){
        $departamento = Departamento::updateOrCreate(['id' => $request->input("id_dep")],
            ['nombre_dep' => $request->input("nombre"), 
             'tipo_dep' => $request->input("tipo"),
             'siglas' => $request->input("siglas"),
             'empresa' => $request->input("empresa"),
             'limitebs' => $request->input("limitebs"),
             'limitedol' => $request->input("limitedol"),
             'activo_dep' => 1]);
        if($departamento){
            return Redirect::back()->with('data', 'success');
        }
        else
            return Redirect::back()->with('data', 'error');
        }

        public function actualizar(Request $request){
          $tipo = $request->tipo;
          if($tipo)
            return Departamento::select('id', 'nombre_dep')
                              ->where('empresa', $request->id_emp)
                              ->where('activo_dep', 1)
                              ->get();
          else
	          return Departamento::select('id', 'nombre_dep')
                              ->where('empresa', $request->id_emp)
                              ->where('activo_dep', 1)
                              ->whereIn('tipo_dep', ['SE', 'SU'])
                              ->get();
	    }

      public function eliminar(Request $request){
         return Departamento::destroy($request->id_dep);
      }

      public function limites(Request $request){
        $id_dep = $request->id_dep;
        return Departamento::limites($id_dep);
      }
}