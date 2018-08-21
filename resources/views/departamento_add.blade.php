@extends('layout')

@section('librerias')
<script src="js/sweetalert.min.js"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Registro de departamentos</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('departamentos')}}">Listado de Departamentos</a></li>
        <li class="breadcrumb-item active">Departamento</li>
    </ul>
</div>

@if(session('data') == "success")
  <script type="text/javascript">
     swal("Acción completada", "El departamento ha sido registrado exitosamente", "success");
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
                    <form id="departamento_nuevo" action="{{route('departamentos_add_db')}}" class="col-auto" method="post">
                        {{ csrf_field() }}
                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm">
                            <label for="nombre" class="col-form-label">Nombre</label>
                                <input id="nombre" name="nombre" type="text" placeholder="Ingrese nombre departamento" class="form-control" required>
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="limitebs" class="col-form-label">Siglas</label>
                                <input id="siglas" name="siglas" type="text" placeholder="Ingrese las siglas del departamento" class="form-control" length="3" required>
                          </div>
                      
                          <div class="col-lg-3 input-group-sm">
                            <label for="tipo" class="col-form-label">Tipo</label>
                                <Select id="tipo" name="tipo" class="form-control" required>
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
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="empresa" class="col-form-label">Empresa/Sucursal</label>
                            
                                <Select id="empresa" name="empresa" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($empresas as $emp)
                                      <option value="{{$emp->id_empresa}}">{{$emp->nombre_emp}}</option> 
                                    @endforeach
                                </Select> 
                          </div> 

                        </div>

                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm">
                            <label for="limitebs" class="col-form-label">Limite Bolivares</label>
                                <input id="limitebs" name="limitebs" type="number" placeholder="Ingrese limite de aprobación en Bs." class="form-control" step=".01" pattern="^\d+(?:\.\d{1,2})?$" required disabled>                      
                          </div>
                          <div class="col-lg-3 input-group-sm">
                            <label for="limitedol" class="col-form-label">Limite Dolares</label>
                                <input id="limitedol" name="limitedol" type="number" placeholder="Ingrese limite de aprobación en USD" class="form-control" step=".01" pattern="^\d+(?:\.\d{1,2})?$" required disabled>
                          </div>
                        </div>

                        <input id="id_dep" name="id_dep" type="hidden" value="" />
                        
                        <center style="padding-top: 10px">
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
      $("#id_dep").val(datos.id);
      $("#nombre").val(datos.nombre_dep);
      $("#tipo").val(datos.tipo_dep);
      $("#empresa").val(datos.empresa);
      $("#limitebs").val(datos.limitebs);
      $("#limitedol").val(datos.limitedol);
      $("#limitebs").removeAttr('disabled');
      $("#limitedol").removeAttr('disabled');
      $("input[type='submit']").val("Actualizar");
    }
  });

  $('#tipo').change(function() {
  	if(this.value == 'SE' || this.value == 'SU'){
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

</script>
@endsection