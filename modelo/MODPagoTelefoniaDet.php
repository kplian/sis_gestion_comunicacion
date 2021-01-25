<?php
/**
*@package pXP
*@file gen-MODPagoTelefoniaDet.php
*@author  (breydi.vasquez)
*@date 24-11-2020 16:26:28
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPagoTelefoniaDet extends MODbase{

	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}

	function listarPagoTelefoniaDet(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='gecom.ft_pago_telefonia_det_sel';
		$this->transaccion='GC_DETPAGTE_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion

		//Definicion de la lista del resultado del query
		$this->captura('id_pago_telefonia_det','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_pago_telefonia','int4');
		$this->captura('fecha','date');
		$this->captura('hora','time');
		$this->captura('anexo','varchar');
		$this->captura('cod_empleado','varchar');
		$this->captura('nombre_empleado','varchar');
		$this->captura('nro_telefono','varchar');
		$this->captura('nombre_telefono','varchar');
		$this->captura('duracion_real','time');
		$this->captura('costo_llamada','numeric');
		$this->captura('servicio_llamada','varchar');
		$this->captura('cod_sucursal','varchar');
		$this->captura('sucursal','varchar');
		$this->captura('ruta','int4');
		$this->captura('troncal','int4');
		$this->captura('cod_usuario','varchar');
		$this->captura('cod_organizacion','varchar');
		$this->captura('organizacion','varchar');
		$this->captura('cod_centro_costo','varchar');
		$this->captura('centro_costo','varchar');
		$this->captura('nro_origen','varchar');
		$this->captura('cod_ciudad','varchar');
		$this->captura('ciudad','varchar');
		$this->captura('cod_pais','varchar');
		$this->captura('pais','varchar');
		$this->captura('duracion_llamada','numeric');
		$this->captura('globa_l','varchar');
		$this->captura('tipo_resp_llamada','varchar');
		$this->captura('transferir_a','varchar');
		$this->captura('transferir_desde','varchar');
		$this->captura('evento','varchar');
		$this->captura('posicion_memoria','varchar');
		$this->captura('cod_compania','varchar');
		$this->captura('tiempo_timbrado','time');
		$this->captura('cod_grupo_base_destino','varchar');
		$this->captura('grupo_base_destino','varchar');
		$this->captura('grupo_destino','varchar');
		$this->captura('cod_interno','varchar');
		$this->captura('fac','varchar');
		$this->captura('desv_de_desv_a','varchar');
		$this->captura('factor_porcentual','numeric');
		$this->captura('id_centro_costo','int4');
		$this->captura('id_concepto_ingas','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_centro_costo','text');
		$this->captura('desc_concepto_ingas','varchar');

		$this->captura('salida','varchar');
		$this->captura('id_numero_celular','int4');
		$this->captura('numero','varchar');
		$this->captura('desc_proveedor','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function insertarPagoTelefoniaDet(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_pago_telefonia_det_ime';
		$this->transaccion='GC_DETPAGTE_INS';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion

		$this->setParametro('id_pago_telefonia','id_pago_telefonia','int4');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('hora','hora','time');
		$this->setParametro('anexo','anexo','varchar');
		$this->setParametro('cod_empleado','cod_empleado','varchar');
		$this->setParametro('nombre_empleado','nombre_empleado','varchar');
		$this->setParametro('nro_telefono','nro_telefono','varchar');
		$this->setParametro('nombre_telefono','nombre_telefono','varchar');
		$this->setParametro('duracion_real','duracion_real','time');
		$this->setParametro('costo_llamada','costo_llamada','numeric');
		$this->setParametro('servicio_llamada','servicio_llamada','varchar');
		$this->setParametro('cod_sucursal','cod_sucursal','varchar');
		$this->setParametro('sucursal','sucursal','varchar');
		$this->setParametro('ruta','ruta','int4');
		$this->setParametro('troncal','troncal','int4');
		$this->setParametro('cod_usuario','cod_usuario','varchar');
		$this->setParametro('cod_organizacion','cod_organizacion','varchar');
		$this->setParametro('organizacion','organizacion','varchar');
		$this->setParametro('cod_centro_costo','cod_centro_costo','varchar');
		$this->setParametro('centro_costo','centro_costo','varchar');
		$this->setParametro('nro_origen','nro_origen','varchar');
		$this->setParametro('cod_ciudad','cod_ciudad','varchar');
		$this->setParametro('ciudad','ciudad','varchar');
		$this->setParametro('cod_pais','cod_pais','varchar');
		$this->setParametro('pais','pais','varchar');
		$this->setParametro('duracion_llamada','duracion_llamada','numeric');
		$this->setParametro('globa_l','globa_l','varchar');
		$this->setParametro('tipo_resp_llamada','tipo_resp_llamada','varchar');
		$this->setParametro('transferir_a','transferir_a','varchar');
		$this->setParametro('transferir_desde','transferir_desde','varchar');
		$this->setParametro('evento','evento','varchar');
		$this->setParametro('posicion_memoria','posicion_memoria','varchar');
		$this->setParametro('cod_compania','cod_compania','varchar');
		$this->setParametro('tiempo_timbrado','tiempo_timbrado','time');
		$this->setParametro('cod_grupo_base_destino','cod_grupo_base_destino','varchar');
		$this->setParametro('grupo_base_destino','grupo_base_destino','varchar');
		$this->setParametro('grupo_destino','grupo_destino','varchar');
		$this->setParametro('cod_interno','cod_interno','varchar');
		$this->setParametro('fac','fac','varchar');
		$this->setParametro('desv_de_desv_a','desv_de_desv_a','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function modificarPagoTelefoniaDet(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_pago_telefonia_det_ime';
		$this->transaccion='GC_DETPAGTE_MOD';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('id_pago_telefonia_det','id_pago_telefonia_det','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_pago_telefonia','id_pago_telefonia','int4');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('hora','hora','time');
		$this->setParametro('anexo','anexo','varchar');
		$this->setParametro('cod_empleado','cod_empleado','varchar');
		$this->setParametro('nombre_empleado','nombre_empleado','varchar');
		$this->setParametro('nro_telefono','nro_telefono','varchar');
		$this->setParametro('nombre_telefono','nombre_telefono','varchar');
		$this->setParametro('duracion_real','duracion_real','time');
		$this->setParametro('costo_llamada','costo_llamada','numeric');
		$this->setParametro('servicio_llamada','servicio_llamada','varchar');
		$this->setParametro('cod_sucursal','cod_sucursal','varchar');
		$this->setParametro('sucursal','sucursal','varchar');
		$this->setParametro('ruta','ruta','int4');
		$this->setParametro('troncal','troncal','int4');
		$this->setParametro('cod_usuario','cod_usuario','varchar');
		$this->setParametro('cod_organizacion','cod_organizacion','varchar');
		$this->setParametro('organizacion','organizacion','varchar');
		$this->setParametro('cod_centro_costo','cod_centro_costo','varchar');
		$this->setParametro('centro_costo','centro_costo','varchar');
		$this->setParametro('nro_origen','nro_origen','varchar');
		$this->setParametro('cod_ciudad','cod_ciudad','varchar');
		$this->setParametro('ciudad','ciudad','varchar');
		$this->setParametro('cod_pais','cod_pais','varchar');
		$this->setParametro('pais','pais','varchar');
		$this->setParametro('duracion_llamada','duracion_llamada','numeric');
		$this->setParametro('globa_l','globa_l','varchar');
		$this->setParametro('tipo_resp_llamada','tipo_resp_llamada','varchar');
		$this->setParametro('transferir_a','transferir_a','varchar');
		$this->setParametro('transferir_desde','transferir_desde','varchar');
		$this->setParametro('evento','evento','varchar');
		$this->setParametro('posicion_memoria','posicion_memoria','varchar');
		$this->setParametro('cod_compania','cod_compania','varchar');
		$this->setParametro('tiempo_timbrado','tiempo_timbrado','time');
		$this->setParametro('cod_grupo_base_destino','cod_grupo_base_destino','varchar');
		$this->setParametro('grupo_base_destino','grupo_base_destino','varchar');
		$this->setParametro('grupo_destino','grupo_destino','varchar');
		$this->setParametro('cod_interno','cod_interno','varchar');
		$this->setParametro('fac','fac','varchar');
		$this->setParametro('desv_de_desv_a','desv_de_desv_a','varchar');
		$this->setParametro('factor_porcentual','factor_porcentual','numeric');
		$this->setParametro('id_centro_costo','id_centro_costo','int4');
		$this->setParametro('id_concepto_ingas','id_concepto_ingas','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function eliminarPagoTelefoniaDet(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_pago_telefonia_det_ime';
		$this->transaccion='GC_DETPAGTE_ELI';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('id_pago_telefonia_det','id_pago_telefonia_det','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function updateEstadoPagoTelf(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='gecom.ft_pago_telefonia_det_ime';
		$this->transaccion='GC_PGTELUP_IME';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('id_pago_telefonia','id_pago_telefonia','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

}
?>
