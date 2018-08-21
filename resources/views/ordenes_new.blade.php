@extends('layout')
@extends('librerias_tablas')

@section('extra')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('js/estados.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid-title">
        <h3 class="no-margin-bottom">Nueva Orden de Compra</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid-title">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Nueva orden de compra</li>
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
						            <thead>
                          <tr>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" class ="w5" data-field="id">#</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-title-tooltip="Mercadeo" data-field="mcdo">MD</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="cliente">Cliente</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="scliente">Subcliente</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="encargado">Encargado</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="asunto">Asunto</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Departamento" class ="w5" data-field="departamento">Dep</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Request for quotation" data-field="rfq">RFQ</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="cotizacion">Cotización</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Items Cotizados" class ="w5" data-field="ic">IC</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="fenvio">F. Envío</th>
                            <th data-title-tooltip="Acciones" data-field="acciones">ACC</th>
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

  function parseDate(str) {
    var mdy = str.split('-');
    return new Date(mdy[0], mdy[1]-1, mdy[2]);
  }

  function datediff(first, second) {
      return Math.round((second-first)/(1000*60*60*24));
  }

  function rechazar(id, cliente, scliente, rfq, fenvio, ic){
    var html =
           '<div class="form-swal"><label class="text-primary">Cliente</label><p> '+ cliente +' <i class="fa fa-arrow-right"></i> '+ scliente +'  </p></div>'+
           '<div class="form-swal"><label class="text-primary">RFQ</label><p>'+ rfq +'</p></div>' + 
           '<div class="form-swal"><label class="text-primary">Items Cotizados</label><p>'+ ic +' items</p></div>' + 
           '<div class="form-swal"><label class="text-primary">Fecha de envio</label><p>'+ fenvio +'</p></div>' +
           '<div class="form-swal"><label class="text-primary">Comentarios</label><textarea id="obs" type="text" placeholder="Ingrese un comentario (opcional)" class="form-control col-lg-8 col-sm-8"></textarea></div>';
    const swalbt = swal.mixin({
      confirmButtonClass: 'btn btn-danger margin-right',
      cancelButtonClass: 'btn btn-dark',
      confirmButtonText: "Rechazar",
      buttonsStyling: false,
      showConfirmButton: true,
      showCancelButton: true,
      focusConfirm: false,
    });

    swalbt({
      title: "Rechazar requerimiento #"+ id +" de " + cliente,
      customClass: 'swal-wide-30',
      html: html
      }).then((result) => {
        if (result.value) {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          var observacion = $('#obs').val();
          $.ajax({
            data: {_token: CSRF_TOKEN, 'id_requerimiento': id, 'obs': observacion},
            url: 'requerimiento_rechazar',
            type: 'post',
            beforeSend: function () {
              swal.isLoading();
            },
            success: function (data) {
              datos = datos.filter(item => item.id !== id);
              $('#table').bootstrapTable("load", datos);
              swal(
                "Resultado:", 
                "El requerimiento seleccionado ha sido rechazado", 
                "success"
              );
            },
            error: function() {
              swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
            }
          });
        };
      });
  }

  $(function () {
    var today = new Date();
    var mes = today.getMonth() + 1;

    requisiciones.forEach(function(v){
      var dias = v.dias;
      if(dias == 0)
        dias = 'hoy';
      else if(dias == 1)
        dias = 'ayer';
      else
        dias = dias + ' días';

      var departamento = '<div title="'+ v.dprincipal +'">'+ v.dprincipal_sg +'</div>';

      if (v.dsecundario)
        departamento += '<div title="'+ v.dsecundario +'">'+ v.dsecundario_sg +'</div>';

      /*if(v.id_requerimiento < '10')
        var id = '000' + v.id_requerimiento; 
      else if(v.id_requerimiento < '100')
        var id = '00' + v.id_requerimiento; 
      else if(v.id_requerimiento < '1000')
        var id = '0' + v.id_requerimiento; */

      /*if(v.prioridad == 'N')
        var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" title="Normal"> </div>';
      else if (v.prioridad == 'I')
        var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" style="background: #FFA74F" title="Inmediata"> </div>';
      else if (v.prioridad == 'U')
        var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" style="background: #FE3D4B" title="Urgente"> </div>';
      else
        var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" style="background: #FEE13F" title="Abierta"> </div>';*/
      var id = ("0000" + v.id_requerimiento).substr(-4,4);
      var idstr = "'" + ("0000" + v.id_requerimiento).substr(-4,4) + "'";
      var cliente = "'" + v.cliente + "'";
      var scliente = "'" + v.nombre_sub + "'";
      var rfq = "'" + v.rfq + "'";
      var fenvio = "'" + v.fenvio + "'";
      var direccion = "storage/cotizaciones/" + v.cotizacion; 
      
      datos.push({
        id: id,
        mcdo: '<div title="'+ v.encargado +'">'+ v.iniciales +'</div>', 
        cliente: v.cliente,
        scliente: v.nombre_sub, 
        encargado: v.encargado_cot,
        asunto: v.asunto,
        clave: v.p_claves,
        departamento: departamento, 
        rfq: v.rfq,
        cotizacion: '<a href="'+ direccion +'" target="_blank">' + v.profit + '</a>',
        ic: v.ic,
        fenvio: v.fenvio +' (<b>'+ dias + '</b>)',
        acciones: '<a href="ordenes_add/'+ v.id_requerimiento + '" title="Aprobar el requerimiento #'+ id +'" class="text-success"><i class="fa fa-check-circle fa-lg"></i></a> <a href="javascript:rechazar('+ idstr +','+ cliente +','+ scliente +','+rfq+','+ fenvio +','+v.ic+');" title="Rechazar requerimiento #'+ id +'" class="text-danger"><i class="fa fa-times-circle fa-lg"></i>'
      });
    });
    
    $('#table').bootstrapTable("load", datos);
  });

  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });

</script>

@endsection