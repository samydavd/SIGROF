<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    public $timestamps = false;
    public $incrementing = true;
	protected $fillable = array('usuario', 'departamento', 'analisis', 'recomendaciones', 'tipo', 'fdesde', 'fhasta', 'freporte');
	protected $primaryKey = 'id_reporte';

	public function guardar($datos){
		return Reporte::create($datos)->id_reporte;
	}

	public function buscar($desde, $hasta, $id_dep, $tipo){
		return Reporte::whereDate('fdesde', $desde)
					  ->whereDate('fhasta', $hasta)
					  ->where('departamento', $id_dep)
					  ->where('tipo', $tipo)
					  ->first();
	}

	public function especifico($id_reporte){
		return Reporte::find($id_reporte);
	}
}
