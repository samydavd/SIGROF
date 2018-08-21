<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feriado extends Model
{
    public $timestamps = false;
    protected $fillable = array('descripcion', 'fecha', 'repeticion');
    protected $primaryKey = 'id_feriado';
    public $incrementing = true;

    public static function datos($id){
        return Feriado::find($id);
    }

    public static function guardar(array $regla, array $datos = []){
		return Feriado::updateOrCreate($regla, $datos)->id_feriado;
	}
}