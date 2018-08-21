<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'Asignaciones';
	protected $fillable = array('requerimiento', 'id_departamento', 'tipo', 'fasignacion', 'fvisto');
	protected $primaryKey = 'requerimiento';
	

	public static function buscar($datos){
		for($i=0; $i<count($datos); $i++){
			$asignacion = Asignacione::join('departamentos', 'departamentos.id', '=', 'id_departamento')
								   	 ->select('id_departamento', 'nombre_dep', 'tipo', 'siglas')
								   	 ->where('requerimiento', $datos[$i]->id_requerimiento)
								   	 ->get();

			foreach($asignacion as $as){
				if($as->tipo == 'P'){
					$datos[$i]->dprincipal = $as->nombre_dep;
					$datos[$i]->dprincipal_id = $as->id_departamento;
					$datos[$i]->dprincipal_sg = $as->siglas;
				}
				else{
					$datos[$i]->dsecundario = $as->nombre_dep;
					$datos[$i]->dsecundario_id = $as->id_departamento;
					$datos[$i]->dsecundario_sg = $as->siglas;
				}
			}
		}
		return $datos;
	}

	public static function especifico($id){  //Revisar
		return Asignacione::join('departamentos', 'departamentos.id', '=', 'asignaciones.id_departamento')
						  ->where('requerimiento', $id)
						  ->select('id_departamento AS id', 'tipo', 'nombre_dep', 'limitebs', 'limitedol', 'fvisto')
						  ->get();
	}

	public static function visto($id_requerimiento, $id_dep){
		return Asignacione::where('requerimiento', $id_requerimiento)->where('id_departamento', $id_dep)->update(['fvisto' => 'now()']);
	}
}
