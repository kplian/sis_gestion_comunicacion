<?php
class RFormularioMovilXls
{
    private $docexcel;
    private $objWriter;
    private $nombre_archivo;
    private $hoja;
    private $columnas=array();
    private $fila;
    private $equivalencias=array();

    private $indice, $m_fila, $titulo;
    private $swEncabezado=0; //variable que define si ya se imprimi el encabezado
    private $objParam;
    public  $url_archivo;

    var $datos_titulo;
    var $datos_detalle;
    var $total;

    public $primerAnio;
    public $ultimoAnio;
    public $anios;

    public $primerAnio2;
    public $ultimoAnio2;

    function __construct(CTParametro $objParam){
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

        $this->docexcel->setActiveSheetIndex(0);

        $this->docexcel->getActiveSheet()->setTitle($this->objParam->getParametro('titulo_archivo'));

        $this->equivalencias=array(0=>'A',1=>'B',2=>'C',3=>'D',4=>'E',5=>'F',6=>'G',7=>'H',8=>'I',
            9=>'J',10=>'K',11=>'L',12=>'M',13=>'N',14=>'O',15=>'P',16=>'Q',17=>'R',
            18=>'S',19=>'T',20=>'U',21=>'V',22=>'W',23=>'X',24=>'Y',25=>'Z',
            26=>'AA',27=>'AB',28=>'AC',29=>'AD',30=>'AE',31=>'AF',32=>'AG',33=>'AH',
            34=>'AI',35=>'AJ',36=>'AK',37=>'AL',38=>'AM',39=>'AN',40=>'AO',41=>'AP',
            42=>'AQ',43=>'AR',44=>'AS',45=>'AT',46=>'AU',47=>'AV',48=>'AW',49=>'AX',
            50=>'AY',51=>'AZ',
            52=>'BA',53=>'BB',54=>'BC',55=>'BD',56=>'BE',57=>'BF',58=>'BG',59=>'BH',
            60=>'BI',61=>'BJ',62=>'BK',63=>'BL',64=>'BM',65=>'BN',66=>'BO',67=>'BP',
            68=>'BQ',69=>'BR',70=>'BS',71=>'BT',72=>'BU',73=>'BV',74=>'BW',75=>'BX',
            76=>'BY',77=>'BZ',
            78=>'CA',79=>'CB',80=>'CC',81=>'CD',82=>'CE',83=>'CF',84=>'CG',85=>'CH',
            86=>'CI',87=>'CJ',88=>'CK',89=>'CL',90=>'CM',91=>'CN',92=>'CO',93=>'CP',
            94=>'CQ',95=>'CR',96=>'CS',97=>'CT',98=>'CU',99=>'CV',100=>'CW',101=>'CX',
            102=>'CY',103=>'CZ',
            104=>'DA',105=>'DB',106=>'DC',107=>'DD',108=>'DE',109=>'DF',110=>'DG',111=>'DH',
            112=>'DI',113=>'DJ',114=>'DK',115=>'DL',116=>'DM',117=>'DN',118=>'DO',119=>'DP',
            120=>'DQ',121=>'DR',122=>'DS',123=>'DT',124=>'DU',125=>'DV',126=>'DW',127=>'DX',
            128=>'DY',129=>'DZ',
            130=>'EA',131=>'EB',132=>'EC',133=>'ED',134=>'EE',135=>'EF',136=>'EG',137=>'EH',
            138=>'EI',139=>'EJ',140=>'EK',141=>'EL',142=>'EM',143=>'EN',144=>'EO',145=>'EP',
            146=>'EQ',147=>'ER',148=>'ES',149=>'ET',150=>'EU',151=>'EV',152=>'EW',153=>'EX',
            154=>'EY',155=>'EZ',
            156=>'FA',157=>'FB',158=>'FC',159=>'FD',160=>'FE',161=>'FF',162=>'FG',163=>'FH',
            164=>'FI',165=>'FJ',166=>'FK',167=>'FL',168=>'FM',169=>'FN',170=>'FO',171=>'FP',
            172=>'FQ',173=>'FR',174=>'FS',175=>'FT',176=>'FU',177=>'FV',178=>'FW',179=>'FX',
            180=>'FY',181=>'FZ',
            182=>'GA',183=>'GB',184=>'GC',185=>'GD',186=>'GE',187=>'GF',188=>'GG',189=>'GH',
            190=>'GI',191=>'GJ',192=>'GK',193=>'GL',194=>'GM',195=>'GN',196=>'GO',197=>'GP',
            198=>'GQ',199=>'GR',200=>'GS',201=>'GT',202=>'GU',203=>'GV',204=>'GW',205=>'GX',
            206=>'GY',207=>'GZ');

    }

