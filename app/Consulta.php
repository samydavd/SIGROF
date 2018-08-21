<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    public $timestamps = false;
	protected $fillable = array('duda', 'requerimiento', 'usuario', 'enviada', 'fregistro');
	protected $primaryKey = 'id_consulta';
	public $incrementing = true;

	public static function informacion_solicitada(){
		Return Consulta::where('enviada', 0)->count();
	}

	public static function guardar(array $datos){
		return Consulta::create($datos);
	}

	public static function listado($datos, $enviado){
		for($i=0; $i<count($datos); $i++){
			$consulta = Consulta::select('id_consulta', 'duda')
							    ->where('requerimiento', $datos[$i]->id_requerimiento)
							    ->where('enviada', $enviado)
							    ->first();
			$datos[$i]->id_consulta = $consulta->id_consulta; //Revisar
			$datos[$i]->duda = $consulta->duda;
		}
		return $datos;
	}

	public function actualizar($requisicion, $dato){
		return Consulta::where('requerimiento', $requisicion)->where('enviada', 0)->update(['enviada' => $dato]);
	}
}
