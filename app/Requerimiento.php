<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Requerimiento extends Model
{
	public $timestamps = false;

	protected $fillable = array('tipo', 'asunto', 'p_claves', 'detalle', 'rfq', 'adjuntos', 'prioridad', 'tcontratacion', 'estatus', 'frequerimiento', 'flimite', 'fregistro', 'scliente', 'ir', 'comprador');

	protected $primaryKey = 'id_requerimiento';

	public $incrementing = true;
	
	public static function listado($id_dep, $tipo_dep){
		//$diff = Requerimiento::select(array(DB::raw('DATEDIFF(fregistro,frequerimiento) as days')))->paginate(10);

		if($tipo_dep == 'SE' || $tipo_dep == 'SU')
			return Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
						->join('subclientes', 'id_subcliente', '=', 'scliente')
					   	->join('usuarios', 'id_usuario', '=', 'subclientes.encargado')
			       		->select('id_requerimiento', 'requerimientos.tipo', 'nombre_sub', 'iniciales', 'nombre AS encargado', 'asunto','p_claves', 'rfq', 'ir', 'prioridad', 'requerimientos.fregistro', DB::raw("extract(day FROM NOW() - requerimientos.fregistro) AS dias"), 'estatus')
			       		->where('id_departamento', $id_dep)
			       		->get();
		else if($tipo_dep == 'OP')
			return Requerimiento::join('subclientes', 'id_subcliente', '=', 'scliente')
					   	->join('usuarios', 'id_usuario', '=', 'subclientes.encargado')
			       		->select('id_requerimiento', 'requerimientos.tipo', 'nombre_sub', 'iniciales', 'nombre AS encargado', 'asunto','p_claves', 'rfq', 'ir', 'prioridad', 'requerimientos.fregistro', DB::raw("extract(day FROM NOW() - requerimientos.fregistro) AS dias"), 'estatus')
			       		->where('requerimientos.tipo', 'O')
			       		->get();
		else
			return Requerimiento::join('subclientes', 'id_subcliente', '=', 'scliente')
					   	->join('usuarios', 'id_usuario', '=', 'subclientes.encargado')
			       		->select('id_requerimiento', 'requerimientos.tipo', 'nombre_sub', 'iniciales', 'nombre AS encargado', 'asunto','p_claves', 'rfq', 'ir', 'prioridad', 'requerimientos.fregistro', DB::raw("extract(day FROM NOW() - requerimientos.fregistro) AS dias"), 'estatus')
			       		->get();
	}

	public static function listado_nuevos($id_dep){
		return Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
						->join('subclientes', 'id_subcliente', '=', 'scliente')
					   	->join('usuarios', 'id_usuario', '=', 'subclientes.encargado')
			       		->select('id_requerimiento', 'nombre_sub', 'iniciales', 'nombre AS encargado', 'asunto','p_claves', 'rfq', 'ir', 'prioridad', 'requerimientos.fregistro', DB::raw("extract(day FROM NOW() - requerimientos.fregistro) AS dias"), 'estatus')
			       		->where('id_departamento', $id_dep)
			       		->where('fvisto', null)
			       		->get();
	}

	public static function listado_general($tipo){
		if($tipo)
			return Requerimiento::join('ordenes', 'ordenes.id_requerimiento', '=', 'requerimientos.id_requerimiento')
						->join('subclientes', 'id_subcliente', '=', 'scliente')
						->join('clientes', 'id_cliente', '=', 'subclientes.cliente')
					   	->join('usuarios', 'id_usuario', '=', 'subclientes.encargado')
					   	->join('entregas', 'requerimiento', '=', 'requerimientos.id_requerimiento')
			       		->select(DB::raw('DISTINCT requerimientos.id_requerimiento'), 'nombre_cliente', 'nombre_sub', 'iniciales', 'nombre AS encargado', 'asunto','p_claves', 'codigo_po', 'po', 'ia', 'ordenes.fregistro', DB::raw("extract(day FROM NOW() - ordenes.fregistro) AS dias"), 'estatus')
			       		->where('factura', null)
			       		->get();
		else
			return Requerimiento::join('ordenes', 'ordenes.id_requerimiento', '=', 'requerimientos.id_requerimiento')
						->join('subclientes', 'id_subcliente', '=', 'scliente')
						->join('clientes', 'id_cliente', '=', 'subclientes.cliente')
					   	->join('usuarios', 'id_usuario', '=', 'subclientes.encargado')
					   	->join('entregas', 'requerimiento', '=', 'requerimientos.id_requerimiento')
			       		->select(DB::raw('DISTINCT requerimientos.id_requerimiento'), 'nombre_cliente', 'nombre_sub', 'iniciales', 'nombre AS encargado', 'asunto','p_claves', 'codigo_po', 'po', 'ia', 'ordenes.fregistro', DB::raw("extract(day FROM NOW() - ordenes.fregistro) AS dias"), 'estatus')
			       		->where('lugar', null)
			       		->get();
	}

	public static function nuevos($id_dep){
		return Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
					 ->where('id_departamento', $id_dep)
					 ->where('fvisto', null)
					 ->count();
	}

	public static function cotizaciones_enviadas(){
		return Requerimiento::leftJoin('subclientes', 'id_subcliente', '=', 'scliente')
					   	->leftJoin('usuarios', 'id_usuario', '=', 'subclientes.encargado')
					   	->leftJoin('cotizaciones', 'cotizaciones.requerimiento', '=', 'id_requerimiento')
					   	->leftJoin('novedades', 'novedades.requerimiento', '=', 'id_requerimiento')
			       		->select(DB::raw("to_char(novedades.fnovedad, 'dd/mm/YY') as fenvio") , DB::raw("extract(day FROM NOW() - novedades.fnovedad) AS dias"), 'id_requerimiento', 'scliente', 'nombre_sub', 'iniciales', 'nombre AS encargado', 'cotizaciones.usuario AS encargado_cot', 'asunto','p_claves', 'rfq', 'profit', 'cotizacion', 'ic', 'prioridad')
			       		->where('estatus', 'CEC')
			       		->where('novedades.req_estatus', 'CEC')
			       		->where('cotizaciones.estado', 'A')
			       		->get();
	}

	public static function encargado($id){
		return Requerimiento::join('subclientes', 'id_subcliente', '=', 'scliente')
			       		->select('id_requerimiento', 'encargados')
			       		->find($id);
	}

	public static function guardar(array $regla, array $datos = []){
		return Usuario::updateOrCreate($regla, $datos)->id_usuario;
	}

	public static function cambiar_estado($id, $estado){
		return Requerimiento::where('id_requerimiento', $id)->update(['estatus' => $estado]);
	}

	public static function etapa($datos){
		for($i=0;$i<count($datos);$i++){
			$etapa = Requerimiento::select('tipo')
							  	  ->where('id_requerimiento', $datos[$i]->requerimiento)
							  	  ->first();
			$datos[$i]->etapa = $etapa->tipo;
		}
		return $datos;
	}

	public static function cotizaciones_listado(){ //Revisar (Reubicar metodo)
		return Requerimiento::leftJoin('subclientes', 'id_subcliente', '=', 'scliente')
					   	->leftJoin('usuarios', 'id_usuario', '=', 'subclientes.encargado')
					   	->join('clientes', 'id_cliente', '=', 'subclientes.cliente')
					   	->join('cotizaciones', 'cotizaciones.requerimiento', '=', 'id_requerimiento')
			       		->select('prioridad', 'id_requerimiento', 'id_cotizacion', 'iniciales', 'nombre AS encargado', 'nombre_cliente', 'nombre_sub', 'rfq', 'ir', 'cotizaciones.ic', 'cotizaciones.monto', 'cotizaciones.moneda', 'fcotizacion', 'validez', 'cotizaciones.cotizacion', 'tercerizado', 'profit', DB::raw("extract(day FROM NOW() - fcotizacion) AS dias"), 'estatus')
			       		->whereIn('cotizaciones.estado', ['P', 'B'])
			       		->get();
	}

	public static function cotizaciones_listado_liberacion(){ //Revisar (Reubicar metodo)
		return Requerimiento::leftJoin('subclientes', 'id_subcliente', '=', 'scliente')
					   	->leftJoin('usuarios', 'id_usuario', '=', 'subclientes.encargado')
					   	->join('clientes', 'id_cliente', '=', 'subclientes.cliente')
					   	->join('cotizaciones', 'cotizaciones.requerimiento', '=', 'id_requerimiento')
			       		->select('prioridad', 'id_requerimiento', 'id_cotizacion', 'iniciales', 'nombre AS encargado', 'nombre_cliente', 'nombre_sub', 'rfq', 'ir', 'cotizaciones.ic', 'cotizaciones.monto', 'cotizaciones.moneda', 'fcotizacion', 'validez', 'cotizaciones.cotizacion', 'tercerizado', 'profit', DB::raw("extract(day FROM NOW() - fcotizacion) AS dias"), 'estatus')
			       		->where('cotizaciones.estado', 'L')
			       		->get();
	}

	public static function solicitudes_declinadas($datos){
		for($i=0;$i<count($datos);$i++){
			$requisicion = Requerimiento::leftJoin('subclientes', 'id_subcliente', '=', 'scliente')
					   	->leftJoin('usuarios', 'id_usuario', '=', 'subclientes.encargado')
					   	->join('clientes', 'id_cliente', '=', 'subclientes.cliente')
					   	->select('iniciales', 'nombre AS encargado', 'nombre_cliente', 'nombre_sub', 'rfq', DB::raw("extract(day FROM NOW() - frequerimiento) AS dias"))
						->where('id_requerimiento', $datos[$i]->id_requerimiento)
						->first();
			$datos[$i]->iniciales = $requisicion->iniciales;
			$datos[$i]->encargado = $requisicion->encargado;
			$datos[$i]->nombre_cliente = $requisicion->nombre_cliente;
			$datos[$i]->nombre_sub = $requisicion->nombre_sub;
			$datos[$i]->rfq = $requisicion->rfq;
			$datos[$i]->dias = $requisicion->dias;
		}
		return $datos;
	}

	public static function solicitudes_mas_informacion($estatus){
		return Requerimiento::leftJoin('subclientes', 'id_subcliente', '=', 'scliente')
					   	->leftJoin('usuarios', 'id_usuario', '=', 'subclientes.encargado')
					   	->join('clientes', 'id_cliente', '=', 'subclientes.cliente')
					   	->select('id_requerimiento', 'iniciales', 'nombre AS encargado', 'nombre_cliente', 'nombre_sub', 'rfq', 'comprador', 'ir', DB::raw("extract(day FROM NOW() - frequerimiento) AS dias"))
						->where('estatus', $estatus)
						->get();
	}

	public static function cotizaciones_aprobadas(){
		return Requerimiento::where('estatus', 'COA')->count();
	}

	public static function cotizaciones_listado_aprobadas(){
		return Requerimiento::leftJoin('subclientes', 'id_subcliente', '=', 'scliente')
					   	->leftJoin('usuarios', 'id_usuario', '=', 'subclientes.encargado')
					   	->join('clientes', 'id_cliente', '=', 'subclientes.cliente')
					   	->join('cotizaciones', 'cotizaciones.requerimiento', '=', 'id_requerimiento')
			       		->select('prioridad', 'id_requerimiento', 'id_cotizacion', 'iniciales', 'nombre AS encargado', 'nombre_cliente', 'nombre_sub', 'rfq', 'ir', 'cotizaciones.ic', 'cotizaciones.monto', 'cotizaciones.moneda', 'fcotizacion', 'validez', 'cotizaciones.cotizacion', 'tercerizado', 'profit', DB::raw("extract(day FROM NOW() - fcotizacion) AS dias"), 'estatus', 'comprador')
			       		->where('requerimientos.estatus', 'COA')
			       		->where('cotizaciones.estado', 'A')
			       		->get();
	}

	public static function buscar($desde, $hasta, $dep){
		return Requerimiento::leftJoin('cotizaciones', 'requerimiento', '=', 'id_requerimiento')
							//->leftJoin('novedades', 'novedades.requerimiento', '=', 'id_requerimiento')
							->join('asignaciones', 'asignaciones.requerimiento', '=', 'id_requerimiento')
							->select(DB::raw('DISTINCT id_requerimiento'), 'requerimientos.fregistro', 'moneda', 'requerimientos.estatus', 'fcotizacion')
							->where('fregistro', '>=', $desde)
							->where('fregistro', '<=', $hasta)
							//->where('cotizaciones.estado', 'A')
							//->where('novedades.req_estatus', 'COA')
							->where('id_departamento', $dep)
							->get();
	}

	public static function buscar_general($desde, $hasta){
		return Requerimiento::leftJoin('cotizaciones', 'requerimiento', '=', 'id_requerimiento')
							//->leftJoin('novedades', 'novedades.requerimiento', '=', 'id_requerimiento')
							->select(DB::raw('DISTINCT id_requerimiento'), 'requerimientos.fregistro', 'moneda', 'requerimientos.estatus', 'fcotizacion')
							->where('fregistro', '>=', $desde)
							->where('fregistro', '<=', $hasta)
							//->where('cotizaciones.estado', 'A')
							//->where('novedades.req_estatus', 'COA')
							->get();
	}

	public static function aceptacion_oferta($desde, $hasta, $dep){
		return Requerimiento::leftJoin('cotizaciones', 'requerimiento', '=', 'id_requerimiento')
							->leftJoin('novedades', 'novedades.requerimiento', '=', 'id_requerimiento')
							->join('asignaciones', 'asignaciones.requerimiento', '=', 'id_requerimiento')
							->select('id_requerimiento', 'requerimientos.fregistro', 'moneda', 'requerimientos.estatus', 'fnovedad')
							->where('fregistro', '>=', $desde)
							->where('fregistro', '<=', $hasta)
							->where('cotizaciones.estado', 'A')
							->where('novedades.req_estatus', 'COA')
							->where('id_departamento', $dep)
							->get();
	}

	public static function aceptacion_oferta_general($desde, $hasta){
		return Requerimiento::leftJoin('cotizaciones', 'requerimiento', '=', 'id_requerimiento')
							->leftJoin('novedades', 'novedades.requerimiento', '=', 'id_requerimiento')
							->select('id_requerimiento', 'requerimientos.fregistro', 'moneda', 'requerimientos.estatus', 'fnovedad')
							->where('fregistro', '>=', $desde)
							->where('fregistro', '<=', $hasta)
							->where('cotizaciones.estado', 'A')
							->where('novedades.req_estatus', 'COA')
							->get();
	}

	public static function indice_ventas($desde, $hasta, $dep){
		return Requerimiento::join('asignaciones', 'asignaciones.requerimiento', '=', 'id_requerimiento')
							->join('facturas', 'facturas.requerimiento', '=', 'id_requerimiento')
							->join('ordenes', 'ordenes.id_requerimiento', '=', 'requerimientos.id_requerimiento')
							->distinct()
							->select('requerimientos.id_requerimiento', 'requerimientos.fregistro', 'ordenes.moneda', 'ordenes.monto', 'requerimientos.estatus')
							->where('requerimientos.fregistro', '>=', $desde)
							->where('requerimientos.fregistro', '<=', $hasta)
							->where('id_departamento', $dep)
							->get();
	}

	public static function indice_ventas_general($desde, $hasta){
		return Requerimiento::join('facturas', 'facturas.requerimiento', '=', 'id_requerimiento')
							->join('ordenes', 'ordenes.id_requerimiento', '=', 'requerimientos.id_requerimiento')
							->distinct()
							->select('requerimientos.id_requerimiento', 'requerimientos.fregistro', 'ordenes.moneda', 'ordenes.monto', 'requerimientos.estatus')
							->where('requerimientos.fregistro', '>=', $desde)
							->where('requerimientos.fregistro', '<=', $hasta)
							->get();
	}

	public static function estadisticas($id_dep, $nivel, $empresa = null){
		if(!$empresa){
			$req['nuevas'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->where('id_departamento', $id_dep)
										  ->where('estatus', 'SCR')
										  ->count();

			$req['proceso'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->where('id_departamento', $id_dep)
										  ->whereIn('estatus', ['SEP', 'SMI', 'MIR', 'MIC', 'COC', 'CPA', 'CPL'])
										  ->count();

			$req['cotizadas'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->where('id_departamento', $id_dep)
										  ->where('estatus', 'COA')
										  ->count();

			$req['enviadas'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->where('id_departamento', $id_dep)
										  ->whereNotIn('estatus', ['SCR', 'SEP', 'SMI', 'MIR', 'MIC', 'COC', 'CPA', 'CPL', 'COA', 'SDE'])
										  ->count();
			$req['ord_nuevas'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->where('id_departamento', $id_dep)
										  ->where('estatus', 'OCR')
										  ->count(DB::raw('DISTINCT id_requerimiento'));

			$req['ord_proceso'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->where('id_departamento', $id_dep)
										  ->whereIn('estatus', ['OEP', 'NEP', 'NET', 'ENP', 'ENT'])
										  ->count(DB::raw('DISTINCT id_requerimiento'));

			$req['ord_facturadas'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->where('id_departamento', $id_dep)
										  ->whereIn('estatus', ['FAP', 'FAC'])
										  ->count(DB::raw('DISTINCT id_requerimiento'));

			$req['ord_totales'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->where('id_departamento', $id_dep)
										  ->whereIn('estatus', ['OCR', 'OEP', 'NEP', 'NET', 'ENP', 'ENT', 'FAP', 'FAC', 'PAP', 'PAG'])
										  ->count();

			$total = Requerimiento::count();
			$req['total'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->where('id_departamento', $id_dep)
										  ->count();	

			if($total>0)					
				$req['carga_departamento'] = ($req['total']*100)/$total;
			else
				$req['carga_departamento'] = 0;

			return $req;
		}
		else {
			$req['nuevas'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->join('departamentos', 'departamentos.id', '=', 'asignaciones.id_departamento')
										  ->join('empresas', 'id_empresa', '=', 'departamentos.empresa')
										  ->where('id_empresa', $empresa)
										  ->where('estatus', 'SCR')
										  ->count();

			$req['proceso'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->join('departamentos', 'departamentos.id', '=', 'asignaciones.id_departamento')
										  ->join('empresas', 'id_empresa', '=', 'departamentos.empresa')
										  ->where('id_empresa', $empresa)
										  ->whereIn('estatus', ['SEP', 'SMI', 'MIR', 'MIC', 'COC', 'CPA', 'CPL'])
										  ->count();

			$req['cotizadas'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->join('departamentos', 'departamentos.id', '=', 'asignaciones.id_departamento')
										  ->join('empresas', 'id_empresa', '=', 'departamentos.empresa')
										  ->where('id_empresa', $empresa)
										  ->where('estatus', 'COA')
										  ->count();

			$req['enviadas'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->join('departamentos', 'departamentos.id', '=', 'asignaciones.id_departamento')
										  ->join('empresas', 'id_empresa', '=', 'departamentos.empresa')
										  ->where('id_empresa', $empresa)
										  ->whereNotIn('estatus', ['SCR', 'SEP', 'SMI', 'MIR', 'MIC', 'COC', 'CPA', 'CPL', 'COA', 'SDE'])
										  ->count();
			$req['ord_nuevas'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->join('departamentos', 'departamentos.id', '=', 'asignaciones.id_departamento')
										  ->join('empresas', 'id_empresa', '=', 'departamentos.empresa')
										  ->where('id_empresa', $empresa)
										  ->where('estatus', 'OCR')
										  ->count(DB::raw('DISTINCT id_requerimiento'));

			$req['ord_proceso'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->join('departamentos', 'departamentos.id', '=', 'asignaciones.id_departamento')
										  ->join('empresas', 'id_empresa', '=', 'departamentos.empresa')
										  ->where('id_empresa', $empresa)
										  ->whereIn('estatus', ['OEP', 'NEP', 'NET', 'ENP', 'ENT'])
										  ->count();

			$req['ord_facturadas'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->join('departamentos', 'departamentos.id', '=', 'asignaciones.id_departamento')
										  ->join('empresas', 'id_empresa', '=', 'departamentos.empresa')
										  ->where('id_empresa', $empresa)
										  ->whereIn('estatus', ['FAP', 'FAC'])
										  ->count();

			$req['ord_totales'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->join('departamentos', 'departamentos.id', '=', 'asignaciones.id_departamento')
										  ->join('empresas', 'id_empresa', '=', 'departamentos.empresa')
										  ->where('id_empresa', $empresa)
										  ->whereIn('estatus', ['OCR', 'OEP', 'NEP', 'NET', 'ENP', 'ENT', 'FAP', 'FAC', 'PAP', 'PAG'])
										  ->count();

			
			$req['total'] = Requerimiento::join('asignaciones', 'requerimiento', '=', 'id_requerimiento')
										  ->join('departamentos', 'departamentos.id', '=', 'asignaciones.id_departamento')
										  ->join('empresas', 'id_empresa', '=', 'departamentos.empresa')
										  ->where('id_empresa', $empresa)
										  ->count(DB::raw('DISTINCT(id_requerimiento)'));

			$total = Requerimiento::count();

			if($total>0)
				$req['carga_empresa'] = ($req['total']*100)/$total;
			else
				$req['carga_empresa'] = 0;
			
			return $req;
		}
	}
}