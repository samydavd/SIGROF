<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    public $timestamps = false;
    public $incrementing = true;
    protected $table = 'Alertas';
    protected $primaryKey = 'id_alerta';
	protected $fillable = array('requerimiento', 'usuario_emisor', 'usuario_destino', 'tipo_alerta', 'fvisto');
	
	public function cargar($id_usuario){
		return Alerta::join('usuarios', 'id_usuario', '=', 'usuario_emisor')
					 ->join('requerimientos', 'id_requerimiento', '=', 'requerimiento')
					 ->where('usuario_destino', $id_usuario)
					 ->where('fvisto', null)
					 ->select('requerimiento', 'tipo_alerta', 'nombre AS nombre_emisor', 'requerimientos.tipo')
					 ->get();
	}

	
	public function verificar($id_requerimiento, $id_usuario){
		return Alerta::where('usuario_destino', $id_usuario)
					 ->where('requerimiento', $id_requerimiento)
					 ->where('fvisto', null)
					 ->get();
	}

	public function guardar($datos){
		return Alerta::create($datos)->id_alerta;
	}

	public function actualizar($id_requerimiento, $id_usuario){
		$hora_actual = 'NOW()';
		return Alerta::where('requerimiento', $id_requerimiento)
					 ->where('usuario_destino', $id_usuario)
					 ->where('fvisto', null)
					 ->update(['fvisto' => $hora_actual]);
	}
}
