<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Mapa;


class MapaController extends Controller 
{
	  public function mapa_acceso(){
        return view('mapa_acceso',['mapas' => Mapa::select('id','nombre_mapa')->orderBy('nombre_mapa', 'desc')->get()]);
    }

    public function mapa_acceso_add_db(Request $request){ 
        $modulos = ['sol' => null, 'ord' => null,'nde' => null,'fac' => null,'clt' => null,
                    'emp' => null,'dep' => null,'usu' => null,'fer' => null,'con' => null];

        $cantidad = ['sol' => 9, 'ord' => 3, 'nde' => 1,'fac' => 1,'clt' => 5,
                     'emp' => 3,'dep' => 3,'usu' => 3,'fer' => 3,'con' => 1];

        foreach(array_keys($modulos) as $mod){
            $i=0;
            for($i=0; $i<= $cantidad[$mod]; $i++){
                if($request->input($mod.$i) != '')
                    $modulos[$mod] .= '1;';
                else
                    $modulos[$mod] .= '0;';
            }
            $modulos[$mod] = substr($modulos[$mod], 0, -1);        
        }
       
        $mapa = Mapa::guardar(['id' => $request->input('mapa_acceso')],
                              ['nombre_mapa' => $request->input('nombre')],
                              ['solicitudes' => $modulos['sol'],
                               'ordenes' => $modulos['ord'],
                               'nde' => $modulos['nde'],
                               'facturacion' => $modulos['fac'],
                               'clientes' => $modulos['clt'],
                               'empresas' => $modulos['emp'],
                               'departamentos' => $modulos['dep'],
                               'usuarios' => $modulos['usu'],
                               'feriados' => $modulos['fer'],
                               'consultas' => $modulos['con']]);

        if($mapa)
            return Redirect::back()->with('data', 'success');
        else
            return Redirect::back()->with('data', 'error');
    }

    public function actualizar(Request $request){ 
        $mapa = Mapa::where('id', $request->mapa)->first();
        return ['mapa' => $mapa];
    }

    public function eliminar(Request $request){
        return Mapa::destroy($request->id_mapa);
    }
}