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
require_once(dirname(__FILE__).'/../reportes/RFormularioFuncionarioXls.php');
require_once(dirname(__FILE__).'/../reportes/RFormularioRegistroDispositivosXls.php');

require_once(dirname(__FILE__).'/../reportes/RFormularioR510Xls.php');
require_once(dirname(__FILE__).'/../reportes/RFormularioR511Xls.php');
require_once(dirname(__FILE__).'/../reportes/RFormularioR512Xls.php');
require_once(dirname(__FILE__).'/../reportes/RFormularioR513Xls.php');
require_once(dirname(__FILE__).'/../reportes/RFormularioR515Xls.php');

require_once(dirname(__FILE__).'/../reportes/RFormularioR510Pdf.php');
require_once(dirname(__FILE__).'/../reportes/RFormularioR511Pdf.php');
require_once(dirname(__FILE__).'/../reportes/RFormularioR512Pdf.php');
require_once(dirname(__FILE__).'/../reportes/RFormularioR513Pdf.php');
require_once(dirname(__FILE__).'/../reportes/RFormularioR514Pdf.php');
require_once(dirname(__FILE__).'/../reportes/RFormularioR515Pdf.php');

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
        if($this->objParam->getParametro('formato_reporte')=='pdf'){
            $nombreArchivo = uniqid(md5(session_id()).'Bitacora') . '.pdf';
        }
        else{
            $nombreArchivo = uniqid(md5(session_id()).'Bitacora') . '.xls';
        }

        if($this->objParam->getParametro('tipo_reporte')=='Formulario'){
            $dataSource = $this->recuperarDatos();
        }elseif ($this->objParam->getParametro('tipo_reporte')=='Equipos Persona'){
            $dataSource = $this->recuperarDatosFuncionario();
        }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-510 Registro de computador portatil'){
            $dataSource = $this->recuperarDatos510();
        }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-511 Registro de cpu y monitor'){
            $dataSource = $this->recuperarDatos511();
        }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-512 Registro de accesorios adicionales'){
            $dataSource = $this->recuperarDatos512();
        }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-513 Registro de telefono IP'){
            $dataSource = $this->recuperarDatos513();
        }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-514 Registro de dispositivos moviles'){
            $dataSource = $this->recuperarDatosDispositivosMoviles();
        }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-515 Registro de lineas corporativas'){
            $dataSource = $this->recuperarDatos515();
        }

        //parametros basicos
        $tamano = 'A3';
        $orientacion = 'L';
        $titulo = 'Bitacora';

        $this->objParam->addParametro('orientacion', $orientacion);
        $this->objParam->addParametro('tamano', $tamano);
        $this->objParam->addParametro('titulo_archivo', $titulo);
        $this->objParam->addParametro('nombre_archivo', $nombreArchivo);

        if($this->objParam->getParametro('formato_reporte')=='pdf'){
            if($this->objParam->getParametro('tipo_reporte')=='5-R-510 Registro de computador portatil'){
                $reporte = new RFormularioR510Pdf($this->objParam);
            }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-511 Registro de cpu y monitor'){
                $reporte = new RFormularioR511Pdf($this->objParam);
            }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-512 Registro de accesorios adicionales'){
                $reporte = new RFormularioR512Pdf($this->objParam);
            }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-513 Registro de telefono IP'){
                $tamano = 'LETTER';
                $this->objParam->addParametro('tamano', $tamano);

                $reporte = new RFormularioR513Pdf($this->objParam);
            }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-514 Registro de dispositivos moviles'){
                $reporte = new RFormularioR514Pdf($this->objParam);
            }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-515 Registro de lineas corporativas'){
                $reporte = new RFormularioR515Pdf($this->objParam);
            }

            //$reporte = new RFormularioR514Pdf($this->objParam);
            $reporte->datosHeader($dataSource->getDatos());
            $reporte->generarReporte();
            $reporte->output($reporte->url_archivo,'F');

        }else{
            if($this->objParam->getParametro('tipo_reporte')=='Formulario'){
                $reporte = new RFormularioAsignacionXls($this->objParam);
                $reporte->setFechas($this->objParam->getParametro('desde'),$this->objParam->getParametro('hasta'));
            }elseif ($this->objParam->getParametro('tipo_reporte')=='Equipos Persona'){
                $reporte = new RFormularioFuncionarioXls($this->objParam);
                $reporte->setFechas($this->objParam->getParametro('desde'),$this->objParam->getParametro('hasta'));
            }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-510 Registro de computador portatil'){
                $reporte = new RFormularioR510Xls($this->objParam);
                $reporte->setFechas($this->objParam->getParametro('desde'),$this->objParam->getParametro('hasta'));
            }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-511 Registro de cpu y monitor'){
                $reporte = new RFormularioR511Xls($this->objParam);
                $reporte->setFechas($this->objParam->getParametro('desde'),$this->objParam->getParametro('hasta'));
            }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-512 Registro de accesorios adicionales'){
                $reporte = new RFormularioR512Xls($this->objParam);
                $reporte->setFechas($this->objParam->getParametro('desde'),$this->objParam->getParametro('hasta'));
            }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-513 Registro de telefono IP'){
                $reporte = new RFormularioR513Xls($this->objParam);
                $reporte->setFechas($this->objParam->getParametro('desde'),$this->objParam->getParametro('hasta'));
            }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-514 Registro de dispositivos moviles'){
                $reporte = new RFormularioRegistroDispositivosXls($this->objParam);
                $reporte->setFechas($this->objParam->getParametro('desde'),$this->objParam->getParametro('hasta'));
            }elseif ($this->objParam->getParametro('tipo_reporte')=='5-R-515 Registro de lineas corporativas'){
                $reporte = new RFormularioR515Xls($this->objParam);
                $reporte->setFechas($this->objParam->getParametro('desde'),$this->objParam->getParametro('hasta'));
            }

            $reporte->datosHeader($dataSource->getDatos(), $this->objParam->getParametro('desde'));
            $reporte->generarReporte();
        }


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

    function recuperarDatosFuncionario()
    {
        $this->objFunc = $this->create('MODEquipo');
        $cbteHeader = $this->objFunc->recuperarDatosFuncionario($this->objParam);
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

        $reporte = null;

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

    function recuperarDatosDispositivosMoviles()
    {
        $this->objFunc = $this->create('MODEquipo');
        $cbteHeader = $this->objFunc->recuperarDatosDispositivosMoviles($this->objParam);
        if ($cbteHeader->getTipo() == 'EXITO') {
            return $cbteHeader;
        } else {
            $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
            exit;
        }
    }

    function recuperarDatos510()
    {
        $this->objFunc = $this->create('MODEquipo');
        $cbteHeader = $this->objFunc->recuperarDatos510($this->objParam);
        if ($cbteHeader->getTipo() == 'EXITO') {
            return $cbteHeader;
        } else {
            $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
            exit;
        }
    }

    function recuperarDatos511()
    {
        $this->objFunc = $this->create('MODEquipo');
        $cbteHeader = $this->objFunc->recuperarDatos511($this->objParam);
        if ($cbteHeader->getTipo() == 'EXITO') {
            return $cbteHeader;
        } else {
            $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
            exit;
        }
    }

    function recuperarDatos512()
    {
        $this->objFunc = $this->create('MODEquipo');
        $cbteHeader = $this->objFunc->recuperarDatos512($this->objParam);
        if ($cbteHeader->getTipo() == 'EXITO') {
            return $cbteHeader;
        } else {
            $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
            exit;
        }
    }

    function recuperarDatos513()
    {
        $this->objFunc = $this->create('MODEquipo');
        $cbteHeader = $this->objFunc->recuperarDatos513($this->objParam);
        if ($cbteHeader->getTipo() == 'EXITO') {
            return $cbteHeader;
        } else {
            $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
            exit;
        }
    }

    function recuperarDatos515()
    {
        $this->objFunc = $this->create('MODEquipo');
        $cbteHeader = $this->objFunc->recuperarDatos515($this->objParam);
        if ($cbteHeader->getTipo() == 'EXITO') {
            return $cbteHeader;
        } else {
            $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
            exit;
        }
    }


}

?>