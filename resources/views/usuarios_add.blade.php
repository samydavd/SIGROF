@extends('layout')

@section('librerias')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Registro de usuarios</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('usuarios')}}">Listado de usuarios</a></li>
        <li class="breadcrumb-item active">Usuario</li>
    </ul>
</div>

@if(session('data') == "success")
  <script type="text/javascript">
     swal("Acción completada", "El usuario ha sido agregado/actualizado exitosamente", "success");
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
                      <p>Ingrese los datos a registrar</p>
                    <form id="departamento_nuevo" action="{{route('usuarios_add_db')}}" class="col-auto" method="post">
                        {{ csrf_field() }}
                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm">
                            <label for="nombre" class="col-form-label">Nombre</label>
                                <input id="nombre" name="nombre" type="text" placeholder="Ingrese nombre departamento" class="form-control" required>
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="nivel" class="col-form-label">Nivel</label>
                                <Select id="nivel" name="nivel" class="form-control" required>
                                  <option value="">Seleccionar</option>
                                    @foreach($niveles as $niv)
                                      <option value="{{$niv->id_nivel}}"> {{$niv->nombre_nivel}} </option>
                                    @endforeach
                                </Select>  
                          </div>
                        
                          <div class="col-lg-3 input-group-sm">
                            <label for="usuario" class="col-form-label">Usuario</label>
                                <input id="usuario" name="usuario" type="text" placeholder="Ingrese nombre de usuario" class="form-control" required>
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="correo" class="col-form-label">Correo electrónico</label>
                                <input id="correo" name="correo" type="text" placeholder="Ingrese correo electrónico" class="form-control" required>
                          </div>
                        
                        </div>

                        <div class="form-group row">

                          <div class="col-lg-3 input-group-sm">
                            <label for="empresa" class="col-form-label">Empresa/sucursal</label>
                            
                                <Select id="empresa" name="empresa" class="form-control" required disabled>
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
                                    @if(isset($departamentos))
                                      @foreach($departamentos as $dep)
                                        <option value="{{$dep->id}}">{{$dep->nombre_dep}}</option> 
                                      @endforeach
                                    @endif
                                </Select>  
                          </div>

                           @if(isset($datos))    
                            <div class="col-lg-3 input-group-sm">
                              <label for="mapa" class="col-form-label">Mapa de acceso</label>
                                <Select id="mapa" name="mapa" class="form-control" required>
                                    @foreach($mapas as $map)
                                      <option value="{{$map->id}}"> {{$map->nombre_mapa}} </option>
                                    @endforeach
                                </Select>  
                            </div>
                          @endif

                        </div>

                        <input id="id_usuario" name="id_usuario" type="hidden" value="" />
                        
                        <center style="margin-top: 10px">
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
  

  $(function() { 
    console.log(datos);
    if (datos) {
      $("#nombre").val(datos.nombre);
      $("#nivel").val(datos.nivel);
      $("#usuario").val(datos.usuario);
      $("#correo").val(datos.correo);
      $("#empresa").val(datos.id_empresa);
      $("#departamento").val(datos.departamento);
      $("#mapa").val(datos.mapa_acceso);
      $("#id_usuario").val(datos.id_usuario);
      $("input[type='submit']").val("Actualizar");
      $('#nivel').change();
      $('#departamento').prop('disabled', false);
    }
  });

  $('#nivel').change(function(){
    var nivel = $(this).val();
    if(nivel != 'GG' && nivel != 'AD'){
      $('#empresa').prop('disabled', false);
    } else {
      $('#departamento').prop('disabled', true);
      $('#empresa').prop('disabled', true);
    }
  });

  $("#empresa").change(function(){

      	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');        
      	var departamento = $("#departamento");
      	var empresa = $(this);

      	if($(this).val() != ''){
          $.ajax({
              data: {_token: CSRF_TOKEN, 'id_emp': empresa.val(), 'tipo': 1},
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
    });

</script>
@endsection