<?php
/****************************************************************************************
*@package pXP
*@file gen-ACTAccesorio.php
*@author  (ymedina)
*@date 29-05-2021 16:19:41
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                29-05-2021 16:19:41    ymedina             Creacion    
  #
*****************************************************************************************/

class ACTAccesorio extends ACTbase{    
            
    function listarAccesorio(){
		$this->objParam->defecto('ordenacion','id_accesorio');

        if($this->objParam->getParametro('id_equipo')!=''){
            $this->objParam->addFiltro(" acc.id_equipo = ".$this->objParam->getParametro('id_equipo'));
        }

        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODAccesorio','listarAccesorio');
        } else{
        	$this->objFunc=$this->create('MODAccesorio');
            
        	$this->res=$this->objFunc->listarAccesorio($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarAccesorio(){
        $this->objFunc=$this->create('MODAccesorio');    
        if($this->objParam->insertar('id_accesorio')){
            $this->res=$this->objFunc->insertarAccesorio($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarAccesorio($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarAccesorio(){
        	$this->objFunc=$this->create('MODAccesorio');    
        $this->res=$this->objFunc->eliminarAccesorio($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>