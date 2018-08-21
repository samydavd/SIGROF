<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    public $timestamps = false;

	protected $fillable = array('requerimiento', 'comentario', 'usuario', 'menciones', 'fcomentario');

	protected $primaryKey = 'id_comentario';

	public $incrementing = true;

    public static function guardar(array $datos = []){
		//return Comentario::updateOrCreate($regla, $datos)->id_cliente;
		return Comentario::create($datos)->id_comentario;
	}

	public static function datos($requerimiento){
		return Comentario::join('usuarios', 'id_usuario', '=', 'comentarios.usuario')
						 ->where('requerimiento', $requerimiento)
						 ->select('comentarios.*', 'nombre AS nombre_usuario')
						 ->orderBy('fcomentario', 'asc')
						 ->get();
	}
}