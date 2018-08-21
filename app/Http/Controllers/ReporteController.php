<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use App\Requerimiento;
use App\Novedade;
use App\Comentario;
use App\Factura;
use App\Pago;
use App\Empresa;
use App\Departamento;
use App\Reporte;
use App\Entrega;



class ReporteController extends Controller 
{

    public function formulario(){
        $empresas = Empresa::where('activo', '1')->get();
        return view('reportes_form', ['empresas' => $empresas]);
    }

    public function formulario_generales(){
        $empresas = Empresa::where('activo', '1')->get();
        return view('reportes_form_generales', ['empresas' => $empresas]);
    }

    public function especifico_generar(Request $request){
        $desde = $request->desde;
        $hasta = $request->hasta;
        $id_dep = $request->departamento;
        $tipo = $request->tipo;

        $departamento = Departamento::datos($id_dep);

        if($tipo == 1){
            $solicitudes = Requerimiento::buscar($desde, $hasta, $id_dep);
            return view('reporte_capacidad_respuesta', [
                'datos' => $solicitudes, 
                'desde' => $desde, 
                'hasta' => $hasta, 
                'departamento' => $departamento
            ]);
        }
        else if($tipo == 2){
            $solicitudes = Requerimiento::aceptacion_oferta($desde, $hasta, $id_dep);
            return view('reporte_aceptacion_oferta', [
                'datos' => $solicitudes, 
                'desde' => $desde, 
                'hasta' => $hasta, 
                'departamento' => $departamento
            ]);
        }
        else if($tipo == 3){
            $solicitudes = Requerimiento::indice_ventas($desde, $hasta, $id_dep);
            $entregas = Entrega::orden_facturada($solicitudes);
            $facturas = Factura::indice_ventas($entregas);
            return view('reporte_indice_ventas', [
                'datos' => $facturas, 
                'desde' => $desde, 
                'hasta' => $hasta, 
                'departamento' => $departamento
            ]);
        }
    }

    public function generales_generar(Request $request){
        $desde = $request->desde;
        $hasta = $request->hasta;
        $id_emp = $request->empresa;
        $tipo = $request->tipo;

        $empresa = Empresa::datos($id_emp);

        if($tipo == 1){
            $solicitudes = Requerimiento::buscar_general($desde, $hasta);
            return view('reporte_general_capacidad_respuesta', [
                'datos' => $solicitudes, 
                'desde' => $desde, 
                'hasta' => $hasta, 
                'empresa' => $empresa
            ]);
        }
        else if($tipo == 2){
            $solicitudes = Requerimiento::aceptacion_oferta_general($desde, $hasta);
            return view('reporte_general_aceptacion_oferta', [
                'datos' => $solicitudes, 
                'desde' => $desde, 
                'hasta' => $hasta, 
                'empresa' => $empresa
            ]);
        }
        else if($tipo == 3){
            $solicitudes = Requerimiento::indice_ventas_general($desde, $hasta);
            $entregas = Entrega::orden_facturada($solicitudes);
            $facturas = Factura::indice_ventas($entregas);
            return view('reporte_general_indice_ventas', [
                'datos' => $facturas, 
                'desde' => $desde, 
                'hasta' => $hasta, 
                'empresa' => $empresa
            ]);
        }
    }

    public function especifico_add_db(Request $request){
        $reporte = new Reporte();
        $reporte->guardar([
            'usuario' => session('id_usuario'),
            'departamento' => $request->departamento,
            'analisis' => $request->analisis, 
            'recomendaciones' => $request->recomendaciones,
            'tipo' => $request->tipo,
            'fdesde' => $request->desde,
            'fhasta' => $request->hasta,
            'freporte' => 'now()'
        ]);
        if($reporte)
            return Redirect('reportes_especificos')->with('data', 'success');
        else
            return Redirect('reportes_especificos')->with('data', 'error');
    }

    public function generales_add_db(Request $request){
        $reporte = new Reporte();
        $reporte->guardar([
            'usuario' => session('id_usuario'),
            'departamento' => $request->empresa,
            'analisis' => $request->analisis, 
            'recomendaciones' => $request->recomendaciones,
            'tipo' => $request->tipo,
            'fdesde' => $request->desde,
            'fhasta' => $request->hasta,
            'freporte' => 'now()'
        ]);
        if($reporte)
            return Redirect('reportes_generales')->with('data', 'success');
        else
            return Redirect('reportes_generales')->with('data', 'error');
    }

