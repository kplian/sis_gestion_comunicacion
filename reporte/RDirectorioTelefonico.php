<?php
class RDirectorioTelefonico
{
    private $docexcel;
    private $objWriter;
    private $numero;
    private $equivalencias=array();
    private $objParam;
    public  $url_archivo;
    private  $cabecera = array();
    function __construct(CTParametro $objParam)
    {
        $this->objParam = $objParam;
        $this->url_archivo = "../../../reportes_generados/".$this->objParam->getParametro('nombre_archivo');
        //ini_set('memory_limit','512M');
        set_time_limit(400);
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array('memoryCacheSize'  => '10MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        $this->docexcel = new PHPExcel();
        $this->docexcel->getProperties()->setCreator("PXP")
            ->setLastModifiedBy("PXP")
            ->setTitle($this->objParam->getParametro('titulo_archivo'))
            ->setSubject($this->objParam->getParametro('titulo_archivo'))
            ->setDescription('Reporte "'.$this->objParam->getParametro('titulo_archivo').'", generado por el framework PXP')
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Report File");



        $this->equivalencias=array( 0=>'A',1=>'B',2=>'C',3=>'D',4=>'E',5=>'F',6=>'G',7=>'H',8=>'I',
            9=>'J',10=>'K',11=>'L',12=>'M',13=>'N',14=>'O',15=>'P',16=>'Q',17=>'R',
            18=>'S',19=>'T',20=>'U',21=>'V',22=>'W',23=>'X',24=>'Y',25=>'Z',
            26=>'AA',27=>'AB',28=>'AC',29=>'AD',30=>'AE',31=>'AF',32=>'AG',33=>'AH',
            34=>'AI',35=>'AJ',36=>'AK',37=>'AL',38=>'AM',39=>'AN',40=>'AO',41=>'AP',
            42=>'AQ',43=>'AR',44=>'AS',45=>'AT',46=>'AU',47=>'AV',48=>'AW',49=>'AX',
            50=>'AY',51=>'AZ',
            52=>'BA',53=>'BB',54=>'BC',55=>'BD',56=>'BE',57=>'BF',58=>'BG',59=>'BH',
            60=>'BI',61=>'BJ',62=>'BK',63=>'BL',64=>'BM',65=>'BN',66=>'BO',67=>'BP',
            68=>'BQ',69=>'BR',70=>'BS',71=>'BT',72=>'BU',73=>'BV',74=>'BW',75=>'BX',
            76=>'BY',77=>'BZ');

    }
    function imprimeCabecera() {
        $this->docexcel->createSheet();
        $this->docexcel->getActiveSheet()->setTitle('DIRECTORIO DE TELÉFONOS');
        $this->docexcel->setActiveSheetIndex(0);

        $styleTitulos1 = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 15,
                'name'  => 'Arial',
                'color' => array(
                    'rgb' => '02176E'
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $styleSubtitulo = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Arial',
                'color' => array(
                    'rgb' => '02176E'
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );


        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('imgNotice');
        $objDrawing->setDescription('Noticia');
        $img = dirname(__FILE__) . '/../../pxp/lib' . $_SESSION['_DIR_LOGO'];
        $objDrawing->setPath($img);
        $objDrawing->setOffsetX(28);    // setOffsetX works properly
        $objDrawing->setOffsetY(300);  //setOffsetY has no effect
        $objDrawing->setCoordinates('B2');
        $objDrawing->setHeight(50); // logo height
        $objDrawing->setWorksheet( $this->docexcel->setActiveSheetIndex());

        if ($this->objParam->getParametro('tipo_numero') == 'interno' )
        {   $this->docexcel->getActiveSheet()->getColumnDimension('D')->setVisible(1);
            $this->docexcel->getActiveSheet()->getColumnDimension('E')->setVisible(0);
            $this->docexcel->getActiveSheet()->getColumnDimension('F')->setVisible(0);
        }elseif ($this->objParam->getParametro('tipo_numero') == 'linea directa'){
            $this->docexcel->getActiveSheet()->getColumnDimension('D')->setVisible(0);
            $this->docexcel->getActiveSheet()->getColumnDimension('E')->setVisible(1);
            $this->docexcel->getActiveSheet()->getColumnDimension('F')->setVisible(0);
        }elseif ($this->objParam->getParametro('tipo_numero') == 'movil'){
            $this->docexcel->getActiveSheet()->getColumnDimension('D')->setVisible(0);
            $this->docexcel->getActiveSheet()->getColumnDimension('E')->setVisible(0);
            $this->docexcel->getActiveSheet()->getColumnDimension('F')->setVisible(1);
        }elseif ($this->objParam->getParametro('tipo_numero') == 'interno,linea directa'|| $this->objParam->getParametro('tipo_numero') == 'linea directa,interno'){
            $this->docexcel->getActiveSheet()->getColumnDimension('D')->setVisible(1);
            $this->docexcel->getActiveSheet()->getColumnDimension('E')->setVisible(1);
            $this->docexcel->getActiveSheet()->getColumnDimension('F')->setVisible(0);
        }elseif ($this->objParam->getParametro('tipo_numero') == 'interno,movil'|| $this->objParam->getParametro('tipo_numero') == 'movil,interno'){
            $this->docexcel->getActiveSheet()->getColumnDimension('D')->setVisible(1);
            $this->docexcel->getActiveSheet()->getColumnDimension('E')->setVisible(0);
            $this->docexcel->getActiveSheet()->getColumnDimension('F')->setVisible(1);
        }elseif ($this->objParam->getParametro('tipo_numero') == 'linea directa,movil'|| $this->objParam->getParametro('tipo_numero') == 'movil,linea directa'){
            $this->docexcel->getActiveSheet()->getColumnDimension('D')->setVisible(0);
            $this->docexcel->getActiveSheet()->getColumnDimension('E')->setVisible(1);
            $this->docexcel->getActiveSheet()->getColumnDimension('F')->setVisible(1);
        }



        //titulos

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'BOLIVIANA DE AVIACIÓN - BOA' );
        $this->docexcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($styleTitulos1);
        $this->docexcel->getActiveSheet()->mergeCells('A2:F2');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,3,'DIRECTORIO TELEFÓNICO' );
        $this->docexcel->getActiveSheet()->getStyle('A3:F3')->applyFromArray($styleTitulos1);
        $this->docexcel->getActiveSheet()->mergeCells('A3:F3');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,4,'Actualizado al '.date("d") . "/" . date("m") . "/" . date("Y") );
        $this->docexcel->getActiveSheet()->getStyle('A4:F4')->applyFromArray($styleSubtitulo);
        $this->docexcel->getActiveSheet()->mergeCells('A4:F4');


