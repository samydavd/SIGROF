@php
switch(session('nivel')) {
  case(1):
    $nivel = "Gerente";
    break;

  case(2):
    $nivel = "Analista";
    break;

  case(3):
    $nivel = "Coordinador";
    break;

  default:
    $nivel = "";
}

if($nivel != "")
  $tipo_usuario = $nivel. ' de ' . session('departamento');
else
  $tipo_usuario = "Gerente General de SERSINCA C.A.";

@endphp

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIGROF</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <!-- Bootstrap CSS-->

    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.css')}}"> 
    <!-- Bootstrap Table -->
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="{{asset('css/fontastic.css')}}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="{{asset('css/font_google.css')}}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{asset('css/style.default.dark.css')}}" id="theme-stylesheet"> 
    <!-- alternative stylesheet-->
    <link rel="stylesheet" href="" id="alt-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">

    <script src="{{asset('vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>

    
    @yield('librerias')
    @yield('extra') <!--revisar-->

  </head>
  
  <body class="">
    <div class="body"></div> 
    <div class="body-size">
      <!-- Main Navbar-->
      <header class="header">
        <nav class="navbar">
          <!-- Search Box-->
          <div class="search-box">
            <button class="dismiss"><i class="icon-close"></i></button>
            <form id="searchForm" action="#" role="search">
              <input type="search" placeholder="Palabra o siglas clave" class="form-control">
            </form>
          </div>
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <!-- Navbar Header-->
              <div class="navbar-header"> <!--href="{{route('/')}}"-->
                <!-- Navbar Brand --><a href="javascript:void(0)" id="estilos" class="navbar-brand"> 
                  <div class="brand-text brand-big"><span>SIGROF </span><strong> PLUS</strong></div>
                  <div class="brand-text brand-small"><strong>SP</strong></div></a>
                <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
              </div>
              <!-- Navbar Menu -->
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <!-- Search-->
                <!--li class="nav-item d-flex align-items-center"><a id="search" href="#"><i class="icon-search"></i></a></li-->
                <!-- Notifications-->
                <li id="notificationes" class="nav-item dropdown"> <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell-o"></i><span id="cnotificationes" class="badge bg-red"></span></a>
                    
                    <!--li><a rel="nofollow" href="#" class="dropdown-item"> 
                        <div class="notification">
                          <div class="notification-content"><i class="fa fa-twitter bg-blue"></i>You have 2 followers</div>
                          <div class="notification-time"><small>4 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong>view all notifications                                            </strong></a></li-->
                </li>
                <!-- Messages                        -->
                <li id="messages" class="nav-item dropdown"> <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-envelope-o"></i><span id="calerta" class="badge bg-orange"></span></a>
                </li>
                <!-- Logout    -->
                <!--li class="nav-item"><a href="{{ route('cerrar_sesion')}}" class="nav-link logout">Cerrar Sesión<i class="fa fa-sign-out"></i></a></li-->
                <li class="dropdown"> 
                  <a id="perfil" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle no-padding-right">
                    <span class="avatar-min"><img src="{{asset('img/avatar.png')}}" alt="..." class="img-fluid rounded-circle"></span>
                    <span class="username text-small">{{session('nombre')}}</span>
                    
                  </a>
                  <ul aria-labelledby="perfil" class="dropdown-menu">

                    <li class="eborder-top">
                      <a href="#"><i class="fa fa-user bg-orange"></i>Perfil</a>
                    </li>
                    <li>
                      <a href="#"><i class="fa fa-book bg-blue"></i>Documentación</a>
                    </li>
                    <li>
                      <a href="{{ route('cerrar_sesion')}}" class="nav-link logout"><i class="fa fa-sign-out bg-red"></i>Cerrar Sesión</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <div class="page-content d-flex align-items-stretch navbar-height">
        <!-- Side Navbar -->
        <nav class="side-navbar">
          <!-- Sidebar Header-->
          <!--div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="{{asset('img/avatar.png')}}" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
              <h1 class="h4">{{session('nombre')}}</h1>
              <p>{{ $tipo_usuario }}</p>
            </div>
          </div-->
          <!-- Sidebar Navidation Menus-->
          <ul class="list-unstyled">
              
            <li class="active"> <a href="{{route('/')}}"><i class="icon-home"></i>Inicio</a></li>

            <li><a href="#sondeos" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-pie-chart" style="color:#FD977C"></i>Sondeos </a>
              <ul id="sondeos" class="collapse list-unstyled">
                    <li><a href="{{ route('sondeos_add') }}">+ Nuevo</a></li>
                    <li><a href="{{ route('requerimientos') }}">Listado</a></li>
                    <!--li><a href="#">Tablero</a></li-->
              </ul>
            </li>
              
            <li><a href="#requisiciones" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows" style="color:#C95454"></i>Requisiciones </a>
              <ul id="requisiciones" class="collapse list-unstyled">
                    <li><a href="#nuevas" aria-expanded="false" data-toggle="collapse"><i class="fa folder"></i>+ Nueva</a>
                      <ul id="nuevas" class="collapse">
                        @if(session('acceso')->solicitudes[0])
                        <li><a href="{{ route('requerimientos_add') }}">Solicitud</a></li>
                        @endif
                        @if(session('acceso')->ordenes[0])
                        <li><a href="{{ route('ordenes_new') }}">Orden</a></li>
                        @endif
                      </ul>
                    <!--li><a href="#listado" aria-expanded="false" data-toggle="collapse">Listado</a>
                      <ul id="listado" class="collapse list-unstyled">
                        <li><a href="{{ route('requerimientos') }}" style="padding-left:30%">General</a></li>
                        <li><a href="requerimientos/sol" style="padding-left:30%">Solicitudes</a></li>
                        <li><a href="requerimientos/ord" style="padding-left:30%">Ordenes</a></li>
                        <li><a href="#" style="padding-left:30%">Por Clientes</a></li>
                      </ul-->
                    </li>
                    <li><a href="{{ route('requerimientos') }}">Listado</a></li>
                    @if(session('acceso')->solicitudes[14])
                      <li><a href="{{ route('contrataciones') }}">Contrataciones</a></li>
                    @endif
                    <!--li><a href="#">Tablero</a></li-->
              </ul>
            </li>
            @if(session('acceso')->clientes[0] || session('acceso')->clientes[2] || session('acceso')->clientes[8] || session('acceso')->clientes[10])     
            <li><a href="#cliente" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-address-card-o" style="color:#5D99E6"></i>Clientes </a>
              <ul id="cliente" class="collapse list-unstyled">
                @if(session('acceso')->clientes[0] || session('acceso')->clientes[2])
                <li><a href="#nuevo" aria-expanded="false" data-toggle="collapse"><i class="fa folder"></i>+ Nuevo</a>
                  <ul id="nuevo" class="collapse list-unstyled">
                    @if(session('acceso')->clientes[0])
                    <li><a href="{{ route('clientes_add') }}">Cliente</a></li>
                    @endif
                    @if(session('acceso')->clientes[2])
                    <li><a href="{{ route('subclientes_add') }}">Subcliente</a></li>
                    @endif
                  </ul>
                </li>
                @endif
                @if(session('acceso')->clientes[8] || session('acceso')->clientes[10])
                <li><a href="#administrar" aria-expanded="false" data-toggle="collapse"><i class="fa folder"></i>Administrar</a>
                  <ul id="administrar" class="collapse list-unstyled">
                    @if(session('acceso')->clientes[8])
                    <li><a href="{{ route('clientes') }}">Clientes</a></li>
                    @endif
                    @if(session('acceso')->clientes[10])
                    <li><a href="{{ route('subclientes') }}">Subclientes</a></li>
                    @endif
                  </ul>
                </li>
                @endif
                <!--li><a href="#">Listado</a>
                      <ul id="listado_clientes" class="nav nav-pills nav-stacked span2">
                        <li><a href="#">Clientes</a></li>
                        <li><a href="#">Subclientes</a></li>
                        <li><a href="#">Prospectos</a></li>
                      </ul>
                </li-->
              </ul>
            </li>
            @endif
              
            <li><a href="#reportes" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-bar-chart" style="color:#37BB65"></i>Consultas </a>
              <ul id="reportes" class="collapse list-unstyled">
                <li><a href="#reporte" aria-expanded="false" data-toggle="collapse"><i class="fa folder"></i>Reportes</a>
                  <ul id="reporte" class="collapse list-unstyled">
                    @if(session('acceso')->consultas[0])
                    <li><a href="{{ route('reportes_generales') }}">Por empresa</a></li>
                    @endif
                    @if(session('acceso')->consultas[2])
                    <li><a href="{{ route('reportes_especificos') }}">Por departamento</a></li>
                    @endif
                  </ul>
                </li>
                <!--li><a href= "">Encuestas</a></li>
                <li><a href= "">Estado de buques</a></li-->
                @if(session('acceso')->feriados[4])
                <li><a href= "{{ route('feriados') }}">Feriados</a></li>
                @endif
              </ul>
            </li>
              
            <li><a href="#configuracion" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-wrench" style="color:#D3773B"></i>Configuración </a>
              <ul id="configuracion" class="collapse list-unstyled"> 
                @if(session('acceso')->empresas[4])
                <li><a href= "{{ route('empresas') }}">Empresas</a></li>
                @endif
                @if(session('acceso')->departamentos[4])
                <li><a href= "{{ route('departamentos') }}">Departamentos</a></li>
                @endif
                @if(session('acceso')->usuarios[4])
                <li><a href= "{{ route('usuarios') }}">Usuarios</a></li>
                @endif
                @if(session('nivel') == 9)
                <li><a href= "{{ route('niveles') }}">Niveles de usuario</a></li>
                <li><a href= "{{ route('mapa_acceso') }}">Mapas de Acceso</a></li>
                @endif
              </ul>
            </li>
              
          </ul>
        </nav>

      <div class="content-inner">
        

