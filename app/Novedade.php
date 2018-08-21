<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Novedade extends Model
{
    public $timestamps = false;

	protected $fillable = array('requerimiento', 'novedad', 'req_estatus', 'usuario', 'fnovedad');

	protected $primaryKey = 'id_novedad';

	public $incrementing = true;

    public static function guardar(array $regla, array $datos = []){
		return Cliente::updateOrCreate($regla, $datos)->id_cliente;
	}

	public static function datos($id){
		return Novedade::join('usuarios', 'id_usuario', '=', 'novedades.usuario')
					   ->where('requerimiento', $id)->orderBy('fnovedad', 'asc')
					   ->select('novedades.*', 'usuarios.nombre')
					   ->get();
	}

	public static function buscar_req($id){
		return Novedade::select('requerimiento')->find($id);
	}

	public static function fecha_cotizado($datos){ // No utilizado
		for($i=0; $i<=(count($datos)-1); $i++){
			$fcotizado = Novedade::select('fnovedad')
								 ->where('requerimiento', $datos[$i]->id_requerimiento)
								 ->where('estatus', 'COA')
								 ->first();
			//$datos[$i]->fcotizado

		}
	}
}