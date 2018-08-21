@php
setlocale(LC_TIME, 'es_VE'); # Localiza en español es_Venezuela
date_default_timezone_set('America/Caracas');

$analisis = isset($analisis)? $analisis : '';
$recomendaciones = isset($recomendaciones)? $recomendaciones : '';

$ord_totales = count($datos); 

$ord_facturadas = 0;
$ord_facturadas_par = 0;
$ord_facturadas_tot = 0;
$ord_pagos_parciales = 0;
$ord_pagos_totales = 0;
$total_pagado_dol = 0;
$total_pagado_bs = 0;


foreach($datos as $dt){
	if($dt->estatus == 'FAP' || $dt->estatus == 'FAC' || $dt->estatus == 'PAP' || $dt->estatus == 'PAG')
		$ord_facturadas++;
	if($dt->estatus == 'FAP')
		$ord_facturadas_par++;
	if($dt->estatus == 'FAC' || $dt->estatus == 'PAP' || $dt->estatus == 'PAG')
		$ord_facturadas_tot++;
	if($dt->monto == $dt->pagado)
		$ord_pagos_totales++;
	else
		$ord_pagos_parciales++;
		
	if(isset($dt->pagado)){
		if($dt->moneda == 'D')
			$total_pagado_dol += $dt->pagado;
		else
			$total_pagado_bs += $dt->pagado;
	}

}

//$porcentaje_aceptacion = ($of_aceptada*100)/$of_enviada;

@endphp

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>Indice de Ventas</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIGROF</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/dist/css/bootstrap.min.css')}}"> 
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="{{asset('css/fontastic.css')}}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="{{asset('css/font_google.css')}}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{asset('css/style.default.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">

    <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('js/Chart.min.js')}}"></script>

	<style type="text/css">

	body
	{
		background: white;
		margin: 10px;
	}
	
	h2, h3
	{
		text-align: center;
	}
	

	table 
	{
    	border-collapse: collapse;
	}

	table, th, td {
	    border: 1px solid black;	    
	    text-align: center;
	    padding: 5px;	    
	}
	tr
	{
		height: 30px;
		vertical-align: middle;
	}
	.iguales tr td
	{
		width: 12.5%;
	}

	.iguales2 tr td
	{
		width: 11.1%;
	}
	</style>
</head>
<body>

<table style="margin:0 auto; width:900px">
	<tr>
		<td rowspan="3"><img src="{{asset('img/logo.png')}}" height="60"></td>
		<td><STRONG>CALIDAD Y GESTION</STRONG></td>
		<td colspan="2">Generado por</td>		
	</tr>
	<tr>		
		<td rowspan="2"><STRONG>REPORTE RESULTADOS DE INDICADORES DE PROCESO</STRONG></td>
		<td>Usuario:</td>
		<td><?php echo session('nombre');?></td>
	</tr>
	<tr>		
		<td>Fecha</td>
		<td><?php echo date("d/m/Y h:i:s a");?></td>		
	</tr>
</table>

<table style="margin:30px auto; width:900px;">
	<tr>
		<td style="width:30%;text-align:left"><strong>NOMBRE DEL INDICADOR</strong></td>
		<td style="text-align:left">Indice de Ventas</td>		
	</tr>
	<tr>				
		<td style="text-align:left"><strong>DEPARTAMENTO</strong></td>
		<td style="text-align:left"><?php echo $departamento->nombre_dep?></td>
	</tr>	
	<tr>				
		<td style="text-align:left"><strong>PERIODO CONSULTADO</strong></td>
		<td style="text-align:left"><?php echo date("d/m/Y", strtotime($desde)).' a '.date("d/m/Y", strtotime($hasta));?></td>
	</tr>	
</table>
<table style="margin:10px auto; width:900px;" class="iguales2">
	<tr style="font-weight:bold; background: #ccc;">
		<td colspan="6"><strong>RESULTADO DEL PERIODO</strong></td>		
	</tr>
	<tr>
		<td value="<?php echo $ord_totales; ?>"><strong>ORDENES TOTALES</strong></td>
		<td colspan="2"><?php echo $ord_totales; ?></td>
		<td><strong>ORDENES FACTURADAS</strong></td>
		<td colspan="2"><?php echo $ord_facturadas; ?></td>		
	</tr>
	<tr>
		<td><strong>FACTURADAS PARCIALES</strong></td>
		<td colspan="2"><?php echo $ord_facturadas_par; ?></td>
		<td><strong>FACTURADAS TOTALES</strong></td>
		<td colspan="2"><?php echo $ord_facturadas_tot; ?></td>		
	</tr>
	<tr>
		<td><strong>PAGOS PARCIALES</strong></td>
		<td colspan="2"><?php echo $ord_pagos_parciales; ?></td>
		<td><strong>PAGOS TOTALES</strong></td>
		<td colspan="2"><?php echo $ord_pagos_totales; ?></td>		
	</tr>
	<tr>
		<!--td><strong>TOTAL RESPUESTAS</strong></td>
		<td></td-->
		<td><strong>TOTAL PAGADO Bs.</strong></td>
		<td colspan="2"><?php echo $total_pagado_bs?> Bs.</td>	
		<td><strong>TOTAL PAGADO US$</strong></td>
		<td colspan="2"><?php echo $total_pagado_dol?> US$</td>	
	</tr>
	
