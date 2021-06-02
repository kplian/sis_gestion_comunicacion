<?php
/****************************************************************************************
*@package pXP
*@file gen-MODEquipoHistorico.php
*@author  (ymedina)
*@date 10-05-2021 16:01:12
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                10-05-2021 16:01:12    ymedina             Creacion    
  #
*****************************************************************************************/

class MODEquipoHistorico extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarEquipoHistorico(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='gecom.ft_equipo_historico_sel';
        $this->transaccion='GC_DETEQU_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
                
        //Definicion de la lista del resultado del query
		$this->captura('id_equipo_historico','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_equipo','int4');
		$this->captura('tipo','varchar');
		$this->captura('marca','varchar');
		$this->captura('modelo','varchar');
		$this->captura('num_serie','varchar');
		$this->captura('estado_fisico','varchar');
		$this->captura('estado','varchar');
		$this->captura('observaciones','varchar');
		$this->captura('operacion','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('id_funcionario_celular','int4');
        
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarEquipoHistorico(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_equipo_historico_ime';
        $this->transaccion='GC_DETEQU_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_equipo','id_equipo','int4');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('marca','marca','varchar');
		$this->setParametro('modelo','modelo','varchar');
		$this->setParametro('num_serie','num_serie','varchar');
		$this->setParametro('estado_fisico','estado_fisico','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('observaciones','observaciones','varchar');
		$this->setParametro('operacion','operacion','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarEquipoHistorico(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_equipo_historico_ime';
        $this->transaccion='GC_DETEQU_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_equipo_historico','id_equipo_historico','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_equipo','id_equipo','int4');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('marca','marca','varchar');
		$this->setParametro('modelo','modelo','varchar');
		$this->setParametro('num_serie','num_serie','varchar');
		$this->setParametro('estado_fisico','estado_fisico','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('observaciones','observaciones','varchar');
		$this->setParametro('operacion','operacion','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarEquipoHistorico(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_equipo_historico_ime';
        $this->transaccion='GC_DETEQU_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_equipo_historico','id_equipo_historico','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>