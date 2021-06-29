<?php
class RFormularioRegistroDispositivosXls
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

        $inicio_filas = 4;

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

        //*************************************Cabecera*****************************************


        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'NRO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,'NOMBRE');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,'GERENCIA');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,'DEPARTAMENTO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(4,$fila,'CONTRATO TRABAJADOR');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(5,$fila,'TIPO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(6,$fila,'MARCA');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(7,$fila,'MODELO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(8,$fila,'NUMERO DE SERIE');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(9,$fila,'COLOR');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(10,$fila,'ROM');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(11,$fila,'RAM');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(12,$fila,'IMEI 1');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(13,$fila,'IMEI 2');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(14,$fila,'ACCESORIOS');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(15,$fila,'CONDICION DEL EQUIPO');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(16,$fila,'FECHA DE ASIGNACION');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(17,$fila,'FECHA DE DEVOLUCION');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(18,$fila,'ESTADO (DEPOSITO U OPERATIVO)');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(19,$fila,'RESPONSABLE DE ASIGNACION');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(20,$fila,'OBSERVACIONES');



        $this->docexcel->getActiveSheet()->getStyle("A$fila:U$fila")->applyFromArray($styleArrayGroupCg);
        $this->docexcel->getActiveSheet()->getRowDimension('5')->setRowHeight(20);

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

            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,$fi+1);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,$value['desc_funcionario1']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,$value['nombre_unidad']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,$value['nombre_departamento']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(4,$fila,$value['tipo_contrato']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(5,$fila,$value['tipo_desc']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(6,$fila,$value['marca']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(7,$fila,$value['modelo']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(8,$fila,$value['num_serie']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(9,$fila,$value['color']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(10,$fila,$value['rom']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(11,$fila,$value['ram']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(12,$fila,$value['imei']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(13,$fila,$value['imei2']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(14,$fila,$value['desc_accesorios']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(15,$fila,$value['estado_fisico']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(16,$fila,$value['fecha_asignacion']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(17,$fila,$value['fecha_devolucion']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(18,$fila,$value['estado']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(19,$fila,$value['asignador']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(20,$fila,$value['observaciones']);

            /*$agrupador['monto_solicitado_bolivianos'] += $value['monto_solicitado_bolivianos'];
            $agrupador['monto_utilizado_bolivianos'] += $value['monto_utilizado_bolivianos'];
            $agrupador['saldo_capital_bolivianos'] += $value['saldo_capital_bolivianos'];
            $agrupador['garantia_activo_fijo'] += $value['garantia_activo_fijo'];

            if($fi < count($datos)-1){
                $siguiente = $datos[$fi+1];
            }else{
                $sumando = true;
            }

            if($siguiente['id_linea_credito'] == $value['id_linea_credito'] and $value['tipo_deuda'] == 'bono'){
                $sumando = false;
            }else{
                $sumando = true;
            }

            if($sumando){
                if($value['tipo_deuda'] == 'bono'){
                    $nombreEntidad = null;
                    switch ($value['desc_linea_credito']) {
                        case "BONOS 1":
                            $nombreEntidad = 'EMISIÓN 1';
                            break;
                        case "BONOS 2":
                            $nombreEntidad = 'EMISIÓN 2';
                            break;
                        case "BONOS 3":
                            $nombreEntidad = 'EMISIÓN 3';
                            break;
                        case "BONOS 4":
                            $nombreEntidad = 'EMISIÓN 4';
                            break;
                        case "BONOS 5":
                            $nombreEntidad = 'EMISIÓN 5';
                            break;
                        case "BONOS 6":
                            $nombreEntidad = 'EMISIÓN 6';
                            break;
                        default:
                            $nombreEntidad = 'dfdf'; //$value['nombre_institucion'];
                    }
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,$nombreEntidad);
                }else{
                    $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,$value['nro_tramite'].' ('.$value['descripcion_contrato'].')');
                }

                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,$value['desc_moneda']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,$agrupador['monto_solicitado_bolivianos']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,$agrupador['monto_utilizado_bolivianos']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(4,$fila,$value['porcentaje_util']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(5,$fila,$agrupador['saldo_capital_bolivianos']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(6,$fila,$value['fecha_limite']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(7,$fila,$value['fecha_desde']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(8,$fila,$value['plazo_anio']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(9,$fila,$value['fecha_hasta']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(10,$fila,$value['tasa_interes']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(11,$fila,$value['periodicidad']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(12,$fila,$value['tipo_garantia']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(13,$fila,$value['inventario']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(14,$fila,$value['caja']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(15,$fila,$agrupador['garantia_activo_fijo']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(16,$fila,$value['ratio_cobertura']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(17,$fila,$value['ratio_cobertura_req']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(18,$fila,$value['garantia_liberada']);
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(19,$fila,$value['prestamo_garantizable']);

                $this->docexcel->getActiveSheet()->getStyle("C$fila:D$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);
                $this->docexcel->getActiveSheet()->getStyle("F$fila:F$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);
                $this->docexcel->getActiveSheet()->getStyle("N$fila:T$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);



                $totales['monto_solicitado_bolivianos'] += $agrupador['monto_solicitado_bolivianos'];
                $totales['saldo_capital_bolivianos'] += $agrupador['saldo_capital_bolivianos'];
                $totales['tasa_interes'] += $value['tasa_interes'];
                $totales['numero'] += 1;

                $agrupador = null;
                $fila++;
            }*/
            $fila++;
        }

        /*$this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,'Total Saldo Deuda');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,$totales['monto_solicitado_bolivianos']);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(5,$fila,$totales['saldo_capital_bolivianos']);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(9,$fila,'Tasa efectiva');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(10,$fila,$totales['tasa_interes']/$totales['numero']);

        $this->docexcel->getActiveSheet()->getStyle("C$fila:F$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);
        $this->docexcel->getActiveSheet()->getStyle("K$fila:K$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);
        $this->docexcel->getActiveSheet()->getStyle("B$fila:B$fila")->applyFromArray($styleArrayGroupCg);
        $this->docexcel->getActiveSheet()->getStyle("J$fila:J$fila")->applyFromArray($styleArrayGroupCg);*/


        $this->docexcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $this->docexcel->getActiveSheet()->getColumnDimension('B')->setWidth(45);

        foreach(range('C','U') as $columnID) {
            $this->docexcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(30);
        }

        $this->docexcel->getActiveSheet()->getStyle("C6:U$fila")
            ->getAlignment()->setWrapText(true);

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

        /*$sheet->getStyle('C3')->getFont()->applyFromArray(array('bold'=>true,
            'size'=>12,
            'name'=>'Arial'));*/

        $styleArrayGroupTitle = array(
            'font'  => array('bold'  => true, 'size'=>16,'color' => array('rgb' => 'FFFFFF')),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '34495E')),
            'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))

        );

        //$sheet->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValueByColumnAndRow(2,2,strtoupper($titulo));
        $sheet->mergeCells('C2:R2');
        $sheet->getRowDimension('2')->setRowHeight(30);

        //$sheet->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValueByColumnAndRow(2,3,'REGISTRO');
        $sheet->mergeCells('C3:J3');
        $sheet->getRowDimension('3')->setRowHeight(30);

        //$sheet->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValueByColumnAndRow(10,3,'REGISTRO DE DISPOSITIVOS MOVILES');
        $sheet->mergeCells('K3:R3');

        //$sheet->getStyle("C2:U3")->getFont()->setSize(16);

        $sheet->getStyle("C2:U3")->applyFromArray($styleArrayGroupTitle);

        $sheet->getStyle('S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValueByColumnAndRow(18,2,'5-R-514/0');
        $sheet->mergeCells('S2:U3');

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

        $this->imprimeTitulo(0, "GERENCIA DE ADMINISTRACIÓN Y FINANZAS","dispositivos");
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