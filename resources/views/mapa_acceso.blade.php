@extends('layout')

@section('librerias')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Mapas de Acceso</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Mapas de Acceso</li>
    </ul>
</div>

@if(session('data') == "success")
  <script type="text/javascript">
     swal("Acción completada", "El mapa de acceso ha sido creado exitosamente", "success");
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
                    <form id="mapas" action="{{route('mapa_acceso_add_db')}}" class="col-auto" method="post">
                        {{ csrf_field() }}

                        <div class="nav-bar form-control disabled">
                          <ul id="nav-bar">
                            <li id="solicitudes"><a href="javascript:void(0)" disabled>Solicitudes</a></li>
                            <li id="ordenes"><a href="javascript:void(0)">Ordenes</a></li>
                            <li id="nde"><a href="javascript:void(0)">NDE</a></li>
                            <li id="facturacion"><a href="javascript:void(0)">Facturación</a></li>
                            <li id="clientes"><a href="javascript:void(0)">Clientes</a></li>
                            <li id="empresas"><a href="javascript:void(0)">Empresas</a></li>
                            <li id="departamentos"><a href="javascript:void(0)">Departamentos</a></li>
                            <li id="usuarios"><a href="javascript:void(0)">Usuarios</a></li>
                            <li id="feriados"><a href="javascript:void(0)">Feriados</a></li>
                            <li id="consultas"><a href="javascript:void(0)">Reportes</a></li>
                            <li id="mostrar" style="width: 20px"><a href="javascript:void(0)"><i title="Mostrar todo" class="fa fa-plus"></i></a></li>
                          </ul>
                        </div>

                        <div class="form-group row">

                          <div class="col-lg-3 input-group-sm">
                            <label for="mapa_acceso" class="col-form-label ">Mapa de Acceso</label>
                              <Select id="mapa_acceso" name="mapa_acceso" class="form-control" required>
                                <option value=''>Seleccionar</option>
                                  @forelse($mapas as $map)
                                    <option value={{$map->id}}> {{$map->nombre_mapa}} </option>
                                  @empty
                                    <option value="">Sin mapas de acceso registrados</option>
                                  @endforelse
                                    <option value='0'>Agregar nuevo</option>
                              </Select> 
                          </div>


                        <span class="col-lg-3 custom"> 
                          <button id="enviar" type="submit" class="btn btn-outline-success btn-sm disabled"> <i class="fa fa-save"></i></button>
                          <button id="borrar" type="reset" class="btn btn-outline-warning btn-sm disabled"> <i class="fa fa-eraser"></i></button>
                          <button id="eliminar" type="button" class="btn btn-outline-danger btn-sm disabled"> <i class="fa fa-times-circle"></i></button>
                        </span>


                        <div class="col-lg-3 input-group-sm hidden">  
                          <label for="mapa_acceso" class="col-form-label">Nombre del mapa</label>
                            <input id="nombre" name="nombre" type="text" placeholder="Ingrese nombre del mapa de acceso" class="form-control">
                        </div>
        
                        <div class="espacio"></div>

                      </div>

                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <div id="box">

                        <fieldset class="scheduler-border solicitudes">
                          <legend class="scheduler-border text-primary">SOLICITUDES</legend>
                            <div id="sol" name="sol" class="control-group text-center-legend">
                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="sol0" id="sol0" autocomplete="off" default="off"/>
                                      <div class="btn-group btn-group-text">
                                          <label for="sol0" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="sol0" class="btn-md" >
                                            Registrar solicitud
                                          </label>
                                      </div>

                                      <input type="checkbox" name="sol1" id="sol1" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="sol1" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="sol1" class="btn-md">
                                              Asignar solicitud
                                          </label>
                                      </div>
                                  </div>

                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="sol2" id="sol2" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="sol2" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="sol2" class="btn-md" >
                                            Cargar cotización
                                          </label>
                                      </div>

                                      <input type="checkbox" name="sol3" id="sol3" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="sol3" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="sol3" class="btn-md">
                                              Aprobar cotización
                                          </label>
                                      </div>
                                  </div>
                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="sol4" id="sol4" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="sol4" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="sol4" class="btn-md">
                                              Enviar cotización
                                          </label>
                                      </div>

                                      <input type="checkbox" name="sol5" id="sol5" autocomplete="off"/>
                                      <div class="btn-group btn-group-text-2">
                                          <label for="sol5" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="sol5" class="btn-md">
                                              Solicitar más información
                                          </label>
                                      </div>
                                  </div>

                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="sol6" id="sol6" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="sol6" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="sol6" class="btn-md" title="Registrar respuesta de solicitud de más información">
                                            Resp. más información
                                          </label>
                                      </div>

                                      <input type="checkbox" name="sol7" id="sol7" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="sol7" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="sol7" class="btn-md">
                                            Visualizar contrataciones  
                                          </label>
                                      </div>
                                  </div>
                                  
                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="sol8" id="sol8" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="sol8" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="sol8" class="btn-md" >
                                            Col. en Proceso
                                          </label>
                                      </div>

                                      <input type="checkbox" name="sol9" id="sol9" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="sol9" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="sol9" class="btn-md">
                                              Declinar solicitud
                                          </label>
                                      </div>
                                  </div>


                                </div>
                        </fieldset>

                        <fieldset class="scheduler-border ordenes">
                          <legend class="scheduler-border text-primary">ORDENES</legend>
                            <div id="ord" name="ord" class="control-group text-center-legend">
                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="ord0" id="ord0" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="ord0" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="ord0" class="btn-md" >
                                            Registrar orden
                                          </label>
                                      </div>

                                      <input type="checkbox" name="ord1" id="ord1" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="ord1" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="ord1" class="btn-md">
                                              Procesar orden
                                          </label>
                                      </div>
                                  </div>

                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="ord2" id="ord2" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="ord2" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="ord2" class="btn-md">
                                              Cerrar una orden
                                          </label>
                                      </div>

                                      <input type="checkbox" name="ord3" id="ord3" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="ord3" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="ord3" class="btn-md">
                                              Declinar orden
                                          </label>
                                      </div>
                                  </div>
                                </div>
                        </fieldset>

                        <fieldset class="scheduler-border nde">
                          <legend class="scheduler-border text-primary">NOTAS DE ENTREGAS</legend>
                            <div class="control-group text-center-legend">
                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="nde0" id="nde0" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="nde0" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="nde0" class="btn-md" >
                                            Agregar NDE
                                          </label>
                                      </div>

                                      <input type="checkbox" name="nde1" id="nde1" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="nde1" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="nde1" class="btn-md">
                                              Marcar entregado
                                          </label>
                                      </div>
                                  </div>
                        </fieldset>

        
                        <!--div class="form-group-fieldset"></div-->

                        <fieldset class="scheduler-border facturacion">
                          <legend class="scheduler-border text-primary">FACTURACIÓN</legend>
                            <div class="control-group text-center-legend">
                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="fac0" id="fac0" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="fac0" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="fac0" class="btn-md">
                                            Agregar factura
                                          </label>
                                      </div>

                                      <input type="checkbox" name="fac1" id="fac1" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="fac1" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="fac1" class="btn-md">
                                            Agregar pago 
                                          </label>
                                      </div>
                                  </div>
                        </fieldset>

                      <!--div class="form-group row-2"-->
                        
                        <fieldset class="scheduler-border clientes">
                          <legend class="scheduler-border text-primary">CLIENTES</legend>
                            <div class="control-group text-center-legend">
                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="clt0" id="clt0" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="clt0" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="clt0" class="btn-md" >
                                            Registrar cliente
                                          </label>
                                      </div>

                                      <input type="checkbox" name="clt1" id="clt1" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="clt1" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="clt1" class="btn-md">
                                              Registrar subcliente
                                          </label>
                                      </div>
                                  </div>

                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="clt2" id="clt2" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="clt2" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="clt2" class="btn-md" >
                                            Modificar cliente
                                          </label>
                                      </div>

                                      <input type="checkbox" name="clt3" id="clt3" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="clt3" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="clt3" class="btn-md">
                                              Modificar subcliente
                                          </label>
                                      </div>
                                  </div>

                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="clt4" id="clt4" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="clt4" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="clt4" class="btn-md" >
                                            Visualizar clientes
                                          </label>
                                      </div>

                                      <input type="checkbox" name="clt5" id="clt5" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="clt5" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="clt5" class="btn-md">
                                              Visualizar subclientes
                                          </label>
                                      </div>
                                  </div>
                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="clt6" id="clt6" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="clt6" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="clt6" class="btn-md">
                                            Eliminar cliente
                                          </label>
                                      </div>

                                      <input type="checkbox" name="clt7" id="clt7" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="clt7" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="clt7" class="btn-md">
                                              Eliminar subcliente
                                          </label>
                                      </div>
                                  </div>
                                </div>
                        </fieldset>

                        <!--div class="form-group-fieldset"></div-->

                        <fieldset class="scheduler-border empresas">
                          <legend class="scheduler-border text-primary">EMPRESAS</legend>
                            <div class="control-group text-center-legend">
                                  
                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="emp0" id="emp0" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="emp0" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="emp0" class="btn-md" >
                                            Registrar empresa
                                          </label>
                                      </div>

                                      <input type="checkbox" name="emp1" id="emp1" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="emp1" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="emp1" class="btn-md">
                                              Modificar empresa
                                          </label>
                                      </div>
                                  </div>

                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="emp2" id="emp2" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="emp2" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="emp2" class="btn-md" >
                                            Visualizar empresas
                                          </label>
                                      </div>

                                      <input type="checkbox" name="emp3" id="emp3" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="emp3" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="emp3" class="btn-md">
                                              Eliminar empresa
                                          </label>
                                      </div>
                                  </div>
                        </fieldset>

                      <!--div class="form-group row-2"-->
  
                      <fieldset class="scheduler-border departamentos">                       
                          <legend class="scheduler-border text-primary">DEPARTAMENTOS</legend>
                            <div class="control-group text-center-legend">
                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="dep0" id="dep0" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="dep0" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="dep0" class="btn-md" >
                                            Reg. departamento
                                          </label>
                                      </div>

                                      <input type="checkbox" name="dep1" id="dep1" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="dep1" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="dep1" class="btn-md">
                                              Modificar departamento
                                          </label>
                                      </div>
                                  </div>

                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="dep2" id="dep2" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="dep2" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="dep2" class="btn-md" >
                                            Ver departamentos
                                          </label>
                                      </div>

                                      <input type="checkbox" name="dep3" id="dep3" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="dep3" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="dep3" class="btn-md">
                                              Eliminar departamento
                                          </label>
                                      </div>
                                  </div>
                          
                        </fieldset>

                        <!--div class="form-group-fieldset"></div-->

                        <fieldset class="scheduler-border usuarios">
                          <legend class="scheduler-border text-primary">USUARIOS</legend>
                            <div class="control-group text-center-legend">
                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="usu0" id="usu0" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="usu0" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="usu0" class="btn-md" >
                                            Registrar usuario
                                          </label>
                                      </div>

                                      <input type="checkbox" name="usu1" id="usu1" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="usu1" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="usu1" class="btn-md">
                                              Modificar usuario
                                          </label>
                                      </div>
                                  </div>

                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="usu2" id="usu2" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="usu2" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="usu2" class="btn-md" >
                                            Visualizar usuarios
                                          </label>
                                      </div>

                                      <input type="checkbox" name="usu3" id="usu3" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="usu3" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="usu3" class="btn-md">
                                              Eliminar usuario
                                          </label>
                                      </div>
                                  </div>
                        </fieldset>

                      <fieldset class="scheduler-border feriados">
                          <legend class="scheduler-border text-primary">FERIADOS</legend>
                            <div class="control-group text-center-legend">
                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="fer0" id="fer0" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="fer0" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="fer0" class="btn-md" >
                                            Registrar feriado
                                          </label>
                                      </div>

                                      <input type="checkbox" name="fer1" id="fer1" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="fer1" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="fer1" class="btn-md">
                                              Modificar feriado
                                          </label>
                                      </div>
                                  </div>

                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="fer2" id="fer2" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="fer2" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="fer2" class="btn-md" >
                                            Visualizar feriados
                                          </label>
                                      </div>

                                      <input type="checkbox" name="fer3" id="fer3" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="fer3" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="fer3" class="btn-md">
                                              Eliminar feriado
                                          </label>
                                      </div>
                                  </div>
                        </fieldset>

                        <!--div class="form-group-fieldset"></div-->

                        <fieldset class="scheduler-border consultas">
                          <legend class="scheduler-border text-primary">REPORTES</legend>
                            <div class="control-group text-center-legend">
                                  <div class="form-group col-lg-auto">
                                      <input type="checkbox" name="con0" id="con0" autocomplete="off" />
                                      <div class="btn-group btn-group-text">
                                          <label for="con0" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                         </label>
                                          <label for="con0" class="btn-md" >
                                            Reportes empresas
                                          </label>
                                      </div>

                                      <input type="checkbox" name="con1" id="con1" autocomplete="off" />
                                      <div class="btn-group btn-group-text-2">
                                          <label for="con1" class="btn-ms btn-info">
                                              <span class="fa fa-check"></span>
                                              <span> </span>
                                          </label>
                                          <label for="con1" class="btn-md">
                                              Reportes departamentos
                                          </label>
                                      </div>
                                  </div>
                        </fieldset>
                </div>

