<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Empresa;


class EmpresaController extends Controller 
{
	public function empresas() {
        return view('empresas',['empresas' => Empresa::where('activo', '1')->get()]);
    }

    public function empresas_add($id = null){
        if($id)
            return view('empresas_add', ['datos' => Empresa::where('id_empresa', $id)->first()]);
        else
            return view('empresas_add');
    }

    public function empresas_add_db(Request $request) {
        $empresa = Empresa::updateOrCreate(['id_empresa' => $request->input("id_empresa")],
                                           ['nombre_emp' => strtoupper($request->input("nombre")), 
                                            'tipo' => $request->input("tipo"),
                                            'ubicacion' => ucwords(strtolower($request->input("ubicacion"))),
                                            'telefono' => $request->input("telefono"),
                                            'cod_telf' => $request->input("cod"),
                                            'activo' => 1]);
        if($empresa)
            return Redirect::back()->with('data', 'success');
        else
            return Redirect::back()->with('data', 'error');
    }

    public function eliminar(Request $request){
        return Empresa::destroy($request->id_empresa);
    }


}