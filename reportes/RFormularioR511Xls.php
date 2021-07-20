<?php
class RFormularioR511Xls
{
    private $docexcel;
    private $objWriter;
    private $nombre_archivo;
    private $hoja;
    private $columnas=array();
    private $fila;
    private $equivalencias=array();

    private $objParam;
    public  $url_archivo;

    var $datos_detalle;
    var $total;

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

    function imprimeDatos($sheet){
        $this->docexcel->setActiveSheetIndex($sheet);
        $datos = $this->datos_detalle;

        $inicio_filas = 4;

        $fila = $inicio_filas+1;

        $styleArrayGroupCg = array(
            'font'  => array('bold'  => true),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'BDD7EE')),
            'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        );


        //*************************************Cabecera*****************************************


        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'NRO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,'NOMBRE');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,'GERENCIA');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,'CPU');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(16,$fila,'MONITOR');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(22,$fila,'FECHA DE ASIGNACION');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(23,$fila,'FECHA DE DEVOLUCION');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(24,$fila,'RESPONSABLE DE ASIGNACION');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(25,$fila,'OBSERVACIONES');

        $this->docexcel->setActiveSheetIndex(0)->mergeCells("D".($fila).":P".($fila));
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("Q".($fila).":V".($fila));
        foreach(range('A','C') as $columnID) {
            $this->docexcel->setActiveSheetIndex(0)->mergeCells($columnID.$fila.":".$columnID.($fila+1));
        }
        foreach(range('W','Z') as $columnID) {
            $this->docexcel->setActiveSheetIndex(0)->mergeCells($columnID.$fila.":".$columnID.($fila+1));
        }
        $this->docexcel->getActiveSheet()->getStyle("A$fila:Z$fila")->applyFromArray($styleArrayGroupCg);

        $fila++;
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,'MARCA');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(4,$fila,'MODELO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(5,$fila,'NUMERO DE SERIE');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(6,$fila,'VIDEO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(7,$fila,'PROCESADOR');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(8,$fila,'RAM');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(9,$fila,'DISPOSITIVO DE ALMACENAMIENTO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(10,$fila,'SISTEMA OPERATIVO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(11,$fila,'MOUSE');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(12,$fila,'TECLADO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(13,$fila,'ACCESORIOS');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(14,$fila,'ESTADO FISICO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(15,$fila,'CODIGO DE INMOVILIZADO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(16,$fila,'TAMAÑO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(17,$fila,'MARCA');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(18,$fila,'MODELO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(19,$fila,'NUMERO DE SERIE');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(20,$fila,'ESTADO FISICO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(21,$fila,'CODIGO DE INMOVILIZADO');

        $this->docexcel->getActiveSheet()->getStyle("A$fila:Z$fila")->applyFromArray($styleArrayGroupCg);
        $this->docexcel->getActiveSheet()->getRowDimension('5')->setRowHeight(20);

        $fila++;
        //*************************************Fin Cabecera*****************************************

        //***********************************Detalle***********************************************

        $totales = null;
        $totalBanco = null;
        $totalBono = null;
        $agrupador = null;
        for ($fi = 0; $fi < count($datos); $fi++) {
            $value = $datos[$fi];

            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,$fi+1);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,$value['desc_funcionario1']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,$value['nombre_unidad']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,$value['marca']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(4,$fila,$value['modelo']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(5,$fila,$value['num_serie']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(6,$fila,$value['tarjeta_video']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(7,$fila,$value['procesador']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(8,$fila,$value['memoria_ram']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(9,$fila,$value['almacenamiento']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(10,$fila,$value['sistema_operativo']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(11,$fila,$value['mouse']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(12,$fila,$value['teclado']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(13,$fila,$value['accesorios']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(14,$fila,$value['estado_fisico']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(15,$fila,$value['codigo_inmovilizado']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(16,$fila,$value['monitor_tamano']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(17,$fila,$value['monitor_marca']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(18,$fila,$value['monitor_modelo']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(19,$fila,$value['monitor_num_serie']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(20,$fila,$value['monitor_estado_fisico']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(21,$fila,$value['monitor_codigo_inmovilizado']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(22,$fila,$value['fecha_inicio']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(23,$fila,$value['fecha_fin']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(24,$fila,$value['asignador']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(25,$fila,$value['observaciones']);

            $fila++;
        }


        $this->docexcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $this->docexcel->getActiveSheet()->getColumnDimension('B')->setWidth(45);

        foreach(range('C','Z') as $columnID) {
            $this->docexcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(30);
        }

        $this->docexcel->getActiveSheet()->getStyle("C5:Z$fila")->getAlignment()->setWrapText(true);

    }

    function imprimeTitulo($sheetNumber,$titulo,$value){
        $sheet = $this->docexcel->setActiveSheetIndex($sheetNumber);
        $styleArrayGroupTitle = array(
            'font'  => array('bold'  => true, 'size'=>16,'color' => array('rgb' => 'FFFFFF')),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '34495E')),
            'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))

        );

        $sheet->setCellValueByColumnAndRow(2,2,strtoupper($titulo));
        $sheet->mergeCells('C2:V2');
        $sheet->getRowDimension('2')->setRowHeight(30);

        $sheet->setCellValueByColumnAndRow(2,3,'REGISTRO');
        $sheet->mergeCells('C3:J3');
        $sheet->getRowDimension('3')->setRowHeight(30);

        $sheet->setCellValueByColumnAndRow(10,3,'REGISTRO CPU Y MONITOR');
        $sheet->mergeCells('K3:V3');

        $sheet->getStyle("C2:Z3")->applyFromArray($styleArrayGroupTitle);

        $sheet->getStyle('W2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValueByColumnAndRow(22,2,'5-R-511/0');
        $sheet->mergeCells('W2:Z3');

        $sheet->setTitle("$value");

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath(dirname(__FILE__).'/../../lib/imagenes/logos/logo.jpg');

        $objDrawing->setHeight(80);
        $objDrawing->setWidth(160);
        $objDrawing->setWorksheet($this->docexcel->setActiveSheetIndex($sheetNumber));
    }

    function generarReporte(){

        $this->imprimeTitulo(0, "GERENCIA DE ADMINISTRACIÓN Y FINANZAS","Dispositivos");
        $this->imprimeDatos(0);

        $this->docexcel->setActiveSheetIndex(0);
        $this->objWriter = PHPExcel_IOFactory::createWriter($this->docexcel, 'Excel5');
        $this->objWriter->save($this->url_archivo);

    }

    function setFechas($fecha_inicio, $fecha_fin){

        $this->primerAnio2 = $fecha_inicio;
        $this->ultimoAnio2 = $fecha_fin;

    }


    function min_attribute_in_array($array, $prop) {
        return min(array_map(function($o) use($prop) {
            return $o->$prop;
        },
            $array));
    }

}

?>