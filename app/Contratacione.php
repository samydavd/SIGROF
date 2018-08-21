<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contratacione extends Model
{
    public $timestamps = false;
    protected $fillable = array('requerimiento', 'nproceso', 'dproceso', 'ncontratacion', 'comercial', 'faclaratoria', 'foferta', 'cpago', 'pbase', 'ffianza', 'observaciones', 'pbase_dol', 'voferta');
    protected $primaryKey = 'requerimiento';
    public $incrementing = false;

    public static function listado(){
        return Contratacione::join('requerimientos', 'id_requerimiento', '=', 'requerimiento')
                            ->join('subclientes', 'id_subcliente', '=', 'requerimientos.scliente')
                            ->join('usuarios', 'id_usuario', '=', 'subclientes.encargado')
                            ->select('contrataciones.*','id_requerimiento', 'nombre_sub', 'iniciales', 'nombre AS encargado', 'asunto','p_claves', 'rfq', 'ir', 'prioridad', 'requerimientos.fregistro', DB::raw("extract(day FROM NOW() - requerimientos.fregistro) AS dias"), 'estatus')
                            ->where('tcontratacion', 'P')
                            ->where('requerimientos.tipo', 'S')
                            ->get();
    }

    public static function datos($id){
       return Contratacione::join('requerimientos', 'id_requerimiento', '=', 'requerimiento')
                        ->join('subclientes', 'id_subcliente', '=', 'requerimientos.scliente')
                        ->join('clientes', 'id_cliente', '=', 'subclientes.cliente')
                        ->join('contactos', 'id_contacto', '=', 'comprador')
                        ->select('contrataciones.*', 'id_requerimiento', 'requerimientos.tipo', 'id_cliente', 'id_subcliente', 'encargados', 'nombre_cliente', 'nombre_sub', 'nombre_contacto', 'asunto', 'detalle', 'p_claves', 'rfq', 'ir', 'prioridad', 'tcontratacion', 'frequerimiento', 'requerimientos.fregistro', 'estatus')
                        ->find($id);
    }
}