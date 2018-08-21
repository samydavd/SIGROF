@extends('layout')

@section('librerias')
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Registrar feriado</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('feriados')}}">Listado de feriados</a></li>
        <li class="breadcrumb-item active">Nuevo feriado</li>
    </ul>
</div>

@if(session('data') == "success")
  <script type="text/javascript">
     swal("Acción completada", "El feriado ha sido registrado exitosamente", "success");
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
                    <form id="feriado_nuevo" action="{{route('feriados_add_db')}}" class="col-auto" method="post">
                        {{ csrf_field() }}
                        
                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm">
                            <label for="fecha" class="col-form-label">Fecha</label>
                                <input id="fecha" name="fecha" type="date" placeholder="Ingrese dirección sede principal del cliente" class="form-control" required>
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="repeticion" class="col-form-label">Repetición</label>
                                <Select id="repeticion" name="repeticion" class="form-control">
                                    <option value="" >Seleccionar</option>
                                    <option value="0">Sin repetición</option> 
                                    <option value="1">Repetir anualmente</option>
                                </Select>
                          </div>

                          <div class="col-lg-6 input-group-sm">
                            <label for="descripcion" class="col-form-label">Descripcion</label>
                                <input id="descripcion" name="descripcion" type="text" placeholder="Ingrese la conmemoracion del dia" class="form-control" required>
                          </div>

                        </div>

                        <input id="id_feriado" name="id_feriado" type="hidden" value="" />
                                              
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

  $(function() { 
    if (datos) {
      $("#id_feriado").val(datos.id_feriado);
      $("#descripcion").val(datos.descripcion);
      $("#fecha").val(datos.fecha);
      $("#repeticion").val(datos.repeticion);
      $("input[type='submit']").val("Actualizar");
    }
    else
      $("input[type='reset']").click();
  });

</script>
@endsection