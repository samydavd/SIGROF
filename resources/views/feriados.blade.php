@extends('layout')
@extends('librerias_tablas')

@section('extra')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Listado de Feriados</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Feriados</li>
    </ul>
</div>

@if(session('data') == "success")
  <script type="text/javascript">
    $(window).ready(function(){
      swal("Acción completada", "El día feriado ha sido actualizado exitosamente", "success")});
  </script>
@elseif(session('data') == "error")
  <script type="text/javascript">
    swal("Ha ocurrido un problema", "El registro no ha podido ser actualizado. Si el problema persiste pongase en contacto con el departamento de soporte", "error");
  </script>
@endif

<section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card card-table">
                      <table id="table"
                          class="small" 
                          data-toggle="table" 
                          data-filter-control="true" 
                          data-filter-show-clear="true"
                          data-show-columns="true"
                          data-pagination="true"
                          --data-pagination-v-align='both'
                          --data-cache="true"
                          data-resizable="true"
                          data-mobile-responsive="true"
                          data-show-multi-sort="true"
                          data-show-refresh="true" 
                          data-sort-name="id"
                          data-sort-order="desc"
                          data-show-export="true" 
                          data-search="true"
                          data-side-pagination="client" 
                          data-page-size="15" 
                          data-page-list="[15, 25, 50, 100, ALL]">
						            <thead style="font-weight: bold;"> <!--style="background: #FF6A6A; color: white" -->
                          <tr>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="descripcion">Descripción</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="diames">Día / Mes</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="año">Año</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="semana">Semana (día)</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="permanente">Permanente</th>
                            <th data-field="acciones">Acciones</th>
                          </tr>
                        </thead>
						          </table>
                    </div>
                  </div>
                </div>
              </div>
          </section>
             @if(session('acceso')->feriados[0])
              <center>
                 <a href="{{ route('feriados_add')}}" class="btn btn-success btn-sm">Registrar Feriado</a>
              </center>
            @endif
@endsection

@section('script')
<script type="text/javascript">
  var feriados = <?php echo $feriados; ?>;
  var datos = [];

  function eliminar(id, nombre){
    swal({
      title: "¿Esta seguro?",
      text: "Eliminar el feriado correspondiente a " + nombre,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ok'
      }).then((result) => {
        if (result.value) {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
          $.ajax({
            data: {_token: CSRF_TOKEN, 'id_feriado': id},
            url:   'feriados_elm',
            type:  'post',
            success: function(data){
              datos = datos.filter(item => item.id !== id);
              $('#table').bootstrapTable("load", datos);
              swal("Acción completada", "El feriado " + nombre + " ha sido eliminado con exito", "success");
            },
            error: function() {
                swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
              }
          });
        }       
      });
  }

  function diaSemana(fecha){
    var dias=["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
    var dt = new Date(fecha[1]+'/'+fecha[2]+'/'+fecha[0]);
    return(dias[dt.getUTCDay()]);   
  };

  Date.prototype.getWeekNumber = function () {
    var d = new Date(+this);
    d.setHours(0, 0, 0, 0);  
    d.setDate(d.getDate() + 4 - (d.getDay() || 7));
    return Math.ceil((((d - new Date(d.getFullYear(), 0, 1)) / 8.64e7) + 1) / 7);
  };

  $(function () {
    var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                 'Junio', 'Julio', 'Agosto', 'Septiembre',
                 'Octubre', 'Noviembre', 'Diciembre'];   
    var permiso_mod = {{session('acceso')->feriados[0]}};
    var permiso_elm = {{session('acceso')->feriados[6]}};  
    feriados.forEach(function(v){
      var descripcion = "'" + v.descripcion + "'";
      var fecha = v.fecha.split('-');
      if(v.repeticion)
        var permanente = "Si";
      else
        var permanente = "No";

      var acciones = '';

      if(permiso_mod)
        acciones += '<a href="feriados_add/'+ v.id_feriado + '"><i class="fa fa-gear fa-lg"></i></a> ';
      if(permiso_elm)
        acciones += '<a href="javascript:eliminar('+ v.id_feriado +','+ descripcion +');" class="text-danger"><i class="fa fa-times-circle fa-lg"></i></a>';


      datos.push({
        id: v.id_feriado,
        descripcion: v.descripcion,
        diames: fecha[2] + ' de ' + meses[fecha[1] - 1],
        año: fecha[0],
        semana: new Date(fecha).getWeekNumber() + ' (' + diaSemana(fecha) + ')',
        permanente: permanente,
        acciones: acciones
      });
    });
    $('#table').bootstrapTable("load", datos);
  });
  //$('#table').bootstrapTable('data-resizable', true);
</script>

@endsection