    function datosHeader ( $detalle, $id_entrega) {

        $this->datos_detalle = $detalle;
        $this->id_entrega = $id_entrega;

    }

    function ImprimeCabera(){

    }

    function imprimeDatos($tipoDato,$sheet, $tipoOperacion){
        $this->docexcel->setActiveSheetIndex($sheet);
        $datos = $this->datos_detalle;

        $styleTitulos = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 9,
                'name'  => 'Arial'
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'BDD7EE')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ));

        $inicio_filas = 2;

        $fila = $inicio_filas+1;

        $styleArrayGroup = array(
            'font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF')),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '34495E')),
            'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))

        );

        $styleArrayGroupCg = array(
            'font'  => array('bold'  => true),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'BDD7EE')),
            'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        );

        $styleArrayGroupCg22 = array(
            'font'  => array('bold'  => true),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'F5B7B1')),
            'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        );


        $styleTitle = array(
            'font'  => array('bold'  => true, 'size' => 15),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'DAEEF3')),
            'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        );

        $styleTitle2 = array(
            'font'  => array('bold'  => true, 'size' => 11),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        );

        $styleFilled = array(
            'font'  => array('bold'  => false),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $styleDetail = array(
            'font'  => array('bold'  => false, 'size' => 10)
        );
        $styleNota = array(
            'font'  => array('bold'  => true)
        );

        $styleGray = array(
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9')),
            'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        );
        //*************************************Cabecera*****************************************

        $value = $datos[0];

        $this->docexcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        $this->docexcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
        $this->docexcel->getActiveSheet()->getStyle("B1:D2")->applyFromArray($styleTitle);
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("E1:E2");

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,3,'DATOS GENERALES');
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("A3:E3");
        $this->docexcel->getActiveSheet()->getStyle("A3:E3")->applyFromArray($styleTitle);
        $this->docexcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);


        //$this->docexcel->getActiveSheet()->getStyle("A5:A5")->applyFromArray($styleArrayGroup);
        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'NOMBRE DEL SOLICITANTE');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,$value['solicitante']);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,'LINEA');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,$value['numero']);
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("D$fila:E$fila");
        $this->docexcel->getActiveSheet()->getStyle("A$fila:A$fila")->applyFromArray($styleGray);
        $this->docexcel->getActiveSheet()->getStyle("C$fila:C$fila")->applyFromArray($styleGray);
        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'DETALLE DEL EQUIPO');
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("A$fila:E$fila");
        $this->docexcel->getActiveSheet()->getStyle("A$fila:E$fila")->applyFromArray($styleTitle);
        $this->docexcel->getActiveSheet()->getRowDimension('5')->setRowHeight(20);
        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'MARCA');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,$value['marca']);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,'CONSUMO CONTROLADO');
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("D$fila:E$fila");
        $this->docexcel->getActiveSheet()->getStyle("A$fila:A$fila")->applyFromArray($styleGray);
        $this->docexcel->getActiveSheet()->getStyle("C$fila:C$fila")->applyFromArray($styleGray);
        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'MODELO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,$value['modelo']);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,'TELCO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,$value['telco']);
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("D$fila:E$fila");
        $this->docexcel->getActiveSheet()->getStyle("A$fila:A$fila")->applyFromArray($styleGray);
        $this->docexcel->getActiveSheet()->getStyle("C$fila:C$fila")->applyFromArray($styleGray);
        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'NUMERO DE SERIE');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,$value['num_serie']);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,'CUENTA DE GASTO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,$value['cuenta_gasto']);
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("D$fila:E$fila");
        $this->docexcel->getActiveSheet()->getStyle("A$fila:A$fila")->applyFromArray($styleGray);
        $this->docexcel->getActiveSheet()->getStyle("C$fila:C$fila")->applyFromArray($styleGray);
        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'IMEI');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,$value['imei']);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,'CUENTA EN TELCO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,$value['cuenta_telco']);
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("D$fila:E$fila");
        $this->docexcel->getActiveSheet()->getStyle("A$fila:A$fila")->applyFromArray($styleGray);
        $this->docexcel->getActiveSheet()->getStyle("C$fila:C$fila")->applyFromArray($styleGray);
        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'ESTADO FISICO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,$value['estado_fisico']);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,'OBSERVACIONES');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,$value['observaciones']);
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("D$fila:E$fila");
        $this->docexcel->getActiveSheet()->getStyle("A$fila:A$fila")->applyFromArray($styleGray);
        $this->docexcel->getActiveSheet()->getStyle("C$fila:C$fila")->applyFromArray($styleGray);
        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'ACCESORIOS');
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("A$fila:E$fila");
        $this->docexcel->getActiveSheet()->getStyle("A$fila:E$fila")->applyFromArray($styleTitle);
        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,$value['observaciones']);
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("A$fila:E$fila");
        $this->docexcel->getActiveSheet()->getRowDimension('12')->setRowHeight(30);
        $this->docexcel->getActiveSheet()->getStyle("A$fila:E$fila")->applyFromArray($styleFilled);
        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,'FIRMA');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,'FECHA');
        $this->docexcel->getActiveSheet()->getStyle("A$fila:E$fila")->applyFromArray($styleTitle2);
        $this->docexcel->getActiveSheet()->getStyle("A$fila:E$fila")->applyFromArray($styleGray);
        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'CONFORMIDAD DE ASIGNACION');
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("A$fila:A".($fila+1));
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,($fila+1),$value['asignador']);
        $this->docexcel->getActiveSheet()->getStyle("B".($fila+1).":B".($fila+1))->applyFromArray($styleGray);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,'FECHA DE ENTREGA');
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("C$fila:C".($fila+1));
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,$value['fecha_entrega']);
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("D$fila:E$fila");
        $this->docexcel->getActiveSheet()->getStyle("D".($fila+1).":E".($fila+1))->applyFromArray($styleGray);
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("D".($fila+1).":E".($fila+1));
        $this->docexcel->getActiveSheet()->getStyle("A$fila:E$fila")->applyFromArray($styleTitle2);
        $this->docexcel->getActiveSheet()->getRowDimension('14')->setRowHeight(40);
        $fila++;
        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'CONFORMIDAD DE RECEPCION');
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("A$fila:A".($fila+1));
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,($fila+1),$value['solicitante']);
        $this->docexcel->getActiveSheet()->getStyle("B".($fila+1).":B".($fila+1))->applyFromArray($styleGray);
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("C$fila:E".($fila+1));
        $this->docexcel->getActiveSheet()->getStyle("A$fila:E$fila")->applyFromArray($styleTitle2);
        $this->docexcel->getActiveSheet()->getRowDimension('16')->setRowHeight(40);
        $fila++;
        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'A partir de la fecha de asignación, el RECEPTOR se hace UNICO RESPONSABLE del equipo y accesorios que se le entrega bajo este documento.');
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("A$fila:E$fila");
        $this->docexcel->getActiveSheet()->getStyle("A$fila:E$fila")->applyFromArray($styleDetail);
        $this->docexcel->getActiveSheet()->getRowDimension('18')->setRowHeight(30);
        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'Nota:');
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("A$fila:E$fila");
        $this->docexcel->getActiveSheet()->getStyle("A$fila:E$fila")->applyFromArray($styleNota);
        $fila++;
        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'Importante: En caso de pérdida del equipo debe reportarse al Departamento de Tecnologias de Información, posteriormente el equipo debe ser repuesto con uno de caraterísticas iguales o superiores, de igual forma en caso de daño al equipo o sus accesorios.');
        $this->docexcel->getActiveSheet()->getStyle("A$fila:E$fila")->applyFromArray($styleDetail);
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("A$fila:E$fila");
        $this->docexcel->getActiveSheet()->getRowDimension('21')->setRowHeight(30);




        $this->docexcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $this->docexcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $this->docexcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $this->docexcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);

        for ($i = 0; $i <= 34; ++$i) {
            $this->docexcel->getActiveSheet()->getStyle("A$i:E$i")->getAlignment()->setWrapText(true);
            if($i >= 3 and $i <= 10){
                $this->docexcel->getActiveSheet()->getStyle("B$i:B$i")->applyFromArray($styleFilled);
                $this->docexcel->getActiveSheet()->getStyle("D$i:D$i")->applyFromArray($styleFilled);
            }
        }

