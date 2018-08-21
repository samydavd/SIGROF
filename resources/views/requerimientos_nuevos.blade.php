@extends('layout')
@extends('librerias_tablas')

@section('extra')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('js/estados.js')}}"></script>
<script src="{{asset('bootstrap/table/extensions/editable/bootstrap-table-editable.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid-title">
        <h2 class="no-margin-bottom">Listado de Requisiciones Nuevas</h2>
    </div>
</header>

<div class="breadcrumb-holder container-fluid-title">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Nuevas requisiciones</li>
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
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-title-tooltip="Mercadeo" data-field="mcdo">MD</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="scliente">Subcliente</th>
                            <!--th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="asunto">Asunto</th-->
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="clave">Clave</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Departamento" class ="w8" data-field="departamento">Dep</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Request for quotation" data-field="rfq">RFQ</th>
                            <!--th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="profit">Profit</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Orden de compra" data-field="po">PO</th-->
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Items Requeridos" class ="w5" data-field="ir">IR</th>
                            <!--th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Items Aprobado" class ="w5" data-field="ia">IA</th-->
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="registro">F. Reg</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="estatus">Estatus</th>
                            <th data-title-tooltip="Acciones" data-field="acciones">AC</th>
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
  var datos = [];

  console.log(requisiciones);

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

        var acciones = '<a href="requerimientos_detalles/'+ v.id_requerimiento + '" class="text-success"><i class="fa fa-plus-square fa-lg"></i></a>';

        if(v.prioridad == 'N')
          var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" title="Normal"> </div>';
        else if (v.prioridad == 'I')
          var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" style="background: #FFA74F" title="Inmediata"> </div>';
        else if (v.prioridad == 'U')
          var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" style="background: #FE3D4B" title="Urgente"> </div>';
        else
          var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" style="background: #FEE13F" title="Abierta"> </div>';

      datos.push({
        id: ("0000" + v.id_requerimiento).substr(-4,4),
        prioridad: prioridad,
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