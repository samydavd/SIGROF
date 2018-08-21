<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    public $timestamps = false;

	protected $fillable = array('nombre_dep', 'tipo_dep', 'empresa', 'siglas', 'limitebs', 'limitedol', 'activo_dep');

	protected $primaryKey = 'id';

	public $incrementing = true;

	public static function datos($id){
		return Departamento::select('id', 'nombre_dep', 'limitebs', 'limitedol')->find($id);
	}

	public static function busuario($id){
		return Departamento::join('usuarios', 'usuarios.departamento', '=', 'departamentos.id')
						   ->where('usuarios.id_usuario', $id)
						   ->select('id', 'nombre_dep', 'usuarios.nombre')
						   ->first();
	}

	public static function buscar($datos){
		for($i=0; $i<count($datos); $i++){

			$principal = Departamento::select('nombre_dep', 'siglas')->where('id', $datos[$i]->dprincipal)->first();
			$datos[$i]->dprincipal = $principal->nombre_dep;
			$datos[$i]->dprincipal_sg = $principal->siglas;

			if(isset($datos[$i]->dsecundario)){
				$secundario = Departamento::select('nombre_dep', 'siglas')->where('id', $datos[$i]->dsecundario)->first();
				$datos[$i]->dsecundario = $secundario->nombre_dep;
				$datos[$i]->dsecundario_sg = $secundario->siglas;
			}	
			
		}
		return $datos;
	}

	public static function limites($id_dep){
		return Departamento::select('limitedol', 'limitebs')->where('id', $id_dep)->first();
	}
}
