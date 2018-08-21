@extends('layout')

@section('librerias')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Registro de solicitud</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Registro de solicitud</li>
    </ul>
</div>

@if(session('data') == "success")
  <script type="text/javascript">
     swal("Acción completada", "El requerimiento ha sido registrada exitosamente", "success");
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
                    <div class="card-body">
                      <!--p>Ingrese los datos a registrar</p-->
                    <form id="departamento_nuevo" action="{{route('requerimientos_add_db')}}" class="col-auto" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <div class="col-lg-3 input-group-sm">
                              <label for="clientes" class="col-form-label">Cliente<!--small class="text-primary">*</small--></label>
                                <Select id="clientes" name="clientes" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($clientes as $clt)
                                      <option value="{{$clt->id_cliente}}"> {{$clt->nombre_cliente}} </option>
                                    @endforeach
                                </Select>  
                            </div>

                            <div class="col-lg-3 input-group-sm">
                              <label for="subclientes" class="col-form-label">Subcliente</label>
                              <Select id="subclientes" name="subclientes" class="form-control" required disabled>
                                    <option value="">Seleccione un subcliente</option>
                              </Select>
                            </div>
                            <div class="col-lg-3 input-group-sm">
                              <label for="comprador" class="col-form-label">Comprador</label>
                              <Select id="comprador" name="comprador" class="form-control" required disabled>
                                    <option value="">Seleccione un comprador</option>
                              </Select>   
                            </div>
                            <div class="col-lg-3 input-group-sm">
                                <label for="tcontratacion" class="col-form-label">Tipo de contratación</label>
                                <Select id="tcontratacion" name="tcontratacion" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <option value="T">Tradicional</option>
                                    <option value="P">Pública</option>
                                </Select>  
                            </div>
                        </div>

                        <div class="publica hidden" style="background:#E9EDFC; padding-top:0.5rem; padding-left:2.2rem; margin-left: -2.2rem; padding-right:1.2rem; margin-right: -1.2rem">

                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm">
                            <label for="nproceso" class="col-form-label">Número de proceso</label>
                                <input id="nproceso" name="nproceso" type="number" class="form-control number-no-spin" min=0 /> 
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="dproceso" class="col-form-label">Denominación del proceso</label>
                                <input id="dproceso" name="dproceso" type="text" class="form-control"> 
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="ncontratacion" class="col-form-label">Nivel de contratación</label>
                                <input id="ncontratacion" name="ncontratacion" type="number" placeholder="Monto < 133.274.213,62 Bs." class="form-control" max="133.274.213,62" min="0" /> 
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="comercial" class="col-form-label">Actividad comercial</label>
                            
                                <Select id="comercial" name="comercial" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="31">31</option>
                                    <option value="39">39</option>
                                    <option value="41">41</option>
                                    <option value="46">46</option>
                                    <option value="47">47</option>
                                    <option value="73">73</option>
                                    <option value="78">78</option>
                                </Select>   
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm">
                            <label for="faclaratoria" class="col-form-label">Fecha reunión de aclaratoria</label>
                                <input id="faclaratoria" name="faclaratoria" type="datetime-local" class="form-control"> 
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="foferta" class="col-form-label">Fecha presentación oferta económica</label>
                                <input id="foferta" name="foferta" type="datetime-local" class="form-control">
                          </div>

                          <div class="col-lg-3 input-group-sm">     
                            <label for="voferta" class="col-form-label">Validez de oferta</label>
                                <input id="voferta" name="voferta" type="number" placeholder="Cantidad de días de validez" class="form-control" min="0"> 
                          </div>

                          <div class="col-lg-3">
                            <label class="col-form-label">Requiere fianza</label>

                            <div class="form-group">
                                <div class="input-group input-group-sm">

                                <Select id="fianza" name="fianza" class="form-control col-lg-3">
                                    <option value=""></option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </Select> 

                                <input id="ffianza" name="ffianza" type="date" placeholder="Ingrese nombre departamento" class="form-control" disabled> 

                              </div>
                            </div>   
                          </div>   
                        </div>

                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm"> 
                            <label for="cpago" class="col-form-label">Condición de pago</label>
                                <Select id="cpago" name="cpago" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <option value="B">Bolívares</option>
                                    <option value="M">Mixto</option>
                                </Select>  
                          </div>

                          <div class="col-lg-3 input-group-sm"> 
                            <label for="pbase" class="col-form-label">Presupuesto base (Bs.)</label>
                                <input id="pbase" name="pbase" type="number" placeholder="Monto en bolívares" class="form-control" min="0">
                          </div>

                          <div class="col-lg-3 input-group-sm pbase_dol" hidden>
                            <label for="pbase_dol" class="col-form-label">Presupuesto base (USD)</label>
                                <input id="pbase_dol" name="pbase_dol" type="number" placeholder="Monto en dolares" class="form-control" min="0">   
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-lg-6 input-group-sm">
                              <label for="observaciones" class="col-form-label">Observaciones</label>
                                <textarea id="observaciones" name="observaciones" type="text" placeholder="Ingrese los detalles de la solicitud" class="form-control"></textarea>
                          </div>
                        </div>
                      </div>

                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm">
                            <label for="empresa" class="col-form-label">Empresa</label>
                                <Select id="empresa" name="empresa" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($empresas as $emp)
                                      <option value="{{$emp->id_empresa}}">{{$emp->nombre_emp}}</option> 
                                    @endforeach
                                </Select>   
                          </div>  

                          <div class="col-lg-3 input-group-sm">
                            <label for="departamentos" class="col-form-label">Departamento(s)</label>
                                <button type="button" id="dep_add" class="btn btn-info btn-xs">+</button>
                                <Select id="departamentos" name="departamentos" class="form-control" disabled>
                                    <option value="">Seleccionar</option>
                                </Select>  
                          </div>

                          <div class="col-lg-6 input-group-sm dep_listado">

                            <input id="dep_listado" type="hidden" value="[]">
                          </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-3 input-group-sm">
                              <label for="rfq" class="col-form-label">RFQ</label>
                                <input id="rfq" name="rfq" type="text" placeholder="Ingrese codigo Request For Quotation" class="form-control" required> 
                            </div>
                            <div class="col-lg-3 input-group-sm">
                                <label for="freq" class="col-form-label">Fecha de solicitud</label>
                                <input id="freq" name="freq" type="date" placeholder="Ingrese nombre departamento" class="form-control" value="{{date('Y-m-d')}}" required> 
                            </div>

                            <div class="col-lg-3 input-group-sm">
                                <label for="prioridad" class="col-form-label">Prioridad</label>
                                <Select id="prioridad" name="prioridad" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <option value="N">Normal</option>
                                    <option value="I">Inmediata</option>
                                    <option value="U">Urgente</option>
                                    <option value="A">Abierta</option>
                                </Select> 
                            </div>

                            <div class="col-lg-3 input-group-sm">
                              <label for="flimite" class="col-form-label">Fecha limite</label>
                                <input id="flimite" name="flimite" type="date" class="form-control" disabled required>
                            </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm">
                            <label for="asunto" class="col-form-label">Asunto</label>
                              <input id="asunto" name="asunto" type="text" placeholder="Ingrese el asunto de la solicitud" class="form-control" maxlength="60" required> 
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="pclaves" class="col-form-label">Palabras clave</label>
                                <input id="pclaves" name="pclaves" type="text" placeholder="Ingrese el asunto de la solicitud" class="form-control" maxlength="35" required> 
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="ir" class="col-form-label">Items solicitados</label>
                              <input id="ir" name="ir" type="number" placeholder="Cantidad de Items solicitados" class="form-control" min="0" required> 
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="adjuntos" class="col-form-label">Adjuntos</label>
                              <input type="file" class="form-control" name="files[]" multiple/>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-lg-6 input-group-sm">
                            <label for="detalles" class="col-form-label">Detalles</label>
                              <textarea id="detalles" name="detalles" type="text" placeholder="Ingrese los detalles de la solicitud" class="form-control"></textarea>
                          </div>
                        </div>

                        <!--img src="{{--Storage::url('adjuntos/Mix.JPG')--}}"-->

                        <input id="id_usuario" name="id_usuario" type="hidden" value="" />
                        
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

  $('#dep_add').click(function(){
    var dep = $('#departamentos option:selected');
    if(dep.val()){
      var nombrestr = "'"+dep.text()+"'";

      $('.dep_listado').append('<button type="button" id="'+dep.val()+'" class="btn btn-info btn-sm btn-view">'+
                              dep.text()+
                              ' <a href="#" onclick="remove_dep('+dep.val()+','+nombrestr+')" class="text-white">'+
                                '<i id="icon" class="fa fa-close"></i>'+
                              '</a>'+
                             '</button>');

      dep.remove();
    }
  });

  function remove_dep(id, nombre){
    $('#departamentos')
         .append($("<option></option>")
         .attr("value", id)
         .text(nombre));

    $('button[id="'+id+'"]').remove();
  }

  function convertDate(fecha) {
    function pad(s) { return (s < 10) ? '0' + s : s; }
    var d = new Date(fecha);
    return [d.getFullYear(), pad(d.getMonth()+1), pad(d.getDate())].join('-');
  }

  $(function() { 
    $("input[type='reset']").click();
  });

  $("#tcontratacion").change(function(){
    if(this.value == 'P'){
      $(".hidden").show(100);
      $(".hidden *:not(textarea, #cparticipantes)").prop('required', true);
    }
    else{
      $(".hidden").hide(100);
      $(".hidden *:not(textarea, #cparticipantes)").prop('required', false);
    }
  });

  $("#fianza").change(function(){
    if(this.value == 1)
      $("#ffianza").removeAttr('disabled'); 
    else
      $("#ffianza").attr({'disabled': 'disabled'});
  });

  $("#clientes").change(function(){

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');        
        var subclientes = $("#subclientes");
        var clientes = $(this);

        if($(this).val() != ''){
          $.ajax({
              data: {_token: CSRF_TOKEN, 'id_cliente': clientes.val()},
              url:   'subclientes_act',
              type:  'post',
              beforeSend: function () {
                clientes.prop('disabled', true);
              },
              success:  function (data) {
                clientes.prop('disabled', false);
                subclientes.find('option').remove();
                subclientes.append('<option value="">Seleccionar</option>');
                data.forEach(function(v){ 
                  subclientes.append('<option value="' + v.id_subcliente + '">' + v.nombre_sub + '</option>');
                });
                subclientes.prop('disabled', false);
              },
              error: function() {
                swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
                clientes.prop('disabled', false);
              }
            });
        }
        else
        {
            subclientes.find('option').remove();
            subclientes.append('<option value="">Seleccione un cliente</option>');
            subclientes.prop('disabled', true);
        }
    });

  $("#subclientes").change(function(){

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');        
        var comprador = $("#comprador");
        var cliente = $("#clientes");
        var subcliente = $(this);

        if($(this).val() != ''){
          $.ajax({
              data: {_token: CSRF_TOKEN, 'id_subcliente': cliente.val()},
              url:   'contactos_act',
              type:  'post',
              beforeSend: function () {
                subcliente.prop('disabled', true);
              },
              success:  function (data) {
                subcliente.prop('disabled', false);
                comprador.find('option').remove();
                //comprador.append('<option value="">Seleccionar</option>');
                data.forEach(function(v){ 
                  comprador.append('<option value="' + v.id_contacto + '">' + v.nombre_contacto + '</option>');
                });
                comprador.prop('disabled', false);
              },
              error: function() {
                swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
                subcliente.prop('disabled', false);
              }
            });
        }
        else
        {
            comprador.find('option').remove();
            comprador.append('<option value="">Seleccione un subcliente</option>');
            comprador.prop('disabled', true);
        }
    });

  $("#empresa").change(function(){

      	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');        
      	var departamentos = $("#departamentos");
      	var empresa = $(this);

      	if($(this).val() != ''){
          $.ajax({
              data: {_token: CSRF_TOKEN, 'id_emp': empresa.val(), 'tipo': 0},
              url:   'departamentos_act',
              type:  'post',
              beforeSend: function () {
                empresa.prop('disabled', true);
                departamentos.prop('disabled', true);
              },
              success:  function (data) {
                empresa.prop('disabled', false);
                departamentos.find('option').remove();
                departamentos.append('<option value="">Seleccionar</option>');
                data.forEach(function(v){ 
                  departamentos
                      .append($("<option></option>")
                      .attr("value", v.id)
                      .text(v.nombre_dep));
                });
                departamentos.prop('disabled', false);
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
    });

  $("#departamentos").change(function(){
    if(this.value == $("#departamento2").val()){
      swal("Ha ocurrido un problema", "Un departamento no puede ser asignado dos veces en una requisición", "error");
      $(this).val("");
    }
  });

  /*$("#departamento2").change(function(){
    if(this.value == $("#departamento").val()){
      swal("Ha ocurrido un problema", "Un departamento no puede ser asignado dos veces en una requisición", "error");
      $(this).val("");
    }
  });*/

  $("#freq").change(function(){
    if(this.value)
      $("#prioridad").prop('disabled', false);
    else
      $("#prioridad").prop('disabled', true);
  });

  $("#prioridad").change(function(){
      
      if(this.value == 'N'){
        fecha = new Date($("#freq").val());
        fecha.setDate(fecha.getDate() + 6);
        $("#flimite").val(convertDate(fecha));
      }
      else if(this.value == 'I'){
        fecha = new Date($("#freq").val());
        fecha.setDate(fecha.getDate() + 4);
        $("#flimite").val(convertDate(fecha));
      }
      else if(this.value == 'U'){
        fecha = new Date($("#freq").val());
        fecha.setDate(fecha.getDate() + 2);
        $("#flimite").val(convertDate(fecha));
      }
      else
        $("#flimite").prop('disabled', false);
  });

  $('#ncontratacion').blur(function(){
    $("#ncontratacion").val(parseFloat($(this).val()).toFixed(2));
  });

  $('#pbase').blur(function(){
    $("#pbase").val(parseFloat($(this).val()).toFixed(2));
  });

  $('#pbase_dol').blur(function(){
    $("#pbase_dol").val(parseFloat($(this).val()).toFixed(2));
  });

  $("#cpago").change(function(){
    if(this.value == 'M')
      $(".pbase_dol").removeAttr('hidden');
    else
      $(".pbase_dol").attr({'hidden': 'hidden'});
  });


</script>
@endsection