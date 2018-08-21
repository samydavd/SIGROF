<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    public $timestamps = false;

    protected $fillable = array('nombre_emp', 'tipo', 'telefono', 'cod_telf', 'ubicacion', 'activo');

    protected $primaryKey = 'id_empresa';

	public $incrementing = true;

	public static function listado(){
		return Empresa::where('activo', 1)->get();
	}

	public static function datos($id_empresa){
		return Empresa::select('id_empresa', 'nombre_emp', 'tipo')->find($id_empresa);
	}
}
