<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacione extends Model
{
    public $timestamps = false;

	protected $fillable = array('profit', 'cotizacion', 'adjunto', 'monto', 'moneda', 'estado', 'tercerizado', 'validez', 'fcotizacion', 'requerimiento', 'usuario', 'ic', 'factor', 'descuento');

	protected $primaryKey = 'id_cotizacion';

	public $incrementing = true;

    public static function guardar(array $datos = []){
		return Cotizacione::create($datos)->id_cotizacion;
	}

	public static function especifico($id){
		return Cotizacione::where('requerimiento', $id)
						  ->whereIn('estado', ['P', 'B', 'A', 'L'])
						  ->orderBy('id_cotizacion','desc')
						  ->first();
	}

	public static function cambiar_estado($id, $estado){
		return Cotizacione::where('id_cotizacion', $id)->update(['estado' => $estado]);
	}

	public static function cantidad_por_aprobar($id_departamento){
		return Cotizacione::join('asignaciones', 'asignaciones.requerimiento', '=', 'cotizaciones.requerimiento')
						   ->where('asignaciones.id_departamento', $id_departamento)
						   ->whereIn('estado', ['P', 'B'])
						   ->select('id_cotizacion')
						   ->count();
	}

	public static function cantidad_por_liberar($id_departamento){
		return Cotizacione::where('estado', 'L')
						   ->select('id_cotizacion')
						   ->count();
	}

	public static function listado(){
		return Requerimiento::leftJoin('subclientes', 'id_subcliente', '=', 'scliente')
					   	->leftJoin('usuarios', 'id_usuario', '=', 'subclientes.encargado')
			       		->select('id_requerimiento', 'requerimientos.tipo', 'nombre_sub', 'iniciales', 'nombre AS encargado', 'asunto','p_claves', 'rfq', 'ir', 'prioridad', 'requerimientos.fregistro', DB::raw("extract(day FROM NOW() - requerimientos.fregistro) AS dias"), 'estatus')
			       		->where()
			       		->get();

			       		//No utilizado
	}

	public static function listado_aprobar(){
		return Requerimiento::leftJoin('subclientes', 'id_subcliente', '=', 'scliente')
					   	->leftJoin('usuarios', 'id_usuario', '=', 'subclientes.encargado')
			       		->select('id_requerimiento', 'requerimientos.tipo', 'nombre_sub', 'iniciales', 'nombre AS encargado', 'asunto','p_claves', 'rfq', 'ir', 'prioridad', 'requerimientos.fregistro', DB::raw("extract(day FROM NOW() - requerimientos.fregistro) AS dias"), 'estatus')
			       		->get();

			       		//No utilizado
	}
}
