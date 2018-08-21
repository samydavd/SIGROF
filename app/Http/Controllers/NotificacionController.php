<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Analista;
use App\Requerimiento;
use App\Consulta;
use App\Novedade;
use App\Comentario;
use App\Cotizacione;
use App\Declinada;
use App\Respuesta;
use App\Ordene;
use App\Entrega;



class NotificacionController extends Controller 
{
    public function cargar(Request $request){
      $usuario = $request->id_usuario;
      $notificaciones = [];

      if(session('nivel') == 6 && session('tipo_dep') != "ME" && session('tipo_dep') != "AD" && session('tipo_dep') != "AP"){

        if(session('acceso')->solicitudes[6]){
          $requerimiento = Cotizacione::cantidad_por_aprobar(session('id_dep'));
          if($requerimiento)
            $notificaciones["cotizacion"] = $requerimiento;
        }

        $requerimiento = Respuesta::pendientes(session('id_dep'));
        if($requerimiento)
          $notificaciones["respuesta"] = $requerimiento;

        $requerimiento = Requerimiento::nuevos(session('id_dep'));
        if($requerimiento)
          $notificaciones["nuevos"] = $requerimiento;

        $requerimiento = Ordene::nuevos(session('id_dep'));
        if($requerimiento)
          $notificaciones["ordenes_nuevas"] = $requerimiento;

        /*$requerimiento = Cotizacione::informacion_recibida(session('id_dep'));
        if($requerimiento)
          $notificaciones["cotizacion"] = $requerimiento;*/
      }

      if(session('nivel') == 9){
        $requerimiento = Cotizacione::cantidad_por_liberar(session('id_dep'));
        if($requerimiento)
          $notificaciones["liberacion"] = $requerimiento;
      }

      if(session('tipo_dep') == 'ME'){
        $requerimiento = Declinada::pendientes();
        if($requerimiento)
          $notificaciones["declinada"] = $requerimiento;

        $requerimiento = Consulta::informacion_solicitada();
        if($requerimiento)
          $notificaciones["informacion"] = $requerimiento;

        $requerimiento = Requerimiento::cotizaciones_aprobadas();
        if($requerimiento)
          $notificaciones["aprobadas"] = $requerimiento;
      }

      if(session('tipo_dep') == 'AD'){
        $requerimiento = Entrega::pendientes_facturar();
        if($requerimiento)
          $notificaciones["por_facturar"] = $requerimiento;
      }

      if(session('tipo_dep') == 'OP'){
        $requerimiento = Entrega::pendientes_entregar();
        if($requerimiento)
          $notificaciones["por_entregar"] = $requerimiento;
      }

      return $notificaciones;
    }
}