<?php
/****************************************************************************************
*@package pXP
*@file gen-ACTEquipo.php
*@author  (ymedina)
*@date 06-05-2021 16:01:48
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                06-05-2021 16:01:48    ymedina             Creacion    
  #
*****************************************************************************************/
include_once(dirname(__FILE__).'/../../lib/lib_general/ExcelInput.php');
require_once(dirname(__FILE__).'/../reportes/RFormularioAsignacionXls.php');
require_once(dirname(__FILE__).'/../reportes/RFormularioMovilXls.php');
require_once(dirname(__FILE__).'/../reportes/RFormAsignacion.php');
require_once(dirname(__FILE__).'/../reportes/RFormEquipo.php');

class ACTEquipo extends ACTbase{    
            
    function listarEquipo(){
		$this->objParam->defecto('ordenacion','id_equipo');

        if($this->objParam->getParametro('tipo')!='') {
            if($this->objParam->getParametro('tipo')=='otros') {
                $this->objParam->addFiltro(" equ.tipo not in (''movil'',''dongle'',''gps'',''centel'') ");
            }else{
                $this->objParam->addFiltro(" equ.tipo in (''movil'',''dongle'',''gps'',''centel'')  ");
            }
        }

        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODEquipo','listarEquipo');
        } else{
        	$this->objFunc=$this->create('MODEquipo');
            
        	$this->res=$this->objFunc->listarEquipo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarEquipoMovil(){
        $this->objParam->defecto('ordenacion','id_equipo');

        $this->objParam->addFiltro(" equ.tipo in (''movil'',''dongle'',''gps'',''centel'')  ");

        $this->objParam->defecto('dir_ordenacion','asc');
        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODEquipo','listarEquipo');
        } else{
            $this->objFunc=$this->create('MODEquipo');

            $this->res=$this->objFunc->listarEquipo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarEquipoPc(){
        $this->objParam->defecto('ordenacion','id_equipo');


        $this->objParam->addFiltro(" equ.tipo not in (''movil'',''dongle'',''gps'',''centel'') ");


        $this->objParam->defecto('dir_ordenacion','asc');
        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODEquipo','listarEquipo');
        } else{
            $this->objFunc=$this->create('MODEquipo');

            $this->res=$this->objFunc->listarEquipo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarEquipoCombo(){
        $this->objParam->defecto('ordenacion','id_equipo');

        if($this->objParam->getParametro('tipo_movil')!='') {
            if($this->objParam->getParametro('tipo_movil')=='SI'){
                $this->objParam->addFiltro(" equ.tipo in (''movil'',''dongle'',''gps'',''centel'') and equ.id_numero_celular is null ");
            }elseif ($this->objParam->getParametro('tipo_movil')=='NO'){
                $this->objParam->addFiltro(" equ.tipo not in (''movil'',''dongle'',''gps'',''centel'') and equ.id_numero_celular is null ");
            }
        }

        if ($this->objParam->getParametro('tipo_servi') != '') {
            $this->objParam->addFiltro("equ.tipo_servicio = ''". $this->objParam->getParametro('tipo_servi')."'' ");
        }

        if ($this->objParam->getParametro('tipo_equ') != '') {
            $this->objParam->addFiltro("equ.tipo = ''". $this->objParam->getParametro('tipo_equ')."'' ");
        }

        $this->objParam->defecto('dir_ordenacion','asc');
        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODEquipo','listarEquipo');
        } else{
            $this->objFunc=$this->create('MODEquipo');

            $this->res=$this->objFunc->listarEquipoCombo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarEquipo(){
        $this->objFunc=$this->create('MODEquipo');    
        if($this->objParam->insertar('id_equipo')){
            $this->res=$this->objFunc->insertarEquipo($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarEquipo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarEquipo(){
        	$this->objFunc=$this->create('MODEquipo');    
        $this->res=$this->objFunc->eliminarEquipo($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function retornarEquipo(){
        $this->objFunc=$this->create('MODEquipo');
        $this->res=$this->objFunc->retornarEquipo($this->objParam);

        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function cambioEquipo(){
        $this->objFunc=$this->create('MODEquipo');
        $this->res=$this->objFunc->cambioEquipo($this->objParam);

        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function reportesEquipo()
    {
        $nombreArchivo = uniqid(md5(session_id()) . 'Bitacora') . '.xls';

        if($this->objParam->getParametro('tipo_reporte')=='Formulario'){
            $dataSource = $this->recuperarDatos();
        }

        //parametros basicos
        $tamano = 'LETTER';
        $orientacion = 'L';
        $titulo = 'Bitacora';

        $this->objParam->addParametro('orientacion', $orientacion);
        $this->objParam->addParametro('tamano', $tamano);
        $this->objParam->addParametro('titulo_archivo', $titulo);
        $this->objParam->addParametro('nombre_archivo', $nombreArchivo);

        if($this->objParam->getParametro('tipo_reporte')=='Formulario'){
            $reporte = new RFormularioAsignacionXls($this->objParam);
            $reporte->setFechas($this->objParam->getParametro('desde'),$this->objParam->getParametro('hasta'));
        }

        $reporte->datosHeader($dataSource->getDatos(), $this->objParam->getParametro('desde'));
        $reporte->generarReporte();

        $this->mensajeExito = new Mensaje();
        $this->mensajeExito->setMensaje('EXITO', 'Reporte.php', 'Reporte generado', 'Se generó con éxito el reporte: ' . $nombreArchivo, 'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());

    }

    function recuperarDatos()
    {
        $this->objFunc = $this->create('MODEquipo');
        $cbteHeader = $this->objFunc->recuperarDatos($this->objParam);
        if ($cbteHeader->getTipo() == 'EXITO') {
            return $cbteHeader;
        } else {
            $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
            exit;
        }
    }

    function reporteFuncionario() {

        $nombreArchivo = uniqid(md5(session_id()) . 'Bitacora') . '.xls';
        $reporte = null;
        //var_dump('yamil',$this->objParam); exit();
        /*if($this->objParam->getParametro('tipo')=='asignacion'){
            $dataSource = $this->recuperarDatos();
        }elseif($this->objParam->getParametro('tipo')=='devolucion'){
            $dataSource = $this->recuperarDatos();
        }*/

        //$this->objParam->addParametro('tipo', 'movil');

        $dataSource = $this->recuperarDatosAsignacion();

        //parametros basicos
        $tamano = 'LETTER';
        $orientacion = 'L';
        $titulo = 'Bitacora';

        $this->objParam->addParametro('orientacion', $orientacion);
        $this->objParam->addParametro('tamano', $tamano);
        $this->objParam->addParametro('titulo_archivo', $titulo);
        $this->objParam->addParametro('nombre_archivo', $nombreArchivo);

        if($this->objParam->getParametro('tipo')=='asignacion'){
            $reporte = new RFormularioMovilXls($this->objParam);
            $reporte->setFechas($this->objParam->getParametro('desde'),$this->objParam->getParametro('hasta'));
        }elseif($this->objParam->getParametro('tipo')=='devolucion'){
            $reporte = new RFormularioMovilXls($this->objParam);
            $reporte->setFechas($this->objParam->getParametro('desde'),$this->objParam->getParametro('hasta'));
        }

        $reporte->datosHeader($dataSource->getDatos(), null);
        $reporte->generarReporte();

        $this->mensajeExito = new Mensaje();
        $this->mensajeExito->setMensaje('EXITO', 'Reporte.php', 'Reporte generado', 'Se generó con éxito el reporte: ' . $nombreArchivo, 'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
    }

    function reporteFuncionarioPDF() {


        $this->objParam->addParametro('tipo', 'movil');

        $dataSource = $this->recuperarDatosAsignacion();

        $nombreArchivo = uniqid(md5(session_id()).'-REPCC') . '.pdf';
        $tamano = 'LETTER';
        $orientacion = 'P';
        $this->objParam->addParametro('orientacion',$orientacion);
        $this->objParam->addParametro('tamano',$tamano);
        $this->objParam->addParametro('titulo_archivo','Curriculum');
        $this->objParam->addParametro('datos_persona',$dataSource->getDatos());

        var_dump('yamil',$dataSource);

        $reporte = new RFormAsignacion($this->objParam);
        $reporte->datosHeader($this->objParam);
        $reporte->generarReporte1($this->objParam);
        $reporte->output($reporte->url_archivo,'F');

        $mensajeExito = new Mensaje();
        $mensajeExito->setMensaje('EXITO', 'Reporte.php', 'Reporte generado', 'Se generó con éxito el reporte: ' . $nombreArchivo, 'control');
        $mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->res = $mensajeExito;
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function reporteFuncionarioDos() {

        $datosPersona = $this->recuperarDatosAsignacion();


        $nombreArchivo = uniqid(md5(session_id()).'-REPCC') . '.pdf';
        $tamano = 'LETTER';
        $orientacion = 'P';
        $this->objParam->addParametro('orientacion',$orientacion);
        $this->objParam->addParametro('tamano',$tamano);
        $this->objParam->addParametro('titulo_archivo','Formulario');
        $this->objParam->addParametro('nombre_archivo',$nombreArchivo);
        $this->objParam->addParametro('datos_persona',$datosPersona->getDatos());

        $reporte = new RFormAsignacion($this->objParam);
        $reporte->datosHeader($this->objParam);
        $reporte->generarReporte1($this->objParam);
        $reporte->output($reporte->url_archivo,'F');

        $mensajeExito = new Mensaje();
        $mensajeExito->setMensaje('EXITO', 'Reporte.php', 'Reporte generado', 'Se generó con éxito el reporte: ' . $nombreArchivo, 'control');
        $mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->res = $mensajeExito;
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function reporteFuncionarioTres() {

        $datosPersona = $this->recuperarDatosAsignacionEquipo();


        $nombreArchivo = uniqid(md5(session_id()).'-REPCC') . '.pdf';
        $tamano = 'LETTER';
        $orientacion = 'P';
        $this->objParam->addParametro('orientacion',$orientacion);
        $this->objParam->addParametro('tamano',$tamano);
        $this->objParam->addParametro('titulo_archivo','Formulario');
        $this->objParam->addParametro('nombre_archivo',$nombreArchivo);
        $this->objParam->addParametro('datos_persona',$datosPersona->getDatos());

        $reporte = new RFormEquipo($this->objParam);
        $reporte->datosHeader($this->objParam);
        $reporte->generarReporte1($this->objParam);
        $reporte->output($reporte->url_archivo,'F');

        $mensajeExito = new Mensaje();
        $mensajeExito->setMensaje('EXITO', 'Reporte.php', 'Reporte generado', 'Se generó con éxito el reporte: ' . $nombreArchivo, 'control');
        $mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->res = $mensajeExito;
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function recuperarDatosAsignacion()
    {
        $this->objFunc = $this->create('MODEquipo');
        $cbteHeader = $this->objFunc->recuperarDatosAsignacion($this->objParam);
        if ($cbteHeader->getTipo() == 'EXITO') {
            return $cbteHeader;
        } else {
            $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
            exit;
        }
    }

    function recuperarDatosAsignacionEquipo()
    {
        $this->objFunc = $this->create('MODEquipo');
        $cbteHeader = $this->objFunc->recuperarDatosAsignacionEquipo($this->objParam);
        if ($cbteHeader->getTipo() == 'EXITO') {
            return $cbteHeader;
        } else {
            $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
            exit;
        }
    }
            
}

?>