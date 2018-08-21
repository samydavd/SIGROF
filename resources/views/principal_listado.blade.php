@extends('layout')
@extends('librerias_tablas')

@section('extra')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid-title">
        <h2 class="no-margin-bottom">Inicio</h2>
    </div>
</header>

<div class="breadcrumb-holder container-fluid-title">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Requisiciones</li>
    </ul>
</div>

@if(session('data') !== null && session('data') != "error")
  <script type="text/javascript">
      swal("Acción completada", '{{session('data')}}', "success");
      session('data') == null; //Revisar
  </script>
@elseif(session('data') == "error")
  <script type="text/javascript">
    swal("Ha ocurrido un problema", "El registro no ha podido ser almacenado. Si el problema persiste pongase en contacto con el departamento de soporte", "error");
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
                          data-search="true"
                          data-resizable="true"
                          data-mobile-responsive="true"
                          data-show-multi-sort="true"
                          data-show-refresh="true" 
                          data-sort-name="id"
                          data-sort-order="desc"
                          data-show-export="true" 
                          data-side-pagination="client" 
                          data-page-size="10" 
                          data-page-list="[10, 25, 50, 100, ALL]">
						            <thead style="font-weight: bold;"> <!--style="background: #FF6A6A; color: white" -->
                          <tr>
                            <th data-field="prioridad"></th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" class ="w5" data-field="id">#</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-title-tooltip="Tipo" data-field="tipo">TP</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-title-tooltip="Mercadeo" data-field="mcdo">MD</th>
                            <th data-sortable="true" data-filter-control="select" class="w12" data-filter-stric-search="true" data-field="scliente">Subcliente</th>
                            <!--th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="asunto">Asunto</th-->
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="clave">Clave</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Departamento" class="w8" data-field="departamento">Dep</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Request for quotation" data-field="rfq">RFQ</th>
                            <!--th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="profit">Profit</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Orden de compra" data-field="po">PO</th-->
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Items Requeridos" class ="w5" data-field="ir">IR</th>
                            <!--th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Items Aprobado" class ="w5" data-field="ia">IA</th-->
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="registro">F. Reg</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="estatus">Estatus</th>
                            <th data-field="acciones">Acciones</th>
                          </tr>
                        </thead>
						          </table>
                    </div>
                  </div>
                </div>
              </div>
          </section>
             
             <!--center>
                 <a href="{{-- route('empresas_add') --}}" class="btn btn-success">Registrar Empresa</a>
            </center-->
@endsection

