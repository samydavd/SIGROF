@extends('layout')

@section('contenido')
<header class="page-header">
            <div class="container-fluid">
              <h3 class="no-margin-bottom">Principal</h3>
            </div>
</header>

<!--Dashboard estadísticas solicitudes de cotización-->
          <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
              <div class="row bg-white has-shadow">
                <!-- Item -->
                <div class="col-xl-3 col-sm-3">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-violet"><i class="icon-user"></i></div>
                    <div class="title"><span>NUEVAS</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 50%; height: 4px;" aria-valuenow="{#val.value}" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-violet"></div>
                      </div>
                    </div>
                    <div class="number"><strong>{{$req['nuevas']}}</strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-3">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-red"><i class="icon-padnote"></i></div>
                    <div class="title"><span>PROCESO</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 50%; height: 4px;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-red"></div>
                      </div>
                    </div>
                    <div class="number"><strong>{{$req['proceso']}}</strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-3">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-green"><i class="icon-bill"></i></div>
                    <div class="title"><span>COTIZADA</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 30%; height: 4px;" aria-valuenow="{#val.value}" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-green"></div>
                      </div>
                    </div>
                    <div class="number"><strong>{{$req['cotizadas']}}</strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-3">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-orange"><i class="icon-check"></i></div>
                    <div class="title"><span>ENVIADA</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 50%; height: 4px;" aria-valuenow="{#val.value}" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-orange"></div>
                      </div>
                    </div>
                    <div class="number"><strong>{{$req['enviadas']}}</strong></div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- Dashboard Cuerpo   -->
          <section class="dashboard-header">
            <div class="container-fluid">
              <div class="row">
                <!-- Estadisticas -->
                <div class="statistics col-lg-3 col-12">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="fa fa-tasks"></i></div>
                    <div class="text"><strong>{{$req['ord_nuevas']}}</strong><br><small>Ordenes Nuevas</small></div>
                  </div>
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-green"><i class="fa fa-calendar-o"></i></div>
                    <div class="text"><strong>{{$req['ord_proceso']}}</strong><br><small>Ordenes Proceso</small></div>
                  </div>
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-orange"><i class="fa fa-paper-plane-o"></i></div>
                    <div class="text"><strong>{{$req['ord_facturadas']}}</strong><br><small>Ordenes Facturadas</small></div>
                  </div>
                </div>
                <!-- Grafica de ordenes de la empresa  -->
                <div class="chart col-lg-6 col-12">
                  <div class="line-chart bg-white d-flex align-items-center justify-content-center has-shadow">
                    <canvas id="graf_ordenes"></canvas>
                  </div>
                </div>
                <div class="chart col-lg-3 col-12">
                  <!-- Requisiciones Mensuales  -->
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-violet"><i class="fa fa-folder-open-o"></i></div>
                    <div class="text"><strong>{{$req['total']}}</strong><br><small>Requerimientos totales</small></div>
                  </div>
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-green"><i class="fa fa-money"></i></div>
                    <div class="text"><strong>{{$req['ord_totales']}}</strong><br><small>Ordenes Totales</small></div>
                  </div>
                  @isset($req['carga_departamento'])
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-blue"><i class="fa fa-building-o"></i></div>
                    <div class="text"><strong>{{number_format($req['carga_departamento'],2,'.',',')}}%</strong><br><small>Solicitudes para el Departamento</small></div>
                  </div>
                  @else
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-blue"><i class="fa fa-building-o"></i></div>
                    <div class="text"><strong>{{number_format($req['carga_empresa'],2,'.',',')}}%</strong><br><small>Solicitudes para la Empresa</small></div>
                  </div>
                  @endif
                  <!-- Satisfaccion Clientes-->
                  <!--div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-green"><i class="fa fa-line-chart"></i></div>
                    <div class="text"><strong>87.98%</strong><br><small>Satisfacción Clientes</small></div>
                  </div-->
                </div>
              </div>
            </div>
          </section>

@endsection

@section('librerias_end')
<script src="js/charts-home.js"></script>
<script src="js/chart.js/Chart.min.js"></script>
<script src="js/front.js"></script> 
@endsection

@section('script')
<script>

var ctx = document.getElementById("graf_ordenes");
var ord_nuevas = {{$req['ord_nuevas']}};
var ord_proceso = {{$req['ord_proceso']}};
var ord_facturadas = {{$req['ord_facturadas']}};
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Nuevas", "En proceso", "Facturadas",],
        datasets: [{
            data: [ord_nuevas, ord_proceso, ord_facturadas],
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',         
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
    	responsive: true,
        legend: {
            display: false
         },
         tooltips: {
            enabled: false
         },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    callback: function (value) { if (Number.isInteger(value)) { return value; } },
                    stepSize: 1
                }
            }]
        }
    }
});
</script>
@endsection