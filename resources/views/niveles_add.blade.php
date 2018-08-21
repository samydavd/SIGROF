@extends('layout')

@section('librerias')
<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap-multiselect.css')}}"> 
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap-multiselect.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Registro de niveles</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('niveles')}}">Listado de Niveles</a></li>
        <li class="breadcrumb-item active">Nivel de usuario</li>
    </ul>
</div>

@if(session('data') !== null && session('data') != "error")
  <script type="text/javascript">
      swal("Acción completada", '{{session('data')}}', "success");
      
      //alert(session('data')); //Revisar
  </script>
  @php
  Session('data', null);
  //session::save();  
  @endphp
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
                    <form id="departamento_nuevo" action="{{route('niveles_add_db')}}" class="col-auto" method="post">
                        {{ csrf_field() }}
                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm">
                            <label for="nombre" class="col-form-label">Nombre del nivel</label>
                            
                                <input id="nombre" name="nombre" type="text" placeholder="Ingrese nombre departamento" class="form-control" required>
                          </div>

                        <!--div class="form-group row">
                          <label for="mapa" class="col-form-label-2 col-lg-2">Tipo dep. asociado</label>

                          <Select id="tipo" name="tipo" class="form-control col-lg-4" required>
                            <option value="">Seleccionar</option>
                            <option value="GE">Gerencia</option> 
                            <option value="SE">Servicio</option> 
                            <option value="SU">Suministro</option>
                            <option value="OP">Logistica y transporte</option>
                            <option value="CA">Calidad</option>
                            <option value="ME">Mercadeo</option> 
                            <option value="AD">Administración</option>
                            <option value="AP">Apoyo</option>
                          </Select>
                    </div-->


                        
                          <div class="col-lg-3 input-group-sm">
                            <label for="mapa" class="col-form-label">Mapa de acceso</label>
                              <Select id="mapa" name="mapa" class="form-control" required>
                                <option value="">Seleccionar</option>
                                @foreach($mapas as $map)
                                  <option value="{{$map->id}}"> {{$map->nombre_mapa}} </option>
                                @endforeach
                              </Select>  
                          </div>
                        </div>


                        <input type="hidden" id="id_nivel" name="id_nivel" value="">
                        
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

  var datos = {!! $nivel or 'null' !!};

  $(function() {
    if (datos) {
      $("#nombre").val(datos.nombre_nivel);
      $("#mapa").val(datos.mapa_acceso);
      $("#id_nivel").val(datos.id_nivel)
      $("input[type='submit']").val("Actualizar");
    }
  });

  var expanded = false;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}

$('checkbox').click(function(){
  $('#tipodep').html(' ');
});

</script>
@endsection