/*
        $this->docexcel->getActiveSheet()->getStyle("A$fila:O$fila")->applyFromArray($styleArrayGroupCg);
        $this->docexcel->getActiveSheet()->getStyle("P$fila:S$fila")->applyFromArray($styleArrayGroup);

        $fila++;
        //*************************************Fin Cabecera*****************************************


        //***********************************Detalle***********************************************

        $totales = null;
        $totalBanco = null;
        $totalBono = null;
        $tmp_rec = $datos[0];
        $inicio = true;
        $prop = 'id_deuda';

        $siguiente = $datos[1];
        $sumando = false;
        $agrupador = null;
        for ($fi = 0; $fi < count($datos); $fi++) {
            $value = $datos[$fi];

            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,$value['marca']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,$value['modelo']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,$value['estado_fisico']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,$value['estado']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(4,$fila,$value['observaciones']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(5,$fila,$value['color']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(6,$fila,$value['imei']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(7,$fila,$value['tamano_pantalla']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(8,$fila,$value['tarjeta_video']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(9,$fila,$value['teclado']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(10,$fila,$value['procesador']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(11,$fila,$value['memoria_ram']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(12,$fila,$value['almacenamiento']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(13,$fila,$value['sistema_operativo']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(14,$fila,$value['accesorios']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(15,$fila,$value['fnombre']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(16,$fila,$value['fci']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(17,$fila,$value['fcodigo']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(18,$fila,$value['femail_empresa']);




        $this->docexcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);

        foreach(range('B','T') as $columnID) {
            $this->docexcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(20);
        }

        $this->docexcel->getActiveSheet()->getStyle('C8:T8')
            ->getAlignment()->setWrapText(true);
        $this->docexcel->getActiveSheet()->getStyle('C9:T9')
            ->getAlignment()->setWrapText(true);*/

        /*$this->docexcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->docexcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->docexcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

        for ($i = 4; $i <= $this->anios+4; ++$i) {
            $this->docexcel->getActiveSheet()->getColumnDimension($this->equivalencias[$i])->setWidth(14);
        }

        $this->docexcel->getActiveSheet()->getStyle('B1:B'.$this->docexcel->getActiveSheet()->getHighestRow())
            ->getAlignment()->setWrapText(true);

        $this->docexcel->getActiveSheet()->getStyle('C1:C'.$this->docexcel->getActiveSheet()->getHighestRow())
            ->getAlignment()->setWrapText(true);*/
    }

    function imprimeTitulo($sheetNumber,$titulo,$value){
        $sheet = $this->docexcel->setActiveSheetIndex($sheetNumber);

        $sheet->getStyle('C3')->getFont()->applyFromArray(array('bold'=>true,
            'size'=>12,
            'name'=>'Arial'));

        $sheet->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValueByColumnAndRow(1,1,strtoupper($titulo));
        $sheet->mergeCells('B1:D2');
        $sheet->setTitle("$value");

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath(dirname(__FILE__).'/../../lib/imagenes/logos/logo.jpg');

        $objDrawing->setHeight(60);
        $objDrawing->setWidth(120);
        $objDrawing->setWorksheet($this->docexcel->setActiveSheetIndex($sheetNumber));
    }

    function generarReporte(){


        $this->imprimeTitulo(0, "ASIGNACION DE TELEFONO CELULAR Y LINEA CORPORATIVA","formulario");
        /*$this->docexcel->createSheet();
        $this->imprimeTitulo(1, "SERVICIO DE LA DEUDA","CUOTA");
        $this->docexcel->createSheet();
        $this->imprimeTitulo(2, "SERVICIO DE LA DEUDA","AMORTIZACION");
        $this->docexcel->createSheet();
        $this->imprimeTitulo(3, "SERVICIO DE LA DEUDA","INTERES POR PAGAR");*/


        $this->imprimeDatos('saldo_capital_bolivianos',0, "FINANCIAMIENTO DETALLADO");
        /*$this->imprimeDatos('cuota_bolivianos',1, "CUOTA");
        $this->imprimeDatos('amortizacion_bolivianos',2, "AMORTIZACION");
        $this->imprimeDatos('interes_pendiente_bolivianos',3, "INTERES POR PAGAR");*/

        $this->docexcel->setActiveSheetIndex(0);
        $this->objWriter = PHPExcel_IOFactory::createWriter($this->docexcel, 'Excel5');
        $this->objWriter->save($this->url_archivo);

    }

    function setFechas($fecha_inicio, $fecha_fin){

        $this->primerAnio2 = $fecha_inicio;
        $this->ultimoAnio2 = $fecha_fin;

    }

    function getColumnByMonth($year) {
        $ts1 = strtotime($this->primerAnio);
        $ts2 = strtotime($year);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diffeee = (($year2 - $year1) * 12) + ($month2 - $month1);
        return $diffeee+4;
    }

    function min_attribute_in_array($array, $prop) {
        return min(array_map(function($o) use($prop) {
            return $o->$prop;
        },
            $array));
    }

}

?>