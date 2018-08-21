<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    public $timestamps = false;
    public $incrementing = true;
    protected $table = 'Requerimientos';
    protected $primaryKey = 'id_requerimiento';
	protected $fillable = array('tipo', 'asunto', 'p_claves', 'detalle', 'rfq', 'adjuntos', 'prioridad', 'tcontratacion', 'estatus', 'frequerimiento', 'flimite', 'fregistro', 'scliente', 'ir', 'comprador');
	
		public static function datos($id){
		return Requerimiento::join('subclientes', 'id_subcliente', '=', 'scliente')
					   	->join('clientes', 'id_cliente', '=', 'subclientes.cliente')
					   	->join('contactos', 'id_contacto', '=', 'comprador')
			       		->select('id_requerimiento', 'requerimientos.tipo', 'id_cliente', 'id_subcliente', 'encargados', 'nombre_cliente', 'nombre_sub', 'nombre_contacto', 'asunto', 'detalle', 'p_claves', 'rfq', 'ir', 'prioridad', 'tcontratacion', 'frequerimiento', 'requerimientos.fregistro', 'estatus')
			       		->find($id);
	}
}
