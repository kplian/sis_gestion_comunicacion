<?php
/****************************************************************************************
*@package pXP
*@file gen-ACTNumeroCelularHistorico.php
*@author  (ymedina)
*@date 12-05-2021 12:47:30
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                12-05-2021 12:47:30    ymedina             Creacion    
  #
*****************************************************************************************/

class ACTNumeroCelularHistorico extends ACTbase{    
            
    function listarNumeroCelularHistorico(){
		$this->objParam->defecto('ordenacion','id_numero_celular_his');

        if($this->objParam->getParametro('id_numero_celular')!=''){
            $this->objParam->addFiltro(" (hnum.id_numero_celular = ".$this->objParam->getParametro('id_numero_celular')." )");
        }

        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODNumeroCelularHistorico','listarNumeroCelularHistorico');
        } else{
        	$this->objFunc=$this->create('MODNumeroCelularHistorico');
            
        	$this->res=$this->objFunc->listarNumeroCelularHistorico($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarNumeroCelularHistorico(){
        $this->objFunc=$this->create('MODNumeroCelularHistorico');    
        if($this->objParam->insertar('id_numero_celular_his')){
            $this->res=$this->objFunc->insertarNumeroCelularHistorico($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarNumeroCelularHistorico($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarNumeroCelularHistorico(){
        	$this->objFunc=$this->create('MODNumeroCelularHistorico');    
        $this->res=$this->objFunc->eliminarNumeroCelularHistorico($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>