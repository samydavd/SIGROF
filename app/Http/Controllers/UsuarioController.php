<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Departamento;
use App\Empresa;
use App\Mapa;
use App\Usuario;
use App\Nivele;
use Session;

class UsuarioController extends Controller 
{
	public function usuarios(){
        return view('usuarios',['usuarios' => Usuario::listado()]);
    }

    public function usuarios_add($id = null){
        $empresas = Empresa::where('activo', '1')->get();
        $niveles = Nivele::buscar();
        if($id){
            $datos = Usuario::datos($id);
            $mapas = Mapa::select('id','nombre_mapa')->get();
            $departamentos = Departamento::where('activo_dep', '1')->where('empresa', $datos->id_empresa)->get();
            $niveles = Nivele::buscar();
            $data = compact('datos', 'departamentos', 'empresas', 'mapas', 'niveles');

            return view('usuarios_add', $data);
        }
        else{
            $data = compact('empresas', 'niveles');
            return view('usuarios_add', $data);
        }
    }

    public function usuarios_add_db(Request $request){
        $nombre = ucwords(strtolower($request->input("nombre")));
        $iniciales = "";
        
        for($i=0; $i<strlen($nombre); $i++){
            if(ctype_upper($nombre[$i])){
                $iniciales .= $nombre[$i];
            }
        }

        if(!$request->mapa){
            $mapa = Nivele::especifico($request->input("nivel"));
            $mapa = $mapa['mapa_acceso'];
        }
        else
            $mapa = $request->input("mapa");

        //dd($request->all());

         $usuario = Usuario::guardar(['id_usuario' => $request->input("id_usuario")],
            ['nombre' => $nombre,
             'iniciales' => $iniciales,
             'nivel' => $request->input("nivel"),
             'correo' => $request->input("correo"),
             'usuario' => trim($request->input("usuario")),
             'departamento' => $request->input("departamento"),
             'activo' => 1,
             'mapa_acceso' => $mapa]);
        
        if($usuario)
            return Redirect('usuarios')->with('data', 'success');
        else
            return Redirect::back()->with('data', 'error');
    }

    public function eliminar(Request $request){
        return Usuario::destroy($request->id_usuario);
    }

    public function lista_analistas(Request $request){
        return Usuario::analistas(session('id_dep'));
    }
}