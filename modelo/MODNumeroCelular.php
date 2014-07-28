<?php
/**
*@package pXP
*@file gen-MODNumeroCelular.php
*@author  (jrivera)
*@date 23-07-2014 22:43:16
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODNumeroCelular extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarNumeroCelular(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='gecom.ft_numero_celular_sel';
		$this->transaccion='GC_NUMCEL_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_numero_celular','int4');
		$this->captura('id_proveedor','int4');
		$this->captura('numero','varchar');
		$this->captura('observaciones','text');
		$this->captura('roaming','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_proveedor','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarNumeroCelular(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_numero_celular_ime';
		$this->transaccion='GC_NUMCEL_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_proveedor','id_proveedor','int4');
		$this->setParametro('numero','numero','varchar');
		$this->setParametro('observaciones','observaciones','text');
		$this->setParametro('roaming','roaming','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarNumeroCelular(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_numero_celular_ime';
		$this->transaccion='GC_NUMCEL_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_numero_celular','id_numero_celular','int4');
		$this->setParametro('id_proveedor','id_proveedor','int4');
		$this->setParametro('numero','numero','varchar');
		$this->setParametro('observaciones','observaciones','text');
		$this->setParametro('roaming','roaming','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarNumeroCelular(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_numero_celular_ime';
		$this->transaccion='GC_NUMCEL_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_numero_celular','id_numero_celular','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>