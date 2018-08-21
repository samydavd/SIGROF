@extends('layout')
@extends('librerias_tablas')

@section('extra')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Listado de Departamentos</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Departamentos</li>
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
                          data-page-size="15" 
                          data-page-list="[15, 25, 50, 100, ALL]">
						            <thead style="font-weight: bold;"> <!--style="background: #FF6A6A; color: white" -->
                          <tr>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="nombre_dep">Nombre</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="empresa">Empresa</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="tipo">Tipo</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="limitebs">Limite en Bolivares</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="limitedol">Limite en Dolares</th>
                            <th data-field="acciones">Acciones</th>
                          </tr>
                        </thead>
                        
  
						          </table>
                    </div>
                  </div>
                </div>
              </div>
          </section>
            @if(session('acceso')->departamentos[0])
            <center style="margin-bottom: 3.5em;">
                 <a href="{{ route('departamentos_add')}}" class="btn btn-success btn-sm">Registrar Departamento</a>
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

  var departamentos = <?php echo $departamentos; ?>;
  var datos = [];

  function eliminar(id, nombre, empresa){
    swal({
      title: "¿Esta seguro?",
      text: "Eliminar el departamento " + nombre + " correspondiente a la empresa " + empresa,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ok'
      }).then((result) => {
        if (result.value) {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
          $.ajax({
            data: {_token: CSRF_TOKEN, 'id_dep': id},
            url:   'departamentos_elm',
            type:  'post',
            success: function(data){
              datos = datos.filter(item => item.id !== id);
              $('#table').bootstrapTable("load", datos);
              swal("Acción completada", "El departamento " + nombre + " ha sido eliminado con exito", "success");
            },
            error: function() {
                swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
              }
          });
        }       
      });
  }

  $(function () {
    var permiso_mod = {{session('acceso')->departamentos[2]}};
    var permiso_elm = {{session('acceso')->departamentos[6]}};

    departamentos.forEach(function(v){
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

      var nombre = "'" + v.nombre_dep + "'";
      var empresa = "'" + v.nombre_emp + "'";

      var acciones = '';

      if(permiso_mod)
        acciones += '<a href="departamentos_add/'+ v.id + '" disabled><i class="fa fa-gear fa-lg"></i></a> ';
      if(permiso_elm)
        acciones += '<a href="javascript:eliminar('+ v.id +','+ nombre +','+ empresa +');" class="text-danger"><i class="fa fa-times-circle fa-lg"></i></a>';
      
      datos.push({
        id: v.id,
        nombre_dep: v.nombre_dep,
        empresa: v.nombre_emp,
        tipo: tipo, 
        limitebs: v.limitebs, 
        limitedol: v.limitedol,
        acciones: acciones
      });
    });
    $('#table').bootstrapTable("load", datos);
  });

</script>

@endsection