@extends('layout')

@section('librerias')
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@endsection

@section('contenido')
<header class="page-header">
    <div class="container-fluid">
        <h3 class="no-margin-bottom">Registrar cliente</h3>
    </div>
</header>

<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('clientes')}}">Listado de clientes</a></li>
        <li class="breadcrumb-item active">Nuevo Cliente</li>
    </ul>
</div>

@if(session('data') == "success")
  <script type="text/javascript">
     swal("Acción completada", "El cliente ha sido actualizado exitosamente", "success");
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
                    <form id="departamento_nuevo" action="{{route('clientes_add_db')}}" class="col-auto" method="post">
                        {{ csrf_field() }}

                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm">
                            <label for="nombre" class="col-form-label">Razón social</label>
                                <input id="nombre" name="nombre" type="text" placeholder="Ingrese nombre del cliente" class="form-control input-sm" required>
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="direccion" class="col-form-label">Dirección</label>
                                <input id="direccion" name="direccion" type="text" placeholder="Ingrese dirección sede principal del cliente" class="form-control" required>
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="t_rif" class="col-form-label">RIF</label>
                            <div class="input-group input-group-sm">
                              <div class="input-group-btn input-group-sm">
                                <Select id="t_rif" name="t_rif" class="form-control">
                                    <option value="" >Tipo</option>
                                    <option value="J">J</option>
                                    <option value="G">G</option> 
                                    <option value="V">V</option>    
                                </Select>
                              </div>
                              <input id="rif" name="rif" type="number" placeholder="Ingrese RIF del cliente (si aplica)" class="form-control number-no-spin" min="0">
                            </div>
                          </div>

                          <div class="col-lg-3 input-group-sm">
                             <label for="pais" class="col-form-label">País</label>
                                <select id="pais" name="pais" class="form-control" required>
                                  <option value="">Seleccionar</option><option value="Venezuela">Venezuela</option><option value="Afganistán">Afganistán</option><option value="Islas Gland">Islas Gland</option><option value="Albania">Albania</option><option value="Alemania">Alemania</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Anguilla">Anguilla</option><option value="Antártida">Antártida</option><option value="Antigua y Barbuda">Antigua y Barbuda</option><option value="Antillas Holandesas">Antillas Holandesas</option><option value="Arabia Saudí">Arabia Saudí</option><option value="Argelia">Argelia</option><option value="Argentina">Argentina</option><option value="Armenia">Armenia</option><option value="Aruba">Aruba</option><option value="Australia">Australia</option><option value="Austria">Austria</option><option value="Azerbaiyán">Azerbaiyán</option><option value="Bahamas">Bahamas</option><option value="Bahréin">Bahréin</option><option value="Bangladesh">Bangladesh</option><option value="Barbados">Barbados</option><option value="Bielorrusia">Bielorrusia</option><option value="Bélgica">Bélgica</option><option value="Belice">Belice</option><option value="Benin">Benin</option><option value="Bermudas">Bermudas</option><option value="Bhután">Bhután</option><option value="Bolivia">Bolivia</option><option value="Bosnia y Herzegovina">Bosnia y Herzegovina</option><option value="Botsuana">Botsuana</option><option value="Isla Bouvet">Isla Bouvet</option><option value="Brasil">Brasil</option><option value="Brunéi">Brunéi</option><option value="Bulgaria">Bulgaria</option><option value="Burkina Faso">Burkina Faso</option><option value="Burundi">Burundi</option><option value="Cabo Verde">Cabo Verde</option><option value="Islas Caimán">Islas Caimán</option><option value="Camboya">Camboya</option><option value="Camerún">Camerún</option><option value="Canadá">Canadá</option><option value="República Centroafricana">República Centroafricana</option><option value="Chad">Chad</option><option value="República Checa">República Checa</option><option value="Chile">Chile</option><option value="China">China</option><option value="Chipre">Chipre</option><option value="Isla de Navidad">Isla de Navidad</option><option value="Ciudad del Vaticano">Ciudad del Vaticano</option><option value="Islas Cocos">Islas Cocos</option><option value="Colombia">Colombia</option><option value="Comoras">Comoras</option><option value="República Democrática del Congo">República Democrática del Congo</option><option value="Congo">Congo</option><option value="Islas Cook">Islas Cook</option><option value="Corea del Norte">Corea del Norte</option><option value="Corea del Sur">Corea del Sur</option><option value="Costa de Marfil">Costa de Marfil</option><option value="Costa Rica">Costa Rica</option><option value="Croacia">Croacia</option><option value="Cuba">Cuba</option><option value="Dinamarca">Dinamarca</option><option value="Dominica">Dominica</option><option value="República Dominicana">República Dominicana</option><option value="Ecuador">Ecuador</option><option value="Egipto">Egipto</option><option value="El Salvador">El Salvador</option><option value="Emiratos Árabes Unidos">Emiratos Árabes Unidos</option><option value="Eritrea">Eritrea</option><option value="Eslovaquia">Eslovaquia</option><option value="Eslovenia">Eslovenia</option><option value="España">España</option><option value="Estados Unidos">Estados Unidos</option><option value="Estonia">Estonia</option><option value="Etiopía">Etiopía</option><option value="Islas Feroe">Islas Feroe</option><option value="Filipinas">Filipinas</option><option value="Finlandia">Finlandia</option><option value="Fiyi">Fiyi</option><option value="Francia">Francia</option><option value="Gabón">Gabón</option><option value="Gambia">Gambia</option><option value="Georgia">Georgia</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Granada">Granada</option><option value="Grecia">Grecia</option><option value="Groenlandia">Groenlandia</option><option value="Guadalupe">Guadalupe</option><option value="Guam">Guam</option><option value="Guatemala">Guatemala</option><option value="Guayana Francesa">Guayana Francesa</option><option value="Guinea">Guinea</option><option value="Guinea Ecuatorial">Guinea Ecuatorial</option><option value="Guinea-Bissau">Guinea-Bissau</option><option value="Guyana">Guyana</option><option value="Haití">Haití</option><option value="Islas Heard y McDonald">Islas Heard y McDonald</option><option value="Honduras">Honduras</option><option value="Hong Kong">Hong Kong</option><option value="Hungría">Hungría</option><option value="India">India</option><option value="Indonesia">Indonesia</option><option value="Irán">Irán</option><option value="Iraq">Iraq</option><option value="Irlanda">Irlanda</option><option value="Islandia">Islandia</option><option value="Israel">Israel</option><option value="Italia">Italia</option><option value="Jamaica">Jamaica</option><option value="Japón">Japón</option><option value="Jordania">Jordania</option><option value="Kazajstán">Kazajstán</option><option value="Kenia">Kenia</option><option value="Kirguistán">Kirguistán</option><option value="Kiribati">Kiribati</option><option value="Kuwait">Kuwait</option><option value="Laos">Laos</option><option value="Lesotho">Lesotho</option><option value="Letonia">Letonia</option><option value="Líbano">Líbano</option><option value="Liberia">Liberia</option><option value="Libia">Libia</option><option value="Liechtenstein">Liechtenstein</option><option value="Lituania">Lituania</option><option value="Luxemburgo">Luxemburgo</option><option value="Macao">Macao</option><option value="ARY Macedonia">ARY Macedonia</option><option value="Madagascar">Madagascar</option><option value="Malasia">Malasia</option><option value="Malawi">Malawi</option><option value="Maldivas">Maldivas</option><option value="Malí">Malí</option><option value="Malta">Malta</option><option value="Islas Malvinas">Islas Malvinas</option><option value="Islas Marianas del Norte">Islas Marianas del Norte</option><option value="Marruecos">Marruecos</option><option value="Islas Marshall">Islas Marshall</option><option value="Martinica">Martinica</option><option value="Mauricio">Mauricio</option><option value="Mauritania">Mauritania</option><option value="Mayotte">Mayotte</option><option value="México">México</option><option value="Micronesia">Micronesia</option><option value="Moldavia">Moldavia</option><option value="Mónaco">Mónaco</option><option value="Mongolia">Mongolia</option><option value="Montserrat">Montserrat</option><option value="Mozambique">Mozambique</option><option value="Myanmar">Myanmar</option><option value="Namibia">Namibia</option><option value="Nauru">Nauru</option><option value="Nepal">Nepal</option><option value="Nicaragua">Nicaragua</option><option value="Níger">Níger</option><option value="Nigeria">Nigeria</option><option value="Niue">Niue</option><option value="Isla Norfolk">Isla Norfolk</option><option value="Noruega">Noruega</option><option value="Nueva Caledonia">Nueva Caledonia</option><option value="Nueva Zelanda">Nueva Zelanda</option><option value="Omán">Omán</option><option value="Países Bajos">Países Bajos</option><option value="Pakistán">Pakistán</option><option value="Palau">Palau</option><option value="Palestina">Palestina</option><option value="Panamá">Panamá</option><option value="Papúa Nueva Guinea">Papúa Nueva Guinea</option><option value="Paraguay">Paraguay</option><option value="Perú">Perú</option><option value="Islas Pitcairn">Islas Pitcairn</option><option value="Polinesia Francesa">Polinesia Francesa</option><option value="Polonia">Polonia</option><option value="Portugal">Portugal</option><option value="Puerto Rico">Puerto Rico</option><option value="Qatar">Qatar</option><option value="Reino Unido">Reino Unido</option><option value="Reunión">Reunión</option><option value="Ruanda">Ruanda</option><option value="Rumania">Rumania</option><option value="Rusia">Rusia</option><option value="Sahara Occidental">Sahara Occidental</option><option value="Islas Salomón">Islas Salomón</option><option value="Samoa">Samoa</option><option value="Samoa Americana">Samoa Americana</option><option value="San Cristóbal y Nevis">San Cristóbal y Nevis</option><option value="San Marino">San Marino</option><option value="San Pedro y Miquelón">San Pedro y Miquelón</option><option value="San Vicente y las Granadinas">San Vicente y las Granadinas</option><option value="Santa Helena">Santa Helena</option><option value="Santa Lucía">Santa Lucía</option><option value="Santo Tomé y Príncipe">Santo Tomé y Príncipe</option><option value="Senegal">Senegal</option><option value="Serbia y Montenegro">Serbia y Montenegro</option><option value="Seychelles">Seychelles</option><option value="Sierra Leona">Sierra Leona</option><option value="Singapur">Singapur</option><option value="Siria">Siria</option><option value="Somalia">Somalia</option><option value="Sri Lanka">Sri Lanka</option><option value="Suazilandia">Suazilandia</option><option value="Sudáfrica">Sudáfrica</option><option value="Sudán">Sudán</option><option value="Suecia">Suecia</option><option value="Suiza">Suiza</option><option value="Surinam">Surinam</option><option value="Svalbard y Jan Mayen">Svalbard y Jan Mayen</option><option value="Tailandia">Tailandia</option><option value="Taiwán">Taiwán</option><option value="Tanzania">Tanzania</option><option value="Tayikistán">Tayikistán</option><option value="Timor Oriental">Timor Oriental</option><option value="Togo">Togo</option><option value="Tokelau">Tokelau</option><option value="Tonga">Tonga</option><option value="Trinidad y Tobago">Trinidad y Tobago</option><option value="Túnez">Túnez</option><option value="Islas Turcas y Caicos">Islas Turcas y Caicos</option><option value="Turkmenistán">Turkmenistán</option><option value="Turquía">Turquía</option><option value="Tuvalu">Tuvalu</option><option value="Ucrania">Ucrania</option><option value="Uganda">Uganda</option><option value="Uruguay">Uruguay</option><option value="Uzbekistán">Uzbekistán</option><option value="Vanuatu">Vanuatu</option><option value="Vietnam">Vietnam</option><option value="Islas Vírgenes Británicas">Islas Vírgenes Británicas</option><option value="Wallis y Futuna">Wallis y Futuna</option><option value="Yemen">Yemen</option><option value="Yibuti">Yibuti</option><option value="Zambia">Zambia</option><option value="Zimbabue">Zimbabue</option>                  
                                </select>
                          </div>
                        
                        </div>

                        <div class="form-group row">
                          <div class="col-lg-3 input-group-sm">
                            <label for="huso" class="col-form-label">Horario</label>
                            
                                <select id="huso" name="huso" class="form-control" required>
                                  <option value="">Seleccionar</option>
                                @php ($timezone_identifiers = DateTimeZone::listIdentifiers())                              
                                    @foreach($timezone_identifiers as $tz)
                                      <option>{{$tz}}</option>
                                    @endforeach                                
                                </select>  
                          </div>

                          <div class="col-lg-3 input-group-sm">
                            <label for="medio" class="col-form-label">Medio</label>
                            
                                <select id="medio" name="medio" class="form-control" required>
                                  <option value="">Seleccionar</option>
                                  <option value="1">Publicidad</option>
                                  <option value="2">Referencia de Cliente</option>
                                  <option value="3">Google</option>
                                  <option value="4">Página Web</option>
                                  <option value="5">Redes Sociales</option>
                                  <option value="6">Personal</option>
                                  <option value="7">Otro</option> 
                                </select>
                          </div>

                            @if(!isset($datos))
                            <div class="col-lg-3 input-group-sm">
                              <label for="herencia" class="col-form-label">Heredar a subcliente</label>
                               <select id="herencia" name="herencia" class="form-control" required>
                                <option value="">Seleccionar</option>
                                <option value="S">Si</option>
                                <option value="N">No</option>
                              </select>
                            </div>
                            @endif

                          <div class="col-lg-3 input-group-sm">
                            <label for="detalles" class="col-form-label">Detalles</label>
                              <textarea id="detalles" name="detalles" placeholder="Ingrese detalles adicionales acerca del cliente" class="form-control"></textarea>
                          </div>
                        </div>

                        <input id="id_cliente" name="id_cliente" type="hidden" value="" />
                                              
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
      $datos = datos.rif.split('-');
      $("#id_cliente").val(datos.id_cliente);
      $("#nombre").val(datos.nombre_cliente);
      $("#direccion").val(datos.direccion);
      $("#t_rif").val($datos[0]);
      $("#rif").val($datos[1]);
      $("#pais").val(datos.pais);
      $("#huso").val(datos.huso);
      $("#medio").val(datos.medio);
      $("#detalles").val(datos.detalles);
      $("#rif").keyup();
      $("input[type='submit']").val("Actualizar");
    }
  });

  $("#rif").keyup(function(){
    if(this.value != ''){
      $('#t_rif').attr({'required': 'required'});
    }
    else
      $("#t_rif").removeAttr('required');
  });

  $("#t_rif").change(function(){
    if(this.value != ''){
      $('#rif').attr({'required': 'required'});
    }
    else
      $("#rif").removeAttr('required');
  });

</script>
@endsection