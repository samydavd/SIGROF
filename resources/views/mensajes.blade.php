<script>
function refrescar_mensajes(id_usuario){
	var CSRF_TOKEN = '{{csrf_field()}}';
	$.ajax({
            data: {_token: CSRF_TOKEN, 'id_usuario': id_usuario},
            url: "{{route('alertas')}}",
            type: 'post',
            success: function (data) {
              console.log(data);
              /*swal(
                "Resultado:", 
                "Solicitud para mas información ha sido enviada exitosamente", 
                "success"
              ).then(function(){location.reload();});*/
            },
            error: function() {
              swal("Ha ocurrido un problema", "Ha ocurrido un error en el servidor al refrescar las alertas", "error");
            }
          });
}
</script>