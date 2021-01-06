<?php
/**
*@package pXP
*@file gen-MODRuta.php
*@author  (breydi.vasquez)
*@date 25-11-2020 18:07:20
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODRuta extends MODbase{

	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}

	function listarRuta(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='gecom.ft_ruta_sel';
		$this->transaccion='GC_GRUTA_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion

		//Definicion de la lista del resultado del query
		$this->captura('id_ruta','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('nro_ruta','int4');
		$this->captura('cod_compania','varchar');
		$this->captura('salida','varchar');
		$this->captura('id_concepto_ingas','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_ingas','varchar');
		$this->captura('desc_partida','varchar');
		$this->captura('gestion','varchar');
		$this->captura('id_gestion','int4');
		$this->captura('id_proveedor','int4');
		$this->captura('desc_proveedor','varchar');


		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function insertarRuta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_ruta_ime';
		$this->transaccion='GC_GRUTA_INS';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nro_ruta','nro_ruta','int4');
		$this->setParametro('cod_compania','cod_compania','varchar');
		$this->setParametro('salida','salida','varchar');
		$this->setParametro('id_concepto_ingas','id_concepto_ingas','int4');
		$this->setParametro('id_proveedor','id_proveedor','int4');
		$this->setParametro('id_gestion','id_gestion','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function modificarRuta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_ruta_ime';
		$this->transaccion='GC_GRUTA_MOD';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('id_ruta','id_ruta','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nro_ruta','nro_ruta','int4');
		$this->setParametro('cod_compania','cod_compania','varchar');
		$this->setParametro('salida','salida','varchar');
		$this->setParametro('id_concepto_ingas','id_concepto_ingas','int4');
		$this->setParametro('id_proveedor','id_proveedor','int4');
		$this->setParametro('id_gestion','id_gestion','int4');


		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function eliminarRuta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_ruta_ime';
		$this->transaccion='GC_GRUTA_ELI';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('id_ruta','id_ruta','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

}
?>
