<?php
/**
*@package pXP
*@file gen-ACTPagoTelefonia.php
*@author  (breydi.vasquez)
*@date 24-11-2020 16:26:24
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTPagoTelefonia extends ACTbase{

	function listarPagoTelefonia(){
		$this->objParam->defecto('ordenacion','id_pago_telefonia');

		$this->objParam->defecto('dir_ordenacion','asc');

		$this->objParam->getParametro('id_gestion') != '' && $this->objParam->addFiltro("pagtel.id_gestion = ".$this->objParam->getParametro('id_gestion')."");

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPagoTelefonia','listarPagoTelefonia');
		} else{
			$this->objFunc=$this->create('MODPagoTelefonia');

			$this->res=$this->objFunc->listarPagoTelefonia($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function insertarPagoTelefonia(){
		$this->objFunc=$this->create('MODPagoTelefonia');
		if($this->objParam->insertar('id_pago_telefonia')){
			$this->res=$this->objFunc->insertarPagoTelefonia($this->objParam);
		} else{
			$this->res=$this->objFunc->modificarPagoTelefonia($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function eliminarPagoTelefonia(){
		$this->objFunc=$this->create('MODPagoTelefonia');
		$this->res=$this->objFunc->eliminarPagoTelefonia($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function listarPlantillaArchivoExcel(){
			$this->objParam->defecto('ordenacion','id_plantilla_archivo_excel');

			$this->objParam->defecto('dir_ordenacion','asc');

			$this->objParam->getParametro('archivoPagTel') == 'GPAGTELF' && $this->objParam->addFiltro(" arxls.codigo in(''GPAGTELF'') ");

			$this->objFunc=$this->create('sis_parametros/MODPlantillaArchivoExcel');
			$this->res=$this->objFunc->listarPlantillaArchivoExcel($this->objParam);
			$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function calculoPagoTelefonia() {
		$this->objFunc=$this->create('MODPagoTelefonia');
		$this->res=$this->objFunc->calculoPagoTelefonia($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

}

?>
