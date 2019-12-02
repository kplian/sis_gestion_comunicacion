<?php
class RReporteTelecomunicaciones
{
    private $docexcel;
    private $objWriter;
    private $equivalencias=array();
    private $depositos=array();
    private $montoDebito=array();
    private $objParam;
    public  $url_archivo;
    public  $fill = 0;
    public  $filles = 0;
    public  $garante = 0;
    public  $pika = 0;


    function __construct(CTParametro $objParam){
        $this->objParam = $objParam;
        $this->url_archivo = "../../../reportes_generados/".$this->objParam->getParametro('nombre_archivo');
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

    function imprimeCabecera($datos1, $sheet) {
        $this->docexcel->createSheet();

        $this->docexcel->setActiveSheetIndex($sheet);
        $this->docexcel->getActiveSheet()->setTitle('FACTURACION '.$this->objParam->getParametro('tipoFactura'));
        $styleTitulos1 = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 11,
                'name'  => 'Calibri',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => 'EDEDED'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $styleTitulos = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 11,
                'name'  => 'Calibri'
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => 'FFFFFF'
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );

        $styleTitulos2 = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 9,
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
                    'rgb' => '5D94CA'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ));

        $styleTitulos3 = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 9,
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
                    'rgb' => '03205D'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ));

        $gdImage = imagecreatefromjpeg('../../../sis_gestion_comunicacion/reporte/Logo2.jpg');
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(100);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWidthAndHeight(148,74);
        $objDrawing->setResizeProportional(true);
        $objDrawing->setWorksheet($this->docexcel->getActiveSheet());

        //$this->docexcel->getActiveSheet()->mergeCells('A1:C1');
        //titulos

        //$this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,1,'REPORTE CONTROL AGENCIAS' );
        if($datos1 == 'celular'){
            $this->docexcel->getActiveSheet()->getStyle('A1:AO1')->applyFromArray($styleTitulos);
            $this->docexcel->getActiveSheet()->mergeCells('A1:AO1');

            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'FACTURACION '.$this->objParam->getParametro('tipoFactura').' GESTION '.$this->objParam->getParametro('datos')[0]['gestion']);
            $this->docexcel->getActiveSheet()->getStyle('A2:AO2')->applyFromArray($styleTitulos);
            $this->docexcel->getActiveSheet()->mergeCells('A2:AO2');

            //$this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,3,'Fecha: '. $this->objParam->getParametro('fecha_fin'));
            $this->docexcel->getActiveSheet()->getStyle('A3:AO3')->applyFromArray($styleTitulos);
            $this->docexcel->getActiveSheet()->getStyle('A4:AO4')->applyFromArray($styleTitulos);
            $this->docexcel->getActiveSheet()->mergeCells('A3:AO3');
        }else{
            $this->docexcel->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($styleTitulos);
            $this->docexcel->getActiveSheet()->mergeCells('A1:Z1');

            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'FACTURACION '.$this->objParam->getParametro('tipoFactura').' GESTION '.$this->objParam->getParametro('datos')[0]['gestion']);
            $this->docexcel->getActiveSheet()->getStyle('A2:Z2')->applyFromArray($styleTitulos);
            $this->docexcel->getActiveSheet()->mergeCells('A2:Z2');

            //$this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,3,'Fecha: '. $this->objParam->getParametro('fecha_fin'));
            $this->docexcel->getActiveSheet()->getStyle('A3:Z3')->applyFromArray($styleTitulos);
            $this->docexcel->getActiveSheet()->getStyle('A4:Z4')->applyFromArray($styleTitulos);
            $this->docexcel->getActiveSheet()->mergeCells('A3:Z3');
        }

        //$this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,4,'Generado por: '. $_SESSION['_LOGIN']);
        //$this->docexcel->getActiveSheet()->mergeCells('A4:H4');
        //$this->docexcel->getActiveSheet()->getStyle('A5:H5')->applyFromArray($styleTitulos);

        if($datos1 == 'celular'){
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,5,'INVENTARIO '.$this->objParam->getParametro('tipoFactura'));
            $this->docexcel->getActiveSheet()->getStyle('A5:N5')->applyFromArray($styleTitulos2);
            $this->docexcel->getActiveSheet()->mergeCells('A5:N5');
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(14,5,'FACTURACION '.$this->objParam->getParametro('tipoFactura'));
            $this->docexcel->getActiveSheet()->getStyle('O5:AA5')->applyFromArray($styleTitulos3);
            $this->docexcel->getActiveSheet()->mergeCells('O5:AA5');
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(27,5,'CONTROL LINEAS MOVILES');
            $this->docexcel->getActiveSheet()->getStyle('AB5:AO5')->applyFromArray($styleTitulos2);
            $this->docexcel->getActiveSheet()->mergeCells('AB5:AO5');
        }else{
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,5,'INVENTARIO '.$this->objParam->getParametro('tipoFactura'));
            $this->docexcel->getActiveSheet()->getStyle('A5:M5')->applyFromArray($styleTitulos2);
            $this->docexcel->getActiveSheet()->mergeCells('A5:M5');
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(13,5,'FACTURACION '.$this->objParam->getParametro('tipoFactura'));
            $this->docexcel->getActiveSheet()->getStyle('N5:Z5')->applyFromArray($styleTitulos3);
            $this->docexcel->getActiveSheet()->mergeCells('N5:Z5');
        }
        //*************************************Cabecera*****************************************
        $this->docexcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $this->docexcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $this->docexcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $this->docexcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $this->docexcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $this->docexcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $this->docexcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $this->docexcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $this->docexcel->getActiveSheet()->getColumnDimension('I')->setWidth(39);
        $this->docexcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $this->docexcel->getActiveSheet()->getColumnDimension('K')->setWidth(14);
        $this->docexcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
        $this->docexcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);

        $this->docexcel->getActiveSheet()->getColumnDimension('N')->setWidth(12);
        $this->docexcel->getActiveSheet()->getColumnDimension('O')->setWidth(12);
        $this->docexcel->getActiveSheet()->getColumnDimension('P')->setWidth(12);
        $this->docexcel->getActiveSheet()->getColumnDimension('Q')->setWidth(12);
        $this->docexcel->getActiveSheet()->getColumnDimension('R')->setWidth(12);
        $this->docexcel->getActiveSheet()->getColumnDimension('S')->setWidth(12);
        $this->docexcel->getActiveSheet()->getColumnDimension('T')->setWidth(12);
        $this->docexcel->getActiveSheet()->getColumnDimension('U')->setWidth(12);
        $this->docexcel->getActiveSheet()->getColumnDimension('V')->setWidth(12);
        $this->docexcel->getActiveSheet()->getColumnDimension('W')->setWidth(12);
        $this->docexcel->getActiveSheet()->getColumnDimension('X')->setWidth(12);
        $this->docexcel->getActiveSheet()->getColumnDimension('Y')->setWidth(12);
        $this->docexcel->getActiveSheet()->getColumnDimension('Z')->setWidth(12);
        $this->docexcel->getActiveSheet()->getColumnDimension('AA')->setWidth(12);
        $this->docexcel->getActiveSheet()->getColumnDimension('AB')->setWidth(24);


        $this->docexcel->getActiveSheet()->setCellValue('A6','Nro');
        $this->docexcel->getActiveSheet()->setCellValue('B6','Proveedor');
        $this->docexcel->getActiveSheet()->setCellValue('C6','Estacion');
        $this->docexcel->getActiveSheet()->setCellValue('D6','Oficina');
        $this->docexcel->getActiveSheet()->setCellValue('E6','Gerencia');
        $this->docexcel->getActiveSheet()->setCellValue('F6','Area');
        $this->docexcel->getActiveSheet()->setCellValue('G6','Descripcion');
        $this->docexcel->getActiveSheet()->setCellValue('H6','Codigo');
        $this->docexcel->getActiveSheet()->setCellValue('I6','Usuario ERP');
        $this->docexcel->getActiveSheet()->setCellValue('J6','Cargo');
        $this->docexcel->getActiveSheet()->setCellValue('K6','Linea ERP');
        $this->docexcel->getActiveSheet()->setCellValue('L6','Nro. Linea');

        if($datos1 == 'celular'){
            $this->docexcel->getActiveSheet()->setCellValue('M6','Roaming');
            $this->docexcel->getActiveSheet()->setCellValue('N6','Status');
            $this->docexcel->getActiveSheet()->setCellValue('O6','ENERO');
            $this->docexcel->getActiveSheet()->setCellValue('P6','FEBRERO');
            $this->docexcel->getActiveSheet()->setCellValue('Q6','MARZO');
            $this->docexcel->getActiveSheet()->setCellValue('R6','ABRIL');
            $this->docexcel->getActiveSheet()->setCellValue('S6','MAYO');
            $this->docexcel->getActiveSheet()->setCellValue('T6','JUNIO');
            $this->docexcel->getActiveSheet()->setCellValue('U6','JULIO');
            $this->docexcel->getActiveSheet()->setCellValue('V6','AGOSTO');
            $this->docexcel->getActiveSheet()->setCellValue('W6','SEPTIEMBRE');
            $this->docexcel->getActiveSheet()->setCellValue('X6','OCTUBRE');
            $this->docexcel->getActiveSheet()->setCellValue('Y6','NOVIEMBRE');
            $this->docexcel->getActiveSheet()->setCellValue('Z6','DICIEMBRE');
            $this->docexcel->getActiveSheet()->setCellValue('AA6','TOTAL');

            $this->docexcel->getActiveSheet()->setCellValue('AB6','SERVICIO');
            $this->docexcel->getActiveSheet()->setCellValue('AC6','ENERO');
            $this->docexcel->getActiveSheet()->setCellValue('AD6','FEBRERO');
            $this->docexcel->getActiveSheet()->setCellValue('AE6','MARZO');
            $this->docexcel->getActiveSheet()->setCellValue('AF6','ABRIL');
            $this->docexcel->getActiveSheet()->setCellValue('AG6','MAYO');
            $this->docexcel->getActiveSheet()->setCellValue('AH6','JUNIO');
            $this->docexcel->getActiveSheet()->setCellValue('AI6','JULIO');
            $this->docexcel->getActiveSheet()->setCellValue('AJ6','AGOSTO');
            $this->docexcel->getActiveSheet()->setCellValue('AK6','SEPTIEMBRE');
            $this->docexcel->getActiveSheet()->setCellValue('AL6','OCTUBRE');
            $this->docexcel->getActiveSheet()->setCellValue('AM6','NOVIEMBRE');
            $this->docexcel->getActiveSheet()->setCellValue('AN6','DICIEMBRE');
            $this->docexcel->getActiveSheet()->setCellValue('AO6','TOTAL');
        }else{
            $this->docexcel->getActiveSheet()->setCellValue('M6','Status');
            $this->docexcel->getActiveSheet()->setCellValue('N6','ENERO');
            $this->docexcel->getActiveSheet()->setCellValue('O6','FEBRERO');
            $this->docexcel->getActiveSheet()->setCellValue('P6','MARZO');
            $this->docexcel->getActiveSheet()->setCellValue('Q6','ABRIL');
            $this->docexcel->getActiveSheet()->setCellValue('R6','MAYO');
            $this->docexcel->getActiveSheet()->setCellValue('S6','JUNIO');
            $this->docexcel->getActiveSheet()->setCellValue('T6','JULIO');
            $this->docexcel->getActiveSheet()->setCellValue('U6','AGOSTO');
            $this->docexcel->getActiveSheet()->setCellValue('V6','SEPTIEMBRE');
            $this->docexcel->getActiveSheet()->setCellValue('W6','OCTUBRE');
            $this->docexcel->getActiveSheet()->setCellValue('X6','NOVIEMBRE');
            $this->docexcel->getActiveSheet()->setCellValue('Y6','DICIEMBRE');
            $this->docexcel->getActiveSheet()->setCellValue('Z6','TOTAL');
        }

        if($datos1 == 'celular'){
            $this->docexcel->getActiveSheet()->getStyle('A6:N6')->applyFromArray($styleTitulos2);
            $this->docexcel->getActiveSheet()->getStyle('O6:AA6')->applyFromArray($styleTitulos3);
            $this->docexcel->getActiveSheet()->getStyle('AB6:AO6')->applyFromArray($styleTitulos2);
            $this->docexcel->getActiveSheet()->getStyle('A6:AO6')->getAlignment()->setWrapText(true);
        }else{
            $this->docexcel->getActiveSheet()->getStyle('A6:M6')->applyFromArray($styleTitulos2);
            $this->docexcel->getActiveSheet()->getStyle('N6:Z6')->applyFromArray($styleTitulos3);
            $this->docexcel->getActiveSheet()->getStyle('A6:Z6')->getAlignment()->setWrapText(true);
        }
        $this->docexcel->getActiveSheet()->freezePaneByColumnAndRow(0,7);


    }

    function generarDatos($datos1, $sheet){
        $this->imprimeCabecera($datos1, $sheet);
        $bordes = array(
            'borders' => array(
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),

        );
        $styleTitulos = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );

        $styleBoa4 = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '5B9BD5'
                )

            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 16,
                'name'  => 'Times New Roman',
                'color' => array(
                    'rgb' => 'FFFFFF'
                )


            ),
            'borders' => array(
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );

        $styleTitulos2 = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 9,
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
                    'rgb' => '5D94CA'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ));

        $styleTitulosC = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );

        $this->numero = 1;
        $fila = 7;
        $datos = $this->objParam->getParametro('datos');
        $ger = '';
        $fila_ini = $fila;
        $fila_fin = $fila;

        $tmp_ini = null;
        $tmp_rec = null;
        $tmp_last = null;
        $previousValue = null;
        for ($i = 0; $i <= count($datos); $i++) {
            if($datos1 == $datos[$i]['tipo']){
                $tmp_ini = $datos[$i];
                $tmp_rec = $datos[$i];
                break;
            }
        }
        for ($j = count($datos); $j >= 0; $j--) {
            if($datos1 == $datos[$j]['tipo']){
                $tmp_last = $datos[$j];
                break;
            }
        }

        $sumatoria_enero = 0;
        $sumatoria_febrero = 0;
        $sumatoria_marzo = 0;
        $sumatoria_abril = 0;
        $sumatoria_mayo = 0;
        $sumatoria_junio = 0;
        $sumatoria_julio = 0;
        $sumatoria_agosto = 0;
        $sumatoria_septiembre = 0;
        $sumatoria_octubre = 0;
        $sumatoria_noviembre = 0;
        $sumatoria_diciembre = 0;
        $sumatoria_linea = 0;
        $sumatoria_ser_enero = 0;
        $sumatoria_ser_febrero = 0;
        $sumatoria_ser_marzo = 0;
        $sumatoria_ser_abril = 0;
        $sumatoria_ser_mayo = 0;
        $sumatoria_ser_junio = 0;
        $sumatoria_ser_julio = 0;
        $sumatoria_ser_agosto = 0;
        $sumatoria_ser_septiembre = 0;
        $sumatoria_ser_octubre = 0;
        $sumatoria_ser_noviembre = 0;
        $sumatoria_ser_diciembre = 0;
        $sumatoria_ser_linea = 0;
        $last_key = end(array_keys($datos));
        $getTitle=false;
        foreach ($datos as $key => $value) {
            if($datos1 == $value['tipo']){
                if($tmp_rec['id_numero_celular'] != $value['id_numero_celular']){

                    $fila_fin = $fila-1;

                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("A".($fila_ini).":A".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("B".($fila_ini).":B".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("C".($fila_ini).":C".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("D".($fila_ini).":D".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("E".($fila_ini).":E".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("F".($fila_ini).":F".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("G".($fila_ini).":G".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("H".($fila_ini).":H".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("I".($fila_ini).":I".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("J".($fila_ini).":J".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("K".($fila_ini).":K".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("L".($fila_ini).":L".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("M".($fila_ini).":M".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("N".($fila_ini).":N".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("O".($fila_ini).":O".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("P".($fila_ini).":P".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("Q".($fila_ini).":Q".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("R".($fila_ini).":R".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("S".($fila_ini).":S".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("T".($fila_ini).":T".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("U".($fila_ini).":U".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("V".($fila_ini).":V".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("W".($fila_ini).":W".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("X".($fila_ini).":X".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("Y".($fila_ini).":Y".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("Z".($fila_ini).":Z".($fila_fin));
                    if($datos1 == 'celular'){
                        $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("AA".($fila_ini).":AA".($fila_fin));
                    }
                    $sumatoria_enero = $sumatoria_enero+$previousValue['enero'];
                    $sumatoria_febrero = $sumatoria_febrero+$previousValue['febrero'];
                    $sumatoria_marzo = $sumatoria_marzo+$previousValue['marzo'];
                    $sumatoria_abril = $sumatoria_abril+$previousValue['abril'];
                    $sumatoria_mayo = $sumatoria_mayo+$previousValue['mayo'];
                    $sumatoria_junio = $sumatoria_junio+$previousValue['junio'];
                    $sumatoria_julio = $sumatoria_julio+$previousValue['julio'];
                    $sumatoria_agosto = $sumatoria_agosto+$previousValue['agosto'];
                    $sumatoria_septiembre = $sumatoria_septiembre+$previousValue['septiembre'];
                    $sumatoria_octubre = $sumatoria_octubre+$previousValue['octubre'];
                    $sumatoria_noviembre = $sumatoria_noviembre+$previousValue['noviembre'];
                    $sumatoria_diciembre = $sumatoria_diciembre+$previousValue['diciembre'];

                    $fila_ini = $fila;
                }
                if($tmp_last['id_numero_celular'] == $value['id_numero_celular']){
                    $fila_fin = $fila;
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("A".($fila_ini).":A".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("B".($fila_ini).":B".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("C".($fila_ini).":C".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("D".($fila_ini).":D".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("E".($fila_ini).":E".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("F".($fila_ini).":F".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("G".($fila_ini).":G".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("H".($fila_ini).":H".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("I".($fila_ini).":I".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("J".($fila_ini).":J".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("K".($fila_ini).":K".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("L".($fila_ini).":L".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("M".($fila_ini).":M".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("N".($fila_ini).":N".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("O".($fila_ini).":O".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("P".($fila_ini).":P".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("Q".($fila_ini).":Q".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("R".($fila_ini).":R".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("S".($fila_ini).":S".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("T".($fila_ini).":T".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("U".($fila_ini).":U".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("V".($fila_ini).":V".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("W".($fila_ini).":W".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("X".($fila_ini).":X".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("Y".($fila_ini).":Y".($fila_fin));
                    $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("Z".($fila_ini).":Z".($fila_fin));
                    if($datos1 == 'celular'){
                        $this->docexcel->setActiveSheetIndex($sheet)->mergeCells("AA".($fila_ini).":AA".($fila_fin));
                    }
                    $sumatoria_enero = $sumatoria_enero+$value['enero'];
                    $sumatoria_febrero = $sumatoria_febrero+$value['febrero'];
                    $sumatoria_marzo = $sumatoria_marzo+$value['marzo'];
                    $sumatoria_abril = $sumatoria_abril+$value['abril'];
                    $sumatoria_mayo = $sumatoria_mayo+$value['mayo'];
                    $sumatoria_junio = $sumatoria_junio+$value['junio'];
                    $sumatoria_julio = $sumatoria_julio+$value['julio'];
                    $sumatoria_agosto = $sumatoria_agosto+$value['agosto'];
                    $sumatoria_septiembre = $sumatoria_septiembre+$value['septiembre'];
                    $sumatoria_octubre = $sumatoria_octubre+$value['octubre'];
                    $sumatoria_noviembre = $sumatoria_noviembre+$value['noviembre'];
                    $sumatoria_diciembre = $sumatoria_diciembre+$value['diciembre'];
                }

                $sumatoria_linea = $value['enero']+$value['febrero']+$value['marzo']+$value['abril']+$value['mayo']+$value['junio']+$value['julio']+$value['agosto']+$value['septiembre']+$value['octubre']+$value['noviembre']+$value['diciembre'];
                $sumatoria_ser_linea = $value['ser_ene']+$value['ser_feb']+$value['ser_mar']+$value['ser_abr']+$value['ser_may']+$value['ser_jun']+$value['ser_jul']+$value['ser_ago']+$value['ser_sep']+$value['ser_oct']+$value['ser_nov']+$value['ser_dic'];

                if (($tmp_rec['id_numero_celular'] != $value['id_numero_celular'])  or ($tmp_ini['id_numero_celular'] == $value['id_numero_celular'])){
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $this->numero);
                }
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $value['rotulo_comercial']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $value['lugar']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $value['oficina']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $value['gerencia']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $value['departamento']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $value['observaciones']);
                //$this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(7, $fila, $value['codigo']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(8, $fila, $value['usuario']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(9, $fila, $value['cargo']);

                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(10, $fila, $value['tipo'].' - '.$value['numero']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(11, $fila, $value['numero']);

                if($datos1 == 'celular'){
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(12, $fila, $value['roaming']);
                    //$this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(13, $fila, $value['estado']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(14, $fila, $value['enero']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(15, $fila, $value['febrero']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(16, $fila, $value['marzo']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(17, $fila, $value['abril']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(18, $fila, $value['mayo']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(19, $fila, $value['junio']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(20, $fila, $value['julio']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(21, $fila, $value['agosto']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(22, $fila, $value['septiembre']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(23, $fila, $value['octubre']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(24, $fila, $value['noviembre']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(25, $fila, $value['diciembre']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(26, $fila, $sumatoria_linea);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(27, $fila, $value['nombre_servicio']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(28, $fila, $value['ser_ene']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(29, $fila, $value['ser_feb']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(30, $fila, $value['ser_mar']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(31, $fila, $value['ser_abr']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(32, $fila, $value['ser_may']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(33, $fila, $value['ser_jun']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(34, $fila, $value['ser_jul']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(35, $fila, $value['ser_ago']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(36, $fila, $value['ser_sep']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(37, $fila, $value['ser_oct']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(38, $fila, $value['ser_nov']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(39, $fila, $value['ser_dic']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(40, $fila, $sumatoria_ser_linea);
                }else{
                    //$this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(12, $fila, $value['estado']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(13, $fila, $value['enero']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(14, $fila, $value['febrero']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(15, $fila, $value['marzo']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(16, $fila, $value['abril']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(17, $fila, $value['mayo']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(18, $fila, $value['junio']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(19, $fila, $value['julio']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(20, $fila, $value['agosto']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(21, $fila, $value['septiembre']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(22, $fila, $value['octubre']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(23, $fila, $value['noviembre']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(24, $fila, $value['diciembre']);
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(25, $fila, $sumatoria_linea);
                }


                if($datos1 == 'celular'){
                    $this->docexcel->getActiveSheet()->getStyle("A$fila:AA$fila")->applyFromArray($styleTitulosC);
                    $this->docexcel->getActiveSheet()->getStyle("O$fila:AA$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);
                    $this->docexcel->getActiveSheet()->getStyle("AC$fila:AO$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);
                    $sumatoria_ser_enero = $sumatoria_ser_enero+$value['ser_ene'];
                    $sumatoria_ser_febrero = $sumatoria_ser_febrero+$value['ser_feb'];
                    $sumatoria_ser_marzo = $sumatoria_ser_marzo+$value['ser_mar'];
                    $sumatoria_ser_abril = $sumatoria_ser_abril+$value['ser_abr'];
                    $sumatoria_ser_mayo = $sumatoria_ser_mayo+$value['ser_may'];
                    $sumatoria_ser_junio = $sumatoria_ser_junio+$value['ser_jun'];
                    $sumatoria_ser_julio = $sumatoria_ser_julio+$value['ser_jul'];
                    $sumatoria_ser_agosto = $sumatoria_ser_agosto+$value['ser_ago'];
                    $sumatoria_ser_septiembre = $sumatoria_ser_septiembre+$value['ser_sep'];
                    $sumatoria_ser_octubre = $sumatoria_ser_octubre+$value['ser_oct'];
                    $sumatoria_ser_noviembre = $sumatoria_ser_noviembre+$value['ser_nov'];
                    $sumatoria_ser_diciembre = $sumatoria_ser_diciembre+$value['ser_dic'];
                }else{
                    $this->docexcel->getActiveSheet()->getStyle("A$fila:Z$fila")->applyFromArray($styleTitulosC);
                    $this->docexcel->getActiveSheet()->getStyle("N$fila:Z$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);
                }

                if (($tmp_rec['id_numero_celular'] != $value['id_numero_celular'])  or ($tmp_ini['id_numero_celular'] == $value['id_numero_celular'])){
                    $this->numero++;
                }
                $fila++;
                $num++;
                $sumatoria_linea = 0;
                $tmp_rec = $value;
                $previousValue = $value;
            }
        }
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,' TOTAL ');



        if($datos1 == 'celular'){
            $this->docexcel->getActiveSheet()->getStyle("A".($fila).":N".($fila))->applyFromArray($styleTitulos2);
            $this->docexcel->getActiveSheet()->mergeCells("A".($fila).":N".($fila));

            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(14, $fila, $sumatoria_enero);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(15, $fila, $sumatoria_febrero);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(16, $fila, $sumatoria_marzo);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(17, $fila, $sumatoria_abril);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(18, $fila, $sumatoria_mayo);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(19, $fila, $sumatoria_junio);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(20, $fila, $sumatoria_julio);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(21, $fila, $sumatoria_agosto);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(22, $fila, $sumatoria_septiembre);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(23, $fila, $sumatoria_octubre);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(24, $fila, $sumatoria_noviembre);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(25, $fila, $sumatoria_diciembre);
            $this->docexcel->getActiveSheet()->getStyle("O$fila:AA$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(28, $fila, $sumatoria_ser_enero);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(29, $fila, $sumatoria_ser_febrero);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(30, $fila, $sumatoria_ser_marzo);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(31, $fila, $sumatoria_ser_abril);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(32, $fila, $sumatoria_ser_mayo);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(33, $fila, $sumatoria_ser_junio);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(34, $fila, $sumatoria_ser_julio);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(35, $fila, $sumatoria_ser_agosto);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(36, $fila, $sumatoria_ser_septiembre);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(37, $fila, $sumatoria_ser_octubre);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(38, $fila, $sumatoria_ser_noviembre);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(39, $fila, $sumatoria_ser_diciembre);
            $this->docexcel->getActiveSheet()->getStyle("AC$fila:AO$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);
        }else{
            $this->docexcel->getActiveSheet()->getStyle("A".($fila).":M".($fila))->applyFromArray($styleTitulos2);
            $this->docexcel->getActiveSheet()->mergeCells("A".($fila).":M".($fila));

            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(13, $fila, $sumatoria_enero);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(14, $fila, $sumatoria_febrero);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(15, $fila, $sumatoria_marzo);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(16, $fila, $sumatoria_abril);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(17, $fila, $sumatoria_mayo);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(18, $fila, $sumatoria_junio);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(19, $fila, $sumatoria_julio);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(20, $fila, $sumatoria_agosto);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(21, $fila, $sumatoria_septiembre);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(22, $fila, $sumatoria_octubre);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(23, $fila, $sumatoria_noviembre);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(24, $fila, $sumatoria_diciembre);
            $this->docexcel->getActiveSheet()->getStyle("N$fila:Z$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);
        }



        //$this->docexcel->getActiveSheet()->getStyle("N".($fila).":Y".($fila))->applyFromArray($styleBoa4);

    }

    function generarReporte(){
        $this->docexcel->setActiveSheetIndex(0);
        $this->objWriter = PHPExcel_IOFactory::createWriter($this->docexcel, 'Excel5');
        $this->objWriter->save($this->url_archivo);
    }

}
?>
