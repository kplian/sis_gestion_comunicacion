<?php
// Extend the TCPDF class to create custom MultiRow
class RFormEquipo extends  ReportePDF {
    var $cabecera;
    var $detalleCbte;
    var $ancho_hoja;
    var $gerencia;
    var $numeracion;
    var $ancho_sin_totales;
    var $cantidad_columnas_estaticas;
    var $total;
    var $with_col;
    var $datos_proyecto;
    var $datos_idiomas ;
    var $datos_persona ;
    var $datos_estudio ;
    var $datos_allegado ;
    var $datos_experiencia;
    var $datos_competencia;
    var $datos_residencia;
    var $datos_estructura;
    var $num_form;
    var $imagenes;
    var $host;
    function datosHeader ( $detalle) {
        $this->SetMargins(16, 30, 16);
        $this->datos_proyecto = $detalle->getParametro('datos_proyecto');
        $this->datos_idiomas = $detalle->getParametro('datos_idiomas');
        $this->datos_persona = $detalle->getParametro('datos_persona');
        $this->datos_estudio = $detalle->getParametro('datos_estudio');
        $this->datos_allegado = $detalle->getParametro('datos_allegado');
        $this->datos_experiencia = $detalle->getParametro('datos_experiencia');
        $this->datos_competencia = $detalle->getParametro('datos_competencia');
        $this->datos_residencia = $detalle->getParametro('datos_residencia');
        $this->datos_estructura = $detalle->getParametro('tipo');
		$this->tipo_equipo = $detalle->getParametro('tipo_equipo');
		$this->datos_mensaje = '';
		$this->datos_mensaje_1 = '';
		$this->recomendaciones_1 = '';
		$this->recomendaciones_2 = '';

        //$this->imagenes = 'http://172.18.79.207/ymedinaetr/sis_seguridad/control/foto_persona/ActionObtenerFoto.php?file='.$this->datos_persona[0]['nombre_archivo_foto'];
        ob_start();
        //include_once(dirname(__FILE__).'/../../lib/lib_general/ExcelInput.php');
        header( "Content-type: image/jpeg" );
        include(dirname(__FILE__).'/../../sis_seguridad/control/foto_persona/ActionObtenerFoto.php');
        $this->imagenes = ob_get_clean();
        //$files = glob(dirname(__DIR__) . '/../../../' . $_SESSION['_FOLDER_FOTOS_PERSONA'] . '/' . $filename . '.*');
        //var_dump('datos_ejecucion', $files);
        $this->host  = $_SERVER['HTTP_HOST'].'/'.strtok(dirname($_SERVER['PHP_SELF']), "/");
        //var_dump('YAMILLLLLL ',  $this->host);

        $this->SetHeaderMargin(15); //margen top header

    }

