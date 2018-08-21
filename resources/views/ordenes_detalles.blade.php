@include('permisos')
@extends('layout')
@extends('librerias_tablas')

@section('extra')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('js/estados.js')}}"></script>
@endsection

@php

  $id_ge2 = isset($ge2)? $ge2->id_usuario : null;
  $id_dep2 = isset($dep2)? $dep2->id : null;

  //dd($analistas);

  $permisos = new permisos($datos->estatus, $dep1->id, $id_dep2, $ge1->id_usuario, $id_ge2, $analistas);

  if($datos->tcontratacion == 'P')
    $contratacion = "Pública";
  else
    $contratacion = "Tradicional";

  /*if(isset($analistas->visto_an1d1))
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
    $visto_an2d2 = 'style="color:none"';*/

  if(isset($cotizacion)){
    if($cotizacion->moneda == "D")
      $monto = "US$ ".number_format($cotizacion->monto,2,'.',',');
    else
      $monto = "Bs ".number_format($cotizacion->monto,2,',','.');

    if($cotizacion->tercerizado)
      $tercerizado = '<span>Si</span>';
    else
      $tercerizado = '<span class="text-red text-bold">No</span>';
  } else
      $tercerizado = 'S/I';

  if($po != '-1'){
    if($po->moneda == "D")
      $po_monto = "US$ ".number_format($po->monto,2,'.',',');
    else
      $po_monto = "Bs ".number_format($po->monto,2,',','.');
  } else
      $po_monto = 'Pendiente';

  if(isset($po->ia))
    $ia = $po->ia;
  else
    $ia = 'S/I';

  if($po->mpago == 'C')
    $mpago = '<span class="text-blue text-bold">Credito</span>';
  else if($po->mpago == 'O')
    $mpago = '<span class="text-orange text-bold">Contado</span>';
  else
    $mpago = '<span class="text-red text-bold">Efectivo</span>';

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
    /*if($an->id_analista == $asig->an1d1)
      $an1d1 = $an->nombre;
    else if($an->id_usuario == $asig->an2d1)
      $an2d1 = $an->nombre;
    else if($an->id_usuario == $asig->an1d2)
      $an1d2 = $an->nombre;
    else if($an->id_usuario == $asig->an2d2)
      $an2d2 = $an->nombre;*/
    }
  }
@endphp

@section('contenido')
<header class="page-header">
    <div class="container-fluid-title">
        <h3 class="no-margin-bottom">Detalles de Requerimiento #{{$datos->id_requerimiento}}</h3>
        <!-- ACCIONES DISPONIBLES -->
        <span class="btn-group-rq">
          
          @if($permisos->estado(['OCR']) && session('acceso')->ordenes[2])
            <a id="procesar" class="btn btn-success btn-sm">Procesar</a> 
          @endif
                          
          @if($permisos->estado(['OCR', 'ENT', 'FAC'], 1) && session('acceso')->nde[0] && $permisos->registrar_nde($nde) && !$po->cierre)
            <a id="rnde" href="#" title="Registrar nota de entrega" class="text-info">
              <i class="fa fa-book"></i>
            </a>  
          @endif
          
                            <!--button id="detalles" class="btn btn-dark btn-sm">Ver detalles</button-->

          @if($permisos->estado(['OCR', 'ENT', 'FAP', 'FAC', 'PAP', 'PAG'], 1) && !$po->cierre && session('acceso')->ordenes[4])
            <a id="ocerrar" href="#" title="Cerrar orden" class="text-primary">
              <i class="fa fa-ban"></i>
            </a> 
          @endif

          @if($permisos->estado(['SDE', 'FAP', 'FAC', 'PAP', 'PAG'], 1) && session('acceso')->ordenes[6])
            <a id="declinar" href="#" title="Declinar requerimiento" class="text-danger"> 
              <i class="fa fa-times-rectangle-o"></i>
            </a>  
          @endif

        </spans>
    </div>
</header>

<div class="breadcrumb-holder container-fluid-title">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('requerimientos')}}">Listado de Requerimientos</a></li>
        <li class="breadcrumb-item active">Detalles de Requerimiento</li>
    </ul>
</div>

