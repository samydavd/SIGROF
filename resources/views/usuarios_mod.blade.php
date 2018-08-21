@extends('layout')

@section('librerias')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="js/sweetalert.min.js"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Listado de Usuarios</h2>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('usuarios')}}">Listado de Usuarios</a></li>
        <li class="breadcrumb-item active">Nuevo Usuario</li>
    </ul>
</div>

@if(session('data') == "success")
  <script type="text/javascript">
     swal("Acción completada", "La empresa ha sido registrado exitosamente", "success");
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
                            <label for="nombre" class="col-form-label col-lg-2">Nombre</label>
                            
                                <input id="nombre" name="nombre" type="text" placeholder="Ingrese nombre departamento" class="form-control col-lg-4" required>
                        
                        </div>

                        <div class="form-group row">
                            <label for="nivel" class="col-form-label col-lg-2">Nivel</label>
                            
                                <Select id="nivel" name="nivel" class="form-control col-lg-4" required>
                                    <option value="">Seleccionar</option>
                                    <option value="AD">Administrador</option>
                                    <option value="GG">Gerente General</option>
                                    <option value="GE">Gerente</option>
                                    <option value="CO">Coordinador</option>
                                    <option value="AN">Analista</option>
                                </Select>  
                        </div>

                        <div class="form-group row">
                            <label for="usuario" class="col-form-label col-lg-2">Usuario</label>
                            
                                <input id="usuario" name="usuario" type="text" placeholder="Ingrese nombre de usuario" class="form-control col-lg-4" required>
                        
                        </div>

                        <div class="form-group row">
                            <label for="empresa" class="col-form-label col-lg-2">Empresa</label>
                            
                                <Select id="empresa" name="empresa" class="form-control col-lg-4" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($empresas as $emp)
                                      <option value="{{$emp->id_empresa}}">{{$emp->nombre_emp}}</option> 
                                    @endforeach
                                </Select>  
                        </div>
                        
                        <div class="form-group row">
                            <label for="departamento" class="col-form-label col-lg-2">Departamento</label>
                            
                                <Select id="departamento" name="departamento" class="form-control col-lg-4" required>
                                    <option value="">Seleccionar</option>
                                </Select>  
                        </div>
                        
                        <center>
                            <input type="submit" value="Registrar" class="btn btn-success">
                            <button type="button" class="btn btn-danger">Limpiar Campos</button>
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

  $(function() {
    $('button').click(function(){
      $("#nombre").val("");
      $("#nivel").val("");
      $("#usuario").val("");
      $("#empresa").val("");
      $("#departamento").val("");
      $("#departamento").prop('disabled', true);
    });
    $('button').click();
  });

  $("#departamento").prop('disabled', true);

  $("#empresa").change(function(){

      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');        
      var departamento = $("#departamento");
      var empresa = $(this);

      if($(this).val() != '')
      {
          $.ajax({
              data: {_token: CSRF_TOKEN, 'id_emp': empresa.val()},
              url:   'actualizar',
              type:  'post',
              beforeSend: function () 
              {
                  empresa.prop('disabled', true);
              },
              success:  function (r) 
              {
                  empresa.prop('disabled', false);

                  departamento.find('option').remove();

                  departamento.append('<option value="">Seleccionar</option>');

                  r.forEach(function(v){ // indice, valor
                      departamento.append('<option value="' + v.id + '">' + v.nombre_dep + '</option>');
                  })

                    departamento.prop('disabled', false);
                },
              error: function()
              {
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