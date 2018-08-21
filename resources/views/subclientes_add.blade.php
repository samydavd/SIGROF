@extends('layout')

@section('librerias')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Registro de subcliente</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('subclientes')}}">Listado de Subclientes</a></li>
        <li class="breadcrumb-item active">Nuevo subcliente</li>
    </ul>
</div>

@if(session('data') == "success")
  <script type="text/javascript">
     swal("Acción completada", "El subcliente ha sido registrado exitosamente", "success");
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
                    <form id="departamento_nuevo" action="{{route('subclientes_add_db')}}" class="col-auto" method="post">
                        {{ csrf_field() }}
                        
                        <div class="form-group row">
                          @isset($clientes)
                          <div class="col-lg-3 input-group-sm">
                            <label for="cliente" class="col-form-label">Cliente</label>
                                <select id="cliente" name="cliente" class="form-control" required>
                                  <option value="">Seleccionar</option>
                                  @foreach($clientes as $cl)
                                    <option value="{{$cl->id_cliente}}"> {{$cl->nombre_cliente}} </option>
                                  @endforeach
                                </select>
                          </div>
                          @endif
                          <div class="col-lg-3 input-group-sm">
                            <label for="nombre" class="col-form-label">Nombre</label>
                                <input id="nombre" name="nombre" type="text" placeholder="Ingrese nombre del subcliente" class="form-control" required>
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="telf" class="col-form-label">Teléfono</label>
                                <input id="telf" name="telf" type="text" placeholder="Ingrese teléfono de contacto principal" class="form-control" required>
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="email" class="col-form-label">Email</label>
                                <input id="email" name="email" type="text" placeholder="ejemplo@dominio" class="form-control number-no-spin" min="0" required>
                          </div>
                        </div>

                        <div class="form-group row">

                         <div class="col-lg-3 input-group-sm">
                            <label for="tipo" class="col-form-label">Tipo</label>
                              <select id="tipo" name="tipo" class="form-control" required>
                                <option value="">Seleccionar</option>
                                <option value="1">Buque</option>
                                <option value="2">Plataforma</option>
                                <option value="3">Oficina</option>
                                <option value="4">Otros</option>
                              </select>
                         </div>

                         <div class="col-lg-3 input-group-sm">
                          <label for="encargado" class="col-form-label">Unidad de mercadeo encargada</label>
                              <select id="encargado" name="encargado" class="form-control">
                                  <option value="">Seleccionar</option>
                                  @foreach($mercadeo as $me)
                                    <option value="{{$me->id_usuario}}"> {{$me->nombre}} </option>
                                  @endforeach
                              </select>
                          </div>

                          <div class="col-lg-3 input-group-sm imo hidden">
                            <label for="imo" class="col-form-label">IMO</label>
                                <input id="imo" name="imo" type="text" placeholder="Ingrese codigo internacional IMO" class="form-control" min="0">
                          </div>
                        
                        </div>

                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm">
                            <label for="super" class="col-form-label">Superintendente</label>
                              <select id="super" name="super" class="form-control">
                                  <option value="">Seleccionar</option>
                                  <option value="0">Nuevo</option>
                              </select>
                          </div>

                            <div class="col-lg-3 input-group-sm super hidden">                   
                              <label for="nombre_super" class="col-form-label">Nombre</label>
                                <input id="nombre_super" name="nombre_super" type="text" placeholder="Ingrese nombre del superintendente" class="form-control" min="0">
                            </div>

                            <div class="col-lg-3 input-group-sm super hidden">
                              <label for="telf_super" class="col-form-label">Teléfono</label>
                                <input id="telf_super" name="telf_super" type="text" placeholder="Ingrese telefono del superintendente" class="form-control" min="0">
                            </div>

                            <div class="col-lg-3 input-group-sm super hidden">
                              <label for="email_super" class="col-form-label">Email</label>
                                  <input id="email_super" name="email_super" type="text" placeholder="ejemplo@dominio" class="form-control" min="0">
                            </div>

                      </div>

                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm">
                            <label for="comp" class="col-form-label">Comprador</label>
                              <select id="comp" name="comp" class="form-control" required>
                                  <option value="">Seleccionar</option>
                                  <option value="0">Nuevo</option>
                              </select>
                          </div>

                          <div class="col-lg-3 comprador input-group-sm comprador hidden">
                            <label for="nombre_comp" class="col-form-label">Nombre</label>
                              <input id="nombre_comp" name="nombre_comp" type="text" placeholder="Ingrese nombre del comprador" class="form-control" min="0">
                          </div>

                          <div class="col-lg-3 input-group-sm comprador hidden">
                            <label for="telf_comp" class="col-form-label">Teléfono</label>
                              <input id="telf_comp" name="telf_comp" type="text" placeholder="Ingrese telefono del comprador" class="form-control" min="0">
                          </div>

                          <div class="col-lg-3 input-group-sm comprador hidden">
                            <label for="email_comp" class="col-form-label">Email</label>
                              <input id="email_comp" name="email_comp" type="text" placeholder="ejemplo@dominio" class="form-control" min="0">
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm">
                            <label for="admin" class="col-form-label">Administrador</label>
                              <select id="admin" name="admin" class="form-control">
                                <option value="">Seleccionar</option>
                                <option value="0">Nuevo</option>
                              </select>
                          </div>

                          <div class="col-lg-3 input-group-sm admin hidden">
                            <label for="nombre_admin" class="col-form-label">Nombre</label>
                              <input id="nombre_admin" name="nombre_admin" type="text" placeholder="Ingrese nombre del administrador" class="form-control" min="0" />
                          </div>

                          <div class="col-lg-3 input-group-sm admin hidden">
                            <label for="telf_admin" class="col-form-label">Teléfono</label>
                              <input id="telf_admin" name="telf_admin" type="text" placeholder="Ingrese telefono del administrador" class="form-control" min="0" />
                          </div>

                          <div class="col-lg-3 input-group-sm admin hidden">
                            <label for="email_admin" class="col-form-label">Email</label>
                                <input id="email_admin" name="email_admin" type="text" placeholder="ejemplo@dominio" class="form-control" min="0" />
                          </div>

                        </div>

                        <input id="id_cliente" name="id_cliente" type="hidden" value="" />
                        <input id="id_subcliente" name="id_subcliente" type="hidden" value="" />
                                              
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
  var herencia = <?php if(isset($herencia)) echo true; else echo "null"; ?>;
  var datos = <?php if(isset($datos)) echo $datos; else echo "null"; ?>;
  var datos_sub = <?php if(isset($datos_sub)) echo $datos_sub; else echo "null"; ?>;

  if(datos){
    $('#id_cliente').val(datos['id_cliente']);
  }

  $('#tipo').change(function() {
    if(this.value != 'AP' && this.value != ''){
      $("#limitebs").removeAttr('disabled');
      $("#limitedol").removeAttr('disabled');
    } else{
      $("#limitebs").attr({'disabled': 'disabled'});
      $("#limitedol").attr({'disabled': 'disabled'});
    }
});
  $('#limitebs').blur(function(){
    $("#limitebs").val(parseFloat($(this).val()).toFixed(2));
  });

  $('#limitedol').blur(function(){
    $("#limitedol").val(parseFloat($(this).val()).toFixed(2));
  });

  $(function() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');        
    var cliente = $("#id_cliente");
    var comprador = $('#comp');
    var superintendente = $('#super');
    var administrador = $('#admin');

          $.ajax({
              data: {_token: CSRF_TOKEN, 'id_cliente': cliente.val(), 'tipo': 1},
              url:  '{{route('subclientes_act')}}',
              type: 'post',
              beforeSend: function () {
                comprador.prop('disabled', true);
                superintendente.prop('disabled', true);
                administrador.prop('disabled', true);
              },
              success:  function (data) {
                data.comp.forEach(function(v){ 
                  comprador.append('<option value="' + v.id_contacto + '">' + v.nombre_contacto + '</option>');
                });
                data.super.forEach(function(v){ 
                  superintendente.append('<option value="' + v.id_contacto + '">' + v.nombre_contacto + '</option>');
                });
                data.admin.forEach(function(v){ 
                  administrador.append('<option value="' + v.id_contacto + '">' + v.nombre_contacto + '</option>');
                });

                comprador.prop('disabled', false);
                superintendente.prop('disabled', false);
                administrador.prop('disabled', false);
                cargar_datos();
              },
              error: function() {
                swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
                comprador.prop('disabled', false);
                superintendente.prop('disabled', false);
                administrador.prop('disabled', false);
              }
            });
    
  });

  function cargar_datos(){
    if (herencia) {
      $("#nombre").val(datos.nombre_cliente);
    } else if(datos_sub){
      $("#id_subcliente").val(datos_sub.id_subcliente);
      $("#nombre").val(datos_sub.nombre_sub);
      $("#email").val(datos_sub.email_sub);
      $("#telf").val(datos_sub.telf_sub);
      $("#tipo").val(datos_sub.tipo);
      $("#encargado").val(datos_sub.encargados);
      $("#super").val(datos_sub.super);
      $("#comp").val(datos_sub.comp);
      $("#admin").val(datos_sub.admin);
      $("#imo").val(datos_sub.imo);
      $('#tipo').change();
      $("input[type='submit']").val("Actualizar");
      $("h3").html("Actualizar subcliente de " + datos.nombre_cliente);
      $(".breadcrumb-item.active").html("Actualizar subcliente");
    }
  }

  $('#tipo').change(function(){
    if($('#tipo').val() == 1)
      $('.imo').removeClass('hidden');
    else
      $('.imo').addClass('hidden');
  });



  $('#super').change(function(){
    if($('#super').val() == "0")
      $('.super').removeClass('hidden');
    else
      $('.super').addClass('hidden');
  });

  $('#comp').change(function(){
    if($('#comp').val() == "0")
      $('.comprador').removeClass('hidden');
    else
      $('.comprador').addClass('hidden');
  });


  $('#admin').change(function(){
    if($('#admin').val() == "0")
      $('.admin').removeClass('hidden');
    else
      $('.admin').addClass('hidden');
  });

</script>
@endsection