    function Header() {
        $this->Ln(3);

        //cabecera del reporte
        $this->Image(dirname(__FILE__).'/../../lib/imagenes/logos/logo.jpg', 10,5,35,20);
        $this->ln(5);

        $this->SetFont('','B',15);
		
		if($this->tipo_equipo == 'laptop'){
            if ($this->datos_estructura == 'asignacion'){
				$this->datos_estructura = "ASIGNACION DE COMPUTADOR PORTATIL";
				$this->num_form = "5-R-502/0";
				$this->datos_mensaje_1 = "A partir de la fecha de asignación, el RECEPTOR se hace UNICO RESPONSABLE del equipo y accesorios que se le entrega bajo este documento.";
				$this->datos_mensaje = "<b>Importante: </b>En caso de pérdida del equipo debe reportarse a Departamento de Tecnologías de Información, posteriormente el equipo debe ser repuesto con uno de caraterísticas iguales o superiores, de igual forma en caso de daño al equipo o sus accesorios.";
				$this->recomendaciones_1 = "Recomendaciones generales en cuanto a cobertura del Seguro:";
				$this->recomendaciones_2 = "- Estos equipos pueden ser  trasladados de un lugar a otro, porque son considerados móviles y/o portátiles y cuentan con cobertura de seguro ante posibles daños; pero se deben tomar las medidas de seguridad necesarias para su resguardo y protección; como cualquier otro bien que la Empresa pone a disposición de su personal.<br>".
					"- En circunstancias donde las computadoras fueran robadas, encontrándose en el interior de un vehículo, lamentablemente la Póliza de Seguro no podrá ser activada, porque queda excluida de la cobertura de robos cuando las pérdidas de los bienes se hallen descuidados y/o abandonados, en cualquier lugar , incluyendo el interior de vehículos motorizados, aun cuando sea dejado por breves minutos. Así mismo si se deja por descuido dentro de un taxi, trufi, transporte público, restaurantes, entre otros.<br>".
					"- En circunstancias de que pueda ser robada del interior de su vivienda, se debe realizar la respectiva denuncia a la FELCC, documento imprescindible para realizar las gestiones con la Cía. De Seguros para la reposición de la computadora portátil.<br><br>".
					"Ante cualquier daño y/o problema de este tipo, agradeceremos comunicarse con el Depto. de Tecnologías de Información.";
			}else if($this->datos_estructura == 'devolucion'){
				$this->datos_estructura = "DEVOLUCION DE COMPUTADOR PORTATIL";
				$this->num_form = "5-R-503/0";
				$this->datos_mensaje_1 = "";
				$this->datos_mensaje = "A partir de la fecha de devolución, el usuario se deslinda de las responsabilidades sobre el equipo informatico";
				$this->recomendaciones_1 = "";
				$this->recomendaciones_2 = '';
			}
        }elseif($this->tipo_equipo == 'pc'){
            if ($this->datos_estructura == 'asignacion'){
				$this->datos_estructura = "ASIGNACION COMPUTADOR DE ESCRITORIO";
				$this->num_form = "5-R-504/0";
				$this->datos_mensaje = "<b>Importante: </b>En caso de el equipo presente fallos en su funcionamiento, ya sea hardware y/o software, debe reportarse a Departamento de Tecnologías de Información, via mail o sistema de soporte de Ende Transmision S.A.";
				$this->datos_mensaje_1 = "A partir de la fecha de asignación, el RECEPTOR se hace UNICO RESPONSABLE del equipo y accesorios que se le entrega bajo este documento.";
			}else if($this->datos_estructura == 'devolucion'){
				$this->datos_estructura = "DEVOLUCION COMPUTADOR DE ESCRITORIO";
				$this->num_form = "5-R-505/0";
				$this->datos_mensaje = "<b>Importante: </b>A partir de la fecha de devolución, el usuario se deslinda de las responsabilidades del equipo estacionario. ";
				$this->datos_mensaje_1 = "";
			}
        }else{//if($this->tipo_equipo == 'telfip'){
            if ($this->datos_estructura == 'asignacion'){
				$this->datos_estructura = "ASIGNACION TELEFONO IP";
				$this->num_form = "5-R-508/0";
				$this->datos_mensaje = "<b>Importante: </b>En caso de el equipo presente fallos en su funcionamiento, ya sea hardware y/o software, debe reportarse a Departamento de Tecnologías de Información, via mail o sistema de soporte de Ende Transmision S.A.";
				$this->datos_mensaje_1 = "A partir de la fecha de asignación, el RECEPTOR se hace UNICO RESPONSABLE del equipo de comunicación y accesorios que se le entrega bajo este documento.";
			}else if($this->datos_estructura == 'devolucion'){
				$this->datos_estructura = "DEVOLUCION TELEFONO IP";
				$this->num_form = "5-R-509/0";
				$this->datos_mensaje = "<b>Importante: </b>A partir de la fecha de devolución, el usuario se deslinda de las responsabilidades sobre el equipo de comunicación. ";
				$this->datos_mensaje_1 = "";
			}
        }

    }

    function generarReporte1() {

        $this->AddPage();

        $with_col = $this->with_col;
        //adiciona glosa
        ob_start();
		if($this->tipo_equipo == 'laptop'){
			include(dirname(__FILE__).'/../reportes/equipo/cuerpo.php');
		}elseif($this->tipo_equipo == 'pc'){
			include(dirname(__FILE__).'/../reportes/equipo/cuerpoPc.php');
		}else{ //if($this->tipo_equipo == 'telfip'){
			include(dirname(__FILE__).'/../reportes/equipo/cuerpoTELIP.php');
		}
        $content = ob_get_clean();

        ob_start();
        include(dirname(__FILE__).'/../reportes/equipo/detalle.php');
        $content2 = ob_get_clean();
        $this->writeHTML($content.$content2, false, false, false, false, '');

        $this->SetFont ('helvetica', '', 5 , '', 'default', true );

        //$this->Ln(2);
        //$this->revisarfinPagina($content);

        $this->Ln(2);

    }

    function revisarfinPagina($content){
        $dimensions = $this->getPageDimensions();
        $hasBorder = false; //flag for fringe case

        $startY = $this->GetY();
        $test = $this->getNumLines($content, 80);

        //if (($startY + 10 * 6) + $dimensions['bm'] > ($dimensions['hk'])) {

        //if ($startY +  $test > 250) {
        $auxiliar = 400;
        //if($this->page==1){
        //	$auxiliar = 250;
        //}
        if ($startY +  $test > $auxiliar) {
            //$this->Ln();
            //$this->subtotales('Pasa a la siguiente página. '.$startY);
            $this->subtotales('Pasa a la siguiente página');
            $startY = $this->GetY();
            if($startY < 70){
                //$this->AddPage();
            }
            else{
                $this->AddPage();
            }


            //$this->writeHTML('<p>text'.$startY.'</p>', false, false, true, false, '');
        }
    }
}
?>