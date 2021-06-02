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

        if($this->objParam->getParametro('disponibles')!='') {
            if($this->objParam->getParametro('disponibles')=='SI'){
                $this->objParam->addFiltro(" numcel.estado = ''activo'' ");
            }
        }

        if ($this->objParam->getParametro('tipo_servi') != '') {
            $this->objParam->addFiltro("s.tipo_servicio = ''". $this->objParam->getParametro('tipo_servi')."'' ");
        }

        if ($this->objParam->getParametro('funcionario_gerencia') != '') {
            $this->objParam->addFiltro("  exists
                                          (WITH RECURSIVE subordinates AS (
                                                  SELECT
                                                      eu.id_uo_hijo,
                                                      eu.id_uo_padre, 
                                                      u.codigo,
                                                      u.nombre_unidad
                                                  FROM
                                                       orga.testructura_uo eu
                                                  JOIN orga.tuo u on eu.id_uo_hijo = u.id_uo    
                                                  WHERE 
                                                      eu.id_uo_hijo = cp.id_uo
                                                  UNION
                                                      SELECT
                                                          eu2.id_uo_hijo,
                                                          eu2.id_uo_padre, 
                                                          u2.codigo,
                                                          u2.nombre_unidad
                                                      FROM
                                                          orga.testructura_uo eu2
                                                      JOIN orga.tuo u2 on eu2.id_uo_hijo = u2.id_uo
                                                      INNER JOIN subordinates s ON s.id_uo_hijo = eu2.id_uo_padre
                                              ) SELECT
                                                  1
                                              FROM
                                                  subordinates
                                              where subordinates.id_uo_hijo = ". $this->objParam->getParametro('funcionario_gerencia')." ) ");
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