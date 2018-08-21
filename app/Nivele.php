<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivele extends Model
{
  public $timestamps = false;
  protected $fillable = array('tipo_dep', 'nombre_nivel', 'mapa_acceso');
  protected $primaryKey = 'id_nivel';
  public $incrementing = true;

  public static function listado(){
    return Nivele::join('mapas', 'id', '=', 'mapa_acceso')->select('id_nivel', 'nombre_nivel', 'nombre_mapa')->get();
  }

  public static function buscar(){
    return Nivele::orderBy('nombre_nivel', 'ASC')->get();
  }

  public static function especifico($id_nivel){
    return Nivele::find($id_nivel);
  }

  public static function guardar($regla, $datos){
    return Nivele::updateOrCreate($regla, $datos);
  }
}