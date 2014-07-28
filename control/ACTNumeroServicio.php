<?php
/**
*@package pXP
*@file gen-ACTNumeroServicio.php
*@author  (jrivera)
*@date 23-07-2014 23:47:15
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTNumeroServicio extends ACTbase{    
			
	function listarNumeroServicio(){
		$this->objParam->defecto('ordenacion','id_numero_servicio');

		$this->objParam->defecto('dir_ordenacion','asc');
		if ($this->objParam->getParametro('id_numero_celular') != '') {
			$this->objParam->addFiltro("numser.id_numero_celular = ". $this->objParam->getParametro('id_numero_celular'));
		}		
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODNumeroServicio','listarNumeroServicio');
		} else{
			$this->objFunc=$this->create('MODNumeroServicio');
			
			$this->res=$this->objFunc->listarNumeroServicio($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarNumeroServicio(){
		$this->objFunc=$this->create('MODNumeroServicio');	
		if($this->objParam->insertar('id_numero_servicio')){
			$this->res=$this->objFunc->insertarNumeroServicio($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarNumeroServicio($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarNumeroServicio(){
			$this->objFunc=$this->create('MODNumeroServicio');	
		$this->res=$this->objFunc->eliminarNumeroServicio($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>