</table> 

    
<input type="hidden" id="ord_totales" value="{{$ord_totales}}">
<input type="hidden" id="ord_facturadas" value="{{$ord_facturadas}}">
<input type="hidden" id="ord_facturadas_par" value="{{$ord_facturadas_par}}">
<input type="hidden" id="ord_facturadas_tot" value="{{$ord_facturadas_tot}}">
<!--input type="hidden" id="prom_aceptacion" value="">
<input type="hidden" id="prom_minimo" value="40"-->

<table style="margin:10px auto; width:900px;" class="iguales2">
	<tr style="font-weight:bold; background: #ccc;">
		<td><strong>GRÁFICO</strong></td>		
	</tr>
	<tr>
		<td>
			<canvas id="graf_facturados" width="400" height="200"></canvas>
		</td>		
	</tr>
</table>
<form id="reporte_iv" action="{{route('reportes_especificos_add_bd')}}" class="col-auto" method="post">
<center>
	@if(session('tipo_dep') == 'CA')
        {{ csrf_field() }}
			<label for="analisis" class="col-form-label col-lg-2">Analisis</label>
		<div>
			<textarea id="analisis" name="analisis" cols=110 required>{{$analisis}}</textarea>
		</div>
			<label for="recomendaciones" class="col-form-label col-lg-2" required>Recomendaciones/Acciones</label>
		<div>
			<textarea id="recomendaciones" name="recomendaciones" cols=110 required>{{$recomendaciones}}</textarea>
		</div>
		<input type="hidden" id="desde" name="desde" value="{{$desde}}">
		<input type="hidden" id="hasta" name="hasta"  value="{{$hasta}}">
		<input type="hidden" id="departamento" name="departamento" value="{{$departamento->id}}">
		<input type="hidden" id="tipo" name="tipo" value="CIVE">
		<input type="submit" class="btn btn-success" value="Almacenar reporte">
	@elseif($analisis && $recomendaciones)
			<label for="analisis" class="col-form-label col-lg-2">Analisis</label>
		<div>
			<textarea id="analisis" name="analisis" cols=110 required disabled>{{$analisis}}</textarea>
		</div>
			<label for="recomendaciones" class="col-form-label col-lg-2" required>Recomendaciones/Acciones</label>
		<div>
			<textarea id="recomendaciones" name="recomendaciones" cols=110 required disabled>{{$recomendaciones}}</textarea>
		</div>
	@endif
    
    <button id="imprimir" class="btn btn-dark">Imprimir Reporte</button>
</center>
</form>
<script>
var ctx = $("#graf_facturados");
var ord_totales = $("#ord_totales").val();
var ord_facturadas = $("#ord_facturadas").val();
var ord_facturadas_par = $("#ord_facturadas_par").val();
var ord_facturadas_tot = $("#ord_facturadas_tot").val();
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Totales", "Facturadas", "Facturadas parcial", "Facturadas total",],
        datasets: [{
            data: [ord_totales, ord_facturadas, ord_facturadas_par, ord_facturadas_tot],
            backgroundColor: [
                'rgba(11, 224, 27, 0.2)',         
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 99, 132, 0.2)',
            ],
            borderColor: [
                'rgba(11, 224, 27, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255,99,132,1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        legend: {
            display: false
         },
         tooltips: {
            enabled: false
         },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
    
var ctx = $("#graf_rendimiento");
var prom_respondidas = $("#prom_respondidas").val();
var prom_minimo = $("#prom_minimo").val();
var verde = 'rgba(11, 224, 27  , 0.2)';
var rojo ='rgba(255, 99, 132, 0.2)';
var bverde = 'rgba(11, 224, 27, 1)';
var brojo = 'rgba(255,99,132,1)';
if (prom_minimo > prom_respondidas){
    var color1 = rojo;
    var bcolor1 = brojo;
}
else {
    var color1 = verde;
    var bcolor1 = bverde;
}

    
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Resultado", "Meta"],
            datasets: [{
                labels: [],
                data: [prom_respondidas, prom_minimo],
                backgroundColor: [
                    color1,
                    'rgba(54, 162, 235, 0.2)',

                ],
                borderColor: [
                    bcolor1,
                    'rgba(54, 162, 235, 1)',

                ],
                borderWidth: 1
            }]
        },
        options: {
            legend: {
            display: false
         },
         tooltips: {
            enabled: false
         },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });



$( document ).ready(function() {
    $("#imprimir").click(function(){
    window.print();
                     });
});
    
</script>    
</body>
</html>