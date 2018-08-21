@extends('layout')

@section('librerias')
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Registro de empresas</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('empresas')}}">Listado de Empresas</a></li>
        <li class="breadcrumb-item active">Empresa</li>
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
                      <form id="departamento_nuevo" action="{{route('empresas_add_db')}}" class="col-auto" method="post">
                        {{ csrf_field() }}

                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm">
                            <label for="nombre" class="col-form-label">Nombre</label>
                                <input id="nombre" name="nombre" type="text" placeholder="Ingrese nombre departamento" class="form-control" required>
                          </div>
                        

                          <div class="col-lg-3 input-group-sm">
                            <label for="tipo" class="col-form-label">Tipo</label>
                                <Select id="tipo" name="tipo" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <option value="0">Sede principal</option> 
                                    <option value="1">Sucursal</option>
                                </Select>  
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="ubicacion" class="col-form-label">Ubicación</label>
                            
                                <input id="ubicacion" name="ubicacion" type="text" placeholder="Ingrese ubicación" class="form-control" required>
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="telefono" class="col-form-label">Teléfono</label>
                            <div class="input-group input-group-sm">
                              <div class="input-group-btn input-group-sm">
                                <Select id="cod" name="cod" class="form-control" required>
                                    <option value=""></option>
                                    <option value="+1">+1</option>
                                    <option value="+58">+58</option> 
                                    <option value="+599">+599</option>    
                                </Select>
                              </div>
                                <input id="telefono" name="telefono" type="text" placeholder="Número de Teléfono" class="form-control" required>
                            </div>
                          </div>
                        </div>

                        <input id="id_empresa" name="id_empresa" type="hidden" value="" />
                        
                        <center style="margin-top:10px">
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
    if (datos) {
      $("#id_empresa").val(datos.id_empresa);
      $("#nombre").val(datos.nombre_emp);
      $("#tipo").val(datos.tipo);
      $("#ubicacion").val(datos.ubicacion);
      $("#empresa").val(datos.id_empresa);
      $("#departamento").val(datos.departamento);
      $("#cod").val(datos.cod_telf);
      $("#telefono").val(datos.telefono);
      $("input[type='submit']").val("Actualizar");
    }
  });

</script>
@endsection