@extends('layout')
@extends('librerias_tablas')

@section('extra')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Listado de Subclientes</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Subclientes</li>
    </ul>
</div>

@if(session('data') == "success")
  <script type="text/javascript">
     swal("Acción completada", "El usuario ha sido modificado exitosamente", "success");
  </script>
@elseif(session('data') == "error")
  <script type="text/javascript">
    swal("Ha ocurrido un problema", "El registro no ha podido ser modificado. Si el problema persiste pongase en contacto con el departamento de soporte", "error");
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
                          data-side-pagination="client" 
                          data-page-size="15" 
                          data-page-list="[15, 25, 50, 100, ALL]">
						            <thead style="font-weight: bold;"> <!--style="background: #FF6A6A; color: white" -->
                          <tr>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="nombre">Nombre</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="telf">Telefono</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="email">Email</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="tipo">Tipo</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="super">Superintendente</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="comp">Comprador</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="admin">Administrador</th>
                            <th data-field="acciones">Acciones</th>
                          </tr>
                        </thead>
						          </table>
                    </div>
                  </div>
                </div>
              </div>
          </section>
            @if(session('acceso')->clientes[2])
              <center style="margin-bottom: 3.5em;">
                 <a href="{{ route('subclientes_add')}}" class="btn btn-success btn-sm">Registrar Subcliente</a>
              </center>
            @endif
@endsection

@section('script')
<script type="text/javascript">

  var subclientes = <?php echo $subclientes; ?>;
  var datos = [];

  function eliminar(id, nombre){
    swal({
      title: "¿Esta seguro?",
      text: "Eliminar el subcliente correspondiente a " + nombre,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ok'
      }).then((result) => {
        if (result.value) {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
          $.ajax({
            data: {_token: CSRF_TOKEN, 'id_subcliente': id},
            url:   'subclientes_elm',
            type:  'post',
            success: function(data){
              datos = datos.filter(item => item.id !== id);
              $('#table').bootstrapTable("load", datos);
              swal("Acción completada", "El subcliente " + nombre + " ha sido eliminado con exito", "success");
            },
            error: function() {
                swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
              }
          });
        }       
      });
  }

  $(function () {
    var permiso_mod = {{session('acceso')->clientes[6]}}
    var permiso_elm = {{session('acceso')->clientes[10]}}
   subclientes.forEach(function(v){
      var nombre = "'" + v.nombre_sub + "'";
      var acciones = '';

      switch(v.tipo){
        case('1'):
          var tipo = 'Buque';
          break;
        case('2'):
          var tipo = 'Plataforma';
          break;
        case('3'):
          var tipo = 'Oficina';
          break;
        case('4'):
          var tipo = 'Otros';
          break;
      }

      if(v.super)
        var superint = v.super.nombre_super;
      else
        var superint = 'S/I';

      if(v.comp)
        var comp = v.comp.nombre_comp;
      else
        var comp = 'S/I';

      if(v.admin)
        var admin = v.admin.nombre_admin;
      else
        var admin = 'S/I';

      if(permiso_mod)
        acciones += '<a href="subclientes_add/'+ v.id_cliente + '/'+ v.id_subcliente + '"><i class="fa fa-gear fa-lg"></i></a> ';
      if(permiso_elm)
        acciones += '<a href="javascript:eliminar('+ v.id_subcliente +','+ nombre +');" class="text-danger"><i class="fa fa-times-circle fa-lg"></i></a>';
  
      datos.push({
        id: v.id_subcliente,
        nombre: v.nombre_sub, 
        telf: v.telf_sub, 
        email: v.email_sub,
        tipo: tipo,
        super: superint,
        comp: comp,
        admin: admin,
        acciones: acciones
      });
    });
    $('#table').bootstrapTable("load", datos);
  });

  //fa fa-ban fa fa-times-circle

</script>

@endsection