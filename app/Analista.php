<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analista extends Model
{
    public $timestamps = false;
	protected $fillable = array('id_analista', 'requerimiento', 'tipo', 'fvisto', 'fasignacion');
	protected $primaryKey = 'id_analista';

	public static function datos($id_requerimiento){
		$analista = Analista::where('requerimiento', $id_requerimiento)->get();
		for($i=0; $i<=(count($analista)-1); $i++){
			if($analista[$i]->id_analista == session('id_usuario') && $analista[$i]->fvisto == null){
				$fvisto = Analista::where('requerimiento', $id_requerimiento)
											->where('id_analista', session('id_usuario'))
											->update(['fvisto' => 'now()']);
			}
		}
		$analista = Analista::where('requerimiento', $id_requerimiento)->get(); //Revisar repetición de consulta. Buscar devolución valor columna.
		return $analista;
	}

	public static function guardar(array $datos){
		return Analista::create($datos);
	}

	public static function visto($id_requerimiento, $id_usuario){
		return Analista::where('requerimiento', $id_requerimiento)->where('id_analista', $id_usuario)->update(['fvisto' => 'now()']);
	}
}
