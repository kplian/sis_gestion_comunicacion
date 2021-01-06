<?php
/**
*@package pXP
*@file gen-ACTPagoTelefoniaDet.php
*@author  (breydi.vasquez)
*@date 24-11-2020 16:26:28
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/
include_once(dirname(__FILE__).'/../../lib/lib_general/ExcelInput.php');
class ACTPagoTelefoniaDet extends ACTbase{

	function listarPagoTelefoniaDet(){
		$this->objParam->defecto('ordenacion','id_pago_telefonia_det');

		$this->objParam->defecto('dir_ordenacion','asc');

		$this->objParam->getParametro('id_pago_telefonia') != '' && $this->objParam->addFiltro("detpagte.id_pago_telefonia = ".$this->objParam->getParametro('id_pago_telefonia')."");

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPagoTelefoniaDet','listarPagoTelefoniaDet');
		} else{
			$this->objFunc=$this->create('MODPagoTelefoniaDet');

			$this->res=$this->objFunc->listarPagoTelefoniaDet($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function insertarPagoTelefoniaDet(){
		$this->objFunc=$this->create('MODPagoTelefoniaDet');
		if($this->objParam->insertar('id_pago_telefonia_det')){
			$this->res=$this->objFunc->insertarPagoTelefoniaDet($this->objParam);
		} else{
			$this->res=$this->objFunc->modificarPagoTelefoniaDet($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function eliminarPagoTelefoniaDet(){
			$this->objFunc=$this->create('MODPagoTelefoniaDet');
		$this->res=$this->objFunc->eliminarPagoTelefoniaDet($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function converToTime($x) {
	    $sec = intval($x * (24 * 60 * 60));
	    $date = new DateTime("today +$sec seconds");
	    return $date->format('H:i:s');
	}

	function cargarArchivoPagTelfExcel() {
		//validar extnsion del archivo
		$id_pago_telefonia = $this->objParam->getParametro('id_pago_telefonia');

		$codigoArchivo = $this->objParam->getParametro('codigo');
		$arregloFiles = $this->objParam->getArregloFiles();

		$error = 'no';
		$mensaje_completo = '';
		//validar errores unicos del archivo: existencia, copia y extension
		if(isset($arregloFiles['archivo']) && is_uploaded_file($arregloFiles['archivo']['tmp_name'])){
				//procesa Archivo
				$archivoExcel = new ExcelInput($arregloFiles['archivo']['tmp_name'], $codigoArchivo);
				$archivoExcel->recuperarColumnasExcel();

				$arrayArchivo = $archivoExcel->leerColumnasArchivoExcel();

				foreach ($arrayArchivo as $fila) {

						$this->objParam->addParametro('id_pago_telefonia', $id_pago_telefonia);
						$this->objParam->addParametro('fecha_hora', $fila['fecha_hora']);
						$this->objParam->addParametro('fecha', $fila['fecha']);
						$this->objParam->addParametro('hora', $this->converToTime($fila['hora']));
						$this->objParam->addParametro('anexo', $fila['anexo']);
						$this->objParam->addParametro('cod_empleado', $fila['cod_empleado']);
						$this->objParam->addParametro('nombre_empleado', $fila['nombre_empleado']);
						$this->objParam->addParametro('nro_telefono', $fila['nro_telefono']);
						$this->objParam->addParametro('nombre_telefono', $fila['nombre_telefono']);
						$this->objParam->addParametro('duracion_real', $this->converToTime($fila['duracion_real']));
						$this->objParam->addParametro('costo_llamada', $fila['costo_llamada']);
						$this->objParam->addParametro('servicio_llamada', $fila['servicio_llamada']);
						$this->objParam->addParametro('cod_sucursal', $fila['cod_sucursal']);
						$this->objParam->addParametro('sucursal', $fila['sucursal']);
						$this->objParam->addParametro('ruta', $fila['ruta']);
						$this->objParam->addParametro('troncal', $fila['troncal']);
						$this->objParam->addParametro('cod_usuario', is_null($fila['cod_usuario'])?'': $fila['cod_usuario']);
						$this->objParam->addParametro('cod_organizacion', $fila['cod_organizacion']);
						$this->objParam->addParametro('organizacion', $fila['organizacion']);
						$this->objParam->addParametro('cod_centro_costo', $fila['cod_centro_costo']);
						$this->objParam->addParametro('centro_costo', $fila['centro_costo']);
						$this->objParam->addParametro('nro_origen', $fila['nro_origen']);
						$this->objParam->addParametro('cod_ciudad', $fila['cod_ciudad']);
						$this->objParam->addParametro('ciudad', $fila['ciudad']);
						$this->objParam->addParametro('cod_pais', $fila['cod_pais']);
						$this->objParam->addParametro('pais', $fila['pais']);
						$this->objParam->addParametro('duracion_llamada', $fila['duracion_llamada']);
						$this->objParam->addParametro('globa_l', $fila['globa_l']);
						$this->objParam->addParametro('tipo_resp_llamada', $fila['tipo_resp_llamada']);
						$this->objParam->addParametro('transferir_a', is_null($fila['transferir_a'])?'': $fila['transferir_a']);
						$this->objParam->addParametro('transferir_desde', is_null($fila['transferir_desde'])?'': $fila['transferir_desde']);
						$this->objParam->addParametro('evento', is_null($fila['evento'])?'':$fila['evento']);
						$this->objParam->addParametro('posicion_memoria', is_null($fila['posicion_memoria'])?'': $fila['posicion_memoria']);
						$this->objParam->addParametro('cod_compania', $fila['cod_compania']);
						$this->objParam->addParametro('tiempo_timbrado', $this->converToTime($fila['tiempo_timbrado']));
						$this->objParam->addParametro('cod_grupo_base_destino', $fila['cod_grupo_base_destino']);
						$this->objParam->addParametro('grupo_base_destino', $fila['grupo_base_destino']);
						$this->objParam->addParametro('grupo_destino', $fila['grupo_destino']);
						$this->objParam->addParametro('cod_interno', $fila['cod_interno']);
						$this->objParam->addParametro('fac', is_null($fila['fac'])?'': $fila['fac']);
						$this->objParam->addParametro('desv_de_desv_a', is_null($fila['desv_de_desv_a'])?'': $fila['fac']);


						$this->objFunc = $this->create('MODPagoTelefoniaDet');
						$this->res = $this->objFunc->insertarPagoTelefoniaDet($this->objParam);

						if($this->res->getTipo()=='ERROR'){
								$error = 'error';
								$mensaje_completo = $this->res->getMensajeTec();
						}
				}

		} else {
				$mensaje_completo = "No se subio el archivo";
				$error = 'error_fatal';
		}

		//armar respuesta en error fatal
		if ($error == 'error_fatal') {

				$this->mensajeRes=new Mensaje();
				$this->mensajeRes->setMensaje('ERROR','ACTPagoTelefoniaDet.php',$mensaje_completo,
				$mensaje_completo,'control');
				//si no es error fatal proceso el archivo
		}

		//armar respuesta en caso de exito o error en algunas tuplas
		if ($error == 'error') {
				$this->mensajeRes=new Mensaje();
				$this->mensajeRes->setMensaje('ERROR','ACTPagoTelefoniaDet.php','Ocurrieron los siguientes errores : ' . $mensaje_completo,
				$mensaje_completo,'control');
		} else if ($error == 'no') {
				$this->objParam->addParametro('id_pago_telefonia', $id_pago_telefonia);
				$this->objFunc1 = $this->create('MODPagoTelefoniaDet');
				$this->res = $this->objFunc1->updateEstadoPagoTelf($this->objParam);
				$this->mensajeRes=new Mensaje();
				$this->mensajeRes->setMensaje('EXITO','ACTPagoTelefoniaDet.php','El archivo fue ejecutado con éxito', 'El archivo fue ejecutado con éxito', 'control');
		}

		//devolver respuesta
		$this->mensajeRes->imprimirRespuesta($this->mensajeRes->generarJson());
	}

}

?>
