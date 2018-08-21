@extends('layout')

@section('librerias')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Registro de sondeo</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Registro de sondeo</li>
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
                            <label for="empresa" class="col-form-label">Empresa</label>
                                <Select id="empresa" name="empresa" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($empresas as $emp)
                                      <option value="{{$emp->id_empresa}}">{{$emp->nombre_emp}}</option> 
                                    @endforeach
                                </Select>   
                          </div>  

                          <div class="col-lg-3 input-group-sm">
                            <label for="departamento" class="col-form-label">Departamento</label>
                                <Select id="departamento" name="departamento" class="form-control" required disabled>
                                    <option value="">Seleccionar</option>
                                </Select>  
                          </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-3 input-group-sm">
                              <label for="ir" class="col-form-label">Items requeridos</label>
                                <input id="ir" name="ir" type="number" placeholder="Cantidad de Items para el sondeo" class="form-control" min="0" required> 
                            </div>

                            <div class="col-lg-3 input-group-sm">
                                <label for="freq" class="col-form-label">Fecha del sondeo</label>
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
                          <div class="col-lg-6 input-group-sm">
                            <label for="asunto" class="col-form-label">Asunto</label>
                              <input id="asunto" name="asunto" type="text" placeholder="Ingrese el asunto de la sondeo" class="form-control" maxlength="60" required> 
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="pclaves" class="col-form-label">Palabras clave</label>
                                <input id="pclaves" name="pclaves" type="text" placeholder="Ingrese el asunto del sondeo" class="form-control" maxlength="35" required> 
                          </div>

                          

                          <div class="col-lg-3 input-group-sm">
                            <label for="adjuntos" class="col-form-label">Adjuntos</label>
                              <input type="file" class="form-group" id="adjuntos" name="files[]" multiple/>
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

  function convertDate(fecha) {
    function pad(s) { return (s < 10) ? '0' + s : s; }
    var d = new Date(fecha);
    return [d.getFullYear(), pad(d.getMonth()+1), pad(d.getDate())].join('-');
  }

  $(function() { 
    $("input[type='reset']").click();
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

  $("#empresa").change(function(){

      	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');        
      	var departamento = $("#departamento");
        var departamento2 = $("#departamento2");
      	var empresa = $(this);

      	if($(this).val() != ''){
          $.ajax({
              data: {_token: CSRF_TOKEN, 'id_emp': empresa.val(), 'tipo': 0},
              url:   'departamentos_act',
              type:  'post',
              beforeSend: function () {
                empresa.prop('disabled', true);
                departamento.prop('disabled', true);
                departamento2.prop('disabled', true);
              },
              success:  function (data) {
                empresa.prop('disabled', false);
                departamento.find('option').remove();
                departamento2.find('option').remove();
                departamento.append('<option value="">Seleccionar</option>');
                departamento2.append('<option value="">Seleccionar</option>');
                data.forEach(function(v){ 
                  departamento.append('<option value="' + v.id + '">' + v.nombre_dep + '</option>');
                  departamento2.append('<option value="' + v.id + '">' + v.nombre_dep + '</option>');
                });
                departamento.prop('disabled', false);
                departamento2.prop('disabled', false);
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

  $("#departamento").change(function(){
    if(this.value == $("#departamento2").val()){
      swal("Ha ocurrido un problema", "Un departamento no puede ser asignado dos veces en una requisición", "error");
      $(this).val("");
    }
  });

  $("#departamento2").change(function(){
    if(this.value == $("#departamento").val()){
      swal("Ha ocurrido un problema", "Un departamento no puede ser asignado dos veces en una requisición", "error");
      $(this).val("");
    }
  });

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