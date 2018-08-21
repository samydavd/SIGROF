<?php

//app/Helpers/Envato/User.php
namespace App\Http;
 
use Illuminate\Support\Facades\DB;
 
class Estados {

	public static function ver_estado_requerimiento($estado)
	{
			if($estado == "SCR")
				$estado = "Nueva";
			else if($estado == "SRG")
				$estado = "Revisada x G.";
			else if($estado == "SAA")
				$estado = "Asignada";
			else if($estado == "SRA")
				$estado = "Revisada x Analista";
			else if($estado == "SEP")
				$estado = "En Proceso";
			else if($estado == "SMI")
				$estado = "Consulta";
			else if($estado == "MIC")
				$$estado = "Consulta Enviada";
			else if($estado == "MIR")
				$estado = "Resp. Recibida";
			else if($estado == "COC")
				$estado = "Cotización Cargada";
			else if($estado == "COA")
				$estado = "Cotización Aprobada";
			else if($estado == "CPA")
				$estado = "Cotización Pre-Aprobada";
			else if($estado == "CPL")
				$estado = "Liberación";
			else if($estado == "CEC")
				$estado = "Enviada al Cliente";
			else if($estado == "SDE")
				$estado = '<span style="color: red;">Declinada</span>';
			else if($estado == "SRE")
				$estado = "Rechazada";
			else if($estado == "SPO")
				$estado = "Aceptada (PO)";
			else if($estado == "OCR")
				$estado = "Orden Nueva";
			else if($estado == "OEP")
				$estado = "En Proceso";
			else if($estado == "NET")
				$estado = "NDE Total";
			else if($estado == "NEP")
				$estado = "NDE Parcial";			
			else if($estado == "ENT")
				$estado = "Entrega Total";
			else if($estado == "ENP")
				$estado = "Entrega Parcial";
			else if($estado == "FAC")
				$estado = "Facturado";
			else if($estado == "FAP")
				$estado = "Fac. Parcial";
			else if($estado == "PAP")
				$estado = "Pago Parcial";
			else if($estado == "PAG")
				$estado = "Pagado";
			else
				$estado = $estado;
			return $estado;
	}
}