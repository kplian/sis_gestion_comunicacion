<?php
/**
*@package pXP
*@file gen-ACTConsumo.php
*@author  (jrivera)
*@date 24-07-2014 19:17:04
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

require_once(dirname(__FILE__).'/../reporte/RCostosTelecomunicaciones.php');																		
class ACTConsumo extends ACTbase{    
			
	function listarConsumo(){
		$this->objParam->defecto('ordenacion','id_consumo');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('id_numero_celular')!='') {
            $this->objParam->addFiltro(" id_numero_celular= ".$this->objParam->getParametro('id_numero_celular'));    
        }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODConsumo','listarConsumo');
		} else{
			$this->objFunc=$this->create('MODConsumo');
			
			$this->res=$this->objFunc->listarConsumo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarConsumo(){
		$this->objFunc=$this->create('MODConsumo');	
		if($this->objParam->insertar('id_consumo')){
			$this->res=$this->objFunc->insertarConsumo($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarConsumo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarConsumo(){
			$this->objFunc=$this->create('MODConsumo');	
		$this->res=$this->objFunc->eliminarConsumo($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function modificarConsumoCsv(){
		//validar extnsion del archivo	
		$arregloFiles = $this->objParam->getArregloFiles();
		$ext = pathinfo($arregloFiles['archivo']['name']);
		$extension = $ext['extension'];
		$error = 'no';
		$mensaje_completo = '';
		//validar errores unicos del archivo: existencia, copia y extension
		if(isset($arregloFiles['archivo']) && is_uploaded_file($arregloFiles['archivo']['tmp_name'])){
			if ($extension != 'csv' && $extension != 'CSV') {
				$mensaje_completo = "La extensión del archivo debe ser CSV";
				$error = 'error_fatal';
			}  
	  	    //upload directory  
		    $upload_dir = "/tmp/";  
		    //create file name  
		    $file_path = $upload_dir . $arregloFiles['archivo']['name'];  
		  	
		    //move uploaded file to upload dir  
		    if (!move_uploaded_file($arregloFiles['archivo']['tmp_name'], $file_path)) {	  
		        //error moving upload file  
		        $mensaje_completo = "Error al guardar el archivo csv en disco";
				$error = 'error_fatal';	  
		    }  
			
		} else {
			$mensaje_completo = "No se subio el archivo";
			$error = 'error_fatal';
		}
		//armar respuesta en error fatal
		if ($error == 'error_fatal') {
			
			$this->mensajeRes=new Mensaje();
			$this->mensajeRes->setMensaje('ERROR','ACTColumnaCalor.php',$mensaje_completo,
										$mensaje_completo,'control');
		//si no es error fatal proceso el archivo
		} else {
			$lines = file($file_path);
			
			foreach ($lines as $line_num => $line) {
				$arr_temp = explode('|', $line);
				
				if (count($arr_temp) != 2) {
					$error = 'error';
					$mensaje_completo .= "No se proceso la linea: $line_num, por un error en el formato \n";
					
				} else {
					$this->objParam->addParametro('numero',$arr_temp[0]);
					$this->objParam->addParametro('monto',$arr_temp[1]);
					$this->objFunc=$this->create('MODConsumo');
					$this->res=$this->objFunc->modificarConsumoCsv($this->objParam);
					if ($this->res->getTipo() == 'ERROR') {
						$error = 'error';
						$mensaje_completo .= $this->res->getMensaje() . " \n";
					}
				}
			}
		}
		
		//armar respuesta en caso de exito o error en algunas tuplas
		if ($error == 'error') {
			$this->mensajeRes=new Mensaje();
			$this->mensajeRes->setMensaje('ERROR','ACTConsumo.php','Ocurrieron los siguientes errores : ' . $mensaje_completo,
										$mensaje_completo,'control');
		} else if ($error == 'no') {
			$this->mensajeRes=new Mensaje();
			$this->mensajeRes->setMensaje('EXITO','ACTConsumo.php','El archivo fue ejecutado con éxito',
										'El archivo fue ejecutado con éxito','control');
		}		
		
		//devolver respuesta
		$this->mensajeRes->imprimirRespuesta($this->mensajeRes->generarJson());
	}

    function  reporteCostosTelecomunicaciones(){

        $this->objFunc=$this->create('MODConsumo');
        $this->res=$this->objFunc->reporteCostosTelecomunicaciones($this->objParam);
        //obtener titulo de reporte
        //var_dump($this->res);exit;
        $titulo ='COSTOS DE SERVICIO DE TELECOMUNICACIONES';
        //Genera el nombre del archivo (aleatorio + titulo)
        $nombreArchivo=uniqid(md5(session_id()).$titulo);
        $nombreArchivo.='.xls';
        $this->objParam->addParametro('nombre_archivo',$nombreArchivo);
        $this->objParam->addParametro('datos',$this->res->datos);
        if($this->objParam->getParametro('tipo_facturacion') =='fijo'){
            $this->objParam->addParametro('tipoFactura','TELEFONIA FIJA');
        }else if($this->objParam->getParametro('tipo_facturacion') =='celular'){
            $this->objParam->addParametro('tipoFactura','TELEFONIA MOVIL');
        }else if($this->objParam->getParametro('tipo_facturacion') =='4g'){
            $this->objParam->addParametro('tipoFactura','SERVICIO 4G');
        }
        //Instancia la clase de excel
        $this->objReporteFormato=new RReporteTelecomunicaciones($this->objParam);
        $this->objReporteFormato->generarDatos();
        $this->objReporteFormato->generarReporte();

        $this->mensajeExito=new Mensaje();
        $this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado',
            'Se generó con éxito el reporte: '.$nombreArchivo,'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());

    }
}

?>