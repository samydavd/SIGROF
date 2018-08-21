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
        <h2 class="no-margin-bottom">Listado de Requerimientos por consultar</h2>
    </div>
</header>

<div class="breadcrumb-holder container-fluid-title">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Requerimientos por consultar</li>
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
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" class ="w5" data-field="id">#</th>
                            <th data-filter-control="select" data-filter-stric-search="true" data-title-tooltip="Unidad de mercadeo encargada" class ="w5" data-field="mcdo">MD</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="cliente">Cliente</th>
                            <th data-sortable="true" data-filter-control="select" data-filter-stric-search="true" data-field="scliente">Subcliente</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Departamento(s)" class ="w8" data-field="departamento">Dep</th>
                            <!--th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="asunto">Asunto</th-->
                            
                            <!--th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="profit">Profit</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Orden de compra" data-field="po">PO</th-->
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Request For Quotation" class ="w10" data-field="rfq">RFQ</th>
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Items Requeridos" class="w5" data-field="ir">IR</th>  
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-title-tooltip="Items Requeridos" class="w10" data-field="duda">Duda</th>                            
                            <th data-sortable="true" data-filter-control="input" data-filter-stric-search="true" data-field="frequerimiento">F. Req</th>
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
  var consulta = <?php echo $datos; ?>; 
  var datos = [];

  function parseDate(str) {
    var mdy = str.split('-');
    return new Date(mdy[0], mdy[1]-1, mdy[2]);
  }

  function datediff(first, second) {
      return Math.round((second-first)/(1000*60*60*24));
  }

  function confirmar(id_requerimiento, id_declinada, scliente){
    swal({
      title: "¿Esta seguro?",
      text: "Confirmar declinación del requerimiento #" + id_requerimiento + " correspondiente al subcliente " + scliente,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ok',
      focusConfirm: false
      }).then((result) => {
        if (result.value) {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
          $.ajax({
            data: {_token: CSRF_TOKEN, 'id_req': id_requerimiento, 'id_dec': id_declinada},
            url: 'declinar_confirmar',
            type: 'post',
            success: function(data){
              swal(
                "Acción completada", 
                "El requerimiento #" + id_requerimiento + " ha sido declinado con exito", 
                "success");
              datos = datos.filter(item => item.id !== ("0000" + id_requerimiento).substr(-4,4));
              $('#table').bootstrapTable("load", datos);   
            },
            error: function() {
                swal(
                  "Ha ocurrido un problema", 
                  "Ha ocurrido un error en el servidor", 
                  "error");
              }
          });
        }       
      });
  }

  function enviar(id_requerimiento, scliente, comprador){
    var enviar = $(this);
    var html = '<form id="envio_cot" action="#">'+
                ' <div class="form-group form-swal row">'+
                  '<div>'+
                    '<label class="text-primary">Remitente</label>'+
                      '<p>{{session('usuario')}}</p>'+
                  '</div>'+
                  '<div class="input-group-sm">'+
                    '<label class="text-primary">Asunto</label>'+
                      '<input id="asunto" name="asunto" type="text" class="form-control col-lg-9 col-sm-9" value="Solicitud de mas información del requerimiento #'+id_requerimiento+'" required>'+
                  '</div>'+
                  '<div class="input-group-sm">'+
                    '<label class="text-primary">Cuerpo</label>'+
                      '<textarea id="cuerpo" name="cuerpo" rows="4" type="text" placeholder="Indique el cuerpo del correo" class="form-control col-lg-9 col-sm-9"></textarea>'+
                  '</div>'+
                  '<div class="input-group-sm">'+
                    '<label class="text-primary">Destinatario</label>'+
                      '<select class="form-control col-lg-9 col-sm-9" id="destino" name="destino" required>'+
                        '<option value="">Seleccionar</option>'+
                      '</select>'+
                  '</div>'+
               '</form>';
    const swalbt = swal.mixin({
      confirmButtonClass: 'btn btn-success btn-sm margin-right',
      cancelButtonClass: 'btn btn-dark btn-sm',
      confirmButtonText: 'Enviar correo',
      buttonsStyling: false,
      showConfirmButton: true,
      showCancelButton: true
    });

    $.ajax({
            data: {'comprador': comprador},
            url: '{{route('comprador')}}',
            type: 'post',
            beforeSend: function () {
              $('#destino').prop('disabled', true);
              enviar.prop('disabled', true);
            },
            success:  function (data) {
              swalbt({
                title: 'Enviar consulta a '+scliente+' del requerimiento #' + id_requerimiento,
                customClass: 'swal-wide-30',
                focusConfirm: false,
                html: html
              }).then((result) => {
                  if (result.value) {
                    var asunto = $('#asunto').val();
                    var cuerpo = $('#cuerpo').val();
                    var destino = $('#destino').val();
                    $.ajax({
                      data: {'id_requerimiento': id_requerimiento, 'asunto': asunto, 'contenido': cuerpo, 'destino': destino},
                      url: 'enviar_solicitud',
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

    consulta.forEach(function(v){
      console.log(v);
      var departamento = '<span title="'+ v.dprincipal +'">'+ v.dprincipal_sg +'</span>';
      var nombre = "'" + v.nombre_sub + "'";
      if(v.dias == 0)
        var dias = 'Hoy';
      else if(v.dias == 1)
        var dias = 'Ayer';
      else
        var dias = v.dias + ' días';

      if (v.dsecundario)
        departamento += ' - <span title="'+ v.dsecundario +'">'+ v.dsecundario_sg +'</span>';

      var scliente = "'"+v.nombre_sub+"'";

      /*if(v.prioridad == 'N')
        var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" title="Normal"> </div>';
      else if (v.prioridad == 'I')
        var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" style="background: #FFA74F" title="Inmediata"> </div>';
      else if (v.prioridad == 'U')
        var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" style="background: #FE3D4B" title="Urgente"> </div>';
      else
        var prioridad = '<div data-toggle="tooltip" data-placement="top" class="circulo" style="background: #FEE13F" title="Abierta"> </div>';*/


      var acciones = '<a href="requerimientos_detalles/'+ v.id_requerimiento + '" title="Ver detalles del requerimiento #'+ v.id_requerimiento + '"><i class="fa fa-plus-square fa-lg"></i></a> <a href="javascript:enviar('+v.id_requerimiento+','+scliente+','+v.comprador+')" title="Solicitar información al cliente" class="text-success"><i class="fa fa-envelope fa-lg"></i></a>';

      datos.push({
        id: ("0000" + v.id_requerimiento).substr(-4,4),
        mcdo: '<div title="'+ v.encargado +'">'+ v.iniciales +'</div>',
        cliente: v.nombre_cliente, 
        scliente: v.nombre_sub, 
        //asunto: v.asunto,
        //clave: v.p_claves,
        departamento: departamento,
        rfq: v.rfq,
        ir: v.ir,
        duda: v.duda,
        frequerimiento: dias,
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