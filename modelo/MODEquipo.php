<?php
/****************************************************************************************
*@package pXP
*@file gen-MODEquipo.php
*@author  (ymedina)
*@date 06-05-2021 16:01:48
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                06-05-2021 16:01:48    ymedina             Creacion    
  #
*****************************************************************************************/

class MODEquipo extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarEquipo(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='gecom.ft_equipo_sel';
        $this->transaccion='GC_EQU_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
                
        //Definicion de la lista del resultado del query
		$this->captura('id_equipo','int4');
		$this->captura('estado_fisico','varchar');
		$this->captura('observaciones','varchar');
		$this->captura('marca','varchar');
		$this->captura('tipo','varchar');
        $this->captura('tipo_desc','varchar');
		$this->captura('modelo','varchar');
		$this->captura('estado','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('num_serie','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('id_equipo_movil','int4');
        $this->captura('color','varchar');
        $this->captura('imei','varchar');
        $this->captura('sn','varchar');
        $this->captura('id_equipo_pc','int4');
        $this->captura('tamano_pantalla','varchar');
        $this->captura('tarjeta_video','varchar');
        $this->captura('teclado','varchar');
        $this->captura('procesador','varchar');
        $this->captura('memoria_ram','varchar');
        $this->captura('almacenamiento','varchar');
        $this->captura('sistema_operativo','varchar');
        $this->captura('accesorios','varchar');
        $this->captura('nombre','varchar');
        $this->captura('id_numero_celular','int4');
        $this->captura('numero','varchar');
        $this->captura('gama','varchar');
        $this->captura('gama_desc','varchar');
        $this->captura('imei2','varchar');
        $this->captura('tipo_servicio','varchar');
        $this->captura('tipo_servicio_desc','varchar');
        
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }

    function listarEquipoCombo(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='gecom.ft_equipo_sel';
        $this->transaccion='GC_EQUCMB_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        //Definicion de la lista del resultado del query
        $this->captura('id_equipo','int4');
        $this->captura('nombre','varchar');
        $this->captura('estado','varchar');
        $this->captura('tipo','varchar');
        $this->captura('id_numero_celular','int4');
        $this->captura('tipo_servicio','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarEquipo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_equipo_ime';
        $this->transaccion='GC_EQU_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_fisico','estado_fisico','varchar');
		$this->setParametro('observaciones','observaciones','varchar');
		$this->setParametro('marca','marca','varchar');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('modelo','modelo','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('num_serie','num_serie','varchar');
        $this->setParametro('id_equipo_movil','id_equipo_movil','int4');
        $this->setParametro('color','color','varchar');
        $this->setParametro('imei','imei','varchar');
        $this->setParametro('sn','sn','varchar');
        $this->setParametro('id_equipo_pc','id_equipo_pc','int4');
        $this->setParametro('tamano_pantalla','tamano_pantalla','varchar');
        $this->setParametro('tarjeta_video','tarjeta_video','varchar');
        $this->setParametro('teclado','teclado','varchar');
        $this->setParametro('procesador','procesador','varchar');
        $this->setParametro('memoria_ram','memoria_ram','varchar');
        $this->setParametro('almacenamiento','almacenamiento','varchar');
        $this->setParametro('sistema_operativo','sistema_operativo','varchar');
        $this->setParametro('accesorios','accesorios','varchar');
        $this->setParametro('id_numero_celular','id_numero_celular','int4');
        $this->setParametro('gama','gama','varchar');
        $this->setParametro('imei2','imei2','varchar');
        $this->setParametro('tipo_servicio','tipo_servicio','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarEquipo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_equipo_ime';
        $this->transaccion='GC_EQU_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_equipo','id_equipo','int4');
		$this->setParametro('estado_fisico','estado_fisico','varchar');
		$this->setParametro('observaciones','observaciones','varchar');
		$this->setParametro('marca','marca','varchar');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('modelo','modelo','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('num_serie','num_serie','varchar');
        $this->setParametro('id_equipo_movil','id_equipo_movil','int4');
        $this->setParametro('color','color','varchar');
        $this->setParametro('imei','imei','varchar');
        $this->setParametro('sn','sn','varchar');
        $this->setParametro('id_equipo_pc','id_equipo_pc','int4');
        $this->setParametro('tamano_pantalla','tamano_pantalla','varchar');
        $this->setParametro('tarjeta_video','tarjeta_video','varchar');
        $this->setParametro('teclado','teclado','varchar');
        $this->setParametro('procesador','procesador','varchar');
        $this->setParametro('memoria_ram','memoria_ram','varchar');
        $this->setParametro('almacenamiento','almacenamiento','varchar');
        $this->setParametro('sistema_operativo','sistema_operativo','varchar');
        $this->setParametro('accesorios','accesorios','varchar');
        $this->setParametro('id_numero_celular','id_numero_celular','int4');
        $this->setParametro('gama','gama','varchar');
        $this->setParametro('imei2','imei2','varchar');
        $this->setParametro('tipo_servicio','tipo_servicio','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarEquipo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_equipo_ime';
        $this->transaccion='GC_EQU_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_equipo','id_equipo','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function retornarEquipo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_equipo_ime';
        $this->transaccion='GC_EQU_RET';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('id_funcionario_celular','id_funcionario_celular','int4');
        $this->setParametro('id_funcionario','id_funcionario','int4');
        $this->setParametro('fecha_fin','fecha_fin','date');
        $this->setParametro('observaciones','observaciones','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function cambioEquipo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_equipo_ime';
        $this->transaccion='GC_EQU_CAM';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('id_funcionario_celular','id_funcionario_celular','int4');
        $this->setParametro('id_funcionario','id_funcionario','int4');
        $this->setParametro('id_equipo','id_equipo','int4');
        $this->setParametro('fecha_fin','fecha_fin','date');
        $this->setParametro('observaciones','observaciones','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function recuperarDatos(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='gecom.ft_equipo_sel';
        $this->transaccion='GC_TIPREP_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);

        //captura parametros adicionales para el count
        $this->setParametro('tipo','tipo','varchar');

        //Definicion de la lista del resultado del query
        $this->captura('id_equipo','int4');
        $this->captura('tipo','varchar');
        $this->captura('marca','varchar');
        $this->captura('modelo','varchar');
        $this->captura('estado_fisico','varchar');
        $this->captura('estado','varchar');
        $this->captura('observaciones','varchar');
        $this->captura('color','varchar');
        $this->captura('imei','varchar');
        $this->captura('tamano_pantalla','varchar');
        $this->captura('tarjeta_video','varchar');
        $this->captura('teclado','varchar');
        $this->captura('procesador','varchar');
        $this->captura('memoria_ram','varchar');
        $this->captura('almacenamiento','varchar');
        $this->captura('sistema_operativo','varchar');
        $this->captura('accesorios','varchar');
        $this->captura('fnombre','varchar');
        $this->captura('fci','varchar');
        $this->captura('fcodigo','varchar');
        $this->captura('email_empresa','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //Devuelve la respuesta
        return $this->respuesta;
    }

    function recuperarDatosFuncionario(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='gecom.ft_equipo_sel';
        $this->transaccion='GC_TIPRFUN_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);

        //captura parametros adicionales para el count
        $this->setParametro('id_funcionario','id_funcionario','varchar');


        //Definicion de la lista del resultado del query
        $this->captura('id_equipo','int4');
        $this->captura('tipo','varchar');
        $this->captura('marca','varchar');
        $this->captura('modelo','varchar');
        $this->captura('estado_fisico','varchar');
        $this->captura('estado','varchar');
        $this->captura('observaciones','varchar');
        $this->captura('color','varchar');
        $this->captura('imei','varchar');
        $this->captura('tamano_pantalla','varchar');
        $this->captura('tarjeta_video','varchar');
        $this->captura('teclado','varchar');
        $this->captura('procesador','varchar');
        $this->captura('memoria_ram','varchar');
        $this->captura('almacenamiento','varchar');
        $this->captura('sistema_operativo','varchar');
        $this->captura('accesorios','varchar');
        $this->captura('fnombre','varchar');
        $this->captura('fci','varchar');
        $this->captura('fcodigo','varchar');
        $this->captura('email_empresa','varchar');
        $this->captura('estado_reg','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //Devuelve la respuesta
        return $this->respuesta;
    }

    function recuperarDatosAsignacion(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='gecom.ft_equipo_sel';
        $this->transaccion='GC_TIPASI_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);

        //captura parametros adicionales para el count
        $this->setParametro('id_funcionario','id_funcionario','int4');
        $this->setParametro('id_funcionario_celular','id_funcionario_celular','int4');

        //Definicion de la lista del resultado del query
        $this->captura('solicitante','varchar');
        $this->captura('numero','varchar');
        $this->captura('marca','varchar');
        $this->captura('modelo','varchar');
        $this->captura('num_serie','varchar');
        $this->captura('imei','varchar');
        $this->captura('estado_fisico','varchar');
        $this->captura('observaciones','varchar');
        $this->captura('accesorios','varchar');
        $this->captura('telco','varchar');
        $this->captura('cuenta_telco','int4');
        $this->captura('cuenta_gasto','varchar');
        $this->captura('asignador','varchar');
        $this->captura('fecha_entrega','date');
        $this->captura('accesorios2','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //Devuelve la respuesta
        return $this->respuesta;
    }

    function recuperarDatosAsignacionEquipo(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='gecom.ft_equipo_sel';
        $this->transaccion='GC_TIPEQU_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);

        //captura parametros adicionales para el count
        $this->setParametro('id_funcionario','id_funcionario','int4');
        $this->setParametro('id_funcionario_celular','id_funcionario_celular','int4');

        //Definicion de la lista del resultado del query
        $this->captura('marca','varchar');
        $this->captura('codigo_inmovilizado','varchar');
        $this->captura('modelo','varchar');
        $this->captura('num_serie','varchar');
        $this->captura('procesador','varchar');
        $this->captura('estado_fisico','varchar');
        $this->captura('memoria_ram','varchar');
        $this->captura('almacenamiento','varchar');
        $this->captura('tamano_pantalla','varchar');
        $this->captura('observaciones','varchar');
        $this->captura('tarjeta_video','varchar');
        $this->captura('accesorios','varchar');
        $this->captura('solicitante','varchar');
        $this->captura('nombre_unidad','varchar');
        $this->captura('teclado','varchar');
        $this->captura('sistema_operativo','varchar');
        $this->captura('asignador','varchar');
        $this->captura('fecha_entrega','date');
        $this->captura('accesorios2','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //Devuelve la respuesta
        return $this->respuesta;
    }

            
}
?>