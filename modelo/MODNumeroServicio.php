<?php
/**
*@package pXP
*@file gen-MODNumeroServicio.php
*@author  (jrivera)
*@date 23-07-2014 23:47:15
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODNumeroServicio extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarNumeroServicio(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='gecom.ft_numero_servicio_sel';
		$this->transaccion='GC_NUMSER_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_numero_servicio','int4');
		$this->captura('id_servicio','int4');
		$this->captura('id_numero_celular','int4');
		$this->captura('observaciones','text');
		$this->captura('estado_reg','varchar');
		$this->captura('fecha_fin','date');
		$this->captura('fecha_inicio','date');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('nombre_servicio','varchar');
        $this->captura('tipo_servicio','varchar');
        $this->captura('tipo_servicio_desc','varchar');
        $this->captura('tarifa','numeric');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarNumeroServicio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_numero_servicio_ime';
		$this->transaccion='GC_NUMSER_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_servicio','id_servicio','int4');
		$this->setParametro('id_numero_celular','id_numero_celular','int4');
		$this->setParametro('observaciones','observaciones','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('fecha_fin','fecha_fin','date');
		$this->setParametro('fecha_inicio','fecha_inicio','date');
        $this->setParametro('tipo_servicio','tipo_servicio','varchar');
        $this->setParametro('tarifa','tarifa','numeric');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarNumeroServicio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_numero_servicio_ime';
		$this->transaccion='GC_NUMSER_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_numero_servicio','id_numero_servicio','int4');
		$this->setParametro('id_servicio','id_servicio','int4');
		$this->setParametro('id_numero_celular','id_numero_celular','int4');
		$this->setParametro('observaciones','observaciones','text');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('fecha_fin','fecha_fin','date');
		$this->setParametro('fecha_inicio','fecha_inicio','date');
        $this->setParametro('tipo_servicio','tipo_servicio','varchar');
        $this->setParametro('tarifa','tarifa','numeric');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarNumeroServicio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_numero_servicio_ime';
		$this->transaccion='GC_NUMSER_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_numero_servicio','id_numero_servicio','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>