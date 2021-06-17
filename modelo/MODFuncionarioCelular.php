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
		/*$this->captura('id_funcionario_celular','int4');
		$this->captura('id_numero_celular','int4');*/
		$this->captura('id_funcionario','int4');
		$this->captura('id_cargo','int4');
        $this->captura('desc_funcionario1','text');
        $this->captura('nombre_cargo','varchar');
		/*$this->captura('fecha_inicio','date');
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
		


		$this->captura('numero','varchar');
		$this->captura('tipo','varchar');
        $this->captura('tipo_asignacion','varchar');
        $this->captura('id_equipo','int4');
        $this->captura('nombre','varchar');
        $this->captura('tipo_asignacion_equipo','varchar');
        $this->captura('codigo_inmovilizado','varchar');*/
		
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
        $this->setParametro('id_equipo','id_equipo','int4');
        $this->setParametro('codigo_inmovilizado','codigo_inmovilizado','varchar');
        $this->setParametro('tipo_asignacion_equipo','tipo_asignacion_equipo','varchar');
        $this->setParametro('tipo_servicio','tipo_servicio','varchar');
		$this->setParametro('id_accesorios','id_accesorios','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

    function insertarFuncionarioCelularMovil(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_funcionario_celular_ime';
        $this->transaccion='GC_FUNMOV_INS';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('id_numero_celular','id_numero_celular','int4');
        $this->setParametro('id_funcionario','id_funcionario','int4');
        $this->setParametro('id_cargo','id_cargo','int4');
        $this->setParametro('fecha_inicio','fecha_inicio','date');
        $this->setParametro('estado_reg','estado_reg','varchar');
        $this->setParametro('fecha_fin','fecha_fin','date');
        $this->setParametro('observaciones','observaciones','text');
        $this->setParametro('id_equipo','id_equipo','int4');
        $this->setParametro('codigo_inmovilizado','codigo_inmovilizado','varchar');
        $this->setParametro('tipo_asignacion_equipo','tipo_asignacion_equipo','varchar');
        $this->setParametro('tipo_servicio','tipo_servicio','varchar');
		$this->setParametro('id_accesorios','id_accesorios','varchar');

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
        $this->setParametro('id_equipo','id_equipo','int4');
        $this->setParametro('codigo_inmovilizado','codigo_inmovilizado','varchar');
        $this->setParametro('tipo_asignacion_equipo','tipo_asignacion_equipo','varchar');
        $this->setParametro('tipo_servicio','tipo_servicio','varchar');
		$this->setParametro('id_accesorios','id_accesorios','varchar');

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

    function listarEquipoAsignado(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='gecom.ft_funcionario_celular_sel';
        $this->transaccion='GC_FUNEQU_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        //Definicion de la lista del resultado del query
        $this->captura('id_funcionario_celular','int4');
        $this->captura('id_funcionario','int4');
        $this->captura('id_cargo','int4');
        $this->captura('estado_reg','varchar');
        $this->captura('id_equipo','int4');
        $this->captura('tipo_asignacion_equipo','varchar');
        $this->captura('id_numero_celular','int4');
        $this->captura('numero','varchar');
        $this->captura('nombre','varchar');
        $this->captura('codigo_inmovilizado','varchar');
        $this->captura('fecha_inicio','date');
        $this->captura('fecha_fin','date');
        $this->captura('tipo_asignacion','varchar');
        $this->captura('observaciones','text');
        $this->captura('id_usuario_reg','int4');
        $this->captura('fecha_reg','timestamp');
        $this->captura('id_usuario_mod','int4');
        $this->captura('fecha_mod','timestamp');
        $this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('tipo_servicio','varchar');
        $this->captura('tipo_servicio_desc','varchar');
		$this->captura('tipo_equipo','varchar');
		$this->captura('id_accesorios','varchar');
		$this->captura('desc_accesorios','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function listarUnidadOrganizacional(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_funcionario_celular_sel';// nombre procedimiento almacenado
        $this->transaccion='GC_FUNUNI_SEL';//nombre de la transaccion
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);

        //defino varialbes que se captran como retornod e la funcion
        $this->captura('id_uo','integer');
        $this->captura('nombre_unidad','varchar');
        $this->captura('codigo','varchar');

        //Ejecuta la funcion
        $this->armarConsulta();

        $this->ejecutarConsulta();
        return $this->respuesta;

    }

    function listarFuncionario(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='gecom.ft_funcionario_celular_sel';// nombre procedimiento almacenado
        $this->transaccion='GC_FUNUO_SEL';//nombre de la transaccion
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->setParametro('id_uo','id_uo','integer');
        $this->setParametro('id_tipo_empleados','id_tipo_empleados','integer');


        //Definicion de la lista del resultado del query

        //defino varialbes que se captran como retornod e la funcion

        $this->captura('id_funcionario','integer');
        $this->captura('codigo','varchar');
        $this->captura('estado_reg','varchar');
        $this->captura('fecha_reg','timestamp');
        $this->captura('id_persona','integer');
        $this->captura('id_usuario_reg','integer');
        $this->captura('fecha_mod','timestamp');
        $this->captura('id_usuario_mod','integer');
        $this->captura('email_empresa','varchar');
        $this->captura('interno','varchar');
        $this->captura('fecha_ingreso','date');
        $this->captura('desc_person','text');
        $this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('ci','varchar');
        $this->captura('num_documento','integer');
        $this->captura('telefono1','varchar');
        $this->captura('celular1','varchar');
        $this->captura('correo','varchar');
        $this->captura('telefono_ofi','varchar');
        $this->captura('antiguedad_anterior','integer');
        $this->captura('estado_civil','varchar');
        $this->captura('genero','varchar');
        $this->captura('fecha_nacimiento','date');
        $this->captura('id_lugar','integer');
        $this->captura('nombre_lugar','varchar');
        $this->captura('nacionalidad','varchar');
        $this->captura('discapacitado','varchar');
        $this->captura('carnet_discapacitado','varchar');
        $this->captura('id_auxiliar','integer');
        $this->captura('desc_auxiliar','varchar');
        $this->captura('profesion','varchar');
        $this->captura('codigo_rciva','varchar');
        $this->captura('fecha_quinquenio','date');
        $this->captura('foto','bytea','id_persona','extension','sesion','foto');
        $this->captura('nombre_archivo_foto','text');
        $this->captura('descripcion_cargo','varchar');
        $this->captura('id_uo','int4');

        //Ejecuta la funcion
        $this->armarConsulta();
        //echo $this->getConsulta(); exit;
        $this->ejecutarConsulta();
        return $this->respuesta;

    }
			
}
?>