<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public $timestamps = false;

	protected $fillable = array('nombre_cliente', 'rif', 'pais', 'huso', 'medio', 'detalles', 'direccion', 'fregistro');

	protected $primaryKey = 'id_cliente';

	public $incrementing = true;

    public static function guardar(array $regla, array $datos = []){
		return Cliente::updateOrCreate($regla, $datos)->id_cliente;
	}

	public static function datos($id){
		return Cliente::find($id);
	}

	public static function listado2(){
		return Cliente::select('id_cliente', 'nombre_cliente')->get();
	}

	public static function listado($datos){
		for($i=0; $i<count($datos); $i++){
			$cliente = Cliente::join('subclientes', 'subclientes.cliente', '=', 'id_cliente')
							  ->where('subclientes.id_subcliente', $datos[$i]->scliente)
							  ->select('nombre_cliente')
							  ->first();
			$datos[$i]->cliente = $cliente->nombre_cliente;
		}
		return $datos;
	}
}
