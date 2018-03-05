<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGROF PLUS</title>

    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/sweetalert.min.js"></script>

    <!-- Google Fonts Enlace Pendiente-->
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'> 

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Other Stylesheet -->
    <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.min.css">  

</head>

<body>
    <div class="body"></div>
    
    @if(session()->has('data'))
        <script type="text/javascript">
            swal("Se ha encontrado un error", "Usuario o contraseña incorrecta. Intente nuevamente.", "error");
        </script>
    @endif
    
    <div class="container">
        <div class="top">
            <!--img src="images/logo.png" width="300" height="100"-->
            <h1 id="title"><span id="logo">SIGROF <span>PLUS</span></span></h1>
        </div>
        <div class="login-box">
            <div class="box-header">
                <h3>LOG IN</h3>
            </div>
            <form method="POST" action="{{ route('validar_sesion')}}">
                {{ csrf_field() }}
                <div class="inputWithIcon inputIconBg">
                    <input type="text" name="usuario" id="usuario" placeholder="Nombre de usuario" required>
                    <i class="glyphicon glyphicon-user" aria-hidden="true"></i>
                </div>
                <div class="inputWithIcon inputIconBg">
                    <input type="password" name="clave" id="clave" placeholder="Contraseña" required>
                    <i class="glyphicon glyphicon-lock" aria-hidden="true"></i>
                </div>
                <button type="submit">Iniciar sesión</button>
            </form>
            <br/>
            <a href="#"><p class="small">Olvide mi contraseña</p></a>
        </div>
    </div>
</body>

<script>
    $(document).ready(function () {
        $('#logo').addClass('animated fadeInDown');
        $("input:text:visible:first").focus();
    });
</script>

</html>