<?php
/****************************************************************************************
*@package pXP
*@file gen-ACTEquipoHistorico.php
*@author  (ymedina)
*@date 10-05-2021 16:01:12
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                10-05-2021 16:01:12    ymedina             Creacion    
  #
*****************************************************************************************/

class ACTEquipoHistorico extends ACTbase{    
            
    function listarEquipoHistorico(){
		$this->objParam->defecto('ordenacion','id_equipo_historico');

        if($this->objParam->getParametro('id_equipo')!='' && $this->objParam->getParametro('id_funcionario_celular')!=''){
            $this->objParam->addFiltro(" detequ.id_equipo = ".$this->objParam->getParametro('id_equipo')." and 
                                         detequ.id_funcionario_celular = ".$this->objParam->getParametro('id_funcionario_celular')." ");
        }else{
            $this->objParam->addFiltro(" (detequ.id_equipo = 0)");
        }

        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODEquipoHistorico','listarEquipoHistorico');
        } else{
        	$this->objFunc=$this->create('MODEquipoHistorico');
            
        	$this->res=$this->objFunc->listarEquipoHistorico($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarEquipoHistorico(){
        $this->objFunc=$this->create('MODEquipoHistorico');    
        if($this->objParam->insertar('id_equipo_historico')){
            $this->res=$this->objFunc->insertarEquipoHistorico($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarEquipoHistorico($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarEquipoHistorico(){
        	$this->objFunc=$this->create('MODEquipoHistorico');    
        $this->res=$this->objFunc->eliminarEquipoHistorico($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>