<?php
//app/Helpers/Envato/User.php
namespace App\Http;

use App\Usuario; 
use Illuminate\Support\Facades\DB;
 
class Funciones {
    /**
     * @param int $user_id User-id
     * 
     * @return string
     */
    public static function get_username($user_id) {
       return app_path();
    }

    public function etapa_requerimiento($id_requerimiento){

    }

    public function usuario_gerente($id_usuario){
    	$usu = new Usuario();
    	return $usu->gerente($id_usuario);
    }
}