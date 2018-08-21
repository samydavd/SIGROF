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
        <h3 class="no-margin-bottom">Listado de Cotizaciones por aprobar</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid-title">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Cotizaciones por aprobar</li>
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
						            <thead style="font-weight: bold;"> <!--style="background: #FF6A6A; color: white" -->
                          <tr>
                            <th data-field="prioridad"></th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" class ="w5" data-field="id">#</th>
                            <th data-filter-control="select" data-filter-stric-search="true" data-title-tooltip="Unidad de mercadeo encargada" class ="w5" data-field="mcdo">MD</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="cliente">Cliente</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="scliente">Subcliente</th>
                            <!--th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="asunto">Asunto</th-->
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" class ="w5" data-field="departamento">Dep</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="rfq" class ="w10" data-field="rfq">RFQ</th>
                            <!--th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="profit">Profit</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Orden de compra" data-field="po">PO</th-->
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Items Requeridos" class ="w5" data-field="ir">IR</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Items Cotizados" class ="w5" data-field="ic">IC</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="monto">Monto</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" class='w5' data-field="fcotizacion">F. Cot</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="estatus">Estatus</th>
                            <th data-title-tooltip="Acciones" data-field="acciones">ACC</th>
                          </tr>
                        </thead>
						          </table>
                    </div>
                  </div>
                </div>
              </div>
          </section>
             
@endsection

