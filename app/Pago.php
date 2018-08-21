<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    public $timestamps = false;
    public $incrementing = true;
	protected $fillable = array('id_factura', 'monto', 'fpago');
	protected $primaryKey = 'id_pago';

	public function pagar($datos){
		return Pago::create($datos)->id_pago;
	}

	public function total_pagado($id_req){
		return Pago::join('facturas', 'nfactura', '=', 'id_factura')
				   ->where('requerimiento', $id_req)
				   ->sum('pagos.monto');
	}

	public static function buscar($datos){
		for($i=0; $i<=(count($datos)-1); $i++){
			$pagos = Pago::where('id_factura', $datos[$i]->nfactura)->sum('monto');
			$datos[$i]->cancelado = $pagos;
		}
		return $datos;
	}
}
