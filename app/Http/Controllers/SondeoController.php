<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
//use App\Sondeo;
use App\Requerimiento;
use App\Novedade;
use App\Comentario;
use App\Cliente;
use App\Empresa;

  
class SondeoController extends Controller 
{
    private function caracteres_especiales($url) {
        $url = strtolower($url);
        $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
        $repl = array('a', 'e', 'i', 'o', 'u', 'n');
        $url = str_replace ($find, $repl, $url);
        $find = array(' ', '&', '\r\n', '\n', '+'); 
        $url = str_replace ($find, '-', $url);
        return $url;
    }

    public function sondeos(){
      $clientes = Cliente::get();
      $empresas = Empresa::listado();

      return view('sondeos_add', 
      ['clientes' => $clientes, 
       'empresas' => $empresas]);
    }

    public function sondeos_add(){
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

        $sondeo = Sondeo::create([
         'scliente' => $request->input('subclientes'),
         'tcontratacion' => $request->input('tcontratacion'),
         'fsondeo' =>  $request->input('freq'),
         'prioridad' =>  $request->input('prioridad'),
         'flimite' =>  $flimite,
         'fregistro' => 'now()',
         'asunto' => $request->input('asunto'),
         'p_claves' =>  $request->input('pclaves'),
         'detalle' =>  $request->input('detalles'),
         'is' =>  $request->input('ir'),
         'adjuntos' => implode(";", $archivos),
         'estatus' => 'SMR'
        ])->id_sondeo;

        $asignaciones = Sondeo_::create([
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
    }
}