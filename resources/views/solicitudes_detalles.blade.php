@include('permisos')
@extends('layout')

@section('librerias')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('js/estados.js')}}"></script>
@endsection

@php
  //$id_ge2 = isset($ge2)? $ge2->id_usuario : null;

  $funciones = new funciones();

  foreach($asignaciones as $asig){
    if($asig->tipo == 'P'){
      $dep1 = $asig;
      $gerente1 = $funciones->usuario_gerente($dep1->id);
    }
    else
      $dep2 = $asig;

     if($asig->id == session('id_dep') && $as->fvisto == null)
        $asignacion->visto($id, session('id_dep'));
  }

  if($solicitud->tcontratacion == 'P')
    $contratacion = "Pública";
  else
    $contratacion = "Tradicional";

  if($solicitud->prioridad == 'N')
    $prioridad = '<span class="circulo"></span><p>Normal</p>';
  else if($solicitud->prioridad == 'I')
    $prioridad = "<span class='text-orange'>Inmediata</span>";
  else if($solicitud->prioridad == 'U')
    $prioridad = "<span class='text-red'>Urgente</span>";
  else if($solicitud->prioridad == 'A')
    $prioridad = "<span class='text-yellow'>Abierta</span>";

  if(isset($dep1->fvisto))
    $visto_ge1 = 'class="text-blue" title="'. $dep1->fvisto .'"';
  else
    $visto_ge1 = 'style="color:none"';

  if(isset($dep2->fvisto))
    $visto_ge2 = 'style="color:blue" title="'. $dep2->fvisto .'"';
  else
    $visto_ge2 = 'style="color:none"';

  if(isset($cotizacion)){
    if($cotizacion->moneda == "D")
      $monto = "US$ ".number_format($cotizacion->monto,2,'.',',');
    else
      $monto = "Bs ".number_format($cotizacion->monto,2,',','.');

    if($cotizacion->tercerizado)
      $tercerizado = '<span>Si</span>';
    else
      $tercerizado = '<span class="text-red">No</span>';
  } else
      $tercerizado = 'S/I';

  foreach($analistas as $an){
    if($an->id_dep == $dep1->id){
      if($an->tipo == 'P'){
        $an1d1 = $an->nusuario;
        if(isset($an->fvisto))
          $visto_an1d1 = 'style="color:green" title="'. $an->fvisto .'"';
        else
          $visto_an1d1 = 'style="color:none"';
      }
      else{
        $an2d1 = $an->nusuario;
        if(isset($an->fvisto))
          $visto_an2d1 = 'style="color:green" title="'. $an->fvisto .'"';
        else
          $visto_an2d1 = 'style="color:none"';
      }
    }
    else if (isset($dep2)){
      if($an->id_dep = $dep2->id){
        if($an->tipo == 'P'){
          $an1d2 = $an->nusuario;
          if(isset($an->fvisto))
            $visto_an1d2 = 'style="color:green" title="'. $an->fvisto .'"';
          else
            $visto_an1d2 = 'style="color:none"';
        }
        else{
          $an2d2 = $an->nusuario;
          if(isset($an->fvisto))
            $visto_an2d2 = 'style="color:green" title="'. $an->fvisto .'"';
          else
            $visto_an2d2 = 'style="color:none"';
        }
      } 
    }
  }

  $id_dep2 = isset($dep2)? $dep2->id : null;

  $permisos = new permisos($solicitud->estatus, $dep1->id, $id_dep2, $ge1->id_usuario, $id_ge2, $analistas);
@endphp

@section('contenido')
<header class="page-header">
    <div class="container-fluid-title">
        <h3 class="no-margin-bottom">Detalles de Requerimiento #{{$solicitud->id_requerimiento}}</h3>
        <!-- ACCIONES DISPONIBLES -->
        <span class="btn-group-rq"> 

          @if($permisos->estado(['COA']) && session('acceso')->solicitudes[8])
            <a id="enviar_cot" href="#" title="Enviar cotización" class="text-primary"> 
              <i class="fa fa-send-o"></i>
            </a>
            <input id="id_cliente" type="hidden" value="{{$solicitud->id_cliente}}" />
          @endif

          @if(($permisos->estado(['COC']) && $permisos->gerente() == 1) ||($permisos->estado(['CPA']) && $permisos->gerente() == 2) || ($permisos->estado(['CPA', 'COC', 'CPL']) && (session('nivel') == 9)))
            <a id="aprobar" href="#" title="Revisar cotización" class="text-success"> 
              <i class="fa fa-check-circle-o"></i>
            </a>
            <input id="dep" type="hidden" value="{{$permisos->gerente()}}" />
          @endif

          @if($permisos->estado(['SEP']) && $permisos->analistas(4))
            <a id="cotizar" href="#" title="Cargar cotización" class="text-orange"> 
              <i class="fa fa-file-pdf-o"></i>
            </a>
          @endif

          @if($permisos->asignacion()) <!--No debe cambiar de estado si requerimiento <> SCR -->
            <a id="asignar" href="#" title="Asignar analistas" class="text-primary"> 
              <i class="fa fa-users"></i>
            </a>
          @endif

          @if($permisos->estado(['SMI', 'MIC', 'MIR', 'SDE'], 1) && session('acceso')->solicitudes[10])
            <a id="aclaratoria" href="#" title="Solicitar mas información" class="text-info"> 
              <i class="fa fa-info-circle"></i>
            </a>
          @endif

          @if($permisos->estado(['MIC']) && session('acceso')->solicitudes[12])
            <a id="respuesta" href="#" title="Respuesta de aclaratoria" class="text-info"> 
              <i class="fa fa-question-circle"></i>
            </a>
          @endif

          @if($permisos->estado(['MIR']) && $permisos->gerente())
            <a id="recibido" href="#" title="Aclaratoria recibida" class="text-success">
              <i class="fa fa-question-circle"></i>
            </a>
          @endif

          @if($permisos->estado(['SDE'], 1) && session('acceso')->solicitudes[18])
            <a id="declinar" href="#" title="Declinar requerimiento" class="text-danger"> 
              <i class="fa fa-times-rectangle-o"></i>
            </a>  
          @endif
          
        </span>
    </div>
