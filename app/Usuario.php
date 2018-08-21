<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usuario extends Model
{
	public $timestamps = false;

	protected $fillable = array('nombre', 'iniciales', 'usuario', 'nivel', 'correo', 'departamento', 'clave', 'preferencias', 'activo', 'mapa_acceso');

	protected $primaryKey = 'id_usuario';

	public $incrementing = true;

	public function existe($usuario){
		return Usuario::where('usuario', $usuario)
                      ->where('activo', 1)
                      ->first();
	}

	public function clave($usuario, $clave){
		return Usuario::where('usuario', $usuario)
                      ->where('activo', 1)
                      ->update(['clave' => $clave]);
	}

	public function verificar_datos($usuario, $clave){
		return Usuario::where('usuario', $usuario)
                      ->where('clave', $clave)
                      ->where('activo', 1)
                      ->first();
	}
	
	public static function listado(){
		return Usuario::leftJoin('departamentos', 'id', '=', 'departamento')
			   	   ->leftJoin('empresas', 'id_empresa', '=', 'departamentos.empresa')
			       ->select('id_usuario', 'nombre', 'usuario', 'nivel', 'correo', 'departamentos.empresa', 'departamentos.nombre_dep', 'empresas.nombre_emp')
			       ->orderBy('nombre')
			       ->get();
	}
	public static function datos($id){
		return Usuario::join('departamentos', 'id', '=', 'departamento')
			   	   ->join('empresas', 'id_empresa', '=', 'departamentos.empresa')
			   	   ->join('mapas', 'mapa_acceso', '=', 'mapas.id')
			       ->select('id_usuario', 'nombre', 'usuario', 'correo', 'nivel', 'departamento', 'mapa_acceso', 'mapas.nombre_mapa', 'empresas.id_empresa')
			       ->where('id_usuario', $id)
			       ->first();
	}

	public static function especifico($id){
		return Usuario::select('id_usuario', 'nombre')->find($id);
	}

	public static function gerente($id_dep){
		return Usuario::select('id_usuario', 'nombre')
					  ->where('departamento', $id_dep)
					  ->where('nivel', 1)
					  ->first();
	}

	public static function varios(array $datos){
		return Usuario::select('id_usuario', 'nombre')->whereIn('id_usuario', $datos)->get();
	}

	public static function guardar(array $regla, array $datos = []){
		return Usuario::updateOrCreate($regla, $datos)->id_usuario;
	}

	public static function mercadeo(){
		return Usuario::join('departamentos', 'id', '=', 'departamento')
                        ->where('tipo_dep', 'ME')
                        ->select('id_usuario', 'nombre')
                        ->get();
	}

	public static function analistas($dep){
		return Usuario::where('departamento', $dep)
						->select('id_usuario', 'nombre')
                        ->get();
	}

	public static function encargados_cotizacion($datos){
		for($i=0; $i<=(count($datos)-1); $i++){
			$encargado = Usuario::select('nombre')->where('id_usuario', $datos[$i]->encargado_cot)->first();
			$datos[$i]->encargado_cot = $encargado->nombre;
		}
		return $datos;
	}

	public static function emisores_alertas($datos){
		for($i=0; $i<=(count($datos)-1); $i++){
			$usuario = Usuario::select('nombre')->where('id_usuario', $datos[$i]->usuario_emisor)->first();
			$datos[$i]->nombre_emisor = $usuario->nombre;
		}
		return $datos;
	}


}