        $this->docexcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
        $this->docexcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
        $this->docexcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $this->docexcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $this->docexcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);
        $this->docexcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
        $this->docexcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true);

    }
    function generarDatos()
    {
        $styleBordes = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $styleAliniar = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );

        $fila = 6;
        $cabecera =  $this->cabecera=array( 0=>'FUNCIONARIO',1=>'CARGO',2=>'INTERNO',3=>'LINEA DIRECTA',4=>'MOVIL');
        $datos = $this->objParam->getParametro('datos');
        $this->imprimeCabecera(0);
        $ofi= '';
        $ger = '';
        $dep = '';
        $ti = '';
        $columna =1;
        foreach ($datos as $value){
            if ($value['oficina_nombre'] != $ofi) {
                $this->imprimeSubtitulo($fila,$value['oficina_nombre']);
                $ofi = $value['oficina_nombre'];
                $fila++;
                if ($cabecera[0]!=$ti){
                    $this->titulos($columna,$fila);
                    $fila++;
                }
            }
            if ($value['gerencia'] != $ger && $value['gerencia'] != $value['oficina_nombre']){
                $this->imprimeSubTituloGerencia($fila,$value['gerencia']);
                $ger = $value['gerencia'];
                $fila++;
            }
            if ($value['departamento'] != $dep && $value['departamento'] != $value['gerencia']){
                $this->imprimeSubTituloDepartamento($fila,$value['departamento']);
                $dep = $value['departamento'];
                $fila++;
            }


                $interno = str_replace(',', '/', trim($value['interno'], '{}'));
                $fijo = str_replace(',', '/', trim($value['fijo'], '{}'));
                $celular = str_replace(',', '/', trim($value['celular'], '{}'));

            ///if ($value['interno'] != '-' && $value['fijo'] != '-' && $value['celular'] != '-') {
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $value['nombre_funcionario']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $value['nombre_cargo_funcionario']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $interno);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $fijo);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $celular);
                $this->docexcel->getActiveSheet()->getStyle("B$fila:F$fila")->applyFromArray($styleBordes);
                $this->docexcel->getActiveSheet()->getStyle("D$fila:F$fila")->applyFromArray($styleAliniar);
                $fila++;
            //}
        }


    }
    function imprimeSubtitulo($fila, $valor) {
        $styleEjecutado= array(
            'font' => array(
                'bold' => true,
                'size' => 16,
                'name' => 'Arial',
                'color' => array(
                    'rgb' => 'FFFFFF'
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '203763'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ));


        $this->docexcel->getActiveSheet()->getStyle("B$fila:F$fila")->applyFromArray($styleEjecutado);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $valor);
        $this->docexcel->getActiveSheet()->mergeCells("B$fila:F$fila");
    }
    function imprimeSubTituloGerencia($fila, $valor) {
        $styleTitulos = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Arial',
                'color' => array(
                    'rgb' => 'FFFFFF'
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '030303'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
            );

        $this->docexcel->getActiveSheet()->getStyle("B$fila:F$fila")->applyFromArray($styleTitulos);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $valor);
        $this->docexcel->getActiveSheet()->mergeCells("B$fila:F$fila");

    }
    function imprimeSubTituloDepartamento($fila, $valor) {
        $styleTitulos = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 11,
                'name'  => 'Arial'
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => 'C9C9C9'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->docexcel->getActiveSheet()->getStyle("B$fila:F$fila")->applyFromArray($styleTitulos);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $valor);
        $this->docexcel->getActiveSheet()->mergeCells("B$fila:F$fila");

    }

    function titulos($columna,$fila){
        $styleEjecutado= array(
            'font' => array(
                'bold' => true,
                'size' => 11,
                'name' => 'Arial',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '05C5EB'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->cabecera=array( 0=>'FUNCIONARIO',1=>'CARGO',2=>'INTERNO',3=>'LINEA DIRECTA',4=>'MOVIL');
        foreach ($this->cabecera as $value){
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow($columna, $fila, $value);
            $this->docexcel->getActiveSheet()->getStyle("B$fila:F$fila")->applyFromArray($styleEjecutado);
            $columna++;
        }

    }

    function generarReporte(){

        //$this->docexcel->setActiveSheetIndex(0);
        $this->objWriter = PHPExcel_IOFactory::createWriter($this->docexcel, 'Excel5');
        $this->objWriter->save($this->url_archivo);
        $this->imprimeCabecera(0);

    }

}
?>