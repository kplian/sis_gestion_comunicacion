<?php
/****************************************************************************************
*@package pXP
*@file gen-MODCuentaProveedor.php
*@author  (ymedina)
*@date 12-05-2021 08:13:06
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                12-05-2021 08:13:06    ymedina             Creacion    
  #
*****************************************************************************************/

class MODCuentaProveedor extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarCuentaProveedor(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='gecom.ft_cuenta_proveedor_sel';
        $this->transaccion='GC_CUP_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
                
        //Definicion de la lista del resultado del query
		$this->captura('id_cuenta','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_proveedor','int4');
		$this->captura('nro_cuenta','int4');
		$this->captura('id_uo','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('desc_proveedor','varchar');
        $this->captura('desc_nombre_unidad','varchar');
        $this->captura('desc_cuenta_prov','varchar');
        
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarCuentaProveedor(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_cuenta_proveedor_ime';
        $this->transaccion='GC_CUP_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_proveedor','id_proveedor','int4');
		$this->setParametro('nro_cuenta','nro_cuenta','int4');
		$this->setParametro('id_uo','id_uo','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarCuentaProveedor(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_cuenta_proveedor_ime';
        $this->transaccion='GC_CUP_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_cuenta','id_cuenta','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_proveedor','id_proveedor','int4');
		$this->setParametro('nro_cuenta','nro_cuenta','int4');
		$this->setParametro('id_uo','id_uo','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarCuentaProveedor(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_cuenta_proveedor_ime';
        $this->transaccion='GC_CUP_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_cuenta','id_cuenta','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>