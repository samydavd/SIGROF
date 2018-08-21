<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Contacto;


class ContactoController extends Controller 
{
	public function actualizar(Request $request){
		if($request->id_cliente){
		      $comp = Contacto::select('id_contacto', 'nombre_contacto')->where('cliente', $request->id_cliente)->where('tipo', 'CO')->get();
        	       $super = Contacto::select('id_contacto', 'nombre_contacto')->where('cliente', $request->id_cliente)->where('tipo', 'SU')->get();
        	       $admin = Contacto::select('id_contacto', 'nombre_contacto')->where('cliente', $request->id_cliente)->where('tipo', 'AD')->get();
        	       return ['comp' => $comp, 'super' => $super, 'admin' => $admin];
        }
        else
        	return Contacto::where('cliente', $request->id_subcliente)->where('tipo', 'CO')->get();
	}

        public function correos(Request $request){
                $datos = Contacto::select('id_contacto', 'nombre_contacto', 'email_contacto')->where('cliente', $request->id_cliente)->get();
                return $datos;
        }

        public function comprador(Request $request){
                $datos = Contacto::select('id_contacto', 'nombre_contacto', 'email_contacto')->where('id_contacto', $request->comprador)->first();
                return $datos;
        }
}