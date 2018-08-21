<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Usuario;
use App\Departamento;
use App\Mapa;
use App\Empresa;
use Auth;
use Session;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Verificamos si hay sesión activa
        if (session("usuario"))
        {
            //return Redirect::to('iniciar');
            return Redirect('principal');
            //flush(session());
            //dump(Session::all());
            //session(['nombre' => null]);
            
        }
        //echo session("nombre");
        //dump(Session::all());
        return view('login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function iniciar()
    {
        return "Entrando";
    }

    public function validar_sesion(Request $request){
        $usu = new Usuario();
        $verificar = $usu->existe($request->usuario);

        if(count($verificar)){
            if($verificar->clave == null) $usu->clave($request->usuario, md5($request->clave));
            $usuario = $usu->verificar_datos($request->usuario, md5($request->clave));
        }
        else
            $usuario = null;

        if(count($usuario)){
            //setlocale(LC_TIME, 'es_VE'); # Localiza en español es_Venezuela
            //date_default_timezone_set('America/Caracas');

            $departamento = Departamento::find($usuario->departamento);
            $empresa = Empresa::find($departamento->empresa);

            if(isset($departamento)){
                $id_dep = $departamento->id;
                $nombre_dep = $departamento->nombre_dep;
                $tipo_dep = $departamento->tipo_dep;
            }
            else {
                $id_dep = -1;
                $nombre_dep = null;
                $tipo_dep = 'NA';
            }

            $mapa = Mapa::especifico($usuario['mapa_acceso']);

            session(['id_usuario' => $usuario->id_usuario,
                     'nombre' => $usuario->nombre,
                     'iniciales' => $usuario->iniciales,
                     'usuario' => $usuario->usuario,
                     'nivel' => $usuario->nivel,
                     'correo' => $usuario->correo,
                     'empresa' => $empresa->id_empresa,
                     'id_dep' => $id_dep,
                     'departamento' => $nombre_dep,
                     'tipo_dep' => $tipo_dep,
                    //['mapa_acceso' => $usuario->mapa_acceso],
                     'clave' => $usuario->clave,
                     'acceso' => $mapa]);
                    //['preferencias' => $usuario->preferencias]
            session::save();
            return Redirect()->route('/');
        }
        else
            return Redirect::back()->with('data', 'Invalid data');
    }


    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cerrar_sesion(){
        Session::flush();
        return Redirect()->route('/');
    }
}
