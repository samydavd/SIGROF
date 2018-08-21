<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    public $timestamps = false;
	protected $fillable = array('consulta', 'respuesta', 'usuario', 'recibido', 'fregistro');
	protected $primaryKey = 'id_respuesta';
	public $incrementing = true;

	public static function informacion_solicitada(){
		Return Consulta::where('enviada', 0)->count();
	}

	public static function guardar(array $datos){
		return Respuesta::create($datos);
	}

	public static function listado($datos){
		for($i=0; $i<count($datos); $i++){
			$respuesta = Respuesta::select('id_respuesta', 'respuesta')
							    ->where('consulta', $datos[$i]->id_consulta)
							    ->where('recibido', 0)
							    ->first();
			$datos[$i]->respuesta = $respuesta->respuesta; //Revisar
		}
		return $datos;
	}

	public static function pendientes($id_dep){ //Optimizar
		return Respuesta::join('consultas', 'id_consulta', '=', 'consulta')
						->join('requerimientos', 'id_requerimiento', '=', 'consultas.requerimiento')
						->join('asignaciones', 'asignaciones.requerimiento', '=', 'id_requerimiento')
						->where('id_departamento', $id_dep)
						->where('recibido', 0)
						->count();
	}
}