</header>

  <!--button id="procesar" class="btn btn-success btn-sm">Procesar</button--> <!--PENDIENTE--> 

<div class="breadcrumb-holder container-fluid-title">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('requerimientos')}}">Listado de Requerimientos</a></li>
        <li class="breadcrumb-item active">Detalles de solicitud de cotización</li>
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

<section class="forms"> 
            <div class="container-fluid">
              <div class="row">
                <!-- Horizontal Form-->
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body-info">
                      <div class="list-group info-group">
                        <div class="form-group bg-green-light row">
                          <div class="col-lg-2">
                            <label class="col-list-label">Cliente</label>
                              <div><p>{{$solicitud->nombre_cliente}}</p></div> 
                          </div>

                          <div class="col-lg-2">
                            <label class="col-list-label">Subcliente</label>
                              <div><p>{{$solicitud->nombre_sub}}</p></div> 
                          </div>

                          <div class="col-lg-2">
                            <label class="col-list-label">Comprador</label>
                              <div><p>{{$solicitud->nombre_contacto}}</p></div> 
                          </div>   

                          <div class="col-lg-2">
                            <label class="col-list-label ">Contratación</label>
                              <div><p>{{$contratacion}}</p></div>
                          </div>

                          <div class="col-lg-2">
                            <label class="col-list-label">RFQ</label>
                              <div><p>{{$solicitud->rfq}}</p></div>
                          </div> 

                          <div class="col-lg-2">
                            <label class="col-list-label">Prioridad</label>
                              <div><p>{!! $prioridad !!}</p></div>
                          </div>  

                          <div class="col-lg-2">
                            <label class="col-list-label">Asunto</label>
                              <div><p>{{$solicitud->asunto}}</p></div>
                          </div>

                          <!--div class="col-lg-2">
                            <label class="col-list-label">Palabras clave</label>
                              <div><p>{{$solicitud->p_claves}}</p></div>
                          </div-->

                          <div class="col-lg-2">
                            <label class="col-list-label">Detalles <a id="detalles" href="javascript:void(0)"><i id="icontenido" class="fa fa-plus-circle" title="Mostrar mas información"></i></a></label>
                              <div class ="text-truncate"><p>{{$solicitud->detalle}}</p></div>
                          </div>

                          <div class="col-lg-2">
                            <label class="col-list-label">Fecha de solicitud</label>
                              <div><p>{{date("d/m/Y", strtotime($solicitud->frequerimiento))}}</p></div>
                          </div>

                          <!--div class="col-lg-2">
                            <label class="col-list-label">Fecha de registro</label>
                              <div><p>{{date("d/m/Y", strtotime($solicitud->fregistro))}}</p></div>  
                          </div--> 

                          <div class="col-lg-2">
                            <label class="col-list-label">Estado</label>
                              <div><p>{!! Estados::ver_estado_requerimiento($solicitud->estatus) !!}</p></div>
                          </div>

                          <div class="col-lg-4">
                            <label class="col-list-label">Departamento(s)</label>
                              <div><p>{{$dep1->nombre_dep}} 
                              @if(isset($dep2))
                                - {{$dep2->nombre_dep}}
                              @endif
                              </p></div>
                              <!--div><p>{{$dep1->nombre_dep}} <i class="fa fa-arrow-right"> </i> {{$ge1->nombre}} <i class="fa fa-check-circle" {!! $visto_ge1!!}></i></p></div-->
                          </div>

                            @if(isset($an1d1))
                            <!--div class="col-lg-3">
                              <label class="col-list-label" title="Analista(s) departamento principal">Analista(s) DP</label>
                                <div>
                                  <p>{{$an1d1}} <i class="fa fa-check-circle an1d1" {!! $visto_an1d1 !!}></i>
                                  @if(isset($an2d1))
                                  - {{$an2d1}} <i class="fa fa-check-circle an1d1" {!! $visto_an2d1 !!}></i>
                                  @endif
                                  </p>
                                </div>
                            </div-->
                            @endif  

                            @if(isset($dep2))
                            <div class="col-lg-3">
                              <label class="col-list-label">Departamento secundario</label>
                                <div><p>{{$dep2->nombre_dep}} <i class="fa fa-arrow-right"> </i> {{$ge2->nombre}} <i class="fa fa-check-circle" {!! $visto_ge2!!}}></i></p></div>
                            </div>
                            @endif

                            @if(isset($an1d2))
                            <div class="col-lg-3">
                              <label class="col-list-label">Analista(s) DS</label>
                                <div><p>{{$an1d2}} <i class="fa fa-check-circle an1d2" {!! $visto_an1d2 !!}></i>
                                @if(isset($an2d2))
                                  - {{$an2d2}} <i class="fa fa-check-circle an1d1" {!! $visto_an2d2 !!}></i>
                                @endif
                                </p></div>
                            </div>
                            @endif 
                                                                     
                        </div>

                        @if(isset($cotizacion))
 
                          <div class="form-group bg-orange-light row" >
                            
                              <div class="col-lg-2">
                                <label class="col-list-label">Cotizacion</label>
                                  <div><p><a href="{{asset('storage/cotizaciones/'. $cotizacion->cotizacion)}}" target="_blank">{{$cotizacion->profit}}</a></p></div>
                              </div>

                              <div class="col-lg-2">
                                <label class="col-list-label">Monto cotizado</label>
                                  <div><p>{{$monto}}</p></div>
                              </div>

                              <div class="col-lg-2">
                                <label class="col-list-label" title="Items cotizados/Items aprobados">Items cotizados</label>
                                  <div><p>{{$cotizacion->ic}}</p></div>
                              </div>

                              <div class="col-lg-2">
                                <label class="col-list-label">Factor (descuento)</label>
                                  <div><p>{{$cotizacion->factor}} ({{$cotizacion->descuento }}%)</p></div>
                              </div>

                              <div class="col-lg-2">
                                <label class="col-list-label">Tercerizado</label>
                                  <div><p>{!! $tercerizado !!}</p></div>
                              </div> 

                              <div class="col-lg-2">
                                <label class="col-list-label">Fecha de cotización</label>
                                  <div><p>{{date("d/m/Y", strtotime($cotizacion->fcotizacion))}}</p></div>
                              </div>
                                                                      
                          </div>
                        @endif 

                        @if($solicitud->estatus == 'SDE')
                          <h4 class="text-center bg-danger">SOLICITUD DECLINADA</h4>
                        @elseif($solicitud->estatus == 'SMI')
                          <h4 class="text-center bg-success">MAS INFORMACIÓN SOLICITADA</h4>
                        @endif

                        <input id="id_requerimiento" name="id_requerimiento" type="hidden" value="{{$solicitud->id_requerimiento}}" />                      
                    </div>
                  </div>
                </div>
                </div>
              </div>
            </div>
            </section>
            <div class="container-fluid container-novedades">
              <div class="row">
                <div class="col-lg-12 row">
                  <div class="col-lg-4">
                    <div class="card-comment">
                      <div class="content-comment">
                        @php($fecha = null)
                        @foreach($novedades as $nov)
                          @if($fecha != date("d/m/Y", strtotime($nov->fnovedad)))
                            <div class="card-date">{{date("d/m/Y", strtotime($nov->fnovedad))}}</div>
                            @php($fecha = date("d/m/Y", strtotime($nov->fnovedad)))
                          @endif
                          <div id="{{$nov->id_novedad}}" class="card-novedad">
                            <div class="novedad">
                              <div class="avatar-min"><img src="{{asset('img/avatar.png')}}" alt="..." class="img-fluid rounded-circle">
                              </div>
                              <div class="novedad-comment"> 
                                <p>{{$nov->novedad}}</p>
                                <div class="card-time"> 
                                  {{date("h:i:s a", strtotime($nov->fnovedad))}}
                                </div>
                              </div>
                            </div>                                                   
                          </div>
                      @endforeach
                    </div>
                  </div>
                </div>
                  <div class="col-lg-4">
                    <div class="card-observacion">
                      <div class="content-comment observacion">
                        @php($fecha = null)
                        @forelse($comentarios as $cm)
                          @if($fecha != date("d/m/Y", strtotime($nov->fnovedad)))
                            <div class="card-date">{{date("d/m/Y", strtotime($nov->fnovedad))}}</div>
                            @php($fecha = date("d/m/Y", strtotime($nov->fnovedad)))
                          @endif
                          <div class="card-novedad">
                            <div class="novedad">
                              <div class="avatar-min"><img src="{{asset('img/avatar.png')}}" alt="..." class="img-fluid rounded-circle"></div>
                              <div class="novedad-comment"> 
                                <p><span style="color:@php(printf("#%06X\n", mt_rand( 0, 0xFFFFFF )))">{{$cm->nombre_usuario}}</span> > {{$cm->comentario}}</p>
                                <div class="card-time"> {{date("h:i:s a", strtotime($cm->fcomentario))}}
                                </div>
                              </div>
                            </div>                                                 
                          </div>
                        @empty
                          <div class="card-novedad">
                            <div class="novedad">
                              <span class="text-blue">Sin comentarios realizados</span>
                            </div>                                                 
                          </div>
                        @endforelse
                    </div>
                  </div>
                  <div class="card-message">
                    <div class="card-novedad">
                      <div class="box-comment">
                          <div class="avatar-min"><img src="{{asset('img/avatar.png')}}" alt="..." class="img-fluid rounded-circle"></div>
                          <textarea id="mensaje" rows=2 class="message-to-send" placeholder="Escriba un comentario"></textarea>
                          <button id="enviar" class="btn btn-link card-message-send"><i class="fa fa-chevron-circle-right fa-lg"></i></button>
                      </div>                                                 
                    </div>         
                  </div>       
                </div>
                @php
                  $colores = ['primary', 'success', 'info', 'danger', 'warning'];
                @endphp
                <div class="col-lg-4 col-md-4">
                <div style="display:inline-block;width:100%; overflow-y:auto;">
                  <ul class="timeline timeline-horizontal">
                    @foreach($novedades as $nov)
                      <li class="timeline-item">
                        <div class="timeline-badge {{$colores[(mt_rand(0,4))]}}"><i class="glyphicon glyphicon-check"></i></div>
                        <div class="timeline-panel">
                          <div class="timeline-heading">
                            <h6 class="timeline-title">{{$nov->novedad}}</h6>
                            <p><small class="text-muted"><i class="fa fa fa-clock-o fa-lg"></i> {{date("d/m/Y h:i:s a", strtotime($nov->fnovedad))}}</small></p>
                          </div>
                          <div class="timeline-body">
                            <p>Usuario: <b>{{$nov->nombre}}</b> <img src="{{asset('img/avatar.png')}}" alt="..." class="img-fluid rounded-circle" style="height: 15px; width: 15px" /></p>
                          </div>
                        </div>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </div>    
              </div>
            </div>
          </div>
         
          <div class="container container-timeline hidden">
            <div class="row">
            </div>
          </div>
        </section>

