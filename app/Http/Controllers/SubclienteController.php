<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Cliente;
use App\Subcliente;
use App\Contacto;
use App\Usuario;

class SubclienteController extends Controller
{
	public function subclientes(){
        $subclientes = Subcliente::listado();
        $datos = Contacto::buscar($subclientes);
        return view('subclientes', ['subclientes' => $datos]);
    }

    public function subclientes_add($id = null, $id_sub = null){
        $mercadeo = Usuario::mercadeo();
        if($id_sub){
            $datos = Cliente::datos($id);
            $datos_sub = Subcliente::datos($id_sub);
            return view('subclientes_add', ['datos' => $datos, 'mercadeo' => $mercadeo, 'datos_sub' => $datos_sub]);
        } else if($id){
            $datos = Cliente::datos($id);
            if(session('herencia')){
                return view('subclientes_add', ['herencia' => true, 
                                                'datos' => $datos,
                                                'mercadeo' => $mercadeo,
                                                'data' => 'success']);
            }
            else
                return view('subclientes_add', ['datos' => $datos,
                                                'mercadeo' => $mercadeo,
                                                'data' => 'success']);
        } else{
            $clientes = Cliente::listado2();
            return view('subclientes_add', ['clientes' => $clientes,
                                            'mercadeo' => $mercadeo]);
        }
    }

    public function subclientes_add_db(Request $request){
         if(isset($request->cliente))
            $cliente = $request->cliente;
        else
            $cliente = $request->id_cliente;
        
        if($request->input('comp') == '0'){
            $comp = Contacto::create([
            'cliente' => $cliente,
            'nombre_contacto' => $request->input('nombre_comp'),
            'telf_contacto' => $request->input('telf_comp'),
            'email_contacto' => $request->input('email_comp'),
            'tipo' => 'CO'])->id_contacto;
        } else
            $comp = $request->input('comp');

        if($request->input('admin') == '0'){
            $admin = Contacto::create([
            'cliente' => $cliente,
            'nombre_contacto' => $request->input('nombre_admin'),
            'telf_contacto' => $request->input('telf_admin'),
            'email_contacto' => $request->input('email_admin'),
            'tipo' => 'AD'])->id_contacto;
        } else
            $admin = $request->input('admin');

        if($request->input('super') == '0'){
            $super = Contacto::create([
            'cliente' => $cliente,
            'nombre_contacto' => $request->input('nombre_super'),
            'telf_contacto' => $request->input('telf_super'),
            'email_contacto' => $request->input('email_super'),
            'tipo' => 'SU'])->id_contacto;
        } else
            $super = $request->input('super');

       

        $subcliente = Subcliente::guardar(['id_subcliente' => $request->input('id_subcliente')],
            ['cliente' => $cliente,
             'nombre_sub' => $request->input('nombre'),
             'telf_sub' => $request->input('telf'),
             'email_sub' => $request->input('email'),
             'tipo' => $request->input('tipo'),
             'encargados' => $request->input('encargado'),
             'encargado' => $request->input('encargado'),
             'super' => $super,
             'comp' => $comp, 
             'admin' => $admin,
             'fregistro' => 'now()',
             'activo' => 1,
             'imo' => $request->input('imo')]);

        if($subcliente){
            return  Redirect::back()->with('data', 'success');
        }
        else{
            return Redirect::back()->with('data', 'error');
        }
    }

    public function actualizar(Request $request){
        if (isset($request->tipo)){
            $comp = Contacto::select('id_contacto', 'nombre_contacto')->where('cliente', $request->id_cliente)->where('tipo', 'CO')->get();
            $super = Contacto::select('id_contacto', 'nombre_contacto')->where('cliente', $request->id_cliente)->where('tipo', 'SU')->get();
            $admin = Contacto::select('id_contacto', 'nombre_contacto')->where('cliente', $request->id_cliente)->where('tipo', 'AD')->get();
            return ['comp' => $comp, 'super' => $super, 'admin' => $admin];
        }
        
        return Subcliente::select('id_subcliente', 'nombre_sub')->where('cliente', $request->id_cliente)->get();
    }

    public function eliminar(Request $request){
        return Subcliente::destroy($request->id_subcliente);
    }
}