@section('script')
<script type="text/javascript">
  var cotizaciones = <?php echo $datos; ?>; 
  var filter = <?php if(isset($filter)) echo '"'. $filter. '"'; else echo "null"; ?>;
  var datos = [];

  function parseDate(str) {
    var mdy = str.split('-');
    return new Date(mdy[0], mdy[1]-1, mdy[2]);
  }

  function datediff(first, second) {
      return Math.round((second-first)/(1000*60*60*24));
  }

  function cstring(data){
    data = "'"+data+"'";
    return data;
  }

  /*'+v.id_cotizacion+','+v.nombre_cliente+','+v.nombre_sub+','+v.rfq+','+v.ir+','+v.ic+', '+v.cotizacion+','+v.profit+','+v.monto+','+v.moneda+','+v.fcotizacion+','+v.tercerizado+'*/

  function aprobar(id_cotizacion, id_requerimiento, cliente, scliente, rfq, ir, ic, cotizacion, profit, monto, moneda, validez, tercerizado, dp_id, ds_id){
    var id_dep = {{session('id_dep')}};
    var limitedol;
    var limitebs;
    $.ajax({
      data: {'id_dep': id_dep},
      url: '{{route('departamento_limite')}}',
      type: 'post',
      success:  function (data) {
        limitedol = data.limitedol;
        limitebs = data.limitebs;
        console.log(data);
      },
      error: function() {
        swal(
          "Ha ocurrido un problema", 
          "Ha ocurrido un error en el servidor", 
          "error");
      }
    });
    if('{{session('nivel')}}' == 9){
      var accion = "Aprobar";
      var valor = "A";
    } else if(dp_id == id_dep){
        var dep2 = (ds_id != null)? true : false;
        if(moneda == 'D'){
          if(monto > limitedol && dep2){
            var accion = "Pre-aprobar";
            var valor = "B";
          } else if (monto > limitedol){
            var accion = "Aprobar para liberación";
            var valor = "L";
          } else {
            var accion = "Aprobar";
            var valor = "A";
          }
        } else {
          if(monto > limitebs && dep2){
            var accion = "Pre-aprobar";
            var valor = "B";
          } else if (cotizacion['monto'] > limitebs){
            var accion = "Aprobar para liberación";
            var valor = "L";
          } else {
            var accion = "Aprobar";
            var valor = "A";
          }
        }
    } else if(ds_id == id_dep){
        if(moneda == 'D'){
          if(monto > limitedol){
              var accion = "Aprobar para liberación";
              var valor = "L";
          } else {
              var accion = "Aprobar";
              var valor = "A";
          }
        } else {
            if (monto > limitebs){
              var accion = "Aprobar para liberación";
              var valor = "L";
          } else {
              var accion = "Aprobar";
              var valor = "A";
          }
        }
    }

    if (moneda == 'D')
      var moneda = ' US$';
    else
      var moneda = ' Bs.';

    if(tercerizado == 1)
      var tercerizado = 'Si';
    else
      var tercerizado = 'No';

    var html = '<form id="fcotizar" method="post" action="{{route('cotizacion_acc')}}" enctype="multipart/form-data">'+
                '<div class="form-group row">'+
                  '<div class="form-swal">'+
                    '<div>'+
                      '<label class="text-primary">Cliente</label>'+
                        '<p>'+cliente+'<i class="fa fa-arrow-right"></i>'+scliente+'</p>'+
                    '</div>'+
                    '<div>'+
                      '<label class="text-primary">RFQ</label>'+
                        '<p>'+rfq+'</p>'+
                    '</div>'+
                    '<div>'+
                      '<label class="text-primary">Items solicitados</label>'+
                        '<p>'+ir+'</p>'+
                    '</div>'+
                    '<div>'+
                      '<label class="text-primary">Items cotizados</label>'+
                        '<p>'+ic+'</p></div>'+
               '<div class="form-swal"><label class="text-primary">Cotización</label><p><a href="{{asset('storage/cotizaciones')}}/'+ cotizacion +'" target="_blank">Ver cotización</a></p></div>'+
               '<div class="form-swal"><label class="text-primary">ID Profit</label><p>'+ profit +'</p></div>'+
               '<div class="form-swal"><label class="text-primary">Monto</label><p>'+ monto + moneda +'</p></div>'+
               '<div class="form-swal"><label class="text-primary">Fecha validez</label><p>'+ validez+'</p></div>'+
               '<div class="form-swal"><label class="text-primary">Tercerizado</label><p>'+ tercerizado +'</p></div>'+
               //'<div class="form-swal"><label class="text-primary margin-auto">Factor utilizado</label><input id="factor" type="text" class="form-control col-lg-7 col-sm-7 margin-bottom" placeholder="Indique el factor utilizado"></div>'+
               //'<div class="form-swal"><label class="text-primary margin-auto">Factor utilizado</label><input id="factor" type="text" class="form-control col-lg-7 col-sm-7 margin-bottom" placeholder="Indique el factor utilizado"></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary margin-auto">Observaciones</label><textarea id="obs" name="obs" type="text" placeholder="Haga un comentario breve (opcional)" class="form-control col-lg-8 col-sm-8"></textarea></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary margin-auto">Acción</label><select class="form-control col-lg-8 col-sm-8" id="accion" name="accion" required><option value="">Seleccionar</option><option value="'+ valor +'">'+ accion +'</option><option value="R">Rechazar</option></select></div>'+
               '<input id="id_cotizacion" name="id_cotizacion" type="hidden" value="'+ cotizacion['id_cotizacion']+'"/>'+
               '</div>';
    const swalbt = swal.mixin({
      confirmButtonClass: 'btn btn-success btn-sm margin-right',
      cancelButtonClass: 'btn btn-dark btn-sm',
      confirmButtonText: "Guardar cambios",
      buttonsStyling: false,
      showConfirmButton: true,
      showCancelButton: true
    });

    swalbt({
      title: 'Detalles de cotización del requerimiento #' + id_requerimiento,
      customClass: 'swal-wide-30',
      focusConfirm: false,
      html: html
    }).then((result) => {
        if (result.value) {

          var aprobar = $(this);
          var observacion = $('#obs').val();
          var accion = $('#accion').val();    
      
          $.ajax({
            data: {_token: CSRF_TOKEN, 'obs': observacion, 'accion': accion, 'id_cot': id_cotizacion, 'id_requerimiento': id_requerimiento},
            url: '{{route('cotizacion_acc')}}',
            type: 'post',
            beforeSend: function () {
              aprobar.prop('disabled', true);
            },
            success:  function (data) {
              console.log(data);
              swal(
                "Resultado:", 
                "La acción ha sido concretada exitosamente", 
                "success"
              ).then(function(){location.reload();});
            },
            error: function() {
              swal(
                "Ha ocurrido un problema", 
                "Ha ocurrido un error en el servidor", 
                "error");
              aprobar.prop('disabled', false);
            }
          });
        };
      });
  }

  function enviar(id_requerimiento, scliente, comprador, cotizacion, profit){
    var enviar = $(this);
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var html = '<form id="envio_cot" action="#"> <div class="form-swal"><label class="text-primary">Remitente</label><p>{{session('correo')}}</p></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Asunto</label><input id="asunto" name="asunto" type="text" class="form-control col-lg-8 col-sm-8 margin-bottom" value="Cotización del requerimiento #'+id_requerimiento+'" required></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Cuerpo</label><textarea id="cuerpo" name="cuerpo" rows="4" type="text" placeholder="Indique el cuerpo del correo" class="form-control col-lg-8 col-sm-8"></textarea></div>'+
               '<div class="form-swal"><label class="text-primary">Cotización adjunta</label><p><a href="{{asset('storage/cotizaciones')}}/'+ cotizacion +'" target="_blank">'+profit+'</a></p></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary margin-auto">Destinatario</label><select class="form-control col-lg-8 col-sm-8 margin-bottom" id="destino" name="destino" required><option value="">Seleccionar</option></select></div>'+
               '<input type="hidden" id="archivo" value="'+cotizacion+'" />' +
               '</form>';
    const swalbt = swal.mixin({
      confirmButtonClass: 'btn btn-success margin-right',
      cancelButtonClass: 'btn btn-dark',
      confirmButtonText: "Enviar correo",
      buttonsStyling: false,
      showConfirmButton: true,
      showCancelButton: true
    });

    $.ajax({
            data: {_token: CSRF_TOKEN, 'comprador': comprador},
            url: 'comprador',
            type: 'post',
            beforeSend: function () {
              $('#destino').prop('disabled', true);
              enviar.prop('disabled', true);
            },
            success:  function (data) {
              swalbt({
                title: 'Enviar cotización a '+scliente+' del requerimiento #' + id_requerimiento,
                customClass: 'swal-wide-30',
                focusConfirm: false,
                html: html
              }).then((result) => {
                  if (result.value) {
                    var asunto = $('#asunto').val();
                    var cuerpo = $('#cuerpo').val();
                    var destino = $('#destino').val();
                    var cotizacion = $('#archivo').val();
                    $.ajax({
                      data: {_token: CSRF_TOKEN, 'id_requerimiento': id_requerimiento, 'asunto': asunto, 'contenido': cuerpo, 'destino': destino, 'cotizacion': cotizacion},
                      url: '{{route('enviar_cot')}}',
                      type: 'post',
                      beforeSend: function () {
                        swal({
                          title: 'Enviando correo. Por favor espere.',
                          allowOutsideClick: false
                        });
                        swal.showLoading();
                      },
                      success:  function (data) {
                        swal.close();
                        swal(
                          "Resultado:", 
                          "El correo ha sido enviado exitosamente", 
                          "success"
                        ).then(function(){location.reload();});
                      },
                      error: function() {
                        swal(
                          "Ha ocurrido un problema", 
                          "Ha ocurrido un error. Verifique su conexión a internet. Si el problema persiste comuniquese con el departamento de soporte", 
                          "error");
                      }
                    });
                  } 
                });

              $('#destino').append('<option value="'+ data.email_contacto +'">'+ data.email_contacto +' ('+ data.nombre_contacto +')</option>');

              $('#destino').prop('disabled', false);
              enviar.prop('disabled', false);

            },
            error: function() {
              swal(
                "Ha ocurrido un problema", 
                "Ha ocurrido un error en el servidor", 
                "error");
              aprobar.prop('disabled', false);
            }
    });
  }

  $(function () {
    var  today = new Date();
    var mes = today.getMonth() + 1;

    cotizaciones.forEach(function(v){
      console.log(v);
      var departamento = '<div title="'+ v.dprincipal +'">'+ v.dprincipal_sg +'</div>';
      var nombre = "'" + v.nombre_sub + "'";
      var dias = v.dias;

      if (v.dsecundario)
        departamento += '<div title="'+ v.dsecundario +'">'+ v.dsecundario_sg +'</div>';

      if(v.prioridad == 'N')
        var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" title="Normal"> </div>';
      else if (v.prioridad == 'I')
        var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" style="background: #FFA74F" title="Inmediata"> </div>';
      else if (v.prioridad == 'U')
        var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" style="background: #FE3D4B" title="Urgente"> </div>';
      else
        var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" style="background: #FEE13F" title="Abierta"> </div>';

      if(v.moneda == 'D')
        var moneda = 'US$';
      else
        var moneda = 'Bs.';

      var cliente = cstring(v.nombre_cliente);
      var scliente = cstring(v.nombre_sub);
      var rfq = cstring(v.rfq);
      var validez = cstring(v.validez);
      var cotizacion = cstring(v.cotizacion);
      var profit = cstring(v.profit);
      var monedastr = cstring(v.moneda);
      var cotizacion = cstring(v.cotizacion);

      if(v.estatus != 'COA')
        var acciones = '<a href="javascript:aprobar('+v.id_cotizacion+','+v.id_requerimiento+','+cliente+','+scliente+','+rfq+','+v.ir+','+v.ic+', '+cotizacion+','+profit+','+v.monto+','+monedastr+','+validez+','+v.tercerizado+','+v.dprincipal_id+','+v.dsecundario_id+')" title="Aprobar cotización del requerimiento #'+v.id_requerimiento+'" class="text-success"><i class=" fa fa-check-circle fa-lg"></i></a> <a href="requerimientos_detalles/'+ v.id_requerimiento + '"><i class="fa fa-plus-square fa-lg"></i></a>';
      else
        var acciones = '<a href="javascript:enviar('+v.id_requerimiento+','+scliente+','+v.comprador+','+cotizacion+','+profit+')" title="Enviar cotización del requerimiento #'+v.id_requerimiento+'" class="text-success"><i class=" fa fa fa-envelope fa-lg"></i></a> <a href="requerimientos_detalles/'+ v.id_requerimiento + '"><i class="fa fa-plus-square fa-lg"></i></a>';

      datos.push({
        prioridad: prioridad,
        id: ("0000" + v.id_requerimiento).substr(-4,4),
        mcdo: '<div title="'+ v.encargado +'">'+ v.iniciales +'</div>',
        cliente: v.nombre_cliente, 
        scliente: v.nombre_sub, 
        //asunto: v.asunto,
        //clave: v.p_claves,
        departamento: departamento,
        rfq: v.rfq,
        ir: v.ir,
        ic: v.ic,
        //registro: v.fregistro + '<b> ('  + dias + ' días) </b>',
        monto: moneda + ' ' + v.monto,
        fcotizacion: dias + ' días',
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