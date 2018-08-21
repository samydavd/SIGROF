<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model {
    public $timestamps = false;
    protected $fillable = array('cliente', 'nombre_contacto', 'telf_contacto', 'email_contacto', 'tipo');
    protected $primaryKey = 'id_contacto';
	public $incrementing = true;

	public static function buscar($datos){
		for($i=0; $i<=(count($datos)-1); $i++){
			$comprador = Contacto::where('id_contacto', $datos[$i]->comp)
						 ->select('id_contacto AS id_comp', 'nombre_contacto AS nombre_comp')
						 ->first();
			$superintendente = Contacto::where('id_contacto', $datos[$i]->super)
							   ->select('id_contacto AS id_super', 'nombre_contacto AS nombre_super')
							   ->first();
			$administrador = Contacto::where('id_contacto', $datos[$i]->admin)
							 ->select('id_contacto AS id_admin', 'nombre_contacto AS nombre_admin')
							 ->first();

			$datos[$i]->comp = $comprador;
			$datos[$i]->super = $superintendente;
			$datos[$i]->admin = $administrador; 
		}
		return $datos;
	}

	public static function guardar(array $regla, array $datos = []){
		return Contacto::updateOrCreate($regla, $datos)->id_subcliente;
	}
}