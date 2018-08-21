@php
setlocale(LC_TIME, 'es_VE'); # Localiza en español es_Venezuela
date_default_timezone_set('America/Caracas');

$analisis = isset($analisis)? $analisis : '';
$recomendaciones = isset($recomendaciones)? $recomendaciones : '';

$of_enviada = 0;
$of_aceptada = 0;
$of_rechazada = 0;

foreach($datos as $dt){
	if($dt->estatus != 'SCR' || $dt->estatus != 'SAA' || $dt->estatus != 'SEP' || $dt->estatus != 'SMI' || $dt->estatus != 'MIC' || $dt->estatus != 'MIR' || $dt->estatus != 'COC' || $dt->estatus != 'CPA' || $dt->estatus != 'CPL' || $dt->estatus != 'SDE')
		$of_enviada++;
	if($dt->estatus == 'OCR' || $dt->estatus == 'OEP' || $dt->estatus == 'NEP' || $dt->estatus == 'NET' || $dt->estatus == 'ENP' || $dt->estatus == 'ENT' || $dt->estatus == 'FAP' || $dt->estatus == 'FAC' || $dt->estatus == 'PAP' || $dt->estatus == 'PAG')
		$of_aceptada++;
	if($dt->estatus == 'SRE')
		$of_rechazada++;

}

if($of_enviada > 0)
	$porcentaje_aceptacion = ($of_aceptada*100)/$of_enviada;
else
	$porcentaje_aceptacion = 0;

@endphp

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>Aceptación Oferta</title>
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
		<td style="text-align:left">Aceptación de Oferta</td>		
	</tr>
	<tr>				
		<td style="text-align:left"><strong>EMPRESA</strong></td>
		<td style="text-align:left"><?php echo $empresa->nombre_emp?></td>
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
		<td value="<?php echo $of_enviada; ?>"><strong>OFERTAS ENVIADAS</strong></td>
		<td colspan="2"><?php echo $of_enviada; ?></td>
		<td><strong>OFERTAS ACEPTADAS</strong></td>
		<td colspan="2"><?php echo $of_aceptada; ?></td>		
	</tr>
	<tr>
		<td><strong>RECHAZADAS</strong></td>
		<td colspan="2"><?php echo $of_rechazada; ?></td>
		<td><strong>SIN RESPUESTA</strong></td>
		<td colspan="2"><?php echo $of_enviada - $of_aceptada; ?></td>		
	</tr>
	<tr>
		<!--td><strong>TOTAL RESPUESTAS</strong></td>
		<td></td-->
		<td><strong>RESULTADO</strong></td>
		<td colspan="2"><?php echo number_format($porcentaje_aceptacion,2,',','.');?>%</td>
		<td><strong>META GENERAL</strong></td>
		<td colspan="2"><?php echo "40%" ?></td>		
	</tr>
	
</table>
    
<!--input type="hidden" id="sol_totales" value="">
<input type="hidden" id="sol_cotizadas" value="">
<input type="hidden" id="sol_declinadas" value="">
<input type="hidden" id="sol_no_respuesta" value=""-->
<input type="hidden" id="prom_aceptacion" value="<?php echo $porcentaje_aceptacion ?>">
<input type="hidden" id="prom_minimo" value="40">

<table style="margin:10px auto; width:900px;" class="iguales2">
	<tr style="font-weight:bold; background: #ccc;">
		<td><strong>GRÁFICO</strong></td>		
	</tr>
	<tr>
		<td>
			<canvas id="graf_rendimiento" width="400" height="200"></canvas>
		</td>		
	</tr>
</table>
<form id="reporte_general_ao" action="{{route('reportes_generales_add_db')}}" class="col-auto" method="post">
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
		<input type="hidden" id="empresa" name="empresa" value="{{$empresa->id_empresa}}">
		<input type="hidden" id="tipo" name="tipo" value="CDAG">
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
    
var ctx = $("#graf_rendimiento");
var prom_aceptacion = $("#prom_aceptacion").val();
var prom_minimo = $("#prom_minimo").val();
var verde = 'rgba(11, 224, 27  , 0.2)';
var rojo ='rgba(255, 99, 132, 0.2)';
var bverde = 'rgba(11, 224, 27, 1)';
var brojo = 'rgba(255,99,132,1)';
if (prom_minimo > prom_aceptacion){
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
                data: [prom_aceptacion, prom_minimo],
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