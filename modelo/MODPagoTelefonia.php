<?php
/**
*@package pXP
*@file gen-MODPagoTelefonia.php
*@author  (breydi.vasquez)
*@date 24-11-2020 16:26:24
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPagoTelefonia extends MODbase{

	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}

	function listarPagoTelefonia(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='gecom.ft_pago_telefonia_sel';
		$this->transaccion='GC_PAGTEL_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion

		//Definicion de la lista del resultado del query
		$this->captura('id_pago_telefonia','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_gestion','int4');
		$this->captura('id_periodo','int4');
		$this->captura('descripcion','text');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('gestion','integer');
		$this->captura('literal','varchar');
		$this->captura('estado','varchar');

		$this->captura('nro_tramite','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function insertarPagoTelefonia(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_pago_telefonia_ime';
		$this->transaccion='GC_PAGTEL_INS';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('id_periodo','id_periodo','int4');
		$this->setParametro('descripcion','descripcion','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function modificarPagoTelefonia(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_pago_telefonia_ime';
		$this->transaccion='GC_PAGTEL_MOD';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('id_pago_telefonia','id_pago_telefonia','int4');
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('id_periodo','id_periodo','int4');
		$this->setParametro('descripcion','descripcion','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function eliminarPagoTelefonia(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_pago_telefonia_ime';
		$this->transaccion='GC_PAGTEL_ELI';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('id_pago_telefonia','id_pago_telefonia','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function calculoPagoTelefonia(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_pago_telefonia_ime';
		$this->transaccion='GC_CALPAGTEL_IME';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('id_pago_telefonia','id_pago_telefonia','int4');
		$this->setParametro('id_gestion','id_gestion','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
}
?>
