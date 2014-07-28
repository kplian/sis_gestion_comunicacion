<?php
/**
*@package pXP
*@file gen-ACTNumeroCelular.php
*@author  (jrivera)
*@date 23-07-2014 22:43:16
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTNumeroCelular extends ACTbase{    
			
	function listarNumeroCelular(){
		$this->objParam->defecto('ordenacion','id_numero_celular');

		$this->objParam->defecto('dir_ordenacion','asc');
		
		if($this->objParam->getParametro('fecha')!='') {
            $this->objParam->addFiltro(" id_numero_celular not in (
            								select id_numero_celular 
            								from gecom.tfuncionario_celular
            								where id_numero_celular = numcel.id_numero_celular and 
            									estado_reg = ''activo'' and 
            									fecha_inicio <= ''".$this->objParam->getParametro('fecha')."'' and 
            									(fecha_fin is null or fecha_fin >= ''".$this->objParam->getParametro('fecha')."''))");    
        }
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODNumeroCelular','listarNumeroCelular');
		} else{
			$this->objFunc=$this->create('MODNumeroCelular');
			
			$this->res=$this->objFunc->listarNumeroCelular($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarNumeroCelular(){
		$this->objFunc=$this->create('MODNumeroCelular');	
		if($this->objParam->insertar('id_numero_celular')){
			$this->res=$this->objFunc->insertarNumeroCelular($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarNumeroCelular($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarNumeroCelular(){
			$this->objFunc=$this->create('MODNumeroCelular');	
		$this->res=$this->objFunc->eliminarNumeroCelular($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>