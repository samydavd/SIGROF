<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Requerimiento;
use App\Asignacione;
use Auth;
use Session;

class PrincipalController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    public function index()
    {
        if (session("usuario")){
            return view('principal'); 
        }
        return view('login');
    }

    public function cerrar_sesion(){
        Session::flush();
        return Redirect()->route('/');
    }

    public function principal(){ //Falta GG
        if((session('nivel') == 7 || session('nivel') == 6) && session('tipo_dep') != 'CA'){
            $requerimientos = Requerimiento::estadisticas(session('id_dep'), session('nivel'));
            return view('principal', ['req' => $requerimientos]);
        }
        else{
            $requerimientos = Requerimiento::estadisticas(session('id_dep'), session('nivel'), session('empresa'));
            return view('principal', ['req' => $requerimientos]);
        }
    }
}
