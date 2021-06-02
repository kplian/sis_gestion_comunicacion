<?php
/**
*@package pXP
*@file gen-ACTServicio.php
*@author  (jrivera)
*@date 23-07-2014 22:43:19
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTServicio extends ACTbase{    
			
	function listarServicio(){
		$this->objParam->defecto('ordenacion','id_servicio');

		$this->objParam->defecto('dir_ordenacion','asc');
		if ($this->objParam->getParametro('id_proveedor') != '') {
			$this->objParam->addFiltro("ser.id_proveedor = ". $this->objParam->getParametro('id_proveedor'));
		}

        if ($this->objParam->getParametro('tipo_servi') != '') {
            $this->objParam->addFiltro("ser.tipo_servicio = ''". $this->objParam->getParametro('tipo_servi')."'' ");
        }

        if ($this->objParam->getParametro('id_proveedor') != '') {
            $this->objParam->addFiltro("ser.id_proveedor = ". $this->objParam->getParametro('id_proveedor')." ");
        }

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODServicio','listarServicio');
		} else{
			$this->objFunc=$this->create('MODServicio');
			
			$this->res=$this->objFunc->listarServicio($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarServicio(){
		$this->objFunc=$this->create('MODServicio');	
		if($this->objParam->insertar('id_servicio')){
			$this->res=$this->objFunc->insertarServicio($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarServicio($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarServicio(){
			$this->objFunc=$this->create('MODServicio');	
		$this->res=$this->objFunc->eliminarServicio($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>