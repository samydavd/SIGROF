<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Asignacione;
use App\Contratacione;
use App\Alerta;
use App\Analista;
use App\Cliente;
use App\Comentario;
use App\Contacto;
use App\Cotizacione;
use App\Departamento;
use App\Empresa;
use App\Mapa;
use App\Novedade;
use App\Requerimiento;
use App\Subcliente;
use App\Usuario;
use Session;


class ContratacionController extends Controller 
{
	public function contrataciones(){
		$contrataciones = Contratacione::listado();
		$datos = Asignacione::buscar($contrataciones);
		return view('contrataciones', ['datos' => $datos]);
	}

	public function contrataciones_detalles($id = null){
		$asignacion = new Asignacione();
        $req = Contratacione::datos($id);
        $alertas = new Alerta();
        $asignaciones = Asignacione::especifico($id);
        foreach($asignaciones as $as){
            if($as->tipo == 'P')
                $dep1 = $as;
            else
                $dep2 = $as;
        }
        $id_dep2 = isset($dep2)? $dep2->id : null;
        $fvisto_dep2 = isset($dep2)? $dep2->fvisto : null;
        if((($dep1->id == session('id_dep') && $dep1->fvisto == null) || ($id_dep2 == session('id_dep') && $fvisto_dep2 == null)) && session('nivel') == 'GE')
            $visto_gerente = $asignacion->visto($id, session('id_dep'));

        $gerente1 = Usuario::gerente($dep1->id);
        $cotizacion = Cotizacione::especifico($id);
        //var_dump($cotizacion);
        $novedades = Novedade::datos($id);
        foreach ($novedades as $nov) {
            $seguimiento[] = $nov->id_novedad;
        }
        if(!isset($seguimiento)) $seguimiento = array();
        $comentarios = Comentario::datos($seguimiento);
        if(isset($dep2)){
            $gerente2 = Usuario::gerente($dep2->id);
        }
        else{
            $dep2 = null;
            $gerente2 = null;
        }
        if($req->estatus != 'SCR'){
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
        

        return view('contrataciones_detalles', ['datos' => $req, 
                                                'dep1' => $dep1, 
                                                'dep2' => $dep2,
                                                'analistas' => $analistas,
                                                'ge1' => $gerente1,
                                                'ge2' => $gerente2,
                                                'cotizacion' => $cotizacion,
                                                'novedades' => $novedades,
                                                'comentarios' => $comentarios]);
	}
}