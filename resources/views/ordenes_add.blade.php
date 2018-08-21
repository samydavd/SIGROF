@extends('layout')

@section('librerias')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Registro de orden de compra para requerimiento #{{$datos->id_requerimiento}}</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Registro de PO</li>
    </ul>
</div>

@if(session('data') == "success")
  <script type="text/javascript">
     swal("Acción completada", "El usuario ha sido registrada exitosamente", "success");
  </script>
@elseif(session('data') == "error")
  <script type="text/javascript">
    swal("Ha ocurrido un problema", "El registro no ha podido ser almacenado. Si el problema persiste pongase en contacto con el departamento de soporte", "error");
  </script>
@endif

@php
if($datos->tcontratacion == 'P')
  $contratacion = "Pública";
else
  $contratacion = "Tradicional";

if(isset($cotizacion)){
  if($cotizacion->moneda == "D")
    $monto = "US$ ".number_format($cotizacion->monto,2,'.',',');
  else
    $monto = "Bs ".number_format($cotizacion->monto,2,',','.');

  if($cotizacion->tercerizado)
    $tercerizado = '<span class="text-green">Si</span>';
  else
    $tercerizado = '<span class="text-red">No</span>';
  } 
else
  $tercerizado = 'S/I';  
@endphp

<section class="forms"> 
            <div class="container-fluid">
              <div class="row">
                <!-- Horizontal Form-->
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                        <div class="list-group">
                        <div class="form-group row">
                          <div class="col-lg-3">
                            <label class="col-list-label">Cliente</label>
                                <div><p>{{$datos->nombre_cliente}}</p></div> 
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
                            <label class="col-list-label">Departamento(s)</label>
                                <div><p>{{$asignaciones[0]->nombre_dep}}
                                @isset($asignaciones[1])
                                - {{$asignaciones[1]->nombre_dep}}                 
                                @endif
                                </p></div> 
                          </div>

                          <div class="col-lg-3">
                            <label class="col-list-label">RFQ</label>
                              <div><p>{{$datos->rfq}}</p></div> 
                          </div>

                          <div class="col-lg-3">
                            <label class="col-list-label">Cotización</label>
                              <div><p><a href="{{asset('storage/cotizaciones/'. $cotizacion->cotizacion)}}" target="_blank">{{$cotizacion->profit}} ({{$monto}})</a></p></div> 
                          </div>   

                          @if(isset($cotizacion->descuento))
                            <div class="col-lg-3">
                              <label class="col-list-label">Factor (descuento)</label>
                                <p>{{$cotizacion->factor}} ({{$cotizacion->descuento }}%)</i></p>
                            </div>
                          @endif 

                        </div>
                      </div>

                        <form id="departamento_nuevo" action="{{route('ordenes_add_db')}}" class="col-auto" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group row">

                          <div class="col-lg-3 input-group-sm">
                            <label for="npo" title="Número de orden de compra" class="col-form-label">Número de PO</label>
                                <input id="npo" name="npo" type="text" placeholder="Ingrese el número de la orden de compra" class="form-control" required> 
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="faprob" class="col-form-label">Fecha aprobación</label>
                              <input id="faprob" name="faprob" type="date" placeholder="Ingrese nombre departamento" class="form-control" value="{{date('Y-m-d')}}" required> 
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="ia" class="col-form-label">Items aprobados</label>
                            <input id="ia" name="ia" type="number" placeholder="Ingrese el número de la orden de compra" class="form-control" value="{{$cotizacion->ic}}" max={{$cotizacion->ic}} min=0 required> 
                          </div>

                          <div class="col-lg-3 input-group-sm">
                          <label for="mpago" class="col-form-label">Modalidad pago</label>
                            <Select id="mpago" name="mpago" class="form-control" required>
                              <option value="">Seleccionar</option>
                              <option value="C">Credito</option>
                              <option value="O">Contado</option>
                              <option value="E">Efectivo</option>
                            </Select> 
                          </div>

                        </div>

                        <div class="form-group row">

                          <div class="col-lg-3 input-group-sm">
                            <label for="monto" class="col-form-label">Monto aprobado</label>
                            <div class="input-group input-group-sm">
                              <input id="monto" name="monto" type="number" class="form-control number-no-spin" placeholder="Indique el monto" max={{$cotizacion->monto}} min=0 />
                              <div class="input-group-btn input-group-sm">
                                @if($cotizacion->moneda == 'D')
                                  <select id="moneda" name="moneda" class="form-control" required><option value="D">US$</option></select>
                                @else
                                  <select id="moneda" name="moneda" class="form-control" required><option value="B">Bs</option></select>
                                @endif
                              </div>
                            </div>
                          </div>

                          <div class="col-lg-6 input-group-sm">
                            <label for="detalles"  class="col-form-label">Detalle de PO</label>
                                <textarea id="detalles" name="detalles" type="text"
                                rows=1 placeholder="Ingrese los detalles de la orden de compra" class="form-control" required></textarea>
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="po" class="col-form-label">Archivo adjunto</label>
                            <input type="file" class="width-100" id="po" name="po" lang="es">
                          </div>

                        </div>

                        

                        <input id="id_requerimiento" name="id_requerimiento" type="hidden" value="{{$datos->id_requerimiento}}" />
                        
                        <center>
                          <input type="submit" value="Registrar" class="btn btn-success btn-sm">
                          <input type="reset" value="Limpiar Campos" class="btn btn-danger btn-sm">
                        </center>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

@endsection

@section('script')
<script type="text/javascript">

  var datos = <?php if(isset($datos)) echo $datos; else echo "null"; ?>;

  $('#monto').blur(function(){
    $("#monto").val(parseFloat($(this).val()).toFixed(2));
  });

</script>
@endsection