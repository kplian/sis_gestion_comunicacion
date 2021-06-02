<?php
/****************************************************************************************
*@package pXP
*@file gen-MODNumeroCelularHistorico.php
*@author  (ymedina)
*@date 12-05-2021 12:47:30
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                12-05-2021 12:47:30    ymedina             Creacion    
  #
*****************************************************************************************/

class MODNumeroCelularHistorico extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarNumeroCelularHistorico(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='gecom.ft_numero_celular_historico_sel';
        $this->transaccion='GC_HNUM_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
                
        //Definicion de la lista del resultado del query
		$this->captura('id_numero_celular_his','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_numero_celular','int4');
		$this->captura('numero','varchar');
		$this->captura('roaming','varchar');
		$this->captura('observaciones','text');
		$this->captura('id_proveedor','int4');
		$this->captura('tipo','varchar');
		$this->captura('estado','varchar');
		$this->captura('credito','numeric');
		$this->captura('limite_consumo','numeric');
		$this->captura('sim','int4');
		$this->captura('id_cuenta','int4');
		$this->captura('operacion','varchar');
		$this->captura('observacion_operacion','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('desc_proveedor','varchar');
        $this->captura('desc_nro_cuenta','varchar');
        $this->captura('id_tipo_cc','int4');
        $this->captura('desc_tipo_cc','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarNumeroCelularHistorico(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_numero_celular_historico_ime';
        $this->transaccion='GC_HNUM_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_numero_celular','id_numero_celular','int4');
		$this->setParametro('numero','numero','varchar');
		$this->setParametro('roaming','roaming','varchar');
		$this->setParametro('observaciones','observaciones','text');
		$this->setParametro('id_proveedor','id_proveedor','int4');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('credito','credito','numeric');
		$this->setParametro('limite_consumo','limite_consumo','numeric');
		$this->setParametro('sim','sim','int4');
		$this->setParametro('id_cuenta','id_cuenta','int4');
		$this->setParametro('operacion','operacion','varchar');
		$this->setParametro('observacion_operacion','observacion_operacion','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarNumeroCelularHistorico(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_numero_celular_historico_ime';
        $this->transaccion='GC_HNUM_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_numero_celular_his','id_numero_celular_his','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_numero_celular','id_numero_celular','int4');
		$this->setParametro('numero','numero','varchar');
		$this->setParametro('roaming','roaming','varchar');
		$this->setParametro('observaciones','observaciones','text');
		$this->setParametro('id_proveedor','id_proveedor','int4');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('credito','credito','numeric');
		$this->setParametro('limite_consumo','limite_consumo','numeric');
		$this->setParametro('sim','sim','int4');
		$this->setParametro('id_cuenta','id_cuenta','int4');
		$this->setParametro('operacion','operacion','varchar');
		$this->setParametro('observacion_operacion','observacion_operacion','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarNumeroCelularHistorico(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_numero_celular_historico_ime';
        $this->transaccion='GC_HNUM_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_numero_celular_his','id_numero_celular_his','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>