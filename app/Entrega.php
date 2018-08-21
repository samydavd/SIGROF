<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Entrega extends Model
{
    public $timestamps = false;
    protected $fillable = array('id_nde', 'requerimiento', 'tipo', 'adjunto', 'lugar', 'usuario', 'factura', 'fnde', 'fentrega', 'fregistro');
    protected $primaryKey = 'id_nde';
    public $incrementing = false;

	public static function datos($id){
		return Entrega::where('requerimiento', $id)->get();
	}

	public static function guardar(array $datos){
		return Entrega::create($datos)->id_nde;
	}

	public function actualizar($id, array $datos){
		return Entrega::where('id_nde', $id)->update($datos);
	}

	public function cantidad($id){
		return Entrega::select('id_nde')->where('requerimiento', $id)->count();
	}

	public function facturar(array $id, $factura){
		return Entrega::whereIn('id_nde', $id)->update(['factura' => $factura]);
	}

	public function facturado($id){
		return Entrega::select('id_nde', 'tipo')->where('requerimiento', $id)->where('factura', '<>', null)->get();
	}

	public static function pendientes_entregar(){
		return Entrega::where('lugar', null)->count(DB::raw('DISTINCT requerimiento'));
	}

	public static function pendientes_facturar(){
		return Entrega::where('lugar', '<>', null)->where('factura', null)->count(DB::raw('DISTINCT requerimiento'));
	}

	public static function listado_pendientes($datos, $tipo){
		if($tipo)
			for($i=0; $i<=(count($datos)-1); $i++){
				$entrega = Entrega::select('id_nde', 'adjunto')->where('requerimiento', $datos[$i]->id_requerimiento)->where('factura', null)->get();	
				$datos[$i]->nde = $entrega->toArray();
			}
		else 
			for($i=0; $i<=(count($datos)-1); $i++){
				$entrega = Entrega::select('id_nde')->where('requerimiento', $datos[$i]->id_requerimiento)->where('lugar', null)->get();	
				$datos[$i]->nde = $entrega->toArray();
			}
			return $datos;
	}

	public static function orden_facturada($datos){
		$facturas = 0;
		$factura_total = 0;
		for($i=0; $i<=(count($datos)-1); $i++){
			$entregas = Entrega::where('requerimiento', $datos[$i]->id_requerimiento)
							  ->select('id_nde', 'tipo', 'factura')
							  ->get();
			foreach($entregas as $en){
				if($en->tipo == 'T' && $en->factura != null)
					$factura_total = 1;
				if($en->factura != null)
					$facturas += 1;
			}
			if($factura_total && $facturas == count($entregas))
				$datos[$i]->fac_total = 1;
		}
		return $datos;
	}
}
