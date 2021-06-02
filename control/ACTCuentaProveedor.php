<?php
/****************************************************************************************
*@package pXP
*@file gen-ACTCuentaProveedor.php
*@author  (ymedina)
*@date 12-05-2021 08:13:06
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                12-05-2021 08:13:06    ymedina             Creacion    
  #
*****************************************************************************************/

class ACTCuentaProveedor extends ACTbase{    
            
    function listarCuentaProveedor(){
		$this->objParam->defecto('ordenacion','id_cuenta');

        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODCuentaProveedor','listarCuentaProveedor');
        } else{
        	$this->objFunc=$this->create('MODCuentaProveedor');
            
        	$this->res=$this->objFunc->listarCuentaProveedor($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarCuentaProveedor(){
        $this->objFunc=$this->create('MODCuentaProveedor');    
        if($this->objParam->insertar('id_cuenta')){
            $this->res=$this->objFunc->insertarCuentaProveedor($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarCuentaProveedor($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarCuentaProveedor(){
        	$this->objFunc=$this->create('MODCuentaProveedor');    
        $this->res=$this->objFunc->eliminarCuentaProveedor($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>