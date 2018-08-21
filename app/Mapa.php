<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mapa extends Model
{
    public $timestamps = false;
    
    protected $fillable = array('nombre_mapa', 'solicitudes', 'ordenes','nde','facturacion','clientes','empresas','departamentos','usuarios','feriados','consultas');

    public static function guardar(array $regla, array $opcional = [], array $datos = []){
    	if($opcional['nombre_mapa']){
    		/*$datos = array_push($datos, $opcional);
    		var_dump($datos);
    		echo $dqdwq;*/
            //dd($datos);
            $datos['nombre_mapa'] = $opcional['nombre_mapa'];
			return Mapa::updateOrCreate($regla, $datos)->id;
    	}
		else
			return Mapa::updateOrCreate($regla, $datos)->id;

	}

    public static function datos(){
        return Mapa::select('id', 'nombre_mapa')->get();
    }

    public static function especifico($id){
        return Mapa::find($id);
    }
}
