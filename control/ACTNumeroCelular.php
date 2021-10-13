<?php
/**
*@package pXP
*@file gen-ACTNumeroCelular.php
*@author  (jrivera)
*@date 23-07-2014 22:43:16
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/
require_once(dirname(__FILE__).'/../reporte/RDirectorioTelefonico.php');
class ACTNumeroCelular extends ACTbase{    
			
	function listarNumeroCelular(){
		$this->objParam->defecto('ordenacion','id_numero_celular');

		$this->objParam->defecto('dir_ordenacion','asc');
		
		if($this->objParam->getParametro('fecha')!='') {
            $this->objParam->addFiltro(" numcel.id_numero_celular not in (
            								select gfc.id_numero_celular 
            								from gecom.tfuncionario_celular gfc
            								where id_numero_celular = numcel.id_numero_celular and 
											gfc.estado_reg = ''activo'' and 
											gfc.fecha_inicio <= ''".$this->objParam->getParametro('fecha')."'' and 
            									(gfc.fecha_fin is null or gfc.fecha_fin >= ''".$this->objParam->getParametro('fecha')."''))");    
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
    function reporteDirectorioTelefonico(){
        $this->objFunc = $this->create('MODNumeroCelular');
        $this->res = $this->objFunc->reporteDirectorioTelefonico($this->objParam);

        //obtener titulo de reporte
        $titulo = 'Directorio Telefonico ';
        //Genera el nombre del archivo (aleatorio + titulo)
        $nombreArchivo = uniqid(md5(session_id()) . $titulo);

        $nombreArchivo .= '.xls';
        $this->objParam->addParametro('nombre_archivo', $nombreArchivo);
        $this->objParam->addParametro('datos', $this->res->datos);
        //Instancia la clase de excel
        $this->objReporteFormato = new RDirectorioTelefonico($this->objParam);
        $this->objReporteFormato->generarDatos();
        $this->objReporteFormato->generarReporte();

        $this->mensajeExito = new Mensaje();
        $this->mensajeExito->setMensaje('EXITO', 'Reporte.php', 'Reporte generado','Se generó con éxito el reporte: ' . $nombreArchivo, 'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
    }


}

?>