    public function buscar(Request $request){
        $reporte = new Reporte();
        $desde = $request->desde;
        $hasta = $request->hasta;
        $tipo = $request->tipo;
        if($request->id_dep){
            if($tipo == 1)
                $tipo = 'CDRE';
            elseif($tipo == 2)
                $tipo = 'CDAE';
            elseif($tipo == 3)
                $tipo = 'CIVE';
            $resultado = $reporte->buscar($desde, $hasta, $request->id_dep, $tipo);
        }
        else{
            if($tipo == 1)
                $tipo = 'CDRG';
            elseif($tipo == 2)
                $tipo = 'CDAG';
            elseif($tipo == 3)
                $tipo = 'CIVG';
            $resultado = $reporte->buscar($desde, $hasta, $request->id_emp, $tipo);
        }
        return $resultado;
    }

    public function generado($id = null){
        if($id){
           $reporte = new Reporte();
           $resultado = $reporte->especifico($id); 

           $desde = $resultado->fdesde;
           $hasta = $resultado->fhasta;
           $id_dep = $resultado->departamento;
           $tipo = $resultado->tipo;

            $departamento = Departamento::datos($id_dep);

            if($tipo == 'CDRE'){
                $solicitudes = Requerimiento::buscar($desde, $hasta, $id_dep);
                return view('reporte_capacidad_respuesta', [
                    'datos' => $solicitudes, 
                    'desde' => $desde, 
                    'hasta' => $hasta, 
                    'departamento' => $departamento,
                    'analisis' => $resultado->analisis,
                    'recomendaciones' => $resultado->recomendaciones
                ]);
            }
            elseif($tipo == 'CDAE'){
                $solicitudes = Requerimiento::buscar($desde, $hasta, $id_dep);
                return view('reporte_aceptacion_oferta', [
                    'datos' => $solicitudes, 
                    'desde' => $desde, 
                    'hasta' => $hasta, 
                    'departamento' => $departamento,
                    'analisis' => $resultado->analisis,
                    'recomendaciones' => $resultado->recomendaciones
                ]);
            }
            elseif($tipo == 'CIVE'){
                $solicitudes = Requerimiento::indice_ventas($desde, $hasta, $id_dep);
                $entregas = Entrega::orden_facturada($solicitudes);
                $facturas = Factura::indice_ventas($entregas);
                return view('reporte_indice_ventas', [
                    'datos' => $facturas, 
                    'desde' => $desde, 
                    'hasta' => $hasta, 
                    'departamento' => $departamento,
                    'analisis' => $resultado->analisis,
                    'recomendaciones' => $resultado->recomendaciones
                ]);
            }
        }
    }

    public function generado_general($id = null){
        if($id){
           $reporte = new Reporte();
           $resultado = $reporte->especifico($id); 

           $desde = $resultado->fdesde;
           $hasta = $resultado->fhasta;
           $id_emp = $resultado->departamento; //Verificar futuramente
           $tipo = $resultado->tipo;

           $empresa = Empresa::datos($id_emp);

            if($tipo == 'CDRG'){
                $solicitudes = Requerimiento::buscar_general($desde, $hasta);
                return view('reporte_general_capacidad_respuesta', [
                    'datos' => $solicitudes, 
                    'desde' => $desde, 
                    'hasta' => $hasta, 
                    'empresa' => $empresa,
                    'analisis' => $resultado->analisis,
                    'recomendaciones' => $resultado->recomendaciones
                ]);
            }
            else if($tipo == 'CDAG'){
                $solicitudes = Requerimiento::aceptacion_oferta_general($desde, $hasta);
                return view('reporte_general_aceptacion_oferta', [
                    'datos' => $solicitudes, 
                    'desde' => $desde, 
                    'hasta' => $hasta, 
                    'empresa' => $empresa,
                    'analisis' => $resultado->analisis,
                    'recomendaciones' => $resultado->recomendaciones
                ]);
            }
            else if($tipo == 'CIVG'){
                $solicitudes = Requerimiento::indice_ventas_general($desde, $hasta);
                $entregas = Entrega::orden_facturada($solicitudes);
                $facturas = Factura::indice_ventas($entregas);
                return view('reporte_general_indice_ventas', [
                    'datos' => $facturas, 
                    'desde' => $desde, 
                    'hasta' => $hasta, 
                    'empresa' => $empresa,
                    'analisis' => $resultado->analisis,
                    'recomendaciones' => $resultado->recomendaciones
                ]);
            }
        }
    }
}