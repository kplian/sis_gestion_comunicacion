<?php
/****************************************************************************************
*@package pXP
*@file gen-ACTAccesorio.php
*@author  (ymedina)
*@date 29-05-2021 16:19:41
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                29-05-2021 16:19:41    ymedina             Creacion    
  #
*****************************************************************************************/
include_once(dirname(__FILE__).'/../../lib/lib_general/ExcelInput.php');
require_once(dirname(__FILE__).'/../reportes/RFormAccesorio.php');

class ACTAccesorio extends ACTbase{    
            
    function listarAccesorio(){
		$this->objParam->defecto('ordenacion','id_accesorio');

        if($this->objParam->getParametro('id_equipo')!=''){
            $this->objParam->addFiltro(" acc.id_equipo = ".$this->objParam->getParametro('id_equipo'));
        }
		
		if($this->objParam->getParametro('disponibles')!='' && $this->objParam->getParametro('disponibles') == 'SI'){
			//var_dump('yamil',$this->objParam); exit();
			/*if($this->objParam->getParametro('id_equip')!=''){
				$this->objParam->addFiltro(" (acc.id_equipo = ".$this->objParam->getParametro('id_equip')." OR acc.id_equipo IS NULL) ");
			}else{
				$this->objParam->addFiltro(" acc.id_equipo is null");
			}*/

            $this->objParam->addFiltro(" acc.id_accesorio not in (select fa.id_accesorio from gecom.tfuncionario_accesorio fa where fa.estado_reg = ''activo'' ) ");
            $this->objParam->addFiltro(" acc.id_equipo is null");
        }

        if($this->objParam->getParametro('tipo_equipo')!=''){
            if($this->objParam->getParametro('tipo_equipo') =='movil'){
                $this->objParam->addFiltro(" acc.tipo in (''cargador_movil'',''cable_datos'',''manos_libres'',''otro_movil'') ");
            }else{
                $this->objParam->addFiltro(" acc.tipo in (''codigo'', ''cargador'', ''mochila'', ''mouse'', ''monitor'', ''headset'', 
                        ''adaptadormulti'', ''adaptadorred'', ''dockingstation'', ''baselaptop'', ''lector'', ''lectorbarras'', ''parlantes'', 
                        ''regleta'', ''switch'', ''discoduro'', ''jabra'', ''camaraweb'', ''microfono'', ''hubusb'',''otro_equipo'') ");
            }
        }

        if($this->objParam->getParametro('tipo_accesorio')!=''){
            $this->objParam->addFiltro(" acc.tipo = ''".$this->objParam->getParametro('tipo_accesorio')."'' ");
        }

        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODAccesorio','listarAccesorio');
        } else{
        	$this->objFunc=$this->create('MODAccesorio');
            
        	$this->res=$this->objFunc->listarAccesorio($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarAccesorioFuncionario(){
        $this->objParam->defecto('ordenacion','id_accesorio');

        /*if($this->objParam->getParametro('id_equipo')!=''){
            $this->objParam->addFiltro(" acc.id_equipo = ".$this->objParam->getParametro('id_equipo'));
        }*/

        if($this->objParam->getParametro('id_funcionario_celular')!=''){
            $this->objParam->addFiltro(" fa.id_funcionario_celular = ".$this->objParam->getParametro('id_funcionario_celular'));
        }

        if($this->objParam->getParametro('disponibles')!='' && $this->objParam->getParametro('disponibles') == 'SI'){
            //var_dump('yamil',$this->objParam); exit();
            if($this->objParam->getParametro('id_equip')!=''){
                $this->objParam->addFiltro(" (acc.id_equipo = ".$this->objParam->getParametro('id_equip')." OR acc.id_equipo IS NULL) ");
            }else{
                $this->objParam->addFiltro(" acc.id_equipo is null");
            }

        }

        if($this->objParam->getParametro('tipo_equipo')!=''){
            if($this->objParam->getParametro('tipo_equipo') =='movil'){
                $this->objParam->addFiltro(" acc.tipo in (''cargador_movil'',''cable_datos'',''manos_libres'',''otro_movil'') ");
            }else{
                $this->objParam->addFiltro(" acc.tipo in (''codigo'', ''cargador'', ''mochila'', ''mouse'', ''monitor'', ''headset'', 
                        ''adaptadormulti'', ''adaptadorred'', ''dockingstation'', ''baselaptop'', ''lector'', ''lectorbarras'', ''parlantes'', 
                        ''regleta'', ''switch'', ''discoduro'', ''jabra'', ''camaraweb'', ''microfono'', ''hubusb'',''otro_equipo'') ");
            }
        }

        $this->objParam->defecto('dir_ordenacion','asc');
        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODAccesorio','listarAccesorioFuncionario');
        } else{
            $this->objFunc=$this->create('MODAccesorio');

            $this->res=$this->objFunc->listarAccesorioFuncionario($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarAccesorioMovil(){
        $this->objParam->defecto('ordenacion','id_accesorio');

        $this->objParam->addFiltro(" acc.tipo in (''cargador_movil'',''cable_datos'',''manos_libres'',''otro_movil'') ");

        if($this->objParam->getParametro('id_equipo')!=''){
            $this->objParam->addFiltro(" acc.id_equipo = ".$this->objParam->getParametro('id_equipo'));
        }

        if($this->objParam->getParametro('disponibles')!='' && $this->objParam->getParametro('disponibles') == 'SI'){
            //var_dump('yamil',$this->objParam); exit();
            if($this->objParam->getParametro('id_equip')!=''){
                $this->objParam->addFiltro(" (acc.id_equipo = ".$this->objParam->getParametro('id_equip')." OR acc.id_equipo IS NULL) ");
            }else{
                $this->objParam->addFiltro(" acc.id_equipo is null");
            }

        }

        $this->objParam->defecto('dir_ordenacion','asc');
        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODAccesorio','listarAccesorio');
        } else{
            $this->objFunc=$this->create('MODAccesorio');

            $this->res=$this->objFunc->listarAccesorio($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarAccesorioEscritorio(){
        $this->objParam->defecto('ordenacion','id_accesorio');

        $this->objParam->addFiltro(" acc.tipo in (''codigo'', ''cargador'', ''mochila'', ''mouse'', ''monitor'', ''headset'', 
                        ''adaptadormulti'', ''adaptadorred'', ''dockingstation'', ''baselaptop'', ''lector'', ''lectorbarras'', ''parlantes'', 
                        ''regleta'', ''switch'', ''discoduro'', ''jabra'', ''camaraweb'', ''microfono'', ''hubusb'',''otro_equipo'') ");

        if($this->objParam->getParametro('id_equipo')!=''){
            $this->objParam->addFiltro(" acc.id_equipo = ".$this->objParam->getParametro('id_equipo'));
        }

        if($this->objParam->getParametro('disponibles')!='' && $this->objParam->getParametro('disponibles') == 'SI'){
            //var_dump('yamil',$this->objParam); exit();
            if($this->objParam->getParametro('id_equip')!=''){
                $this->objParam->addFiltro(" (acc.id_equipo = ".$this->objParam->getParametro('id_equip')." OR acc.id_equipo IS NULL) ");
            }else{
                $this->objParam->addFiltro(" acc.id_equipo is null");
            }

        }

        $this->objParam->defecto('dir_ordenacion','asc');
        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODAccesorio','listarAccesorio');
        } else{
            $this->objFunc=$this->create('MODAccesorio');

            $this->res=$this->objFunc->listarAccesorio($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarAccesorio(){
        $this->objFunc=$this->create('MODAccesorio');    
        if($this->objParam->insertar('id_accesorio')){
            $this->res=$this->objFunc->insertarAccesorio($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarAccesorio($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarAccesorio(){
        $this->objFunc=$this->create('MODAccesorio');
        $this->res=$this->objFunc->eliminarAccesorio($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function reporteAccesorio(){

        $datosPersona = $this->recuperarDatosAccesorio();

        $nombreArchivo = uniqid(md5(session_id()).'-REPCC') . '.pdf';
        $tamano = 'LETTER';
        $orientacion = 'P';
        $this->objParam->addParametro('orientacion',$orientacion);
        $this->objParam->addParametro('tamano',$tamano);
        $this->objParam->addParametro('titulo_archivo','Formulario');
        $this->objParam->addParametro('nombre_archivo',$nombreArchivo);
        $this->objParam->addParametro('datos_persona',$datosPersona->getDatos());

        $reporte = null;

        $reporte = new RFormAccesorio($this->objParam);
        $reporte->datosHeader($this->objParam);
        $reporte->generarReporte1($this->objParam);
        $reporte->output($reporte->url_archivo,'F');

        $mensajeExito = new Mensaje();
        $mensajeExito->setMensaje('EXITO', 'Reporte.php', 'Reporte generado', 'Se generó con éxito el reporte: ' . $nombreArchivo, 'control');
        $mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->res = $mensajeExito;
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function recuperarDatosAccesorio()
    {
        $this->objFunc = $this->create('MODAccesorio');
        $cbteHeader = $this->objFunc->recuperarDatosAccesorio($this->objParam);
        if ($cbteHeader->getTipo() == 'EXITO') {
            return $cbteHeader;
        } else {
            $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
            exit;
        }
    }

    function insertarAccesorioFuncionario(){
        $this->objFunc=$this->create('MODAccesorio');
        $this->res=$this->objFunc->insertarAccesorioFuncionario($this->objParam);

        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function eliminarAccesorioFuncionario(){
        $this->objFunc=$this->create('MODAccesorio');
        $this->res=$this->objFunc->eliminarAccesorio($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function retornarAccesorio(){
        $this->objFunc=$this->create('MODAccesorio');
        $this->res=$this->objFunc->retornarAccesorio($this->objParam);

        $this->res->imprimirRespuesta($this->res->generarJson());
    }

            
}

?>