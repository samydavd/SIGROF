<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Cliente;
//use Auth;
//use Session;
//use Illuminate\Support\Facades\Storage;


class ClienteController extends Controller 
{

	public function clientes(){
        return view('clientes', ['clientes' => Cliente::orderBy('id_cliente')->get()]);
    }

    public function clientes_add($id = null){
        if($id){
            $datos = Cliente::datos($id);
            return view('clientes_add', ['datos' => $datos]);
        }
        else
            return view('clientes_add');
    }

    public function clientes_add_db(Request $request){
        $rif = $request->input('t_rif') . '-' .$request->input('rif');

        /*echo $request->input('herencia');
        echo $daondqwo;*/


        $cliente = Cliente::guardar(['id_cliente' => $request->input('id_cliente')],
            ['nombre_cliente' => $request->input('nombre'),
             'rif' => $rif,
             'pais' => $request->input('pais'),
             'huso' => $request->input('huso'),
             'medio' => $request->input('medio'),
             'detalles' => $request->input('detalles'),
             'direccion' => $request->input('direccion'),
             'fregistro' => 'now()']);


        if($cliente){
            if($request->input('id_cliente')){
                return Redirect::back()->with('data', 'success');
            }
            else{
                //$datos_cliente = ['id_cliente' => $cliente, 'nombre_cliente' => $request->input('nombre')];
                return redirect('subclientes_add/'. $cliente); //->with('herencia', $request->input('herencia'));    //Revisar herencia
            }
            
                //, ['data' => 'success', 'cliente' => $cliente]);
        }
        else{
            return Redirect::back()->with('data', 'error');
        }
    }

    public function actualizar(){
       
    }

    public function eliminar(Request $request){
        return Cliente::destroy($request->id_cliente);
    }



}
