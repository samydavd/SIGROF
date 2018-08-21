function refrescar_notificaciones(id_usuario){
  //var host = window.location.host;
  var host = 'localhost:5050/gestionv2/public/';
  $.ajax({
    data: {'id_usuario': id_usuario},
    url: 'http://'+host+'/notificaciones',
    type: 'post',
    success: function (data) {
      //console.log(data);
       $('#noti').html(''); // Limpiando bandeja
      if((Object.keys(data)).length != 0){
        $('#notificationes').append('<ul aria-labelledby="notifications" class="dropdown-menu" id="noti"></ul>');
      }
      if(data['nuevos']){
        var link = 'http://'+host+'/requerimientos_nuevos';
        $('#noti').append('<li><a rel="nofollow" href="'+link+'" class="dropdown-item"><div class="notification">'+ 
                             '<div class="notification-content"><i class="fa fa-bell-o fa-lg bg-green">'+
                             '</i>'+data['nuevos']+' Nuevo(s) requerimiento(s) </div> <div class="notification-time">'+
                             '<small>hace unos minutos</small></div> </div></a></li>');
      
      }
      if(data['ordenes_nuevas']){
        var link = 'http://'+host+'/ordenes_nuevas';
        $('#noti').append('<li><a rel="nofollow" href="'+link+'" class="dropdown-item"><div class="notification">'+ 
                             '<div class="notification-content"><i class="fa fa-bell-o fa-lg bg-blue">'+
                             '</i>'+data['ordenes_nuevas']+' Nueva(s) orden(es) de compra </div> <div class="notification-time">'+
                             '<small>hace unos minutos</small></div> </div></a></li>');
      
      }
      if(data['cotizacion']){
        var link = 'http://'+host+'/cotizaciones';
        $('#noti').append('<li><a rel="nofollow" href="'+link+'" class="dropdown-item"><div class="notification">'+ 
                             '<div class="notification-content"><i class="icon-check fa-lg bg-orange">'+
                             '</i>'+data['cotizacion']+' Cotizacion(es) pendiente(s) </div> <div class="notification-time">'+
                             '<small>hace unos minutos</small></div> </div></a></li>');
      }
      if(data['informacion']){
        var link = 'http://'+host+'/solicitud_informacion';
        $('#noti').append('<li><a rel="nofollow" href="'+link+'" class="dropdown-item"><div class="notification">'+ 
                             '<div class="notification-content"><i class="fa fa-question fa-lg bg-orange">'+
                             '</i>'+data['informacion']+' Solicitud(es) en consulta </div> <div class="notification-time">'+
                             '<small>hace unos minutos</small></div> </div></a></li>');
      
      }
      if(data['liberacion']){
        var link = 'http://'+host+'/cotizaciones_liberacion';
        $('#noti').append('<li><a rel="nofollow" href="'+link+'" class="dropdown-item"><div class="notification">'+ 
                             '<div class="notification-content"><i class="icon-check fa-lg bg-orange">'+
                             '</i>'+data['liberacion']+' Cotizacion(es) por liberar </div> <div class="notification-time">'+
                             '<small>hace unos minutos</small></div> </div></a></li>');
      
      }
      if(data['aprobadas']){
        var link = 'http://'+host+'/cotizaciones_aprobadas';
        $('#noti').append('<li><a rel="nofollow" href="'+link+'" class="dropdown-item"><div class="notification">'+ 
                             '<div class="notification-content"><i class="fa fa-check fa-lg bg-green">'+
                             '</i>'+data['aprobadas']+' Cotizacion(es) aprobada(s) </div> <div class="notification-time">'+
                             '<small>hace unos minutos</small></div> </div></a></li>');
      
      }
      if(data['respuesta']){
        var link = 'http://'+host+'/solicitud_respuesta';
        $('#noti').append('<li><a rel="nofollow" href="'+link+'" class="dropdown-item"><div class="notification">'+ 
                             '<div class="notification-content"><i class="fa fa-question fa-lg bg-blue">'+
                             '</i>'+data['respuesta']+' Solicitud(es) con aclaratoria recibida </div> <div class="notification-time">'+
                             '<small>hace unos minutos</small></div> </div></a></li>');
      
      }
      if(data['declinada']){
        var link = 'http://'+host+'/declinadas';
        $('#noti').append('<li><a rel="nofollow" href="'+link+'" class="dropdown-item"><div class="notification">'+ 
                             '<div class="notification-content"><i class="fa fa-times fa-lg bg-red">'+
                             '</i>'+data['declinada']+' Solicitud(es) declinada(s) </div> <div class="notification-time">'+
                             '<small>hace unos minutos</small></div> </div></a></li>');
      
      }
      if(data['por_entregar']){
        var link = 'http://'+host+'/entregas_pendientes';
        $('#noti').append('<li><a rel="nofollow" href="'+link+'" class="dropdown-item"><div class="notification">'+ 
                             '<div class="notification-content"><i class="icon-check fa-lg bg-green">'+
                             '</i>'+data['por_entregar']+' Orden(es) con NDE por entregar </div> <div class="notification-time">'+
                             '<small>hace unos minutos</small></div> </div></a></li>');
      
      }
      if(data['por_facturar']){
        var link = 'http://'+host+'/entregas_facturar';
        $('#noti').append('<li><a rel="nofollow" href="'+link+'" class="dropdown-item"><div class="notification">'+ 
                             '<div class="notification-content"><i class="icon-check fa-lg bg-green">'+
                             '</i>'+data['por_facturar']+' Orden(es) por facturar </div> <div class="notification-time">'+
                             '<small>hace unos minutos</small></div> </div></a></li>');
      
      }
      $('#cnotificationes').html('');
      $('#cnotificationes').append((Object.keys(data)).length);
    },
    error: function() {
      //swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor al refrescar las notificaciones", "error");
    }
  });
}

//'<li><a rel="nofollow" href="#" class="dropdown-item"> <div class="notification"> <div class="notification-content"><i class="fa fa-envelope bg-green"></i>You have 6 new messages </div> <div class="notification-time"><small>4 minutes ago</small></div> </div></a></li>'

