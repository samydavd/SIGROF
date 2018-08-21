<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ordene extends Model
{
    //protected $table = 'ordenes';

    public $timestamps = false;

	protected $fillable = array('id_requerimiento', 'codigo_po', 'po', 'mpago', 'detalles', 'moneda', 'monto', 'ia',  'fpo', 'fregistro', 'cierre');

	protected $primaryKey = 'id_requerimiento';

	public $incrementing = false;

	public static function listado(){
		return Ordene::join('requerimiento', 'requerimiento.id_requerimiento', '=', 'ordenes.id_requerimiento')
					 ->get();
	}

    public static function guardar(array $datos = []){
		return Ordene::create($datos);
	}

	public static function datos($id, $tipo){
		return Asignacione::where('requerimiento', $id)->where('tipo', $tipo)->first();
	}

	public static function especifico($id){
		return Ordene::where('id_requerimiento', $id)->first();
	}

	public function cerrar($id){
		return Ordene::where('id_requerimiento', $id)->update(['cierre' => 1]);
	}

	public function ver_cierre($id){
		return Ordene::where('id_requerimiento', $id)->select('cierre')->first();
	}

	public static function nuevos($id_dep){ //Revisar para casos de dos departamentos
		return Ordene::join('requerimientos', 'requerimientos.id_requerimiento', '=', 'ordenes.id_requerimiento')
					 ->join('asignaciones', 'asignaciones.requerimiento', '=', 'requerimientos.id_requerimiento')
					 ->where('id_departamento', $id_dep)
					 ->where('estatus', 'OCR')
					 ->count();
	}

	public static function listado_nuevos($id_dep){ //Revisar cantidad de INNER JOIN
		return Ordene::join('requerimientos', 'requerimientos.id_requerimiento', '=', 'ordenes.id_requerimiento')
					 ->join('asignaciones', 'asignaciones.requerimiento', '=', 'requerimientos.id_requerimiento')
					 ->join('subclientes', 'id_subcliente', '=', 'scliente')
					 ->join('clientes', 'id_cliente', '=', 'subclientes.cliente')
					 ->join('usuarios', 'id_usuario', '=', 'subclientes.encargado')
					 ->where('id_departamento', $id_dep)
					 ->where('estatus', 'OCR')
					 ->select('requerimientos.id_requerimiento', 'nombre_cliente', 'nombre_sub', 'iniciales', 'nombre AS encargado', 'asunto','p_claves', 'rfq', 'codigo_po', 'po', 'monto', 'moneda', 'ir', 'ia', 'ordenes.fregistro', DB::raw("extract(day FROM NOW() - ordenes.fregistro) AS dias"), 'estatus')
					 ->get();
	}
}
