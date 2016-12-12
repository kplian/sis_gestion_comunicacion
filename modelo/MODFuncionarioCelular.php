<?php
/**
*@package pXP
*@file gen-MODFuncionarioCelular.php
*@author  (jrivera)
*@date 24-07-2014 00:10:05
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODFuncionarioCelular extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarFuncionarioCelular(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='gecom.ft_funcionario_celular_sel';
		$this->transaccion='GC_FUNCEL_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		
		$this->setParametro('historico','historico','varchar');
				
		//Definicion de la lista del resultado del query
		$this->captura('id_funcionario_celular','int4');
		$this->captura('id_numero_celular','int4');
		$this->captura('id_funcionario','int4');
		$this->captura('id_cargo','int4');
		$this->captura('fecha_inicio','date');
		$this->captura('estado_reg','varchar');
		$this->captura('fecha_fin','date');
		$this->captura('observaciones','text');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		$this->captura('nombre_cargo','varchar');
		$this->captura('desc_funcionario1','text');
		$this->captura('numero','varchar');
		$this->captura('tipo','varchar');
        $this->captura('tipo_asignacion','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarFuncionarioCelular(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_funcionario_celular_ime';
		$this->transaccion='GC_FUNCEL_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_numero_celular','id_numero_celular','int4');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('id_cargo','id_cargo','int4');
		$this->setParametro('fecha_inicio','fecha_inicio','date');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('fecha_fin','fecha_fin','date');
		$this->setParametro('observaciones','observaciones','text');
        $this->setParametro('tipo_asignacion','tipo_asignacion','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarFuncionarioCelular(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_funcionario_celular_ime';
		$this->transaccion='GC_FUNCEL_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_funcionario_celular','id_funcionario_celular','int4');
		$this->setParametro('id_numero_celular','id_numero_celular','int4');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('id_cargo','id_cargo','int4');
		$this->setParametro('fecha_inicio','fecha_inicio','date');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('fecha_fin','fecha_fin','date');
		$this->setParametro('observaciones','observaciones','text');
        $this->setParametro('tipo_asignacion','tipo_asignacion','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarFuncionarioCelular(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_funcionario_celular_ime';
		$this->transaccion='GC_FUNCEL_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_funcionario_celular','id_funcionario_celular','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>