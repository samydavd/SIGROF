<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcliente extends Model {
    public $timestamps = false;
    protected $fillable = array('cliente', 'nombre_sub', 'telf_sub', 'email_sub', 'tipo', 'encargados', 'encargado', 'super', 'comp', 'admin', 'fregistro', 'activo', 'imo');
    protected $primaryKey = 'id_subcliente';
	public $incrementing = true;

	public static function listado(){
		$subclientes = Subcliente::join('clientes', 'id_cliente', '=', 'cliente')->get();
		/*foreach($subclientes as $sub){
			$
		}
		->join('contactos', 'id_contacto', '=', 'super')
			   	   ->join('contactos', 'id_contacto', '=', 'comp')
			   	   ->join('contactos', 'id_contacto', '=', 'admin')
			       ->select('id_subcliente', 'id_cliente', 'subclientes.tipo', 'nombre_contacto', 'departamentos.empresa', 'departamentos.nombre_dep', 'empresas.nombre_emp')*/
		return $subclientes;
	}

	public static function datos($id){
		return Subcliente::find($id);
	}

	public static function guardar(array $regla, array $datos = []){
		return Subcliente::updateOrCreate($regla, $datos)->id_subcliente;
	}
}
