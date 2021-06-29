<?php
/****************************************************************************************
*@package pXP
*@file gen-MODAccesorio.php
*@author  (ymedina)
*@date 29-05-2021 16:19:41
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                29-05-2021 16:19:41    ymedina             Creacion    
  #
*****************************************************************************************/

class MODAccesorio extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarAccesorio(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='gecom.ft_accesorio_sel';
        $this->transaccion='GC_ACC_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
                
        //Definicion de la lista del resultado del query
		$this->captura('id_accesorio','int4');
        $this->captura('id_equipo','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('nombre','varchar');
		$this->captura('marca','varchar');
		$this->captura('num_serie','varchar');
		$this->captura('estado_fisico','varchar');
		$this->captura('observaciones','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
		$this->captura('tipo','varchar');
		$this->captura('modelo','varchar');
		$this->captura('resumen','varchar');
        $this->captura('tipo_desc','varchar');
        $this->captura('marca_desc','varchar');
        $this->captura('estado_fisico_desc','varchar');
        
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarAccesorio(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_accesorio_ime';
        $this->transaccion='GC_ACC_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('marca','marca','varchar');
		$this->setParametro('num_serie','num_serie','varchar');
		$this->setParametro('estado_fisico','estado_fisico','varchar');
		$this->setParametro('observaciones','observaciones','varchar');
        $this->setParametro('id_equipo','id_equipo','int4');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('modelo','modelo','varchar');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarAccesorio(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_accesorio_ime';
        $this->transaccion='GC_ACC_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_accesorio','id_accesorio','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('marca','marca','varchar');
		$this->setParametro('num_serie','num_serie','varchar');
		$this->setParametro('estado_fisico','estado_fisico','varchar');
		$this->setParametro('observaciones','observaciones','varchar');
        $this->setParametro('id_equipo','id_equipo','int4');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('modelo','modelo','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarAccesorio(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_accesorio_ime';
        $this->transaccion='GC_ACC_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_accesorio','id_accesorio','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>