<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use App\Asignacione;
use App\Alerta;
use App\Analista;
use App\Cliente;
use App\Comentario;
use App\Contacto;
use App\Cotizacione;
use App\Contratacione;
use App\Departamento;
use App\Empresa;
use App\Mapa;
use App\Novedade;
use App\Requerimiento;
use App\Subcliente;
use App\Usuario;
use Auth;
use Session;

class RequerimientoController extends Controller
{
	public function requerimientos($filter=null){
        $requerimientos = Requerimiento::listado(session('id_dep'), session('tipo_dep'));
        $datos = Asignacione::buscar($requerimientos);
        return view('requerimientos', 
        ['datos' => $datos, 
         'filter' => ucwords($filter)]);
    }

    public function requerimientos_add(){
        $clientes = Cliente::get();
        $empresas = Empresa::listado();

        return view('requerimientos_add', 
        ['clientes' => $clientes, 
         'empresas' => $empresas]);
    }

    public function analistas(array $datos){
        return Usuario::varios($datos);
    }

    public function listado_nuevos(){
        $requerimientos = Requerimiento::listado_nuevos(session('id_dep'));
        $datos = Asignacione::buscar($requerimientos);
        return view('requerimientos_nuevos', ['datos' => $datos]);
    }

    private function caracteres_especiales($url) {
        $url = strtolower($url);
        $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
        $repl = array('a', 'e', 'i', 'o', 'u', 'n');
        $url = str_replace ($find, $repl, $url);
        $find = array(' ', '&', '\r\n', '\n', '+'); 
        $url = str_replace ($find, '-', $url);
        return $url;
    }

    public function requerimientos_add_db(Request $request){
        
        if($request->hasFile('files')){
            $files = $request->file('files'); 
            foreach ($files as $file) {
                $nombre = $this->caracteres_especiales($file->getClientOriginalName());
                if(Storage::exists('public/adjuntos/'.$nombre)){
                    $sig = 1;
                    $nuevo = explode(".", $nombre);
                    $ext = end($nuevo);
                    $nombre_nuevo = $nuevo[0].'-'.$sig;
                    while (Storage::exists('public/adjuntos/'.$nombre_nuevo.'.'.$ext)){
                        $sig++;
                        $nombre_nuevo = $nuevo[0]. $sig;
                    }
                    $nombre = $nombre_nuevo.'.'.$ext;
                }
                $file->storeAs('public/adjuntos', $nombre);
                $archivos[] = $nombre;
            }
        } else
            $archivos = [];

        if(isset($request->flimite))
            $flimite = $request->flimite;
        else {
            if ($request->input('prioridad') == 'N')
                $flimite = date("Y-m-d", strtotime($request->input('flimite')."+ 5 days"));
            elseif ($request->input('prioridad') == 'I')
                $flimite = date("Y-m-d", strtotime($request->input('flimite')."+ 3 days"));
            elseif ($request->input('prioridad') == 'U')
                $flimite = date("Y-m-d", strtotime($request->input('flimite')."+ 1 days"));
        }

        $requisicion = Requerimiento::create([
         'tipo' => 'S',
         'scliente' => $request->input('subclientes'),
         'comprador' => $request->input('comprador'),
         'tcontratacion' => $request->input('tcontratacion'),
         'rfq' => $request->input('rfq'),
         'frequerimiento' =>  $request->input('freq'),
         'prioridad' =>  $request->input('prioridad'),
         'flimite' =>  $flimite,
         'fregistro' => 'now()',
         'asunto' => $request->input('asunto'),
         'p_claves' =>  $request->input('pclaves'),
         'detalle' =>  $request->input('detalles'),
         'ir' =>  $request->input('ir'),
         'adjuntos' => implode(";", $archivos),
         'estatus' => 'SCR'
        ])->id_requerimiento;

        $asignaciones = Asignacione::create([
         'requerimiento' => $requisicion,
         'id_departamento' => $request->input('departamento'),
         'tipo' => 'P',
         'fasignacion' => 'now()'
        ]);

        if($request->input('departamento2'))
            $asignaciones = Asignacione::create([
             'requerimiento' => $requisicion,
             'id_departamento' => $request->input('departamento2'),
             'tipo' => 'S',
             'fasignacion' => 'now()'
            ]);

        $novedad = Novedade::create([
         'requerimiento' => $requisicion,
         'novedad' => "Requerimiento #".$requisicion." registrado por ".session('nombre'),
         'req_estatus' => 'SCR',
         'usuario' => session('id_usuario'),
         'fnovedad' => 'now()'
        ])->id_novedad;

        if($request->input('tcontratacion') == 'P'){
            $contratacion = Contratacione::create(
            ['requerimiento' => $requisicion,
            'nproceso' => $request->input('nproceso'), 
            'dproceso' => $request->input('dproceso'), 
            'ncontratacion' => $request->input('ncontratacion'),
            'comercial' => $request->input('comercial'), 
            'foferta' => $request->input('foferta'), 
            'faclaratoria' => $request->input('faclaratoria'), 
            'cpago' => $request->input('cpago'),
            'voferta' => $request->input('voferta'), 
            'pbase' => $request->input('pbase'),
            'pbase_dol' => $request->input('pbase_dol'), 
            'ffianza' => $request->input('ffianza'), 
            'observaciones' => $request->input('observaciones')
            ]);
        }

        if($requisicion)
            return Redirect::back()->with('data', 'success');
        else
            return Redirect::back()->with('data', 'error');
    }

    public function requerimiento_procesar(Request $request){
        $requisicion = $request->id_req;

        $novedad = Novedade::create([
            'requerimiento' => $requisicion,
            'novedad' => "Requerimiento #". $requisicion  ." en proceso por ". session('nombre'),
            'req_estatus' => 'SEP',
            'usuario' => session('id_usuario'),
            'fnovedad' => 'now()'
        ])->usuario;
  
        $estado = Requerimiento::cambiar_estado($requisicion, 'SEP');
        return $estado;
    }

    public function rechazar(Request $request){
        $requisicion = $request->id_requerimiento;
        $observacion = $request->obs;
        $estatus = 'SRE';

        $novedad = Novedade::create([
            'requerimiento' => $requisicion,
            'novedad' => session('nombre'). " ha marcado como Rechazado el requerimiento #". $requisicion,
            'req_estatus' => $estatus,
            'usuario' => session('id_usuario'),
            'fnovedad' => 'now()'
        ])->id_novedad;

        if($observacion) //RV
            $comentario = Comentario::guardar([
                'seguimiento' => $novedad,
                'comentario' => $observacion,
                'usuario' => session('id_usuario'), 
                'fcomentario' => 'now()'
            ]);    

        $estado = Requerimiento::cambiar_estado($requisicion, $estatus);
        return $estado;
    }
}