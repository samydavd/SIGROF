function ver_estado_requerimiento(estado)
{
			if(estado == "SCR")
				var estado = "Nueva";
			else if(estado == "SRG")
				var estado = "Revisada x G.";
			else if(estado == "SAA")
				var estado = "Asignada";
			else if(estado == "SRA")
				var estado = "Revisada x Analista";
			else if(estado == "SEP")
				var estado = "En Proceso";
			else if(estado == "SMI")
				var estado = "Consulta";
			else if(estado == "MIC")
				var estado = "Consulta Enviada";
			else if(estado == "MIR")
				var estado = "Resp. Recibida";
			else if(estado == "COC")
				var estado = "Cotización Cargada";
			else if(estado == "COA")
				var estado = "Cotización Aprobada";
			else if(estado == "CPA")
				var estado = "Cotización Pre-Aprobada";
			else if(estado == "CPL")
				var estado = "Liberación";
			else if(estado == "CEC")
				var estado = "Enviada al Cliente";
			else if(estado == "SDE")
				var estado = '<span style="color: red;">Declinada</span>';
			else if(estado == "SRE")
				var estado = "Rechazada";
			else if(estado == "SPO")
				var estado = "Aceptada (PO)";
			else if(estado == "OCR")
				var estado = "Orden Nueva";
			else if(estado == "OEP")
				var estado = "En Proceso";
			else if(estado == "NET")
				var estado = "NDE Total";
			else if(estado == "NEP")
				var estado = "NDE Parcial";			
			else if(estado == "ENT")
				var estado = "Entrega Total";
			else if(estado == "ENP")
				var estado = "Entrega Parcial";
			else if(estado == "FAC")
				var estado = "Facturado";
			else if(estado == "FAP")
				var estado = "Fac. Parcial";
			else if(estado == "PAP")
				var estado = "Pago Parcial";
			else if(estado == "PAG")
				var estado = "Pagado";
			else
				var estado = estado;
			return estado;
}