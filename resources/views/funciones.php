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
	
	public function __construct($estado, $dep1, $dep2, $gerente1, $gerente2 = null, $an1d1 = null, $an2d1 = null, $an1d2 = null, $an2d2 = null) {
		$this->estado = $estado;
		$this->dep1 = $dep1;
        $this->dep2 = $dep2;
        $this->gerente1 = $gerente1;
        $this->gerente2 = $gerente2;
        $this->an1d1 = $an1d1;
        $this->an2d1 = $an2d1;
        $this->an1d2 = $an1d2;
        $this->an2d2 = $an2d2;
   	}

	public function estado(array $estados, $comparador = null){
		if(!is_null($comparador)){
			foreach($estados as $es)
				if($this->estado == $es)
					return false;
			return true;
		} else{
			foreach($estados as $es)
				if($this->estado == $es)
					return true;	
			return false;	
		}
	}

	public function asignacion(){
		if(($this->gerente1 == session('id_dep') && !$this->an1d1) || ($this->gerente2 == session('id_dep') && !$this->an1d2))
			return true;
		return false;
	}

	public function tipo_dep(){
		if($this->dep1 == session('id_dep'))
			return true;
		return false;
	}

	public function analistas(){
		if($this->an1d1 == session('id_usuario') || $this->an1d2 == session('id_usuario'))
			return true;
		return false;
	}

	public function permisos_departamento(){

	}
}
@endphp