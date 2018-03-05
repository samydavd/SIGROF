<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
	public static function buscar($nombre){
		echo $nombre;
		return 1;
	}
}
