@include('permisos')
@extends('layout')

@section('librerias')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('js/estados.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid-title">
        <h3 class="no-margin-bottom">Detalles de Licitación - Requerimiento #{{$datos->id_requerimiento}}</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid-title">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('contrataciones')}}">Listado de Licitaciones</a></li>
        <li class="breadcrumb-item active">Detalles de Licitación</li>
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
@php

  /*$id_an1d1 = isset($asig->an1d1)? $asig->an1d1 : null;
  $id_an2d1 = isset($asig->an2d1)? $asig->an2d1 : null;
  $id_an1d2 = isset($asig->an1d2)? $asig->an1d2 : null;
  $id_an2d2 = isset($asig->an2d2)? $asig->an2d2 : null;*/
  $id_ge2 = isset($ge2)? $ge2->id_usuario : null;

  //$permisos = new permisos($datos->estatus, $datos->dep1, $datos->dep2, $ge1->id_usuario, $id_ge2, $id_an1d1, $id_an2d1, $id_an1d2, $id_an2d2);

  if($datos->tcontratacion == 'P')
    $contratacion = "Pública";
  else
    $contratacion = "Tradicional";

if($datos->prioridad == 'N')
    $prioridad = "Normal";
  else if($datos->prioridad == 'I')
    $prioridad = "Inmediata";
  else if($datos->prioridad == 'U')
    $prioridad = "Urgente";
  else if($datos->prioridad == 'A')
    $prioridad = "Abierta";


  if(isset($analistas->visto_an1d1))
    $visto_an1d1 = 'style="color:green" title="'. $asig->visto_an1d1 .'"';
  else
    $visto_an1d1 = 'style="color:none"';

  if(isset($asig->visto_an2d1))
    $visto_an2d1 = 'style="color:green" title="'. $asig->visto_an2d1 .'"';
  else
    $visto_an2d1 = 'style="color:none"';

  if(isset($asig->visto_an1d2))
    $visto_an1d2 = 'style="color:green" title="'. $asig->visto_an1d2 .'"';
  else
    $visto_an1d2 = 'style="color:none"';

  if(isset($asig->visto_an2d2))
    $visto_an2d2 = 'style="color:green" title="'. $asig->visto_an2d2 .'"';
  else
    $visto_an2d2 = 'style="color:none"';

  if(isset($cotizacion)){
    if($cotizacion->moneda == "D")
      $monto = "US$ ".number_format($cotizacion->monto,2,'.',',');
    else
      $monto = "Bs ".number_format($cotizacion->monto,2,',','.');

    if($cotizacion->tercerizado)
      $tercerizado = '<span class="text-green">Si</span>';
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

  if($datos->cpago == 'M')
    $condicion = 'Mixto';
  else
    $codicion = 'Bolivares';

  $id_dep2 = isset($dep2)? $dep2->id : null;

  $permisos = new permisos($datos->estatus, $dep1->id, $id_dep2, $ge1->id_usuario, $id_ge2, $analistas);

@endphp

<section class="forms"> 
            <div class="container-fluid">
              <div class="row">
                <!-- Horizontal Form-->
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">

                        <!--div class="table-personalized">    
                          <table class="table table-bordered table-center">
                            <thead class="thead-blue">
                              <tr>
                                <th>Tercerizado</th>
                                <th>Contratación</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th>@php echo $tercerizado; @endphp</th>
                                <th>{{$contratacion}}</th>
                              </tr>
                            </tbody>
                          </table>                              
                          
                        </div--> 

                        <div class="list-group">
                        <div class="form-group row">
                            <div class="col-lg-3">
                            <label class="col-list-label">Cliente</label>
                                <div><p>{{$datos->nombre_cliente}}</p> <a id="contenido" href="javascript:void(0)"><i id="icontenido" class="fa fa-plus-circle" title="Mostrar mas información"></i></a></div> 
                          </div>

                          <div class="col-lg-3">
                            <label class="col-list-label">Subcliente</label>
                              <div><p>{{$datos->nombre_sub}}</p></div> 
                          </div>

                          <div class="col-lg-3">
                            <label class="col-list-label">Comprador</label>
                              <div><p>{{$datos->nombre_contacto}}</p></div> 
                          </div>   

                          <div class="col-lg-3">
                              <label class="col-list-label ">Contratación</label>
                                <div><p>{{$contratacion}}</p></div>
                          </div>                                               
                        </div>

                        <div class="form-group row">
                             <div class="col-lg-3">
                            <label class="col-list-label">Departamento principal</label>
                                <div><p>{{$dep1->nombre_dep}} <i class="fa fa-arrow-right"> </i> {{$ge1->nombre}} <i class="fa fa-check-circle" {{--$visto_ge2--}}></i></p></div>
                          </div>

                            @if(isset($an1d1))
                            <div class="col-lg-3">
                              <label class="col-list-label" title="Analista(s) departamento principal">Analista(s) DP</label>
                                <div>
                                  <p>{{$an1d1}} <i class="fa fa-check-circle an1d1" {{$visto_an1d1}}></i>
                                  @if(isset($an2d1))
                                  - {{$an1d1}} <i class="fa fa-check-circle an1d1" {{$visto_an1d1}}></i>
                                  @endif
                                  </p>
                                </div>
                            </div>
                            @endif  

                            @if(isset($dep2))
                            <div class="col-lg-3">
                              <label class="col-list-label">Departamento secundario</label>
                                <div><p>{{$dep2->nombre_dep}} <i class="fa fa-arrow-right"> </i> {{$ge2->nombre}} <i class="fa fa-check-circle" {{--$visto_ge2--}}></i></p></div>
                            </div>
                            @endif

                            @if(isset($an1d2))
                            <div class="col-lg-3">
                              <label class="col-list-label">Analista(s) DS</label>
                                <div><p>{{$an1d2}} <i class="fa fa-check-circle an1d2" {{$visto_an1d1}}></i></p></div>
                            </div>
                            @endif                                            
                        </div>

                        <div class="form-group row">
                              <div class="col-lg-3">
                                <label class="col-list-label">Asunto</label>
                                <div><p>{{$datos->asunto}}</p></div>
                              </div>

                              <div class="col-lg-3">
                                <label class="col-list-label">Palabras clave</label>
                                  <div><p>{{$datos->p_claves}}</p></div>
                              </div>

                              <div class="col-lg-3">
                                <label class="col-list-label">RFQ</label>
                                  <div><p>{{$datos->rfq}}</p></div>
                              </div> 

                              <div class="col-lg-3">
                                <label class="col-list-label">Prioridad</label>
                                  <div><p>{!! $prioridad !!}</p></div>
                              </div>                                                                     
                        </div>

                        <div class="form-group row">

                            <div class="col-lg-3">
                              <label class="col-list-label">Fecha de solicitud</label>
                                <div><p>{{date("d/m/Y", strtotime($datos->frequerimiento))}}</p></div>
                            </div>

                            <div class="col-lg-3">
                              <label class="col-list-label">Fecha de registro</label>
                                <div><p>{{date("d/m/Y", strtotime($datos->fregistro))}}</p></div>  
                            </div> 

                            @if(isset($cotizacion))
                            <div class="col-lg-3">
                              <label class="col-list-label">Cotizacion</label>
                                <p><a href="{{asset('storage/cotizaciones/'. $cotizacion->cotizacion)}}" target="_blank">{{$cotizacion->profit}} ({{$monto}})</a></p>
                            </div>
                            @endif

                            @if(isset($cotizacion->descuento))
                            <div class="col-lg-3">
                              <label class="col-list-label">Factor (descuento)</label>
                                <p>{{$cotizacion->factor}} ({{$cotizacion->descuento }}%)</i></p>
                            </div>
                            @endif 

                            <!--div class="col-lg-3">
                              <label class="col-list-label">Tercerizado</label>
                                <div><p>{!! $tercerizado !!}</p></div>
                            </div-->                                               
                        </div>

                        <div class="form-group row">
                          <div class="col-lg-3">
                            <label class="col-list-label" title="Número del proceso">Número del proceso</label>
                                <p>{{$datos->nproceso}}</p>
                          </div>

                          <div class="col-lg-3">
                            <label class="col-list-label" title="Denominación del proceso">Denominación del proceso</label>
                                <p>{{$datos->dproceso}}</p>
                          </div>

                          <div class="col-lg-3">
                            <label class="col-list-label" title="Fecha de aclaratoria">Fecha aclaratoria</label>
                                <p>{{$datos->faclaratoria}}</p>
                          </div>

                          <div class="col-lg-3">
                            <label class="col-list-label" title="Fecha de presentación de la oferta económica">Fecha presentación</label>
                                <p>{{$datos->foferta}} ({{$datos->voferta}} días de validez)</p>
                          </div>

                        </div>

                        <div class="form-group row">
                          <div class="col-lg-3">
                            <label class="col-list-label">Condición pago</label>
                                <p>{{$condicion}}</p>
                          </div>

                          <div class="col-lg-3">
                            <label class="col-list-label">Nivel de contratación</label>
                                <p>{{$datos->ncontratacion}} Bs.</p>
                          </div>

                          <div class="col-lg-3">
                            <label class="col-list-label">Presupuesto base (Bs.)</label>
                                <p>{{$datos->pbase}} Bs.</p>
                          </div>

                          @if(isset($datos->pbase_dol))
                          <div class="col-lg-3">
                            <label class="col-list-label" title="Presupuesto base (US$)">Presupuesto base (US$)</label>
                                <p>{{$datos->pbase_dol}} US$</p>
                          </div>
                          @endif

                        </div>

                        @if($datos->estatus == 'SDE')
                          <h4 class="text-center bg-danger">SOLICITUD DECLINADA</h4>
                        @elseif($datos->estatus == 'SMI')
                          <h4 class="text-center bg-success">MAS INFORMACIÓN SOLICITADA</h4>
                        @endif

                        <input id="id_requerimiento" name="id_requerimiento" type="hidden" value="{{$datos->id_requerimiento}}" />                      
                        <div style="margin-left: auto">
                          @if($permisos->estado(['SDE'], 1))
                            <button id="declinar" class="btn btn-danger btn-sm">Declinar</button>
                          @endif
                        </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
            </div>
            <div class="container-fluid">
              <div class="row">
                <!-- Horizontal Form-->
                <div class="col-lg-12">
                  <div class="card-comment">
                    <div class="content-comment">
                      @php($fecha = null)
                      @foreach($novedades as $nov)
                        @if($fecha != date("d/m/Y", strtotime($nov->fnovedad)))
                          <div class="card-date">{{date("d/m/Y", strtotime($nov->fnovedad))}}</div>
                          @php($fecha = date("d/m/Y", strtotime($nov->fnovedad)))
                        @endif
                        <div id="{{'nov_'. $nov->id_novedad}}" data-id={{$nov->id_novedad}} class="card-novedad">
                          <div class="novedad">
                            <div class="avatar-min"><img src="{{asset('img/avatar.png')}}" alt="..." class="img-fluid rounded-circle"></div>
                            <div class="novedad-comment"> {{$nov->novedad}}<a href='javascript:responder({{$nov->id_novedad}})' class=" bg-link"><i class="fa fa-reply fa-lg"></i></a><div class="card-time">{{date("h:i:s a", strtotime($nov->fnovedad))}}</div>
                            </div>
                          </div>                                                   
                        </div>
                        @php($comentario = null)
                        @foreach($comentarios as $cm)
                          @if($cm->seguimiento == $nov->id_novedad)
                            <!--@if(!$comentario)
                              <div class="img-respose"><i class="fa fa-level-up fa-3x"></i></div>
                              @php($comentario = 1)
                            @endif-->
                            <div id="{{'com_'. $cm->id_comentario}}" class="card-observacion">
                              <div class="novedad">
                                <div class="avatar-min"><img src="{{asset('img/avatar.png')}}" alt="..." class="img-fluid rounded-circle"></div>
                                  <div class="novedad-comment"> <div style="color:@php(printf( "#%06X\n", mt_rand( 0, 0xFFFFFF )))"> {{$cm->nombre_usuario}}</div>{{' > '.$cm->comentario}}<div class="card-time">
                                    @if($fecha != date("d/m/Y", strtotime($cm->fcomentario)))
                                      {{'('.date("d/m/Y", strtotime($cm->fcomentario)).') '}}
                                    @endif
                                    {{date("h:i:s a", strtotime($cm->fcomentario))}}</div>
                                </div>
                              </div>                                                   
                            </div>
                          {{--@else
                            @break--}} <!-- Revisar seccion --> 
                          @endif
                        @endforeach
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="container-fluid">
              <div class="row">
                <!-- Horizontal Form-->
                <div class="col-lg-12">
                      <div class="card-message">
                      <div class="avatar-min card-message-image"><img src="{{asset('img/avatar.png')}}" alt="..." class="img-fluid rounded-circle"></div>
                      <button id="enviar" class="btn btn-link card-message-image-send"><i class="fa fa-chevron-circle-right fa-lg"></i></button>
                      <textarea id="mensaje" class="message-to-send" placeholder="Escriba un comentario"></textarea>        
                      </div>       
                </div>
              </div>
            </div>
          </section>

@endsection

@section('script')
<script type="text/javascript">
$('#declinar').click(function(){
    var id_req = $('#id_requerimiento').val();
    var html = 
    '<div class="form-swal"><label class="text-primary">Cliente</label><p>{{$datos->nombre_cliente}} <i class="fa fa-arrow-right"> </i> {{$datos->nombre_sub}}</p></div>'+
    '<div class="form-swal"><label class="text-primary">RFQ</label><p>{{$datos->rfq}}</p></div>'+
    '<div class="form-swal"><label class="text-primary margin-auto">Declinada por</label><select id="razon" name="razon" class="form-control col-lg-8 col-sm-8 margin-bottom" required><option value="">Seleccionar</option><option value="C">Cliente</option><option value="S">Sersinca</option></div></select></div>'+
    '<div class="form-swal"><label class="text-primary margin-auto">Comentarios</label><textarea id="motivo" type="text" placeholder="Indique los detalles de la declinación del requerimiento" class="form-control col-lg-8 col-sm-8" required></textarea></div>';
    const swalbt = swal.mixin({
      confirmButtonClass: 'btn btn-danger margin-right',
      cancelButtonClass: 'btn btn-info',
      confirmButtonText: "Declinar",
      buttonsStyling: false,
      showConfirmButton: true,
      showCancelButton: true
    });

    swalbt({
      title: 'Declinar requerimiento #' + id_req,
      customClass: 'swal-wide',
      focusConfirm: false,
      showCloseButton: true,
      html: html
      }).then((result) => {
        if (result.value) {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          var razon = $('#razon').val();
          var motivo = $('#motivo').val();
          $.ajax({
            data: {_token: CSRF_TOKEN, 'id_req': id_req, 'razon': razon, 'obs': motivo},
            url: '{{route('declinar')}}',
            type: 'post',
            success: function(data){
              swal(
                "Acción completada", 
                "El requerimiento #" + id_req + " ha sido declinado exitosamente", 
                "success"
              ).then(function(){location.reload();});
            },
            error: function() {
                swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
              }
          });
        }       
      });
  });
</script>
@endsection