<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    public $timestamps = false;
    protected $fillable = array('nfactura', 'requerimiento', 'adjunto', 'monto', 'moneda', 'usuario', 'ndes', 'ffactura', 'fregistro');
    protected $primaryKey = 'nfactura';
    public $incrementing = false;

	public static function datos($id){
		return Factura::join('entregas', 'factura', '=', 'nfactura')
					  ->distinct()
					  ->select('facturas.*')
					  ->where('entregas.requerimiento', $id)
					  ->get();
	}

	public static function guardar(array $datos){
		return Factura::create($datos)->nfactura;
	}

	public static function total_pagado($requerimiento){ // No utilizado
		return Factura::where('requerimiento', $requerimiento)->sum('cancelado');
	}

	public static function total_a_pagar($requerimiento){ // No utilizado
		return Factura::where('requerimiento', $requerimiento)->sum('monto');
	}

	public static function indice_ventas($datos){
		for($i=0; $i<=(count($datos)-1); $i++){
			$factura = Factura::join('pagos', 'id_factura', '=', 'nfactura')
							  ->where('requerimiento', $datos[$i]->id_requerimiento)
							  ->sum('pagos.monto');
			$datos[$i]->pagado = $factura;
		}

		return $datos;
	}
}
