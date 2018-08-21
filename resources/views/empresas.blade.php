@extends('layout')
@extends('librerias_tablas')

@section('extra')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Listado de Empresas</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Empresas</li>
    </ul>
</div>

@if(session('data') == "success")
  <script type="text/javascript">
     swal("Acción completada", "La empresa ha sido actualizada exitosamente", "success");
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
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="nombre">Nombre</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="tipo">Tipo</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="ubicacion">Ubicación</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="telefono">Teléfono</th>
                            <th data-field="acciones">Acciones</th>
                          </tr>
                        </thead>
						          </table>
                    </div>
                  </div>
                </div>
              </div>
          </section>
            @if(session('acceso')->empresas[0])
              <center style="margin-bottom: 3.5em;">
                 <a href="{{ route('empresas_add')}}" class="btn btn-success btn-sm">Registrar Empresa</a>
              </center>
            @endif
@endsection

@section('script')
<script type="text/javascript">
  var empresas = <?php echo $empresas; ?>;
  var datos = [];

  function eliminar(id, nombre){
    swal({
      title: "¿Esta seguro?",
      text: "Eliminar la empresa correspondiente a " + nombre,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ok'
      }).then((result) => {
        if (result.value) {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
          $.ajax({
            data: {_token: CSRF_TOKEN, 'id_empresa': id},
            url:   'empresas_elm',
            type:  'post',
            success: function(data){
              datos = datos.filter(item => item.id !== id);
              $('#table').bootstrapTable("load", datos);
              swal("Acción completada", "La empresa " + nombre + " ha sido eliminado con exito", "success");
            },
            error: function() {
                swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
              }
          });
        }       
      });
  }

  $(function () {
    var permiso_mod = {{session('acceso')->empresas[2]}};
    var permiso_elm = {{session('acceso')->empresas[6]}};
    empresas.forEach(function(v){
      var nombre = "'" + v.nombre_emp + "'";
      var acciones = '';

      if (v.tipo == 0)
        var tipo = "Sede Principal"
      else
        var tipo = "Sucursal"

      if(permiso_mod)
        acciones += '<a href="empresas_add/'+ v.id_empresa + '"><i class="fa fa-gear fa-lg"></i></a> ';
      if(permiso_elm)
        acciones += '<a href="javascript:eliminar('+ v.id_empresa +','+ nombre +');" class="text-danger"><i class="fa fa-times-circle fa-lg"></i></a>';

      datos.push({
        id: v.id_empresa,
        nombre: v.nombre_emp,
        tipo: tipo, 
        ubicacion: v.ubicacion, 
        telefono: v.cod_telf + v.telefono,
        acciones: acciones
      });
    });
    $('#table').bootstrapTable("load", datos);
  });
  //$('#table').bootstrapTable('data-resizable', true);
</script>

@endsection