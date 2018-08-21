<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use App\Asignacione;
use App\Alerta;
use App\Analista;
use App\Ordene;
use App\Requerimiento;
use App\Usuario;
use App\Cliente;
use App\Departamento;
use App\Cotizacione;
use App\Novedade;
use App\Comentario;
use App\Entrega;
use App\Factura;
use App\Pago;


class OrdenController extends Controller 
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

        public function ordenes_new(){
                $cotizaciones_env = Requerimiento::cotizaciones_enviadas();
                $encargados = Usuario::encargados_cotizacion($cotizaciones_env);
                $dasignados = Asignacione::buscar($encargados);
                $datos = Cliente::listado($dasignados);
                return view('ordenes_new', ['datos' => $datos]);
        }

        public function ordenes_add($id = null){
                $requisicion = Requerimiento::datos($id);
                $cotizacion = Cotizacione::especifico($id);
                $dasignados = Asignacione::especifico($id);
                $gerentes[] = Usuario::gerente($dasignados[0]->id);
                if (isset($dasignados[1])){
                   $gerentes[] = Usuario::gerente($dasignados[1]->id);     
                }

                return view('ordenes_add', 
                ['datos' => $requisicion,
                 'cotizacion' => $cotizacion,
                 'asignaciones' => $dasignados, 
                 'gerentes' => $gerentes]);
        }

        public function ordenes_add_db(Request $request){
                $requisicion = $request->id_requerimiento;

                if($request->hasFile('po')){
                    $file = $request->file('po');
                    $nombre = explode(".", $file->getClientOriginalName());
                    $ext = end($nombre);
                    $archivo = 'PO'.$requisicion;
                    if(Storage::exists('public/ordenes/'.$archivo.'.'.$ext)){
                        $sig = 1;
                        $archivo = 'PO'.$requisicion.'-'.$sig;
                        while (Storage::exists('public/ordenes/'.$archivo.'.'.$ext)){
                            $sig++;
                            $archivo = 'PO'.$requisicion.'-'.$sig;
                        } 
                    }
                    $archivo .= '.'.$ext;
                    $file->storeAs('public/ordenes', $archivo);         
                } else
                    $archivo = '-1';

                $orden = Ordene::guardar([
                        'id_requerimiento' => $requisicion,
                        'codigo_po' => $request->npo,
                        'po' => $archivo,
                        'detalles' => $request->detalles,
                        'ia' => $request->ia,
                        'mpago' => $request->mpago,
                        'monto' => $request->monto,
                        'moneda' => $request->moneda,
                        'fpo' => $request->faprob,
                        'fregistro' => 'now()']);

                $novedad = Novedade::create([
                        'requerimiento' => $requisicion,
                        'novedad' => "Orden del requerimiento #".$requisicion." creada por ". session('nombre'),
                        'req_estatus' => 'OCR',
                        'usuario' => session('id_usuario'),
                        'fnovedad' => 'now()'
                ])->id_novedad;

                $estado = Requerimiento::cambiar_estado($requisicion, 'OCR');

                $estado = Requerimiento::find($requisicion);
                $estado->tipo = 'O';
                $estado->save();

                if($orden)
                    return Redirect('ordenes_detalles/'.$requisicion);
                else
                    return Redirect::back()->with('data', 'error');
        }

        public function ordenes_detalles($id = null){
            if($id){
                $alertas = new Alerta();
                $requerimientos = Requerimiento::datos($id);
                $asignaciones = Asignacione::especifico($id);
                $cotizacion = Cotizacione::especifico($id);
                $po = Ordene::especifico($id);
                foreach($asignaciones as $as){
                    if($as->tipo == 'P')
                        $dep1 = $as;
                    else
                        $dep2 = $as;
                }
                $gerente1 = Usuario::gerente($dep1->id);
                if(isset($dep2))
                    $gerente2 = Usuario::gerente($dep2->id);
                else {
                    $dep2 = null;
                    $gerente2 = null;
                }    
                $novedades = Novedade::datos($id);
                $comentarios = Comentario::datos($id);
                $nde = Entrega::datos($id);
                //foreach($nde as $n){$ids_fac[]=$n->factura;};
                $facturas = Factura::datos($id);
                $fac = Pago::buscar($facturas);

                if(true){ //Pendiente, estudiar caso
                    $analistas = Analista::datos($id);
                    for($i=0;$i<count($analistas);$i++){
                        $usuario = Departamento::busuario($analistas[$i]->id_analista);
                        $analistas[$i]->id_dep = $usuario->id;
                        $analistas[$i]->ndep = $usuario->nombre_dep;
                        $analistas[$i]->nusuario = $usuario->nombre;
                        //$analistas[$i]->append(array($usuario));
                    }
                }
                else
                    $analistas = array();

                $usuario_alertas = $alertas->buscar($id, session('id_usuario'));

                if($usuario_alertas)
                    $usuario_alertas = $alertas->actualizar($id, session('id_usuario')); 
        
                return view('ordenes_detalles',[
                    'datos' => $requerimientos,
                    'dep1' => $dep1, 
                    'dep2' => $dep2,
                    'ge1' => $gerente1,
                    'ge2' => $gerente2,
                    'analistas' => $analistas,
                    'cotizacion' => $cotizacion,
                    'po' => $po,
                    'nde' => $nde,
                    'facturas' => $fac,
                    'novedades' => $novedades,
                    'comentarios' => $comentarios]);
            }
        }

        public function listado_nuevos(){
            $requerimientos = Ordene::listado_nuevos(session('id_dep'));
            $datos = Asignacione::buscar($requerimientos);
            return view('ordenes_nuevas', ['datos' => $datos]);
        }

        public function procesar(Request $request){
            $requisicion = $request->id_req; 
            $estado = Requerimiento::cambiar_estado($requisicion, 'OEP');

            $novedad = Novedade::create([
                'requerimiento' => $requisicion,
                'novedad' => "Orden del requerimiento #".$requisicion." colocada en proceso por ". session('nombre'),
                'req_estatus' => 'OEP',
                'usuario' => session('id_usuario'),
                'fnovedad' => 'now()'
            ])->id_novedad;

            if($estado)
                return Redirect::back()->with('data', 'La orden de compra del requerimiento #'.$requisicion.' fue aceptada');
            else
                return Redirect::back()->with('data', 'error');     
        }

        public function cerrar(Request $request){
            $entrega = new Entrega();
            $orden = new Ordene();
            $requisicion = $request->id_req; 
            $estatus = $request->estatus;
            $cierre = $orden->cerrar($requisicion);
            $ndes = $entrega->cantidad($requisicion);

            if(!$ndes){
                $estado = Requerimiento::cambiar_estado($requisicion, 'SDE');
                $estatus = 'SDE';
                $torden = 'declinada';
            }
            else{
                if($estatus == 'ENP') $estatus = 'ENT';             
                $torden = 'cerrada';
            }

            $novedad = Novedade::create([
                'requerimiento' => $requisicion,
                'novedad' => "Orden del requerimiento #".$requisicion." ha sido ".$torden." por ". session('nombre'),
                'req_estatus' => $estatus,
                'usuario' => session('id_usuario'),
                'fnovedad' => 'now()'
            ])->id_novedad;

            if($cierre)
                return 1;
                //return Redirect::back()->with('data', 'La orden de compra del requerimiento #'.$requisicion.' fue aceptada');
            else
                return 0;
        }
}