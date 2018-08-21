@extends('layout')
@extends('librerias_tablas')

@section('extra')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@endsection

@extends('librerias_tablas')

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Listado de Clientes</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Clientes</li>
    </ul>
</div>

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
                          data-sort-name="nombre"
                          data-sort-order="asc"
                          data-show-export="true" 
                          data-search="true"
                          data-side-pagination="client" 
                          data-page-size="15" 
                          data-page-list="[15, 25, 50, 100, ALL]">
                        <thead style="font-weight: bold;"> <!--style="background: #FF6A6A; color: white" -->
                          <tr>                       
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="nombre">Nombre</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="tipo">Tipo</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="pais">País</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="medio">Medio</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="fregistro">Fecha de registro</th>
                            <th data-field="acciones">ACC</th>
                          </tr>
                        </thead>
                        
  
                      </table>
                    </div>
                  </div>
                </div>
              </div>
          </section>
            @if(session('acceso')->clientes[0]) 
            <center style="margin-bottom: 3.5em;">
                 <a href="{{ route('clientes_add')}}" class="btn btn-success btn-sm">Registrar cliente</a>
            </center>
            @endif
@endsection

@section('script')
<script type="text/javascript">
  /*$(function () {
  var $table = $('#table');
  $('#toolbar').find('select').change(function () {
    $table.bootstrapTable('refreshOptions', {
      exportDataType: $(this).val()    
    });
  });
});*/

  var clientes = <?php echo $clientes; ?>;
  var datos = [];

  function eliminar(id, nombre){
    swal({
      title: "¿Esta seguro?",
      text: "Eliminar el usuario correspondiente a " + nombre,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ok'
      }).then((result) => {
        if (result.value) {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
          $.ajax({
            data: {_token: CSRF_TOKEN, 'id_cliente': id},
            url:   'clientes_elm',
            type:  'post',
            success: function(data){
              datos = datos.filter(item => item.id !== id);
              $('#table').bootstrapTable("load", datos);
              swal("Acción completada", "El cliente " + nombre + " ha sido eliminado con exito", "success");
            },
            error: function() {
                swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
              }
          });
        }       
      });
  }

  $(function () {
    var permiso_mod = {{session('acceso')->clientes[4]}};
    var permiso_elm = {{session('acceso')->clientes[10]}};

    clientes.forEach(function(v){
      var nombre = "'" + v.nombre_cliente + "'";
      var acciones = ''; 

      switch(v.medio){
          case(1):var medio = 'Publicidad';
                  break;
          case(2):var medio = 'Referencia del cliente';
                  break;
          case(3):var medio = 'Google';
                  break;
          case(4):var medio = 'Página web';
                  break;
          case(5):var medio = 'Redes sociales';
                  break;
          case(6):var medio = 'Personal';
                  break;
          default:var medio = 'Otros';
                  break;
      }
         
      if (v.medio = '1')
        var tipo = "Publicidad";
      else if(v)
        var tipo = "Suministro";

      if(permiso_mod)
        acciones += '<a href="clientes_add/'+ v.id_cliente + '"><i class="fa fa-gear fa-lg"></i></a> ';
      if(permiso_elm)
        acciones += '<a href="javascript:eliminar('+ v.id_cliente +','+ nombre +');" class="text-danger"><i class="fa fa-times-circle fa-lg"></i></a>';
      
      datos.push({
        id: v.id_cliente,
        tipo: 'Prospecto',
        nombre: v.nombre_cliente, 
        pais: v.pais, 
        medio: medio, 
        fregistro: v.fregistro,
        acciones: acciones
      });
    });
    $('#table').bootstrapTable("load", datos);
  });

</script>

@endsection