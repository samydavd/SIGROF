function refrescar_mensajes(id_usuario){
        if (window.location.host == 'localhost:5050/gestionv2/')
          var host = 'localhost:5050/gestionv2/public/';
        else
          var host = window.location.host;
        $.ajax({
            data: {'id_usuario': id_usuario},
            url: 'http://'+host+'/alertas',
            type: 'post',
            success: function (data) {
              if(data){
                $('#alertas').html('');
                $('#messages').append('<ul aria-labelledby="notifications" class="dropdown-menu" id="alertas"></ul>');
                data.forEach(function(v){
                  if(v.tipo == 'S')
                    var link = 'http://'+host+'/solicitudes_detalles/'+v.requerimiento;
                  else
                    var link = 'http://'+host+'/ordenes_detalles/'+v.requerimiento;
                  $('#alertas').append('<li><a rel="nofollow" href="'+link+'" class="dropdown-item d-flex"><div class="msg-profile"><div class="avatar-min"> <img src="img/avatar.png" alt="..." class="img-fluid rounded-circle"></div></div>'+
                                        '<div class="msg-body">'+
                                        '<h3 class="h5">'+ v.nombre_emisor +'</h3><span>Escribió un mensaje</span>'+
                                        '</div></a></li>');
                });
                $('#calerta').html('');
                $('#calerta').append(data.length);
              }
            },
            error: function() {
              //swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor al refrescar las alertas", "error");
            }
        });
    }