@if(session('data') !== null && session('data') != "error")
  <script type="text/javascript">
      swal("Acción completada", '{{session('data')}}', "success");
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

                      <!--iframe src="http://docs.google.com/gview?url=http://www.snee.com/xml/xslt/sample.doc&embedded=true" style="width:500px; height:500px;" frameborder="0"></iframe>

                      <iframe src="http://docs.google.com/gview?url=http://fzs.sve-mo.ba/sites/default/files/dokumenti-vijesti/sample.pdf&embedded=true#:0.page.20" width="500" height="500" frameborder="2"></iframe-->

                      @if($permisos->estado(['OCR'], 1))
                      <!--Proximamente-->
                      <!--div class="table-personalized ordenes_detalles table-height">
                        <table id="table" 
                          class="small" 
                          data-toggle="table">
                          
                          <thead class="thead-blue">
                            <tr>
                              <th colspan="3" class="text-center">Renglones pendientes</th>
                            </tr>
                            <tr>
                              <th data-sortable="true" class="w5" data-field="item" data-title-tooltip="Número de renglón">#</th>
                              <th data-sortable="true" data-field="descripcion">Producto/Servicio</th>
                              <th data-sortable="true" class="w5" data-field="unidades" data-title-tooltip="Unidades">Unid</th>
                            </tr>
                          </thead>
                        </table>
                      </div-->
                      @endif

                      <div class="list-group info-group">
                        <div class="form-group bg-green-light row">
                          <div class="col-lg-2">
                            <label class="col-list-label">Cliente</label>
                              <div><p>{{$datos->nombre_cliente}}</p></div> 
                          </div>

                          <div class="col-lg-2">
                            <label class="col-list-label">Subcliente</label>
                              <div><p>{{$datos->nombre_sub}}</p></div> 
                          </div>

                          <div class="col-lg-2">
                            <label class="col-list-label">Comprador</label>
                              <div><p>{{$datos->nombre_contacto}}</p></div> 
                          </div>   

                          <div class="col-lg-2">
                            <label class="col-list-label ">Contratación</label>
                              <div><p>{{$contratacion}}</p></div>
                          </div>

                          <div class="col-lg-2">
                            <label class="col-list-label">RFQ</label>
                              <div><p>{{$datos->rfq}}</p></div>
                          </div> 

                          <div class="col-lg-2">
                            <label class="col-list-label">Asunto</label>
                              <div><p>{{$datos->asunto}}</p></div>
                          </div>

                          <div class="col-lg-2">
                            <label class="col-list-label">Detalles <a id="detalles" href="javascript:void(0)"><i id="icontenido" class="fa fa-plus-circle" title="Mostrar mas información"></i></a></label>
                              <div class ="text-truncate"><p>{{$datos->detalle}}</p></div>
                          </div>

                          <div class="col-lg-2">
                            <label class="col-list-label">Fecha de solicitud</label>
                              <div><p>{{date("d/m/Y", strtotime($datos->frequerimiento))}}</p></div>
                          </div>

                          <div class="col-lg-2">
                            <label class="col-list-label">Estado</label>
                              <div><p>{!! Estados::ver_estado_requerimiento($datos->estatus) !!}</p></div>
                          </div>

                          <div class="col-lg-4">
                            <label class="col-list-label">Departamento(s)</label>
                              <div><p>{{$dep1->nombre_dep}} 
                              @if(isset($dep2))
                                - {{$dep2->nombre_dep}}
                              @endif
                              </p></div>
                          </div>
                        </div>

                        <div class="form-group bg-orange-light row">                                              
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

                        <div class="form-group bg-blue-light row">

                          @if(isset($po))
                              <div class="col-lg-2">
                                <label class="col-list-label" title="Purchase Order (Orden de Compra)">Orden de compra</label>
                                  <p><a href="{{asset('storage/ordenes/'. $po->po)}}" target="_blank">{{$po->codigo_po}}</a></p>
                              </div>

                              <div class="col-lg-2">
                                <label class="col-list-label" title="Monto aprobado">Monto aprobado</label>
                                  <div><p>{{$po_monto}}</p></div>
                              </div>
                            @endif

                          <div class="col-lg-2">
                            <label class="col-list-label">Método de Pago</label>
                              <div><p>{!! $mpago !!}</p></div>
                          </div>

                          <div class="col-lg-2">
                            <label class="col-list-label">Detalles de PO</label>
                              <div><p>{{$datos->detalle}}</p></div>
                          </div>

                          <div class="col-lg-2">
                            <label class="col-list-label">Fecha de aprobación</label>
                                <div><p>{{date("d/m/Y", strtotime($po->fpo))}}</p></div>
                          </div>

                          <div class="col-lg-2">
                            <label class="col-list-label">Items aprobados</label>
                              <div><p>{{$ia}}</p></div>
                          </div>
                        </div>

                        <input id="id_requerimiento" name="id_requerimiento" type="hidden" value="{{$datos->id_requerimiento}}" />
                        <input id="req_estatus" name="req_estatus" type="hidden" value="{{$datos->estatus}}" />

                        @if($po->cierre)
                          <h4 class="text-center bg-blue">ORDEN CERRADA</h4>
                        @endif

                        
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
              <div id="informacion" class="container-fluid" style="margin-bottom: 10px">
                <div class="row">
                  <div class="col-lg-6">
                    <h2>Cotización</h2>
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe class="embed-responsive-item" src="{{asset('storage/cotizaciones/'. $cotizacion->cotizacion)}}"></iframe>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <h2>Orden de compra</h2>
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe class="embed-responsive-item" src="{{asset('storage/ordenes/'. $po->po)}}"></iframe>
                    </div>
                  </div>
                </div>
              </div>

            @if($permisos->estado(['OCR'], 1))  
            <div class="container-fluid" style="margin-top: -15px">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body-tables row">
                      <div class="col-lg-6">
                        <table id="tnde" class="small table-sm" data-toggle="table">
                          <thead class="bg-red">
                            <tr>
                              <th colspan="5" class="text-center" title="Notas de entrega registradas">NDE registrada(s)</th>
                            </tr>
                            <tr>
                              <th data-sortable="true" data-field="id">#NDE</th>
                              <th data-sortable="true" data-field="tipo">Tipo</th>
                              <th data-sortable="true" data-field="fnde">F. NDE</th>
                              <th data-sortable="true" data-field="fentrega">F. entrega</th>
                              <th data-sortable="true" data-field="soporte">Soporte</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                      <div class="col-lg-6">
                        <table id="tfactura" class="small table-sm" data-toggle="table">
                          <thead class="bg-green">
                            <tr>
                              <th colspan="6" class="text-center">Registro de Factura(s)</th>
                            </tr>
                            <tr>
                              <th data-sortable="true" class="w5" data-field="id">#FAC</th>
                              <th data-sortable="true" data-field="nde">NDE</th>
                              <th data-sortable="true" data-field="ffactura">F. factura</th>
                              <th data-sortable="true" data-field="monto">Monto</th>
                              <th data-sortable="true" data-field="pagado">Pagado</th>
                              <th data-sortable="true" data-field="soporte">Soporte</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif
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
                  <div style="display:inline-block; width:100%; overflow-y:auto;">
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
        </section>

