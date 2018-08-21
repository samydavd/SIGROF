$('#declinar').click(function(){
    //var host = window.location.host;
    var host = 'localhost:5050/gestionv2/public/';
    var url = 'declinar';
    var id_req = $('#id_requerimiento').val();
    var html= '<form id="fdeclinar" method="post" action="'+host+url+'">'+
                '<div class="form-group form-swal row">'+
                  '<div class="input-group-sm">'+
                    '<label class="text-primary">Declinada por</label>'+
                      '<select id="razon" name="razon" class="form-control col-lg-9 col-sm-9" required>'+
                        '<option value="">Seleccionar</option>'+
                        '<option value="C">Cliente</option>'+
                        '<option value="S">Sersinca</option>'+
                      '</select>'+
                  '</div>'+
                  '<div class="input-group-sm">'+
                    '<label class="text-primary">Comentarios</label>'+
                      '<textarea id="motivo" type="text" placeholder="Indique los detalles de la declinación del requerimiento" class="form-control col-lg-9 col-sm-9" required></textarea>'+
                  '</div>'+
                '</div>'+
                '<input id="id_req" name="id_req" type="hidden" value="'+ id_req +'" />' +
                '<input type="submit" class="btn btn-danger btn-sm margin-right" value="Declinar" />'+
                '<input type="button" onclick="javascript:swal.close();" class="btn btn-dark btn-sm" value="Cancelar" />'+
              '</form>';
    swal({
      title: 'Declinar requerimiento #' + id_req,
      customClass: 'swal-wide-30',
      html: html,
      showConfirmButton: false
    });
});