@endsection

@section('librerias_end')
  <script src="{{asset('js/modals/declinar.js')}}"></script>
@endsection

@section('script')
<script type="text/javascript">

  var datos = {!! $solicitud or "null" !!};
  var defecto = $('.card-novedad').last().attr('data-id');
  var selected;
  /*alert($(".card-comment").scrollHeight());
  $(".card-comment").scrollTop($(".card-comment").scrollHeight());*/

  function hora_actual(){
    var actual = new Date();
    var hora = actual.getHours();
    var minutos = actual.getMinutes();
    var segundos = actual.getSeconds();
    var mer = (hora>12)?"pm":"am";
    hora = hora%12;
    if(hora==0) {hora=12};
    if(hora<10) hora='0'+hora;
    if(minutos<10) minutos='0'+minutos;
    if(segundos<10) segundos='0'+segundos;
    return hora + ":" + minutos + ":" + segundos + ' ' + mer;
  }

  $('#novedades').click(function(){
    $('.container-novedades').removeClass('hidden');
    $('.container-timeline').addClass('hidden');
  });

  $('#timeline').click(function(){
    $('.container-novedades').addClass('hidden');
    $('.container-timeline').removeClass('hidden');
  });

  $('#procesar').click(function(){
    var procesar = $(this);
    var id_req = $('#id_requerimiento').val();

    $.ajax({
        data: {'id_req': id_req},
        url: '{{route('procesar')}}',
        type: 'post',
        beforeSend: function () {
          procesar.prop('disabled', true);
        },
        success:  function (data) {
          swal(
            "Resultado:", 
            "El requerimiento #"+ id_req + " ha sido colocado en proceso", 
            "success"
          ).then(function(){location.reload();});
          
        },
        error: function() {
          swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
          procesar.prop('disabled', false);
        }
      });
  });

  $('#respuesta').click(function(){
    var respuesta = $(this);
    var id_req = $('#id_requerimiento').val();   

    $.ajax({
        data: {'id_req': id_req},
        url: '{{route('datos_mas_informacion')}}',
        type: 'post',
        beforeSend: function () {
          respuesta.prop('disabled', true);
        },
        success:  function (data) {
          console.log(data);
          var html = '<form id="frespuesta" method="post" action="{{route('respuesta_recibida_db')}}">'+
                     '<div class="form-swal"><label class="text-primary">Cliente</label><p>{{$datos->nombre_cliente}} <i class="fa fa-arrow-right"> </i> {{$datos->nombre_sub}}</p></div>'+
                     '<div class="form-swal"><label class="text-primary">RFQ</label><p>{{$datos->rfq}}</p></div>'+
                     '<div class="form-swal"><label class="text-primary">Fecha consulta</label><p>'+data.fregistro+'</p></div>'+
                     '<div class="form-swal"><label class="text-primary margin-auto">Duda/pregunta</label><p>'+data.duda+'</p></div>'+
                     '<div class="form-swal input-group-sm"><label class="text-primary margin-auto">Respuesta</label><textarea id="res" name="res" placeholder="Indique los detalles de la respuesta otorgada por el cliente" class="form-control col-lg-8 col-sm-8" required></textarea></div>'+
                     '<input id="id_consulta" name="id_consulta" type="hidden" value="'+ data.id_consulta +'"/>' +
                     '<input id="id_req" name="id_req" type="hidden" value="'+ id_req +'"/>' +
                     '<input type="submit" class="btn btn-success btn-sm margin-right" value="Registrar">'+
                     '<a href="javascript:swal.close();" class="btn btn-dark btn-sm">Cancelar</a>'+
                     '</form>';
          swal({
            title: 'Respuesta de consulta del requerimiento #' + id_req,
            showConfirmButton: false,
            customClass: 'swal-wide-30',
            html: html
          });
          respuesta.prop('disabled', false);
        },
        error: function() {
          swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
          respuesta.prop('disabled', false);
        }
      });
  });

  $('#recibido').click(function(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var id_req = $('#id_requerimiento').val();
    var recibido = $(this);

    $.ajax({
        data: {_token: CSRF_TOKEN, 'id_req': id_req},
        url: '{{route('procesar')}}',
        type: 'post',
        beforeSend: function () {
          recibido.prop('disabled', true);
        },
        success:  function (data) {
          swal(
            "Resultado:", 
            "Se ha indicado que la aclaratoria del requerimiento #"+ id_req + " ha sido recibida exitosamente", 
            "success"
          ).then(function(){location.reload();});
          
        },
        error: function() {
          swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
          recibido.prop('disabled', false);
        }
      });
  });

  $('#cotizar').click(function(){
    var id_req = $('#id_requerimiento').val();
    var html= '<form id="fcotizar" method="post" action="{{route('cotizar')}}" enctype="multipart/form-data">'+
                '<div class="form-group row">'+
                  '<div class="form-swal col-lg-5">' +
                    '<div>'+
                      '<label class="text-primary">Cliente</label>'+
                        '<p>{{$datos->nombre_cliente}}<i class="fa fa-arrow-right"></i>{{$datos->nombre_sub}}</p>'+
                    '</div>'+
                    '<div>'+
                      '<label class="text-primary">RFQ</label>'+
                        '<p>{{$datos->rfq}}</p>'+
                    '</div>'+
                    '<div>'+
                      '<label class="text-primary">Items solicitados</label>'+
                        '<p>{{$datos->ir}}</p>'+
                    '</div>'+
                    '<div class="input-group-sm">'+
                      '<label class="text-primary">Items cotizados</label>'+
                        '<input name="ic" type="number" class="form-control col-lg-8 col-sm-8" placeholder="Indique la cantidad de items a cotizar" value="{{$datos->ir}}" required>'+
                    '</div>'+
                    '<div class="input-group-sm">'+
                      '<label class="text-primary">Cotización</label>'+
                        '<input style="max-width: 60%" type="file" id="file" name="file" required/>'+
                    '</div>'+
                    '<div class="input-group-sm">'+
                      '<label class="text-primary">ID Profit</label>'+
                        '<input name="profit" type="text" class="form-control col-lg-8 col-sm-8" placeholder="Indique el número de cotización" required>'+
                    '</div>'+
                    '<div class="input-group-sm">'+
                      '<label class="text-primary">Monto</label>'+
                        '<input name="monto" type="number" class="form-control col-lg-5 col-sm-5 margin-bottom number-no-spin" placeholder="Indique el monto" required><select id="moneda" name="moneda" class="form-control col-lg-3 col-sm-3 margin-bottom" required><option value="">Seleccionar</option><option value="B">Bolivares</option><option value="D">Dolares</option></select>'+
                    '</div>'+
                    '<div class="input-group-sm">'+
                      '<label class="text-primary">Fecha validez</label>'+
                        '<input name="validez" type="date" class="form-control col-lg-8 col-sm-8" value="{{date("Y-m-d")}}" required>'+
                    '</div>'+
                    '<div class="input-group-sm">'+
                      '<label class="text-primary">Tercerizado</label>'+
                        '<select id="tercerizado" name="tercerizado" class="form-control col-lg-8 col-sm-8" required><option value="">Seleccionar</option><option value="0">Sí</option><option value="1">No</option></select>'+
                    '</div>'+
                    '<div class="input-group-sm">'+
                      '<label class="text-primary">Factor utilizado</label>'+
                        '<input id="factor" name="factor" type="text" class="form-control col-lg-8 col-sm-8" placeholder="Indique el factor utilizado">'+
                    '</div>'+
                    '<div class="input-group-sm">'+
                      '<label class="text-primary">Descuento</label>'+
                        '<input id="descuento" name="descuento" type="text" class="form-control col-lg-8 col-sm-8" placeholder="Indique el descuento de lo cotizado">'+
                    '</div>'+
                    '<div class="input-group-sm">'+
                      '<label class="text-primary">Comentarios</label>'+
                        '<textarea name="obs" type="text" placeholder="Haga un comentario breve (opcional)" class="form-control col-lg-8 col-sm-8"></textarea>'+
                    '</div>'+
                    '<input id="id_requerimiento" name="id_requerimiento" type="hidden" value="'+ id_req +'" />' +
                    '<center>'+
                    '<input type="submit" class="btn btn-success btn-sm margin-right" value="Cargar cotización" />'+
                    '<input type="button" onclick="javascript:swal.close();" class="btn btn-dark btn-sm" value="Cancelar" />'+
                    '</center>'+
                  '</div>' +
                  '<div class="col-lg-7">'+
                    'Previsualizar cotización<iframe id="fpreview" src="" style="width:100%; height: 430px" frameborder="2"></iframe>' +
                  '</div>' +
                '</div>'+
              '</form>';

    swal({
      title: 'Cargar cotización del requerimiento #' + id_req,
      showConfirmButton: false,
      customClass: 'swal-wide-60',
      html: html
    });

    $(function() {
      $("#file").change(function () {
        pdffile = document.getElementById("file").files[0];
        pdffile_url = URL.createObjectURL(pdffile);
        $('#fpreview').attr('src', pdffile_url);
      });
    });

  });

  $('#aprobar').click(function(){
    var cotizacion = {!! $cotizacion or 'null' !!};
    var dep2 = {!! $dep2 or 'null' !!};
    if('{{session('nivel')}}' == 9){
      var accion = "Aprobar";
      var valor = "A";
    } 
    else if('{{$dep1->id}}' == {{session('id_dep')}}){
        if(dep2){
            var accion = "Pre-aprobar";
            var valor = "B";
        }
        else{
          if(cotizacion['moneda'] == 'D'){
          
            if (cotizacion['monto'] > {{$dep1->limitedol}}){
              var accion = "Aprobar para liberación";
              var valor = "L";
            } else {
              var accion = "Aprobar";
              var valor = "A";
            }
          } else {
            if(dep2){
              var accion = "Pre-aprobar";
              var valor = "B";
            } else if (cotizacion['monto'] > {{$dep1->limitebs}}){
              var accion = "Aprobar para liberación";
              var valor = "L";
            } else {
              var accion = "Aprobar";
              var valor = "A";
            }
          }
        }
      } 
      else if(dep2['id'] == {{session('id_dep')}}){
          if(cotizacion['moneda'] == 'D'){
            if(cotizacion['monto'] > dep2['limitedol']){
              var accion = "Aprobar para liberación";
              var valor = "L";
            } else {
              var accion = "Aprobar";
              var valor = "A";
            }
          } else {
            if (cotizacion['monto'] > dep2['limitebs']){
              var accion = "Aprobar para liberación";
              var valor = "L";
          } else {
              var accion = "Aprobar";
              var valor = "A";
          }
        }
    }

    if (cotizacion['moneda'] == 'D')
      var moneda = ' US$';
    else
      var moneda = ' Bs.';

    if(cotizacion['tercerizado'] == 1)
      var tercerizado = 'Si';
    else
      var tercerizado = 'No';
    var id_req = $('#id_requerimiento').val();
    var html = '<div class="form-swal"><label class="text-primary">Cliente</label><p>{{$datos->nombre_cliente}} <i class="fa fa-arrow-right"> </i> {{$datos->nombre_sub}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">RFQ</label><p>{{$datos->rfq}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">Items solicitados</label><p>{{$datos->ir}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">Items cotizados</label><p>'+ cotizacion['ic']+'</p></div>'+
               '<div class="form-swal"><label class="text-primary">Cotización</label><p><a href="{{asset('storage/cotizaciones')}}/'+ cotizacion['cotizacion'] +'" target="_blank">Ver cotización</a></p></div>'+
               '<div class="form-swal"><label class="text-primary">ID Profit</label><p>'+ cotizacion['profit'] +'</p></div>'+
               '<div class="form-swal"><label class="text-primary">Monto</label><p>'+ cotizacion["monto"] + moneda +'</p></div>'+
               '<div class="form-swal"><label class="text-primary">Fecha validez</label><p>'+ cotizacion['validez']+'</p></div>'+
               '<div class="form-swal"><label class="text-primary">Tercerizado</label><p>'+ tercerizado +'</p></div>'+
               //'<div class="form-swal"><label class="text-primary margin-auto">Factor utilizado</label><input id="factor" type="text" class="form-control col-lg-7 col-sm-7 margin-bottom" placeholder="Indique el factor utilizado"></div>'+
               //'<div class="form-swal"><label class="text-primary margin-auto">Factor utilizado</label><input id="factor" type="text" class="form-control col-lg-7 col-sm-7 margin-bottom" placeholder="Indique el factor utilizado"></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary margin-auto">Observaciones</label><textarea id="obs" name="obs" type="text" placeholder="Haga un comentario breve (opcional)" class="form-control col-lg-8 col-sm-8"></textarea></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary margin-auto">Acción</label><select class="form-control col-lg-8 col-sm-8" id="accion" name="accion" required><option value="">Seleccionar</option><option value="'+ valor +'">'+ accion +'</option><option value="R">Rechazar</option></select></div>'+
               '<input id="id_cotizacion" name="id_cotizacion" type="hidden" value="'+ cotizacion['id_cotizacion']+'"/>';
    const swalbt = swal.mixin({
      confirmButtonClass: 'btn btn-success btn-sm margin-right',
      cancelButtonClass: 'btn btn-dark btn-sm',
      confirmButtonText: "Guardar cambios",
      buttonsStyling: false,
      showConfirmButton: true,
      showCancelButton: true
    });

    swalbt({
      title: 'Detalles de cotización del requerimiento #' + id_req,
      customClass: 'swal-wide-30',
      focusConfirm: false,
      html: html
    }).then((result) => {
        if (result.value) {

          /*var aprobar = $(this);
          var estatus = $('#estatus').val();
          var observacion = $('#obs').val();
          var accion = $('#accion').val();
          var dep1 = {{$datos->dep1}};
          var dep2 = {{$datos->dep2}};
          
          var monto = $('#monto').val();
          var moneda = $('#moneda').val()*/
          var aprobar = $(this);
          var accion = $('#accion').val();
          var observacion = $('#obs').val();
          var id_cotizacion = $('#id_cotizacion').val();
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      
          $.ajax({
            data: {_token: CSRF_TOKEN, 'obs': observacion, 'accion': accion, 'id_cot': id_cotizacion, 'id_requerimiento': id_req},
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
  });

  $('#enviar_cot').click(function(){
    var enviar = $(this);
    var cotizacion = {!! $cotizacion or 'null' !!};
    var id_req = $('#id_requerimiento').val();
    var id_cliente = $('#id_cliente').val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var html = '<form id="envio_cot" action="#"> <div class="form-swal"><label class="text-primary">Remitente</label><p>{{session('usuario')}}</p></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Asunto</label><input id="asunto" name="asunto" type="text" class="form-control col-lg-8 col-sm-8 margin-bottom" value="Cotización del requerimiento #'+id_req+'" required></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Cuerpo</label><textarea id="cuerpo" name="cuerpo" rows="4" type="text" placeholder="Indique el cuerpo del correo" class="form-control col-lg-8 col-sm-8"></textarea></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary margin-auto">Destinatario</label><select class="form-control col-lg-8 col-sm-8 margin-bottom" id="destino" name="destino" required><option value="">Seleccionar</option></select></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Cotización adjunta</label><p><a href="{{asset('storage/cotizaciones')}}/'+ cotizacion['cotizacion'] +'" target="_blank">'+cotizacion['profit']+'</a></p></div>'+
               '<input type="hidden" id="archivo" value="'+cotizacion['cotizacion']+'" /> </form>';
    const swalbt = swal.mixin({
      confirmButtonClass: 'btn btn-success btn-sm margin-right',
      cancelButtonClass: 'btn btn-dark btn-sm',
      confirmButtonText: "Enviar correo",
      buttonsStyling: false,
      showConfirmButton: true,
      showCancelButton: true
    });

    $.ajax({
            data: {_token: CSRF_TOKEN, 'id_cliente': id_cliente},
            url: 'contactos_correos',
            type: 'post',
            beforeSend: function () {
              $('#destino').prop('disabled', true);
              enviar.prop('disabled', true);
            },
            success:  function (data) {
              swalbt({
                title: 'Enviar cotización del requerimiento #' + id_req,
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
                      data: {_token: CSRF_TOKEN, 'id_requerimiento': id_req, 'asunto': asunto, 'contenido': cuerpo, 'destino': destino, 'cotizacion': cotizacion},
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

              data.forEach(function(v){
                $('#destino').append('<option value="'+ v.email_contacto +'">'+ v.email_contacto +' ('+ v.nombre_contacto +')</option>');
              });

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
  });

  $('#enviar').click(function(){
    if(selected == null)
      selected = defecto;

    var mensaje = $('#mensaje');
    var novedad = $('#nov_'+selected);
    var id_req = $('#id_requerimiento').val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    
      
      $.ajax({
        data: {_token: CSRF_TOKEN, 'id_nov': selected, 'mensaje': mensaje.val(), 'id_req': id_req},
        url: 'comentarios_add',
        type: 'post',
        beforeSend: function () {
          mensaje.prop('disabled', true);
        },
        success:  function (data) {
          
          $('#nov_'+selected).after('<div id="com_'+ data.id_comentario + '" class="card-observacion"><div class="novedad"><div class="avatar-min"><img src="{{asset('img/avatar.png')}}" alt="..." class="img-fluid rounded-circle"></div><div class="novedad-comment"> <div style="color:#017134"> {{session('nombre')}} </div> > '+ mensaje.val() +'<div class="card-time">'+ hora_actual() +'</div></div></div></div>');

          mensaje.prop('disabled', false);
          mensaje.val('');
        },
        error: function() {
          swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
          mensaje.prop('disabled', false);
        }
      });
  });     
  
  $('#asignar').click(function(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var id_req = $('#id_requerimiento').val();
    var tipo_dep = $('#tipo_dep').val();
    
    var html= '<form id="prueba" method="post" action="{{route('asignar')}}">'+
                '{{csrf_field()}}'+
                '<div class="form-group form-swal row ">'+
                  '<div class="input-group-sm">'+
                    '<label for="analista1" class="text-primary">Analista principal</label>'+
                      '<select id="analista1" name="analista1" class="form-control col-lg-8 col-sm-8" required></select>'+
                  '</div>' +
                  '<div class="input-group-sm">'+
                    '<label for="analista2" class="text-primary">Analista de apoyo</label>'+
                      '<select id="analista2" name="analista2" class="form-control col-lg-8 col-sm-8"></select>'+
                  '</div>'+
                  '<div class="input-group-sm">'+
                    '<label for="obs" class="text-primary">Observación</label>'+
                      ' <textarea id="obs" name="obs" type="text" placeholder="Ingrese un comentario" class="form-control col-lg-8 col-sm-8"></textarea>'+
                  '</div>'+
                '</div>'+
                '<input id="id_requerimiento" name="id_requerimiento" type="hidden" value="'+ id_req +'"/>'+
                '<input id="tipo_dep" name="tipo_dep" type="hidden" value="' + tipo_dep + '"/>' +
                '<input class="btn btn-info btn-sm" value="Registrar" type="submit">' + 
              '</form>';

    $.ajax({
        data: {_token: CSRF_TOKEN},
        url: 'analistas',
        type: 'post',
        beforeSend: function () {
          $('#analista1').prop('disabled', true);
          $('#analista2').prop('disabled', true);
        },
        success: function (data) {
          swal({
            title: 'Asignar analistas',
            focusConfirm: false,
            showConfirmButton: false,
            showCancelButton: false,
            customClass: 'swal-wide-30',
            html: html,
          });
          $('#analista1').append('<option value="">Seleccionar analista</option>');
          $('#analista2').append('<option value="">Seleccionar analista</option>');
          data.forEach(function(v){
            $('#analista1').append('<option value="'+ v.id_usuario +','+ v.nombre +'">'+ v.nombre +'</option>');
            $('#analista2').append('<option value="'+ v.id_usuario +','+ v.nombre +'">'+ v.nombre  +'</option>');
          });
          $('#analista1').prop('disabled', false);
          $('#analista2').prop('disabled', false);
        },
        error: function() {
          swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
          analista1.prop('disabled', false);
          analista2.prop('disabled', false);
        }
      });
  });

  $('#detalles').click(function(){
    var id_req = $('#id_requerimiento').val();

    swal({
      title: 'Detalles del requerimiento #' + id_req,
      text: `{{$datos->detalle}}`,
      cancelButtonText: "Cerrar",
      cancelButtonClass: 'btn btn-dark btn-sm',
      buttonsStyling: false,
      focusConfirm: false,
      showConfirmButton: false,
      showCloseButton: true,
      showCancelButton: true,
      customClass: 'swal-wide-25',
    });
  });

  $('#aclaratoria').click(function(){
    var id_req = $('#id_requerimiento').val();
    var html= '<form id="faclaratoria" method="post" action="{{route('mas_informacion')}}">'+
                '{{csrf_field()}}' +
                '<div class="form-group form-swal row">'+
                  '<div class="input-group-sm">'+
                    '<textarea id="obs" name="obs" placeholder="Indique los detalles de la solicitud de información" class="form-control col-lg-12 col-sm-12" required></textarea>'+
                  '</div>'+
                '</div>'+
                '<input id="id_req" name="id_req" type="hidden" value="'+ id_req +'" />' +
                '<input type="submit" class="btn btn-success btn-sm margin-right" value="Solicitar mas información" />'+
                '<input type="button" onclick="javascript:swal.close();" class="btn btn-dark btn-sm" value="Cancelar" />'+
              '</form>';
    swal({
      title: 'Solicitar mas información del requerimiento #' + id_req,
      showConfirmButton: false,
      customClass: 'swal-wide-30',
      html: html
    });
  });

  

  function responder(id){
    if(selected!='')
      $('#nov_'+selected).css('background-color','#fff');

    if(selected == id)
      selected = null;
    
    else {
      $('#nov_'+id).css('background-color','#9DAABC');
      selected = id;
    }
  }

  $(function() { 
    /*if(asignaciones){
      $('.an1d1').prop('color', none);
    }*/
  });

  /*$("#empresa").change(function(){

      	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');        
      	var departamento = $("#departamento");
      	var empresa = $(this);

      	if($(this).val() != ''){
          $.ajax({
              data: {_token: CSRF_TOKEN, 'id_emp': empresa.val()},
              url:   'departamentos_act',
              type:  'post',
              beforeSend: function () {
                empresa.prop('disabled', true);
              },
              success:  function (data) {
                empresa.prop('disabled', false);
                departamento.find('option').remove();
                departamento.append('<option value="">Seleccionar</option>');
                data.forEach(function(v){ 
                  departamento.append('<option value="' + v.id + '">' + v.nombre_dep + '</option>');
                });
                departamento.prop('disabled', false);
              },
              error: function() {
                swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
                empresa.prop('disabled', false);
              }
            });
        }
        else
        {
            departamento.find('option').remove();
            departamento.append('<option value="">Seleccionar</option>');
            departamento.prop('disabled', true);
        }
    });*/

</script>
@endsection