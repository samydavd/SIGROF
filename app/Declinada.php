<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Declinada extends Model
{
    public $timestamps = false;

	protected $fillable = array('razon', 'observacion', 'confirmacion', 'requerimiento', 'usuario');

	protected $primaryKey = 'id_declinada';

	public $incrementing = true;

    public static function crear(array $datos = []){
		return Declinada::create($datos)->id_declinada;
	}

	public static function especifico($id){
		return Cotizacione::where('requerimiento', $id)->where('estado', 'P')->where('estado', 'A')->where('estado', 'L')->orderBy('id_cotizacion','desc')->first();
	}

	public static function pendientes(){
		return Declinada::where('confirmacion', 0)->count();
	}

	public static function listado(){
		return Declinada::join('usuarios', 'id_usuario', '=', 'declinadas.usuario')
					    ->select('requerimiento AS id_requerimiento', 'razon', 'observacion', 'id_declinada', 'nombre AS nusuario', 'iniciales AS inusuario')
					    ->where('confirmacion', 0)
					    ->get();
	}

	public function confirmacion($id_declinada){
		return Declinada::where('id_declinada', $id_declinada)->update(['confirmacion' => 1]);
	}

	public function reactivacion($id_declinada){
		return Declinada::where('id_declinada', $id_declinada)->update(['confirmacion' => 2]);
	}
}