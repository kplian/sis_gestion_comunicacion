<?php
/**
*@package pXP
*@file gen-MODConsumo.php
*@author  (jrivera)
*@date 24-07-2014 19:17:04
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODConsumo extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarConsumo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='gecom.ft_consumo_sel';
		$this->transaccion='GC_CON_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_consumo','int4');
		$this->captura('id_numero_celular','int4');
		$this->captura('id_periodo','int4');
		$this->captura('id_gestion','int4');
		$this->captura('id_servicio','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('observaciones','text');
		$this->captura('consumo','numeric');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('periodo','int4');
		$this->captura('gestion','int4');
		$this->captura('nombre_servicio','varchar');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarConsumo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_consumo_ime';
		$this->transaccion='GC_CON_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_numero_celular','id_numero_celular','int4');
		$this->setParametro('id_periodo','id_periodo','int4');
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('id_servicio','id_servicio','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('observaciones','observaciones','text');
		$this->setParametro('consumo','consumo','numeric');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarConsumo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_consumo_ime';
		$this->transaccion='GC_CON_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_consumo','id_consumo','int4');
		$this->setParametro('id_numero_celular','id_numero_celular','int4');
		$this->setParametro('id_periodo','id_periodo','int4');
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('id_servicio','id_servicio','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('observaciones','observaciones','text');
		$this->setParametro('consumo','consumo','numeric');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarConsumo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_consumo_ime';
		$this->transaccion='GC_CON_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_consumo','id_consumo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	function modificarConsumoCsv(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_consumo_ime';
		$this->transaccion='GC_CONCSV_UPD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('id_periodo','id_periodo','int4');
		$this->setParametro('numero','numero','varchar');
		$this->setParametro('monto','monto','numeric');		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

    function reporteCostosTelecomunicaciones(){

        $this->procedimiento ='gecom.ft_consumo_sel';
        $this->transaccion='GC_COSREP_SEL';
        $this->tipo_procedimiento='SEL';

        $this->setParametro('id_gestion','id_gestion','int4');
        $this->setParametro('tipo_facturacion','tipo_facturacion','varchar');
        $this->setCount(false);
        $this->captura('gerencia','varchar');
        $this->captura('departamento','varchar');
        $this->captura('oficina','varchar');
        $this->captura('lugar','varchar');
        $this->captura('usuario','varchar');
        $this->captura('cargo','varchar');
        $this->captura('rotulo_comercial','varchar');
        $this->captura('id_numero_celular','int4');
        $this->captura('observaciones','text');
        $this->captura('gestion','int4');
        $this->captura('numero','varchar');
        $this->captura('enero','numeric');
        $this->captura('febrero','numeric');
        $this->captura('marzo','numeric');
        $this->captura('abril','numeric');
        $this->captura('mayo','numeric');
        $this->captura('junio','numeric');
        $this->captura('julio','numeric');
        $this->captura('agosto','numeric');
        $this->captura('septiembre','numeric');
        $this->captura('octubre','numeric');
        $this->captura('noviembre','numeric');
        $this->captura('diciembre','numeric');
        $this->captura('tipo','varchar');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //var_dump( $this->respuesta);exit;
        //Devuelve la respuesta
        return $this->respuesta;
    }
}
?>