<!--body style="background-image: url('img/fondo3.jpg'); width: 100; height: 100; "-->
          @yield('contenido')
      </div>
      </div>
    </div>

          <!-- Page Footer-->
          <footer class="main-footer">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-6">
                  <p>SERSINCA C.A. 2018</p>
                </div>
                <div class="col-sm-6 text-right">
                  <p><b>Todos los derechos reservados &copy;</b></p>
                </div>
              </div>
            </div>
          </footer>
        
      
  </body>

  <script src="{{asset('vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
  <script src="{{asset('vendor/jquery-validation/jquery.validate.min.js')}}"></script>
  <script src="{{asset('js/front.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/mensajes.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/notificaciones.js')}}"></script>  

  <script> 
    setTimeout(ajaxRefresh, 1000);

    function ajaxRefresh()
    {
        refrescar_mensajes({{session('id_usuario')}});
        refrescar_notificaciones({{session('id_usuario')}});
        setTimeout(ajaxRefresh, 15000);
    }

    if($.cookie("css")) {
      $("#alt-stylesheet").attr("href", $.cookie("css"));
    }

    $('#estilos').click(function(){

      if($.cookie("css") != -1){
        $('#alt-stylesheet').attr('href', '{{asset('css/style.default.dark.css')}}');
        $.cookie("css", -1);
      }
      else{
        $('#alt-stylesheet').attr('href', '{{asset('css/style.default.light.css')}}');
        $.cookie("css", $('#alt-stylesheet').attr('href'));
      }
//$('#original').click(function (){
   //$('link[href="style2.css"]').attr('href','style1.css');
    });

/*var myVar = setInterval(myTimer, 4000);

function myTimer() {
    var d = new Date();
    document.getElementById("demo").innerHTML = d.toLocaleTimeString();
}*/
  </script>
@yield('librerias_end')
</body>
@yield('script')
</html>