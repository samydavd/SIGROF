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

class SolicitudController extends Controller
{
	public function solicitudes_detalles($id = null){
		if($id){
        	$asignacion = new Asignacione();
        	$an = new Analista();
        	$sol = new Solicitud();
        	$alertas = new Alerta();
        	$asig = new Asignacion();

        	$solicitud = $sol->datos($id);
        	$asignaciones = $asig->especifico($id);

        	/*foreach($asignaciones as $as){ //Agregar en vista
            	if($as->tipo == 'P')
                	$dep1 = $as;
            	else
                	$dep2 = $as;*/
        }
        //$id_dep2 = isset($dep2)? $dep2->id : null;
        //$fvisto_dep2 = isset($dep2)? $dep2->fvisto : null;
        /*if((($dep1->id == session('id_dep') && $dep1->fvisto == null) || ($id_dep2 == session('id_dep') && $fvisto_dep2 == null)) && session('nivel') == 6){
            $visto_gerente = $asignacion->visto($id, session('id_dep'));
            $asignaciones = Asignacione::especifico($id);
            foreach($asignaciones as $as){ //Revisar repetición innecesaria
                if($as->tipo == 'P')
                    $dep1 = $as;
                else
                    $dep2 = $as;
            }
        }*/

        //$gerente1 = Usuario::gerente($dep1->id);
        $cotizacion = Cotizacione::especifico($id);
        $novedades = Novedade::datos($id);
        $comentarios = Comentario::datos($id);
        /*if(isset($dep2)){
            $gerente2 = Usuario::gerente($dep2->id);
        }
        else{
            $dep2 = null;
            $gerente2 = null;
        }*/
        if($solicitud->estatus != 'SCR'){
            $analistas = Analista::datos($id);
            /*for($i=0;$i<count($analistas);$i++){
                $usuario = Departamento::busuario($analistas[$i]->id_analista);
                $analistas[$i]->id_dep = $usuario->id;
                $analistas[$i]->ndep = $usuario->nombre_dep;
                $analistas[$i]->nusuario = $usuario->nombre;
                //$analistas[$i]->append(array($usuario));
            }*/
        }
        //else
            //$analistas = array();

        $usu_alerta = $alertas->verificar($id, session('id_usuario'));

        if($usu_alertas)
            $alertas->actualizar($id, session('id_usuario')); 
        
        return view('solicitudes_detalles', ['solicitud' => $solicitud, 
        									 'asignaciones' => $asignaciones,
                                              //'dep1' => $dep1, 
                                              //'dep2' => $dep2,
                                              'analistas' => $analistas,
                                              //'ge1' => $gerente1,
                                                //'ge2' => $gerente2,
                                              'cotizacion' => $cotizacion,
                                              'novedades' => $novedades,
                                              'comentarios' => $comentarios]);
    	}
    	else
    		return Redirect('requerimientos');
    }
}