@endsection

@section('script')
<script type="text/javascript">

  var box=0;
  var id=0;

  function permisos(data){
    var registros = {'sol': data.solicitudes.split(";"), 
                     'ord': data.ordenes.split(";"),
                     'nde': data.nde.split(";"),
                     'fac': data.facturacion.split(";"),
                     'clt': data.clientes.split(";"),
                     'emp': data.empresas.split(";"),
                     'dep': data.departamentos.split(";"),
                     'usu': data.usuarios.split(";"),
                     'fer': data.feriados.split(";"),
                     'con': data.consultas.split(";")};

    for(rg in registros){
      $.each(registros[rg], function(v,i) {

          if((i == 1 && !$('#' + rg + v).is(':checked')) || (i == 0 && $('#' + rg + v).is(':checked'))){
            $('#' + rg + v).click();
          }
      });
    }
  }

  function reordenar(elem){

    $('.' + elem).toggle();
  
    if($('.' + elem).is(":visible")){
      $('#' + elem).addClass('active');
      
      if(box % 2 === 0 || box === 0){
        $("#mapas").append('<div value='+ box +' id="box' + box +'" class="form-group row-2"></div>');
        $("#box" + box).append($("." + elem));

      } else {
        $("#box" + (box-1)).append('<div value='+ box +' id="box' + box +'" class="form-group-fieldset"></div>');
        $("#box" + (box-1)).append($("." + elem));
      }
      $("." + elem).attr('value', box);
      box++;
    }

    else {
      var id_box = $('.' + elem).parent().attr('value');
      var index = parseInt($('.' + elem).attr('value'));
      box--;

      $('#' + elem).removeClass('active');
      $('#box').append($('.' + elem));
      
      if((index % 2) != 0)
        $('#box' + index).remove();

      for(var i=index; i<box; i++){
        $('fieldset[value="'+ (i+1) +'"]').attr('value', i);

            if((i % 2) != 0){
              $('#box' + (i-1)).append('<div value='+ i +' id="box' + i +'" class="form-group-fieldset"></div>');
              $('#box' + (i-1)).append($('fieldset[value='+ i +']'));
            }
            else
              $('#box' + (i+1)).remove();
      }
      if((box%2)!=0){
        $('#box' + (box+1)).remove();
      } 
    }
  }

  function limpiar(){
    var modulos = ['solicitudes', 'ordenes', 'nde', 'facturacion', 'clientes', 'empresas', 'departamentos', 'usuarios', 'feriados', 'consultas'];
    for(md in modulos){
      if($('#' + modulos[md]).hasClass('active'))
        $('#' + modulos[md]).removeClass('active');
      if($('.' + modulos[md]).is(":visible")){
        $("#box").append($('.' + modulos[md]));
        $('.' + modulos[md]).hide();
      }
    } 
    for(var i=0; i<=box; i+=2){
      $('#box'+i).remove();
    }
    box=0;
  }

  function mostrar_todo(){
    var modulos = ['solicitudes', 'ordenes', 'nde', 'facturacion', 'clientes', 'empresas', 'departamentos', 'usuarios', 'feriados', 'consultas'];
    for(md in modulos){
      if(!$('#' + modulos[md]).hasClass('active'))
        $('#' + modulos[md]).addClass('active');
      if(!$('.' + modulos[md]).is(":visible")){
        //alert(modulos[md]);
        reordenar(modulos[md]);
        //$("#box").remove($('.' + modulos[md]));
      }
    } 
   // for(var i=0; i<=box; i+=2){
      //$('#box'+i).remove();
   // }
    box=9;
  }

  function mostrar_menos(){
    var modulos = ['solicitudes', 'ordenes', 'nde', 'facturacion', 'clientes', 'empresas', 'departamentos', 'usuarios', 'feriados', 'consultas'];
    for(md in modulos){
      if($('#' + modulos[md]).hasClass('active'))
        $('#' + modulos[md]).removeClass('active');
      if($('.' + modulos[md]).is(":visible")){
        $("#box").append($('.' + modulos[md]));
        $('.' + modulos[md]).hide();
      }
    } 
    for(var i=0; i<=box; i+=2){
      $('#box'+i).remove();
    }
    box=0;
  }

  function inicial(){
    $('.nav-bar').prop('disabled', false);
    $('.nav-bar').removeClass('disabled');
    $('#enviar').removeClass('disabled');
    $('#borrar').removeClass('disabled');
    limpiar();
    reordenar('solicitudes');
  }

  $('#borrar').click(function(){
    $(".hidden").hide(100);
    $('.nav-bar').prop('disabled', true);
    $('.nav-bar').addClass('disabled');
    $('#enviar').addClass('disabled');
    $('#borrar').addClass('disabled');
    $('#eliminar').addClass('disabled');
    limpiar();
  });

    $('#mostrar').click(function(){
      if($('#mostrar').hasClass('active')){
        $('#mostrar').removeClass('active');
        $('#mostrar a i').attr("class", "fa fa-plus");
        $('#mostrar a i').attr("title", "Mostrar todo");
        limpiar();
      }
      else{
        $('#mostrar').addClass('active');
        $('#mostrar a i').attr("class", "fa fa-minus");
        $('#mostrar a i').attr("title", "Mostrar menos");
        mostrar_todo();
      }
    });
    

    $('#eliminar').click(function(){
      var mapa = $('#mapa_acceso');
      swal({
      title: "¿Esta seguro?",
      text: "Eliminar el mapa " + mapa.text(),
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ok'
      }).then((result) => {
        if (result.value) {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
          $.ajax({
            data: {_token: CSRF_TOKEN, 'id_mapa': mapa.val()},
            url:   'mapas_elm',
            type:  'post',
            success: function(data){
              //mapa.find(mapa.val()).remove();
              swal("Acción completada", "El mapa de acceso " + mapa + " ha sido eliminado con exito", "success");
            },
            error: function() {
                swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
              }
          });
        }       
      });
      /*$("#nombre").val("");
      $("#nombre").hide(100);
      $("#n_acceso").hide(100);
      $("#mapa_acceso").val("");
      $('.nav-bar').prop('disabled', true);
      $('.nav-bar').addClass('disabled');
      $('#enviar').addClass('disabled');
      $('#borrar').addClass('disabled');
      $('#eliminar').addClass('disabled');
      limpiar();*/
    });

  $('#solicitudes').click(function(){
    reordenar('solicitudes');
  });

  $('#ordenes').click(function(){  
    reordenar('ordenes');
  });

  $('#nde').click(function(){
    reordenar('nde');
  });

  $('#facturacion').click(function(){
    reordenar('facturacion');
  });

  $('#empresas').click(function(){
    reordenar('empresas');
  });

  $('#clientes').click(function(){
    reordenar('clientes');
  });

  $('#departamentos').click(function(){
    reordenar('departamentos');
  });

  $('#usuarios').click(function(){
    reordenar('usuarios');
  });

  $('#feriados').click(function(){
    reordenar('feriados');
  });

  $('#consultas').click(function(){
    reordenar('consultas');
  });

  $('#mapa_acceso').change(function (){

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');        
    var acceso = $("#mapa_acceso");

    if($(this).val() != '' && $(this).val() != '0') {
      $.ajax({
        data: {_token: CSRF_TOKEN, 'mapa': acceso.val()},
        method: 'post',
        url: 'mapas_act',
        beforeSend: function () {
          acceso.prop('disabled', true);
        },
        success: function (data) {   
            //id = data.mapa[id];
            //alert($('#mapa_acceso').html());
            acceso.prop('disabled', false);      
            //$("#id_mapa").val(id);
            $('#eliminar').removeClass('disabled');
            permisos(data.mapa);
            inicial();
        },
        error: function(){
          swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor", "error");
          usuario.prop('disabled', false);
        }
      });
    } else if($(this).val() == "0"){
      //$('#borrar').click();
      inicial();
      $(".hidden").show(150);
      //$("#mapa_acceso").val("0");
    }
    else {
        $('#borrar').click();
    }
  });

</script>
@endsection