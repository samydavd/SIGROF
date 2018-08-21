    
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="css/fontastic.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="css/font_google.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
      
    <script src="js/jquery-3.2.1.min.js"></script>

    
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="bootstrap/table/bootstrap-table.min.css">

<table id="table" class="table" data-toggle="table" data-show-columns="true">
							<thead>
                          <tr>
                            <th data-sortable="true">ID</th>
                            <th data-sortable="true">Nombre</th>
                            <th data-sortable="true">Tipo de Servicio</th>
                            <th data-sortable="true">Limite de Asignación</th>
                          </tr>
                        </thead>
                        <tbody>
                            
                             @php
                                echo '<tr> <th colspan="4"> Sin departamentos registrados </th></tr>';
                             

                                /*else{
                                    
                                    foreach ($this->_ci_cached_vars as $row){
                                        
                                            if ($row['tipo'] == "1")
                                                $tipo_departamento = "Servicio";
                                            elseif ($row['tipo'] == "2")
                                                $tipo_departamento = "Suministro";
                                            elseif ($row['tipo'] == "3")
                                                $tipo_departamento = "Mercado";
                                            elseif ($row['tipo'] == "4")
                                                $tipo_departamento = "Administración";
                                            elseif ($row['tipo'] == "5")
                                                $tipo_departamento = "N/A";
                                        
                                            if ($row['limitebs'] < '900000000' && $row['limitebs'] != '0') $limite = $row['limitebs'];
                                            elseif ($row['limitebs'] < '2147483646') $limite = 'N/A';
                                            else $limite = 'Indefinido';
                                        
                                            echo '<tr> <td>'.$row['id_departamento'].'</td>';
                                            echo '<td>'.$row['nombre_departamento'].'</td>';
                                            echo '<td>'.$tipo_departamento.'</td>';
                                            echo '<td>'.$limite.'</td></tr>';
                                        }
                    
                                }*/
                            @endphp
							<tr>
                            	<td>1</td>
                            	<td>Comercializacion</td>
                            	<td>Suministro</td>
                            	<td>4000</td>
                          	</tr>
                          	<tr>
                            	<td>2</td>
                            	<td>Comercializacion</td>
                            	<td>Suministro</td>
                            	<td>4000</td>
                          	</tr>
                          	<tr>
                            	<td>3</td>
                            	<td>Comercializacion</td>
                            	<td>Suministro</td>
                            	<td>4000</td>
                          	</tr>
                          	<tr>
                            	<td>4</td>
                            	<td>Comercializacion</td>
                            	<td>Suministro</td>
                            	<td>4000</td>
                          	</tr>

                            
                        </tbody> 

						</table>

<script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/charts-home.js"></script>
    <script src="js/front.js"></script>
    

    <script src="fiddle.js"></script> 
    <script src="bootstrap/table/bootstrap-table.min.js"></script>
    <script src="bootstrap/table/locale/bootstrap-table-es-ES.js"></script>