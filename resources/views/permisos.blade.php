@php
class permisos {

	private $estado;
	private $dep1;
    private $dep2;
    private $gerente1;
    private $gerente2;
    private $an1d1;
    private $an2d1;
    private $an1d2;
    private $an2d2;
	
	public function __construct($estado, $dep1, $dep2, $gerente1, $gerente2, $analistas) {
		foreach($analistas as $an){
			if($an->id_dep == $dep1){
      			if($an->tipo == 'P')
        			$an1d1 = $an->id_analista;
      			else
        			$an2d1 = $an->id_analista;
        	}
    		else if (isset($dep2)){
      			if($an->id_dep = $dep2)
        			if($an->tipo == 'P')
          				$an1d2 = $an->id_analista;
        			else
          				$an2d2 = $an->id_analista;
      		} 
		}

		$this->estado = $estado;
		$this->dep1 = $dep1;
        $this->dep2 = $dep2;
        $this->gerente1 = $gerente1;
        $this->gerente2 = $gerente2;
        $this->an1d1 = isset($an1d1)? $an1d1 : null;
        $this->an2d1 = isset($an2d1)? $an2d1 : null;
        $this->an1d2 = isset($an1d2)? $an1d2 : null;
        $this->an2d2 = isset($an2d2)? $an2d2 : null;
   	}

	public function estado(array $estados, $comparador = null){
		if(is_null($comparador)){ // Compara que estado actual == estado(s) indicado(s)
			foreach($estados as $es)
				if($this->estado == $es)
					return true;	
			return false;
		} else{					  // Compara que estado actual != estado(s) indicado(s)
			foreach($estados as $es)
				if($this->estado == $es) 
					return false;
			return true;		
		}
	}

	public function asignacion(){
		if((($this->gerente1 == session('id_usuario') && $this->an1d1 == null) || ($this->gerente2 == session('id_usuario') && $this->an1d2 == null)) && session('acceso')->solicitudes[2])
			return true;
		return false;
	}

	public function tipo_dep(){
		if($this->dep1 == session('id_dep'))
			return true;
		return false;
	}

	public function analistas($id = null){
		if($id)
			if(($this->an1d1 == session('id_usuario') || $this->an1d2 == session('id_usuario') || $this->an1d2 == session('id_usuario') || $this->an2d2 == session('id_usuario')) && session('acceso')->solicitudes[$id])
					return true;
		else
			if($this->an1d1 == session('id_usuario') || $this->an1d2 == session('id_usuario') || $this->an1d2 == session('id_usuario') || $this->an2d2 == session('id_usuario'))
					return true;
		return false;
	}

	public function gerente(){
		if($this->gerente1 == session('id_usuario') && session('acceso')->solicitudes[6])
			return 1;
		else if($this->gerente2 == session('id_usuario') && session('acceso')->solicitudes[6])
			return 2;
		else 
			return 0;
	}

	public function almacen(){
		if(session('nivel') == 'CA')
			return 1;
		return 0;
	}

	public function pertenece_departamento($dep){
		if($dep == 1)
			return 1;
		return 0;
	}

	public function mercadeo(){
		if(session('tipo_dep') == 'ME')
			return 1;
		else 
			return 0;
	}

	public function nde_por_facturar($ndes){
		foreach ($ndes as $nd)
			if($nd->factura == null && $nd->fentrega != null)
				return true;
		return false;
	}

	public function registrar_nde($ndes){
		foreach ($ndes as $nd)
			if($nd->tipo == 'T')
				return false;
		return true;
	}

	public function administracion(){
		if(session('tipo_dep') == 'AD')
			return 1;
		else 
			return 0;
	}
}
@endphp