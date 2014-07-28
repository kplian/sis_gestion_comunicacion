<?php
/**
*@package pXP
*@file gen-ACTFuncionarioCelular.php
*@author  (jrivera)
*@date 24-07-2014 00:10:05
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTFuncionarioCelular extends ACTbase{    
			
	function listarFuncionarioCelular(){
		$this->objParam->defecto('ordenacion','id_funcionario_celular');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODFuncionarioCelular','listarFuncionarioCelular');
		} else{
			$this->objFunc=$this->create('MODFuncionarioCelular');
			
			$this->res=$this->objFunc->listarFuncionarioCelular($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarFuncionarioCelular(){
		$this->objFunc=$this->create('MODFuncionarioCelular');	
		if($this->objParam->insertar('id_funcionario_celular')){
			$this->res=$this->objFunc->insertarFuncionarioCelular($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarFuncionarioCelular($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarFuncionarioCelular(){
			$this->objFunc=$this->create('MODFuncionarioCelular');	
		$this->res=$this->objFunc->eliminarFuncionarioCelular($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>