@endsection

@section('librerias_end')
  <script src="{{asset('js/modals/declinar.js')}}"></script>
@endsection

@section('script')
<script type="text/javascript">

  var pendientes = [];
  var notas = {!! $nde or 'null' !!};
  var facturas = {!! $facturas or 'null' !!};
  var nde = [];
  var fac = [];

  $(function () {
    pendientes.push({
        item: 1,
        descripcion: '72-0314RKC GX-2009',
        unidades: 5
      });
    pendientes.push({
        item: 1,
        descripcion: '72-4422RHC GX-2011',
        unidades: 2
      });

    notas.forEach(function(v){
      var id = v.id_nde;

      if(v.tipo == 'P')
        var tipo = 'Parcial';
      else
        var tipo = 'Total';

      if(v.fentrega)
        var fentrega = v.fentrega;
      else
        var fentrega = 'Pendiente';

      if(v.adjunto)
        var adjunto = '<a href="{{asset('storage/nde')}}/'+v.adjunto+'" target="_blank">Ver adjunto</a>';
      else
        var adjunto = 'Pendiente';

      var posicion = nde.length;

      nde.push({
        id: '<a href="javascript:detalles_nde('+posicion+')">'+id+'</a>',
        tipo: tipo,
        fnde: v.fnde,
        fentrega: fentrega,
        soporte: adjunto
      });
    });

    facturas.forEach(function(v){
      var id = v.nfactura;
      var ffactura = v.ffactura;

      if(v.adjunto)
        var adjunto = '<a href="{{asset('storage/facturas')}}/'+v.adjunto+'" target="_blank">Ver adjunto</a>';
      else
        var adjunto = 'Pendiente';

      if(v.moneda == 'D')
        var monto = v.monto + ' US$';
      else
        var monto = v.monto + ' Bs';

      if(v.cancelado){
        if(v.moneda == 'D')
          pagado = v.cancelado + ' US$';
        else
          pagado = v.cancelado + ' Bs';
      }
      else
        var pagado = '-';


      var posicion = fac.length;

      fac.push({
        id: '<a href="javascript:detalles_fac('+posicion+')">'+id+'</a>',
        ffactura: ffactura,
        nde: v.ndes,
        monto: monto,
        pagado: pagado,
        soporte: adjunto
      });
    });

    $('#informacion').addClass('hidden'); //Buscar mejor método
    if($('#req_estatus').val() == 'OCR'){ 
      $('.hidden').show();
      $('#icontenido').attr("class", "fa fa-minus-circle");
      $('#icontenido').attr("title", "Mostrar menos información");
    }
    $('#table').bootstrapTable("load", pendientes);
    $('#tnde').bootstrapTable("load", nde);
    //$('#tnde').bootstrapTable("load", "<tr><th colspan='5'>Orden cerrada</th></tr>");
    $('#tfactura').bootstrapTable("load", fac);
    $('#table').bootstrapTable('resetView', {height: getHeight(pendientes)});
    $('#tnde').bootstrapTable('resetView', {height: getHeight(nde)} );
    $('#tfactura').bootstrapTable('resetView', {height: getHeight(fac)} );
  });

  function getHeight(data) {
        const MAX_HEIGHT = 300;
        const ROW_HEIGHT = 37;
        const HEIGHT = (data.length * ROW_HEIGHT) + 85;
        if(HEIGHT > MAX_HEIGHT)
          return MAX_HEIGHT;
        else
          return none;
        //return Math.min(MAX_HEIGHT, );
  }

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

  function detalles_nde(pos){
    var nde_data = notas[pos];
    var id_req = $('#id_requerimiento').val();
    var estatus = $('#req_estatus').val();
    var id_nde = nde_data['id_nde'];
    var tnde = nde_data['tipo'];
    var permiso = {{session('acceso')->nde[2]}};

    if(nde_data['lugar'])
      var lugar = '<p><input id="lugar" name="lugar" type="hidden" value="'+nde_data['lugar']+'">'+nde_data['lugar']+'</p>';
    else if(permiso)
      var lugar = '<input id="lugar" name="lugar" type="text" class="form-control col-lg-8 col-sm-8 margin-bottom" placeholder="Indique el lugar de entrega" required>';
    else 
      var lugar = '<p>No entregado</p>';

    if(nde_data['fentrega'])
      var fentrega = '<p><input id="fentrega" name="fentrega" type="hidden" value="'+nde_data['fentrega']+'">'+nde_data['fentrega']+'</p>';
    else if(permiso)
      var fentrega = '<input id="fentrega" name="fentrega" type="date" class="form-control col-lg-8 col-sm-8 margin-bottom" value="{{date("Y-m-d")}}" required>'
    else
      var fentrega = '<p>N/A</p>';

    if(nde_data['adjunto'])
      var adjunto = '<a href="{{asset('storage/nde')}}/'+nde_data['adjunto']+'" target="_blank">Ver adjunto</a>';
    else if(permiso)
      var adjunto = '<input class="margin-bottom" style="max-width: 60%" type="file" id="adjunto" name="adjunto">';
    else
      var adjunto = '<p>Sin soporte</p>';

    if(tnde == 'P')
      var tipo = 'Parcial';
    else
      var tipo = 'Total';

    var cotizacion = {!! $cotizacion or 'null' !!}; 
    var html = '<form id="modnde" method="post" action="{{route('modificar_nde')}}" enctype="multipart/form-data">'+
               '{{ csrf_field() }}' +
               '<div class="form-swal"><label class="text-primary">Cliente</label><p>{{$datos->nombre_cliente}} <i class="fa fa-arrow-right"> </i> {{$datos->nombre_sub}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">RFQ</label><p>{{$datos->rfq}}</p></div>'+
               //'<div class="form-swal"><label class="text-primary">Fecha requerimiento</label><p>{{$datos->frequerimiento}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">Items aprobados</label><p>{{$po->ia}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">Cotización</label><p><a href="{{asset('storage/cotizaciones')}}/'+ cotizacion['cotizacion'] +'" target="_blank">Ver cotización</a></p></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary" title="Número de nota de entrega"># NDE</label><p>'+nde_data['id_nde']+'</p></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Fecha de emisión</label><p>'+nde_data['fnde']+'</p></div>' +
               '<div class="form-swal input-group-sm"><label class="text-primary" title="Tipo de nota de entrega">Tipo de NDE</label><p>'+tipo+'</p></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Lugar de entrega</label>'+lugar+'</div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Fecha de entrega</label>'+fentrega+'</div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Cargar soporte</label>'+adjunto+'</div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Comentarios</label><textarea id="obs" name="obs" type="text" placeholder="Haga un comentario breve (opcional)" class="form-control col-lg-8 col-sm-8"></textarea></div>'+
               '<input id="id_nde" name="id_nde" type="hidden" value="'+id_nde+'">'+
               '<input id="id_req" name="id_req" type="hidden" value="'+id_req+'">'+
               '<input id="tnde" name="tnde" type="hidden" value="'+tnde+'">'+
               '<input id="estatus" name="estatus" type="hidden" value="'+estatus+'">'; 

    if(!nde_data['adjunto']){
      html += '<input type="submit" class="btn btn-success btn-sm margin-right" value="Guardar">';
    }
    
    html += '<a href="javascript:swal.close();" class="btn btn-dark btn-sm">Cerrar</a></form>';

    swal({
      title: 'Detalles de la NDE #'+id_nde+' del requerimiento #'+id_req,
      focusConfirm: false,
      customClass: 'swal-wide-30',
      html: html,
      showConfirmButton: false,
    });



    /*.then((result) => {
        if (result.value) {
          //var formData = new FormData(form[0]);
          //formData.append('image', $('input[type=file]')[0].files[0]); 
          //console.log(formData);
          $("#modnde").submit();
          /*var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          var estatus = $('#req_estatus').val();
          var fentrega = $('#fentrega').val();
          var lugar = $('#lugar').val();
          var adjunto = $('#adjunto').val();
          var obs = $('#obs').val();
          console.log(adjunto);
          console.log(lugar);
          $.ajax({
            data: {_token: CSRF_TOKEN, 'id_req': id_req, 'id_nde': id_nde, 'estatus': estatus, 'tipo': tnde, 'fentrega': fentrega, 'lugar': lugar, 'adjunto': adjunto, 'obs': obs},
            url: 'modificar_nde',
            type: 'post',
            contentType: false,
            processData: false,
            success:  function (data) {
              console.log(data);
              swal(
                "Resultado:", 
                "La nota de entrega #"+ id_nde +" del requerimiento #"+ id_req + " ha sido modificada exitosamente", 
                "success"
              ).then(function(){location.reload();});
            },
            error: function() {
              swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
            }
          });
      };
    });*/
  }
  

  /*$("#modnde").submit(function(e){ // Investigar al respecto
    e.preventDefault();
    var form = $(this);
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var data = new FormData(form[0]);
    data.append('_token', CSRF_TOKEN);
    console.log(form[0]);
    $.ajax({
        url: 'modificar_nde',
        type: 'POST',
        data: data,
        cache: false,
        processData: false,
        contentType : false,
        success: function (data) {
            console.log(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
});

    $('#modnde').submit(function(e){
    e.stopPropagation(); 
    e.preventDefault();
  });*/

  function detalles_fac(pos){
    var fac_data = facturas[pos];
    var id_req = $('#id_requerimiento').val();
    var estatus = $('#req_estatus').val();
    var id_fac = fac_data['nfactura'];
    var diferencia = fac_data['monto'] - fac_data['cancelado'];
    var permiso = {{session('acceso')->facturacion[2]}};

    if (fac_data['moneda'] == 'D')
      var moneda = 'US$';
    else
      var moneda = 'Bs';

    var monto = fac_data['monto'] + ' ' + moneda;

    if(fac_data['cancelado'] != fac_data['monto'] && permiso)
      var cancelar = '<div class="form-swal input-group-sm"><label class="text-primary">Monto a cancelar</label><input id="cancelado" name="cancelado" type="number" class="form-control col-lg-6 col-sm-6 number-no-spin margin-bottom" step=".01" pattern="^\d+(?:\.\d{1,2})?$" min="0" max="'+diferencia+'" required><select id="moneda" name="moneda" class="form-control col-lg-2 col-sm-2 margin-bottom" required><option value="'+fac_data['moneda']+'">'+moneda+'</option></select></div>';
    else
      var cancelar = '';
    
    if(fac_data['cancelado'])
      var cancelado = '<p>'+fac_data['cancelado']+' '+ moneda +'</p>';
    else 
      var cancelado = '<p>Ningun monto registrado</p>';

    

    if(fac_data['adjunto'])
      var adjunto = '<a href="{{asset('storage/facturas')}}/'+fac_data['adjunto']+'" target="_blank">Ver adjunto</a>';
    else
      var adjunto = '<input class="margin-bottom" style="max-width: 60%" type="file" id="adjunto" name="adjunto">';

    var cotizacion = {!! $cotizacion or 'null' !!}; 
    var html = '<form id="pfactura" method="post" action="{{route('pagar_factura')}}" enctype="multipart/form-data">'+
               '{{ csrf_field() }}' +
               '<div class="form-swal"><label class="text-primary">Cliente</label><p>{{$datos->nombre_cliente}} <i class="fa fa-arrow-right"> </i> {{$datos->nombre_sub}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">RFQ</label><p>{{$datos->rfq}}</p></div>'+
               //'<div class="form-swal"><label class="text-primary">Fecha requerimiento</label><p>{{$datos->frequerimiento}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">Items aprobados</label><p>{{$po->ia}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">Cotización</label><p><a href="{{asset('storage/cotizaciones')}}/'+ cotizacion['cotizacion'] +'" target="_blank">Ver cotización</a></p></div>'+
               '<div class="form-swal"><label class="text-primary" title="Número de nota de entrega"># Factura</label><p>'+fac_data['nfactura']+'</p></div>'+
               '<div class="form-swal"><label class="text-primary" title="Notas de entrega facturadas">Monto</label><p>'+monto+'</p></div>'+
               '<div class="form-swal"><label class="text-primary">Fecha de factura</label><p>'+fac_data['ffactura']+'</p></div>' +
               '<div class="form-swal"><label class="text-primary">Monto cancelado</label>'+cancelado+'</div>' + cancelar +
               '<div class="form-swal"><label class="text-primary" title="Notas de entrega facturadas">NDE Facturadas</label><p>'+fac_data['ndes']+'</p></div>'+
               '<div class="form-swal"><label class="text-primary">Soporte</label>'+adjunto+'</div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Comentarios</label><textarea id="obs" name="obs" type="text" placeholder="Haga un comentario breve (opcional)" class="form-control col-lg-8 col-sm-8"></textarea></div>'+
               '<input id="id_fac" name="id_fac" type="hidden" value="'+id_fac+'">'+
               '<input id="id_req" name="id_req" type="hidden" value="'+id_req+'">'+
               '<input id="estatus" name="estatus" type="hidden" value="'+estatus+'">';

    if(fac_data['monto'] != fac_data['cancelado']){
      html += '<input type="submit" class="btn btn-success btn-sm margin-right" value="Guardar">';
    }

    html +=  '<a href="javascript:swal.close();" class="btn btn-dark btn-sm">Cerrar</a></form>';

    swal({
      title: 'Detalles de Factura #'+id_fac+' del requerimiento #'+id_req,
      focusConfirm: false,
      customClass: 'swal-wide-30',
      html: html,
      showConfirmButton: false
    });
  }

  $('#rfactura').click(function(){
    var cotizacion = {!! $cotizacion or 'null' !!};

    var id_notas = [];
    notas.forEach(function(v){
      if(v.factura == null && v.fentrega != null)
        id_notas.push('<span style="margin-right:5px"><input id="notas_facturar[]" name="notas_facturar[]" type="checkbox" class="checkbox-template" value="'+v.id_nde+'"> '+v.id_nde+'</span>');
    });

    if (cotizacion['moneda'] == 'D')
      var moneda = 'US$';
    else
      var moneda = 'Bs.';

    var id_req = $('#id_requerimiento').val();
    var rfactura = $(this);
    var html = '<form id="regfactura" method="post" enctype="multipart/form-data" action="{{route('registrar_factura')}}">'+
               '{{ csrf_field() }}' +
               '<div class="form-swal"><label class="text-primary">Cliente</label><p>{{$datos->nombre_cliente}} <i class="fa fa-arrow-right"> </i> {{$datos->nombre_sub}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">RFQ</label><p>{{$datos->rfq}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">Fecha requerimiento</label><p>{{$datos->frequerimiento}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">Items aprobados</label><p>{{$po->ia}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">Cotización</label><p><a href="{{asset('storage/cotizaciones')}}/'+ cotizacion['cotizacion'] +'" target="_blank">Ver cotización</a></p></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary" title="Número de factura"># Factura</label><input id="id_fac" name="id_fac" class="form-control col-lg-8 col-sm-8 margin-bottom" placeholder="Indique el número de Factura" required></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Fecha de emisión</label><input id="ffac" name="ffac" type="date" class="form-control col-lg-8 col-sm-8 margin-bottom" value="{{date("Y-m-d")}}" required></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Monto facturado</label><input name="monto" type="number" class="form-control col-lg-6 col-sm-6 margin-bottom number-no-spin" placeholder="Indique el monto" step=".01" pattern="^\d+(?:\.\d{1,2})?$" min="0" max="{{$po->monto}}"><select id="moneda" name="moneda" class="form-control col-lg-2 col-sm-2 margin-bottom" required><option value="'+cotizacion['moneda']+'">'+moneda+'</option></select></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary" title="NDE">NDE</label><div class="margin-bottom">'+id_notas+'</div></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Factura escaneada</label><input class="margin-bottom" style="max-width: 60%" type="file" id="adjunto" name="adjunto" required></div>'+
               //'<div class="form-swal"><label class="text-primary">Lugar de entrega</label><input id="lugar" name="lugar" type="text" class="form-control col-lg-8 col-sm-8 margin-bottom" placeholder="Indique el lugar de entrega"></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Comentarios</label><textarea id="obs" name="obs" type="text" placeholder="Haga un comentario breve (opcional)" class="form-control col-lg-8 col-sm-8"></textarea></div>'+
               '<input id="id_req" name="id_req" type="hidden" value="{{$datos->id_requerimiento}}" />' +
               '<input id="estatus" name="estatus" type="hidden" value="{{$datos->estatus}}" />' +
               '<input type="submit" class="btn btn-success btn-sm margin-right" value="Guardar">' +
               '<a href="javascript:swal.close();" class="btn btn-dark btn-sm">Cerrar</a>' +
               //'<input type="submit" value="Enviar" />' +
               '</form>'; 

    swal({
      title: 'Registrar Factura en el requerimiento #' + id_req,
      focusConfirm: false,
      customClass: 'swal-wide-35',
      html: html,
      showConfirmButton: false
    });
  });

  $('#contenido').click(function(){
    var icono = $('#icontenido');
    if($('.hidden').is(":visible")){
      icono.attr("class", "fa fa-plus-circle");
      icono.attr("title", "Mostrar más información"); 
    }
    else {
      icono.attr("class", "fa fa-minus-circle");
      icono.attr("title", "Mostrar menos información");
    }
      $('.hidden').toggle();
      //$('paper-tab#button').click();
  });

  var datos = <?php if(isset($datos)) echo $datos; else echo "null"; ?>;
  var selected;
  /*alert($(".card-comment").scrollHeight());
  $(".card-comment").scrollTop($(".card-comment").scrollHeight());*/

  $('#procesar').click(function(){
    var id_req = $('#id_requerimiento').val();
    var procesar = $(this);
    /*var cotizacion = {!! $cotizacion or 'null' !!};
    if (cotizacion['moneda'] == 'D')
      var moneda = 'US$';
    else
      var moneda = 'Bs.';  
    var html = '<div class="form-swal"><label class="text-primary">Cliente</label><p>{{$datos->nombre_cliente}} <i class="fa fa-arrow-right"> </i> {{$datos->nombre_sub}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">RFQ</label><p>{{$datos->rfq}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">Fecha requerimiento</label><p>{{$datos->frequerimiento}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">Items solicitados</label><p>{{$datos->ir}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">Items cotizados</label><input name="ic" type="number" class="form-control col-lg-8 col-sm-8 margin-bottom" placeholder="Indique la cantidad de items a cotizar" value="'+ cotizacion['ic']+'"></div>'+
               '<div class="form-swal"><label class="text-primary">Cotización</label><p><a href="{{asset('storage/cotizaciones')}}/'+ cotizacion['cotizacion'] +'" target="_blank">Ver cotización</a></p></div>'+
               '<div class="form-swal"><label class="text-primary">ID Profit</label><input name="profit" type="text" class="form-control col-lg-8 col-sm-8 margin-bottom" placeholder="Indique el número de cotización" value="'+ cotizacion['profit'] +'"></div>'+
               '<div class="form-swal"><label class="text-primary">Monto</label><input name="monto" type="number" class="form-control col-lg-5 col-sm-5 margin-bottom number-no-spin" placeholder="Indique el monto" value="'+ cotizacion["monto"] +'"><select id="moneda" name="moneda" class="form-control col-lg-3 col-sm-3 margin-bottom" required><option value="'+ cotizacion["moneda"] +'">'+moneda+'</option></select></div>'+
               '<div class="form-swal"><label class="text-primary">Comentarios</label><textarea id="obs" name="obs" type="text" placeholder="Haga un comentario breve (opcional)" class="form-control col-lg-8 col-sm-8"></textarea></div>'+
               '<input id="id_cotizacion" name="id_cotizacion" type="hidden" value="'+ cotizacion['id_cotizacion']+'"/>'; 
    const swalbt = swal.mixin({
      confirmButtonClass: 'btn btn-success margin-right',
      cancelButtonClass: 'btn btn-dark',
      confirmButtonText: 'Procesar',
      buttonsStyling: false,
      showConfirmButton: true,
      showCancelButton: true
    });

    swalbt({
      title: 'Procesar orden del requerimiento #' + id_req + ' <i class="fa fa-info-circle fa-sm" title="Modifique estos datos solamente si la Orden de compra es distinta a la cotización"></i>',
      customClass: 'swal-wide',
      focusConfirm: false,
      html: html
    }).then((result) => {
        if (result.value) {*/
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
            data: {_token: CSRF_TOKEN, 'id_req': id_req},
            url: 'procesar',
            type: 'post',
            beforeSend: function () {
              procesar.prop('disabled', true);
            },
            success:  function (data) {
              swal(
                "Resultado:", 
                "La orden de compra del requerimiento #"+ id_req + " ha sido aceptada", 
                "success"
              ).then(function(){location.reload();});
            },
            error: function() {
              swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
              procesar.prop('disabled', false);
            }
          });
      /*};
    });*/
  });

  $('#ocerrar').click(function(){
    var id_req = $('#id_requerimiento').val();
    var estatus = $('#req_estatus').val();
    var ocerrar = $(this);
    swal({
      title: "¿Esta seguro?",
      text: "Cerrar la orden de compra del requerimiento #" + id_req,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ok'
      }).then((result) => {
        if (result.value) {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
            data: {_token: CSRF_TOKEN, 'id_req': id_req, 'estatus': estatus},
            url: 'cerrar_orden',
            type: 'post',
            beforeSend: function () {
              ocerrar.prop('disabled', true);
            },
            success:  function (data) {
              swal(
                "Resultado:", 
                "La orden de compra del requerimiento #"+ id_req + " ha sido cerrada", 
                "success"
              ).then(function(){location.reload();});
            },
            error: function() {
              swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
              ocerrar.prop('disabled', false);
            }
          });
        }
      });
  });

  $('#rnde').click(function(){
    var id_req = $('#id_requerimiento').val();
    var rnde = $(this);
    var cotizacion = {!! $cotizacion or 'null' !!}; 
    var html = '<div class="form-swal"><label class="text-primary">Cliente</label><p>{{$datos->nombre_cliente}} <i class="fa fa-arrow-right"> </i> {{$datos->nombre_sub}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">RFQ</label><p>{{$datos->rfq}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">Fecha requerimiento</label><p>{{$datos->frequerimiento}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">Items aprobados</label><p>{{$po->ia}}</p></div>'+
               '<div class="form-swal"><label class="text-primary">Cotización</label><p><a href="{{asset('storage/cotizaciones')}}/'+ cotizacion['cotizacion'] +'" target="_blank">Ver cotización</a></p></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary" title="Número de nota de entrega"># NDE</label><input id="id_nde" name="id_nde" class="form-control col-lg-8 col-sm-8 margin-bottom" placeholder="Indique el número de Nota de Entrega"></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Fecha de emisión</label><input id="fnde" name="fnde" type="date" class="form-control col-lg-8 col-sm-8 margin-bottom" value="{{date("Y-m-d")}}"></div>' +
               '<div class="form-swal input-group-sm"><label class="text-primary" title="Tipo de nota de entrega">Tipo de NDE</label><select id="tipo" name="tipo" class="form-control col-lg-8 col-sm-8 margin-bottom"><option value="">Seleccionar</option><option value="P">Parcial</option><option value="T">Total</option></select></div>'+
               //'<div class="form-swal"><label class="text-primary">Lugar de entrega</label><input id="lugar" name="lugar" type="text" class="form-control col-lg-8 col-sm-8 margin-bottom" placeholder="Indique el lugar de entrega"></div>'+
               '<div class="form-swal input-group-sm"><label class="text-primary">Comentarios</label><textarea id="obs" name="obs" type="text" placeholder="Haga un comentario breve (opcional)" class="form-control col-lg-8 col-sm-8"></textarea></div>'; 
    const swalbt = swal.mixin({
      confirmButtonClass: 'btn btn-success btn-sm margin-right',
      cancelButtonClass: 'btn btn-dark btn-sm',
      confirmButtonText: 'Registrar',
      buttonsStyling: false,
      showConfirmButton: true,
      showCancelButton: true
    });

    swalbt({
      title: 'Registrar NDE del requerimiento #' + id_req,
      focusConfirm: false,
      customClass: 'swal-wide-35',
      html: html
    }).then((result) => {
        if (result.value) {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          var estatus = $('#req_estatus').val();
          var id_nde = $('#id_nde').val();
          var fnde = $('#fnde').val();
          var tipo = $('#tipo').val();
          var obs = $('#obs').val();
          $.ajax({
            data: {_token: CSRF_TOKEN, 'id_req': id_req, 'id_nde': id_nde, 'estatus': estatus, 'fnde': fnde, 'tipo': tipo, 'obs': obs},
            url: 'registrar_nde',
            type: 'post',
            beforeSend: function () {
              rnde.prop('disabled', true);
            },
            success:  function (data) {
              swal(
                "Resultado:", 
                "La nota de entrega #"+ data +" del requerimiento #"+ id_req + " ha sido registrada exitosamente", 
                "success"
              ).then(function(){location.reload();});
            },
            error: function() {
              swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
              rnde.prop('disabled', false);
            }
          });
      };
    });
  });

  $('#novedades').click(function(){
    $('.container-novedades').removeClass('hidden');
    $('.container-timeline').addClass('hidden');
  });

  $('#timeline').click(function(){
    $('.container-novedades').addClass('hidden');
    $('.container-timeline').removeClass('hidden');
  });

  $('#enviar').click(function(){

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
    
    var html = '<form id="prueba" method="post" action="{{route('asignar')}}">'+
               '{{csrf_field()}}' +
               '<div class="form-group row"><label for="analista1" class="col-form-label col-sm-4 margin-auto">Analista</label> <select id="analista1" name="analista1" class="form-control margin col-lg-7 col-sm-7" required></select></div>' +
               '<div class="form-group row"><label for="analista2" class="col-form-label col-lg-4 col-sm-4 margin-auto">Analista 2</label> <select id="analista2" name="analista2" class="form-control margin col-lg-7 col-sm-7"></select></div>'+
               '<div class="form-group row"><label for="obs" class="col-form-label col-lg-4 col-sm-4 margin-auto">Observación</label> <textarea id="obs" type="text" placeholder="Ingrese un comentario" class="form-control margin col-lg-7 col-sm-7"></textarea></div>'+
               '<input id="id_requerimiento" name="id_requerimiento" type="hidden" value="'+ id_req +'"/>' +
               '<input id="tipo_dep" name="tipo_dep" type="hidden" value="' + tipo_dep + '"/>' +
               '<input class="btn btn-info" value="Registrar" type="submit">' + 
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
            html: html
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
    var html = 
    '<div class="form-swal"><label class="text-primary">Cliente</label><p>{{$datos->nombre_cliente}} <i class="fa fa-arrow-right"> </i> {{$datos->nombre_sub}}</p></div>'+
    '<div class="form-swal"><label class="text-primary">Comprador</label><p>{{$datos->nombre_contacto}}</p></div>'+
    '<div class="form-swal"><label class="text-primary">Departamento</label><p>{{$dep1->nombre_dep}} <i class="fa fa-arrow-right"></i> {{$ge1->nombre}}</p></div>'+
    '<div class="form-swal"><label class="text-primary">RFQ</label><p>{{$datos->rfq}}</p></div>'+
    '<div class="form-swal"><label class="text-primary">Fecha requerimiento</label><p>{{$datos->frequerimiento}}</p></div>'+
    '<div class="form-swal"><label class="text-primary">Fecha registro</label><p>{{$datos->fregistro}}</p></div>'+
    `<div class="form-swal"><label class="text-primary">Asunto</label><p>{{$datos->asunto}}</p></div>`+
    `<div class="form-swal"><label class="text-primary">Detalles</label><p>{{$datos->detalle}}</p></div>`+
    '<div class="form-swal"><label class="text-primary">Estado</label><p>'+ ver_estado_requerimiento('{{$datos->estatus}}') +'</p></div>';

    swal({
      title: 'Detalles del requerimiento #' + id_req,
      cancelButtonClass: 'btn btn-dark',
      buttonsStyling: false,
      cancelButtonText: "Cerrar",
      focusConfirm: false,
      showConfirmButton: false,
      showCloseButton: true,
      showCancelButton: true,
      customClass: 'swal-wide',
      html: html
    });
  });

  function responder(id){
    if(selected!='')
      $('#nov_'+selected).css('background-color','#fff');

    if(selected == id)
      selected='';
    
    else {
      $('#nov_'+id).css('background-color','#9DAABC');
      selected = id;
    }
  }

</script>
@endsection