@extends('layout')

@section('librerias')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Reportes Generales</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Reportes Generales</li>
    </ul>
</div>

@if(session('data') == "success")
  <script type="text/javascript">
     swal("Acción completada", "Los detalles del reporte han sido registrados exitosamente", "success");
     
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
                    <!--div class="card-header">
                      <div class="nav-bar">
                          <ul id="nav-bar">
                            <li id="solicitudes" class="active"><a href="#porintervalo">Por periodo</a></li>
                            <li id="ordenes"><a href="#porfechas">Por intervalo de fechas</a></li>
                          </ul>
                      </div>
                    </div-->
                    <div class="card-body">
                        <form id="departamento_nuevo" target="_blank" action="{{route('reportes_generales_generar')}}" class="col-auto" method="post">
                        {{ csrf_field() }}

                         


                      <!--div class="form-group row" style="padding-right: 10px; padding-bottom: -50px">
                       <fieldset class="scheduler-border col-lg-6" style="margin: 0; padding: 0">
                        <legend class="scheduler-border"><p style="color: #777; font-size: 14px; margin: 0; padding: 0;">Por periodo</p></legend-->
                        
                        <div class="form-group row">
                          <div class="col-lg-4 input-group-sm">
                            <label for="tiempo" class="col-form-label">Intervalo de tiempo</label>
                            <Select id="tiempo" name="tiempo" class="form-control">
                              <option value="">Seleccionar</option>
                              <option value="TR">Trimestral</option> 
                              <option value="FP">Fechas personalizadas</option>
                            </Select>
                          </div>
  
                          <div class="col-lg-4 input-group-sm">
                            <label for="tipo" class="col-form-label">Empresa</label>
                                <select id="empresa" name="empresa" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($empresas as $emp)
                                      <option value="{{$emp->id_empresa}}">{{$emp->nombre_emp}}</option> 
                                    @endforeach
                                </select>
                          </div>

                          <div class="col-lg-4 input-group-sm">
                             <label for="tipo" class="col-form-label">Tipo</label>  
                                <Select id="tipo" name="tipo" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <option value="1">Capacidad de Respuesta</option> 
                                    <option value="2">Aceptación de oferta</option>
                                    <option value="3">Indice de Ventas</option> 
                                </Select>
                          </div>

                        </div>

                        <!--/fieldset>

                       

                        <fieldset class="scheduler-border col-lg-6" style="margin: 0; padding: 0">
                          <legend class="scheduler-border"><p style="color: #777; font-size: 14px; margin: 0; padding: 0">Por intervalo de fechas</p></legend>
                            <div class="form-group row">
                              <div class="col-lg-6 input-group-sm">
                                <label for="tipo" class="col-form-label">Desde</label>
                                  <input type="date" id="desde" name="desde" class="form-control" required/>
                              </div>

                              <div class="col-lg-6 input-group-sm">
                                <label for="tipo" class="col-form-label">Hasta</label>
                                  <input type="date" id="hasta" name="hasta" class="form-control" required/>
                              </div>
                            </div>
                        </fieldset-->
                      <!--/div-->

                        <div class="form-group row">

                            <div id="fdesde" class="col-lg-4 input-group-sm hidden">
                              <label for="desde" class="col-form-label">Desde</label>
                                <input type="date" id="desde" name="desde" class="form-control" required/>
                            </div>

                            <div id="fhasta" class="col-lg-4 input-group-sm hidden">
                              <label for="hasta" class="col-form-label">Hasta</label>
                                <input type="date" id="hasta" name="hasta" class="form-control" required />
                            </div>
                          
                          <div id="trimestral" class="col-lg-4 hidden">
                            <label for="tipo" class="col-form-label">Periodo</label>
                            <div class="input-group input-group-sm">
                              <Select id="periodo" name="periodo" class="form-control">
                                <option value="">Seleccionar trimestre</option>
                                <option value="1">Primer trimestre</option> 
                                <option value="2">Segundo trimestre</option>
                                <option value="3">Tercer trimestre</option>
                                <option value="4">Cuarto trimestre</option>
                              </Select>
                              <div class="input-group-btn input-group-sm">
                                <Select id="anio" name="anio" class="form-control">
                                    <option value="">Año</option>
                                    <option value="2018">2018</option> 
                                </Select>
                              </div>
                            </div>
                          </div>

                        </div>

                        <div id="archivo" class="form-group row hidden">
                            <label for="archivo" class="col-form-label col-lg-2">Archivo</label>  
                        
                        </div>

                        <center style="margin-top: 10px">
                            <input type="submit" value="Generar reporte" class="btn btn-success btn-sm">
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
    
    $("#periodo, #anio").change(function(){
        var periodo = $("#periodo").val();

        if(periodo == 1)
        {
            $("#desde").val($("#anio").val() + "-01-01");
            $("#hasta").val($("#anio").val() + "-03-01");            
        }        
        else if(periodo == 2)
        {
            $("#desde").val($("#anio").val() + "-04-01");
            $("#hasta").val($("#anio").val() + "-06-30");            
        }        
        else if(periodo == 3)
        {
            $("#desde").val($("#anio").val() + "-07-01");
            $("#hasta").val($("#anio").val() + "-09-30");            
        }        
        else if(periodo == 4)
        {
            $("#desde").val($("#anio").val() + "-10-01");
            $("#hasta").val($("#anio").val() + "-12-31");            
        }    
    });

    $("#tiempo").change(function(){
      var tiempo = $(this).val();
      if(tiempo == 'TR'){
        $('#trimestral').removeClass('hidden');
        $('#fdesde').addClass('hidden');
        $('#fhasta').addClass('hidden');
      }
      else if(tiempo == 'FP'){
        $('#trimestral').addClass('hidden');
        $('#fdesde').removeClass('hidden');
        $('#fhasta').removeClass('hidden');
      }
      else{
        $('#trimestral').addClass('hidden');
        $('#fdesde').addClass('hidden');
        $('#fhasta').addClass('hidden');
      }
    });

    $("#desde, #hasta, #empresa, #tipo").change(function(){
     var hasta = $('#hasta').val();
     var desde = $('#desde').val();
     var id_emp = $('#empresa').val();
     var tipo = $('#tipo').val();
     var archivo = $("#archivo");
     if (hasta != '' && desde != '' && id_emp != '' && tipo != ''){

     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
              data: {_token: CSRF_TOKEN, 'desde': desde, 'hasta': hasta, 'id_emp': id_emp, 'tipo': tipo},
              url:   '{{route('archivo_reporte')}}',
              type:  'post',
              beforeSend: function () {
                //empresa.prop('disabled', true);
              },
              success:  function (data) {
                //empresa.prop('disabled', false);
                if(data){
                    archivo.find('a').remove();    
                    archivo.append('<a href="reporte_general/'+data.id_reporte+'" target="_blank">Reporte del '+data.freporte+'</a>');
                    archivo.show();
                }
                else{
                    archivo.find('p').remove(); 
                    archivo.hide();
                }
              },
              error: function() {
                swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
                //empresa.prop('disabled', false);
              }
        });
    }
    else
      archivo.hide();  
    });
</script>
@endsection