<?php
/**
*@package pXP
*@file gen-MODServicio.php
*@author  (jrivera)
*@date 23-07-2014 22:43:19
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODServicio extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarServicio(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='gecom.ft_servicio_sel';
		$this->transaccion='GC_SER_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_servicio','int4');
		$this->captura('id_proveedor','int4');
		$this->captura('trafico_adicional','numeric');
		$this->captura('tarifa','numeric');
		$this->captura('estado_reg','varchar');
		$this->captura('nombre_servicio','varchar');
		$this->captura('observaciones','text');
		$this->captura('codigo_servicio','varchar');
		$this->captura('trafico_libre','numeric');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_proveedor','varchar');
		$this->captura('defecto','varchar');
        $this->captura('tipo_servicio','varchar');
        $this->captura('tipo_servicio_desc','varchar');
        $this->captura('nombre_combo','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarServicio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_servicio_ime';
		$this->transaccion='GC_SER_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_proveedor','id_proveedor','int4');
		$this->setParametro('trafico_adicional','trafico_adicional','numeric');
		$this->setParametro('tarifa','tarifa','numeric');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre_servicio','nombre_servicio','varchar');
		$this->setParametro('observaciones','observaciones','text');
		$this->setParametro('codigo_servicio','codigo_servicio','varchar');
		$this->setParametro('trafico_libre','trafico_libre','numeric');
		$this->setParametro('defecto','defecto','varchar');
        $this->setParametro('tipo_servicio','tipo_servicio','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarServicio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_servicio_ime';
		$this->transaccion='GC_SER_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_servicio','id_servicio','int4');
		$this->setParametro('id_proveedor','id_proveedor','int4');
		$this->setParametro('trafico_adicional','trafico_adicional','numeric');
		$this->setParametro('tarifa','tarifa','numeric');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre_servicio','nombre_servicio','varchar');
		$this->setParametro('observaciones','observaciones','text');
		$this->setParametro('codigo_servicio','codigo_servicio','varchar');
		$this->setParametro('trafico_libre','trafico_libre','numeric');
		$this->setParametro('defecto','defecto','varchar');
        $this->setParametro('tipo_servicio','tipo_servicio','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarServicio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_servicio_ime';
		$this->transaccion='GC_SER_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_servicio','id_servicio','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>