@php
setlocale(LC_TIME, 'es_VE'); # Localiza en español es_Venezuela
date_default_timezone_set('America/Caracas');

$analisis = isset($analisis)? $analisis : '';
$recomendaciones = isset($recomendaciones)? $recomendaciones : '';

$sol_totales = count($datos);
$sol_declinadas = 0;
$sol_cotizadas_dol = 0;
$sol_cotizadas_bs = 0;
$sol_respondidas = 0;
$sol_no_respondidas = 0;
$cantidad_dias = 0;
$resp_rapida = 0;
$resp_lenta = 0;

foreach($datos as $dt){
    if($dt->estatus == 'SDE')
        $sol_declinadas++;
    else{
        $fregistro = new DateTime($dt->fregistro);
        $fcotizado = new DateTime($dt->fcotizacion);
        if(isset($fcotizado))
            $cotizado = new DateTime();
        if($dt->estatus == 'SCR' || $dt->estatus == 'SAA' || $dt->estatus == 'SEP' || $dt->estatus == 'SMI' || $dt->estatus == 'MIC' || $dt->estatus == 'MIR' || $dt->estatus == 'COC' || $dt->estatus == 'CPA' || $dt->estatus == 'CPL')
            $sol_no_respondidas++;
        else{
            $sol_respondidas++;
            if($dt->moneda == 'D')
                $sol_cotizadas_dol++;
            else
                $sol_cotizadas_bs++;
        }
    
        $diff = $fcotizado->diff($fregistro);
        $diff = $diff->format('%d');
        $cantidad_dias += $diff;
    }

    if($dt->estatus != 'SCR' && $dt->estatus != 'SAA' && $dt->estatus != 'SEP' && $dt->estatus != 'SMI' && $dt->estatus != 'MIC' && $dt->estatus != 'MIR' && $dt->estatus != 'COC' && $dt->estatus != 'CPA' && $dt->estatus != 'CPL' && $dt->estatus != 'SDE'){
        if($diff <= 2 || $dt->estatus == 'SDE')
            $resp_rapida++;
        else
            $resp_lenta++;
    }

}

if($sol_totales > 0) {
    $porcentaje_respondidas = ($resp_rapida*100)/($resp_rapida+$resp_lenta);
    $promedio_dias = $cantidad_dias/($sol_no_respondidas+$sol_respondidas);
}
else{
    $porcentaje_respondidas = $promedio_dias = 0;
}

@endphp

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <title>Capacidad de Respuesta</title>
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
        <td style="text-align:left">Capacidad de Respuesta</td>     
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
        <td value="<?php echo $sol_totales; ?>"><strong>SOLICITUDES</strong></td>
        <td colspan="2"><?php echo $sol_totales; ?></td>
        <td><strong>PROMEDIO DÍAS</strong></td>
        <td colspan="2"><?php echo number_format($promedio_dias,2,'.',',') .' día(s) '; ?></td>      
    </tr>
    <tr>
        <td><strong>DECLINADAS</strong></td>
        <td colspan="2"><?php echo $sol_declinadas; ?></td>
        <td><strong>SIN RESPUESTA</strong></td>
        <td colspan="2"><?php echo $sol_no_respondidas; ?></td>     
    </tr>
    <tr>
        <td><strong>COTIZADOS Bs.</strong></td>
        <td colspan="2"><?php echo $sol_cotizadas_bs;?></td>    
        <td><strong>COTIZADOS US$</strong></td>
        <td colspan="2"><?php echo $sol_cotizadas_dol;?></td>           
    </tr>
    <tr>
        <td><strong>RESP. <= A 2 DÍAS</strong></td>
        <td colspan="2"><?php echo $resp_rapida; ?></td>
        <td><strong>RESP. > A 2 DÍAS</strong></td>
        <td colspan="2"><?php echo $resp_lenta;?></td>          
    </tr>   
    <tr>
        <td colspan="6"></td>       
    </tr>
    <tr>
        <td><strong>TOTAL RESPUESTAS</strong></td>
        <td><?php echo $sol_respondidas;?></td>
        <td><strong>RESULTADO</strong></td>
        <td ><?php echo number_format($porcentaje_respondidas,2,',','.');?>%</td>
        <td><strong>META GENERAL</strong></td>
        <td><?php echo "62% <= 2 días" ?></td>      
    </tr>
    
</table>
    
<input type="hidden" id="sol_totales" value="<?php echo $sol_totales; ?>">
<input type="hidden" id="sol_cotizadas" value="<?php echo $sol_respondidas; ?>">
<input type="hidden" id="sol_declinadas" value="<?php echo $sol_declinadas; ?>">
<input type="hidden" id="sol_no_respuesta" value="<?php echo $sol_no_respondidas; ?>">
<input type="hidden" id="prom_respondidas" value="<?php echo $porcentaje_respondidas ?>">
<input type="hidden" id="prom_minimo" value="62">

<table style="margin:10px auto; width:900px;" class="iguales2">
    <tr style="font-weight:bold; background: #ccc;">
        <td><strong>SOLICITUDES</strong></td>       
    </tr>
    <tr>
        <td>
            <canvas id="graf_solicitudes" width="400" height="200"></canvas>
        </td>       
    </tr>
</table>

<table style="margin:10px auto; width:900px;" class="iguales2">
    <tr style="font-weight:bold; background: #ccc;">
        <td><strong>RENDIMIENTO (%)</strong></td>       
    </tr>
    <tr>
        <td>
            <canvas id="graf_rendimiento" width="400" height="200"></canvas>
        </td>       
    </tr>
</table>
<form id="reporte_general_cr" action="{{route('reportes_generales_add_db')}}" class="col-auto" method="post">
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
        <input type="hidden" id="tipo" name="tipo" value="CDRG">
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
var ctx = $("#graf_solicitudes");
var sol_totales = $("#sol_totales").val();
var sol_cotizadas = $("#sol_cotizadas").val();
var sol_declinadas = $("#sol_declinadas").val();
var sol_no_respuesta = $("#sol_no_respuesta").val();
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Totales", "Cotizadas","Declinadas", "Sin respuesta",],
        datasets: [{
            data: [sol_totales, sol_cotizadas, sol_declinadas, sol_no_respuesta],
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