@section('script')
<script type="text/javascript">
  var requisiciones = <?php echo $datos; ?>; 
  var filter = <?php if(isset($filter)) echo '"'. $filter. '"'; else echo "null"; ?>;
  var datos = [];

  function parseDate(str) {
    var mdy = str.split('-');
    return new Date(mdy[0], mdy[1]-1, mdy[2]);
  }

  function datediff(first, second) {
      return Math.round((second-first)/(1000*60*60*24));
  }

  console.log(requisiciones);


  /*function eliminar(id, nombre){
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
  }*/

  //Lograr validación de formularios en sweet alert con AJAX

  function declinar(id_requerimiento, cliente, scliente, rfq){
    var html = '<form id="declinar" method="post" action="{{route('declinar')}}">'+
    '{{csrf_field()}}' +
    '<div class="form-swal"><label class="text-primary">Subcliente</label><p>'+scliente+'</p></div>'+
    '<div class="form-swal"><label class="text-primary">RFQ</label><p>'+rfq+'</p></div>'+
    '<div class="form-swal"><label class="text-primary margin-auto">Declinada por</label><select id="razon" name="razon" class="form-control col-lg-8 col-sm-8 margin-bottom" required><option value="">Seleccionar</option><option value="C">Cliente</option><option value="S">Sersinca</option></div></select></div>'+
    '<div class="form-swal"><label class="text-primary margin-auto">Comentarios</label><textarea id="obs" name="obs" type="text" placeholder="Indique los detalles de la declinación del requerimiento" class="form-control col-lg-8 col-sm-8" required></textarea></div>'+
    '<input id="id_req" name="id_req" type="hidden" value="'+ id_requerimiento +'"/>' +
    '<input type="submit" class="btn btn-danger margin-right" value="Declinar">'+
    '<a href="javascript:swal.close();" class="btn btn-dark">Cancelar</a>'+
    '</form>';

    swal({
      title: "Declinar el requerimiento #" + id_requerimiento,
      showConfirmButton: false,
      html: html,
      //customClass: 'swal-title'
      })/*.then((result) => {
        if (result.value) {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
          $.ajax({
            data: {_token: CSRF_TOKEN, 'id_req': id_requerimiento},
            url: 'declinar',
            type: 'post',
            success: function(data){
              datos = datos.filter(item => item.id !== ("0000" + id_requerimiento).substr(-4,4));
              $('#table').bootstrapTable("load", datos);
              swal(
                "Acción completada", 
                "El requerimiento #" + id + " ha sido declinado con exito", 
                "success");
            },
            error: function() {
                swal(
                  "Ha ocurrido un problema", 
                  "Ha ocurrido un error en el servidor", 
                  "error");
              }
          });
        }       
      });*/
  }

  $(function () {
    var  today = new Date();
    var mes = today.getMonth() + 1;

    requisiciones.forEach(function(v){
      var departamento = '<span title="'+ v.dprincipal +'">'+ v.dprincipal_sg +'</span> ';
      var cliente = "'" + v.nombre_cliente + "'";
      var scliente = "'" + v.nombre_sub + "'";
      var rfq = "'"+v.rfq+"'";
      
      if(v.dias == 0)
        var dias = 'Hoy';
      else if(v.dias == 1)
        var dias = 'Ayer';
      else
        var dias = v.dias + ' días';

      if (v.dsecundario)
        departamento += '- <span title="'+ v.dsecundario +'">'+ v.dsecundario_sg +'</span>';

      if (v.tipo == 'S'){
        var tipo = "Sol";
        var acciones = '<a href="requerimientos_detalles/'+ v.id_requerimiento + '" class="text-success"><i class="fa fa-plus-square fa-lg"></i></a>';

        if(v.prioridad == 'N')
          var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" title="Normal"> </div>';
        else if (v.prioridad == 'I')
          var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" style="background: #FFA74F" title="Inmediata"> </div>';
        else if (v.prioridad == 'U')
          var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" style="background: #FE3D4B" title="Urgente"> </div>';
        else
          var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" style="background: #FEE13F" title="Abierta"> </div>';
      }
      else{
        var tipo = "Ord";
        var acciones = '<a href="ordenes_detalles/'+ v.id_requerimiento + '" class="text-success"><i class="fa fa-plus-square fa-lg"></i></a>';

        var prioridad = '<a href="{{asset('storage/ordenes')}}/'+v.adjunto+'" target="_blank"><div data-toggle="tooltip" data-placement="top" style="padding-right:6px" title="Orden de compra creada"><img src="{{asset('img/PO.png')}}" style="width: 16px; height: 16px;"></div></a>';
      }

      if(v.estatus == 'SEP' || v.estatus == 'SCR' || v.estatus == 'SAA' || v.estatus == 'COC' || v.estatus == 'COA' || v.estatus == 'CPA' || v.estatus == 'CPL')
        acciones += ' <a href="empresas_add/'+ v.id_requerimiento + '"><i class="fa fa-gear fa-lg"></i></a> <a href="javascript:declinar('+ v.id_requerimiento +','+cliente+','+ scliente +','+rfq+');" class="text-danger"><i class="fa fa-times-circle fa-lg"></i></a>';

      datos.push({
        id: ("0000" + v.id_requerimiento).substr(-4,4),
        prioridad: prioridad,
        tipo: tipo,
        mcdo: '<div title="'+ v.encargado +'">'+ v.iniciales +'</div>', 
        scliente: v.nombre_sub, 
        asunto: v.asunto,
        clave: v.p_claves,
        departamento: departamento,
        rfq: v.rfq,
        ir: v.ir,
        //registro: v.fregistro + '<b> ('  + dias + ' días) </b>',
        registro: dias,
        estatus: ver_estado_requerimiento(v.estatus),
        acciones: acciones
      });
    });

    $('#table').bootstrapTable("load", datos);
    
    /*$('#table').bootstrapTable({
      formatLoadingMessage: function () {
            return "Espere";
      }
    });

    $("#table").bootstrapTable("showLoading");

    setTimeout(function () {$("#table").bootstrapTable("hideLoading");}, 1000);*/


    /*if(filter){
      $('select.tipo').val(filter);
      $('select.tipo').trigger('change');
    }*/
  });

  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });
  

</script>

@endsection