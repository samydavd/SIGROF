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
        <h3 class="no-margin-bottom">Listado de Niveles de Usuario</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Niveles de Usuario</li>
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
                          data-sort-name="id"
                          data-sort-order="desc"
                          data-show-export="true" 
                          data-search="true"
                          data-side-pagination="client" 
                          data-page-size="10" 
                          data-page-list="[10, 25, 50, 100, ALL]">
                        <thead style="font-weight: bold;"> <!--style="background: #FF6A6A; color: white" -->
                          <tr>                       
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="id">ID Nivel</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="nombre">Nombre</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="mpa">Mapa de Acceso Asignado</th>
                            <!--th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="tda">Tipo de departamento asociado</th-->
                            <th data-field="acciones" class="w7">ACC</th>
                          </tr>
                        </thead>
                        
  
                      </table>
                    </div>
                  </div>
                </div>
              </div>
          </section>
             
            <center style="margin-bottom: 3.5em;">
                 <a href="{{ route('niveles_add')}}" class="btn btn-success btn-sm">Registrar nivel</a>
            </center>
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

  var niveles = <?php echo $datos; ?>;
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
    niveles.forEach(function(v){
      /*var nombre = "'" + v.nombre_cliente + "'";

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
        var tipo = "Publicidad"
      else if(v)
        var tipo = "Suministro"*/

      if (v.tipo_dep == "SE")
        var tipo = "Servicio"
      else if (v.tipo_dep == "SU")
        var tipo = "Suministro"
      else if (v.tipo_dep == "ME")
        var tipo = "Mercadeo"
      else if (v.tipo_dep == "AD")
        var tipo = "Administración"
      else if (v.tipo_dep == "GE")
        var tipo = "Gerencia"
      else if (v.tipo_dep == "OP")
        var tipo = "Logistica/Transporte"
       else if (v.tipo_dep == "CA")
        var tipo = "Calidad"
      else
        var tipo = "Apoyo"
      
      datos.push({
        id: v.id_nivel,
        nombre: v.nombre_nivel,
        mpa: v.nombre_mapa, 
        //tda: v.tipodep;
        acciones: '<a href="niveles_add/'+ v.id_nivel + '"><i class="fa fa-gear fa-lg"></i></a>'});
    });
    $('#table').bootstrapTable("load", datos);
  });

</script>

@endsection