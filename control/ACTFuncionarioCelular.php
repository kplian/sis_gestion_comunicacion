<?php
/**
*@package pXP
*@file gen-ACTFuncionarioCelular.php
*@author  (jrivera)
*@date 24-07-2014 00:10:05
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTFuncionarioCelular extends ACTbase{    
			
	function listarFuncionarioCelular(){
		$this->objParam->defecto('ordenacion','id_funcionario');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODFuncionarioCelular','listarFuncionarioCelular');
		} else{
			$this->objFunc=$this->create('MODFuncionarioCelular');
			
			$this->res=$this->objFunc->listarFuncionarioCelular($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarFuncionarioCelular(){
		$this->objFunc=$this->create('MODFuncionarioCelular');	
		if($this->objParam->insertar('id_funcionario_celular')){
			$this->res=$this->objFunc->insertarFuncionarioCelular($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarFuncionarioCelular($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

    function insertarFuncionarioCelularMovil(){
        $this->objFunc=$this->create('MODFuncionarioCelular');
        if($this->objParam->insertar('id_funcionario_celular')){
            $this->res=$this->objFunc->insertarFuncionarioCelularMovil($this->objParam);
        } else{
            $this->res=$this->objFunc->modificarFuncionarioCelular($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
						
	function eliminarFuncionarioCelular(){
			$this->objFunc=$this->create('MODFuncionarioCelular');	
		$this->res=$this->objFunc->eliminarFuncionarioCelular($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

    function listarEquipoAsignado(){
        $this->objParam->defecto('ordenacion','id_funcionario_celular');

        $this->objParam->addFiltro(" (funcel.tipo_asignacion_equipo = ''equipo'' ) and e.tipo not in (''movil'',''dongle'',''gps'',''centel'') ");

        if($this->objParam->getParametro('id_funcionario')!=''){
            $this->objParam->addFiltro(" (funcel.id_funcionario = ".$this->objParam->getParametro('id_funcionario')." )");
        }

        $this->objParam->defecto('dir_ordenacion','asc');
        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODFuncionarioCelular','listarEquipoAsignado');
        } else{
            $this->objFunc=$this->create('MODFuncionarioCelular');

            $this->res=$this->objFunc->listarEquipoAsignado($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarNumeroAsignado(){
        $this->objParam->defecto('ordenacion','id_funcionario_celular');

        $this->objParam->addFiltro(" (e.tipo = ''movil'' or funcel.id_numero_celular is not null)");

        if($this->objParam->getParametro('id_funcionario')!=''){
            $this->objParam->addFiltro(" (funcel.id_funcionario = ".$this->objParam->getParametro('id_funcionario')." )");
        }

        $this->objParam->defecto('dir_ordenacion','asc');
        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODFuncionarioCelular','listarEquipoAsignado');
        } else{
            $this->objFunc=$this->create('MODFuncionarioCelular');

            $this->res=$this->objFunc->listarEquipoAsignado($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarUnidadOrganizacional(){

        // parametros de ordenacion por defecto
        $this->objParam->defecto('ordenacion','id_uo');
        $this->objParam->defecto('dir_ordenacion','asc');

        if ($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte=new Reporte($this->objParam, $this);
            $this->res=$this->objReporte->generarReporteListado('MODFuncionarioCelular','listarUnidadOrganizacional');
        }
        else {
            $this->objFunSeguridad=$this->create('MODFuncionarioCelular');
            //ejecuta el metodo de lista personas a travez de la intefaz objetoFunSeguridad
            $this->res=$this->objFunSeguridad->listarUnidadOrganizacional($this->objParam);

        }

        $respuesta = $this->res->getDatos();
        array_unshift ( $respuesta, array(  'id_uo'=>'-1',
            'nombre_unidad'=>'Todos',
            'codigo'=>'todos') );
        $this->res->setDatos($respuesta);

        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarFuncionario(){

        //el objeto objParam contiene todas la variables recibidad desde la interfaz

        // parametros de ordenacion por defecto
        $this->objParam->defecto('ordenacion','FUNCIO.id_funcionario');
        $this->objParam->defecto('dir_ordenacion','asc');
        $this->objParam->addFiltro("FUNCIO.estado_reg = ''activo''");



        //crea el objetoFunSeguridad que contiene todos los metodos del sistema de seguridad
        if ($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte=new Reporte($this->objParam, $this);
            $this->res=$this->objReporte->generarReporteListado('MODFuncionarioCelular','listarFuncionario');
        }
        else {
            $this->objFunSeguridad=$this->create('MODFuncionarioCelular');
            //ejecuta el metodo de lista funcionarios a travez de la intefaz objetoFunSeguridad
            $this->res=$this->objFunSeguridad->listarFuncionario($this->objParam);

        }

        //imprime respuesta en formato JSON para enviar lo a la interface (vista)
        $this->res->imprimirRespuesta($this->res->generarJson());



    }

			
}

?>