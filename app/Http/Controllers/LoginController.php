<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Usuario;
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
            Session::flush();
            dump(Session::all());
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
    public function create()
    {
        return "Entrando";
    }

    public function validar_sesion(Request $request){
        //dd($request->all());

        $usuario = Usuario::where('usuario', $request->input("usuario"))
                          ->where('clave', md5($request->input("clave")))
                          ->where('activo', 1)->first();

        if(count($usuario)){
            session(['id_usuario' => $usuario->id_usuario,
                     'nombre' => $usuario->nombre,
                     'iniciales' => $usuario->iniciales,
                     'usuario' => $usuario->usuario,
                     'nivel' => $usuario->nivel,
                     'empresa' => $usuario->empresa,
                     'departamento' => $usuario->departamento,
                    //['mapa_acceso' => $usuario->mapa_acceso],
                     'clave' => $usuario->clave]);
                    //['preferencias' => $usuario->preferencias]
            dump(Session::all());

            echo "bienvenido";
            session::save();
        }
        else
            return Redirect::back()->with('data', 'Invalid data');
        //echo $request->input("nombre");
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
}
