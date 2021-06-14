<?php
class RFormularioFuncionarioXls
{
    private $docexcel;
    private $objWriter;
    private $nombre_archivo;
    private $hoja;
    private $columnas=array();
    private $fila;
    private $equivalencias=array();

    private $indice, $m_fila, $titulo;
    private $swEncabezado=0; //variable que define si ya se imprimi� el encabezado
    private $objParam;
    public  $url_archivo;

    var $datos_detalle;
    var $total;

    public $primerAnio;
    public $ultimoAnio;

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
            76=>'BY',77=>'BZ');

    }

    function datosHeader ( $detalle, $id_entrega) {

        $this->datos_detalle = $detalle;
        $this->id_entrega = $id_entrega;

    }

    function ImprimeCabera(){

    }

    function imprimeDatos(){
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

        $inicio_filas = 9;

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
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,5,'Fecha:');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,6,'Nombre:');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,7,'C.I.:');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,8,'Codigo:');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,9,'Email:');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,5,$this->ultimoAnio2);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,6,$datos[0]['fnombre']);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,7,$datos[0]['fci']);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,8,$datos[0]['fcodigo']);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,9,$datos[0]['femail_empresa']);
        $this->docexcel->getActiveSheet()->getStyle("A5:A9")->applyFromArray($styleArrayGroup);

        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,$fila,'EQUIPOS');
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("A".($fila).":H".($fila));

        $fila++;

        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'Estado');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'Tipo');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'Marca');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,'Modelo');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,'Estado Fisico');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,'Ubicacion');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(4,$fila,'Observaciones');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(5,$fila,'Color');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(6,$fila,'Imei');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(7,$fila,'Tamano Pantalla');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(8,$fila,'Tarjeta Video');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(9,$fila,'Teclado');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(10,$fila,'Procesador');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(11,$fila,'Memoria RAM');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(12,$fila,'Almacenamiento');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(13,$fila,'Sistema Operativo');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(14,$fila,'Accesorios');

        /*$this->docexcel->getActiveSheet()->getColumnDimension($this->equivalencias[0])->setWidth(20);
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,$fila,'En Bolivianos');
        $this->docexcel->getActiveSheet()->getColumnDimension($this->equivalencias[1])->setWidth(30);
        $this->docexcel->getActiveSheet()->getColumnDimension($this->equivalencias[2])->setWidth(30);
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,$fila,'Bs.');
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,$fila,'Bs.');
        $this->docexcel->getActiveSheet()->getColumnDimension($this->equivalencias[3])->setWidth(35);
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$fila,'Años');
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,$fila,'%');
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,$fila,'Historica');
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$fila,'Vigente');
        $this->docexcel->getActiveSheet()->getColumnDimension($this->equivalencias[4])->setWidth(15);
        $this->docexcel->getActiveSheet()->getStyle("A".($fila).":H".($fila))->applyFromArray($styleArrayGroup);*/
        $fila++;
        //*************************************Fin Cabecera*****************************************

        /////////////////////***********************************Detalle***********************************************
        $totalPublica = null;
        $totalBanco = null;
        $totalBono = null;
        $totalTotales = null;
        $tmp_rec = $datos[0];
        $siguiente = $datos[0];
        $agrupador = null;
        $addFila = true;
        $sumando = false;
        for ($fi = 0; $fi < count($datos); $fi++) {
            $value = $datos[$fi];

            if(($tmp_rec['tipo_deuda'] != $value['tipo_deuda']) or $fi == 0){
                if($value['tipo_deuda'] == 'public'){
                    $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,$fila,'Deuda Publica');
                    $totalPublica['fila'] = $fila;
                }elseif ($value['tipo_deuda'] == 'banco'){
                    $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,$fila,'Deuda Con Intituciones Financieras - Banca');
                    $totalBanco['fila'] = $fila;
                }elseif ($value['tipo_deuda'] == 'bono'){
                    $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,$fila,'Deuda Con Mercado de Valores - Bono');
                    $totalBono['fila'] = $fila;
                }
                foreach(range('C','H') as $columnID) {
                    $this->docexcel->getActiveSheet()->setCellValue($columnID.$fila,0);
                }

                $fila++;
            }

            foreach(range('C','H') as $columnID) {
                $this->docexcel->getActiveSheet()->setCellValue($columnID.$fila,0);
            }

            if($fi < count($datos)-1){
                $siguiente = $datos[$fi+1];
            }else{
                $sumando = true;
            }

            $agrupador['monto_bolivianos'] = $agrupador['monto_bolivianos'] + $value['monto_bolivianos'];
            $agrupador['saldo_bolivianos'] = $agrupador['saldo_bolivianos'] + $value['saldo_bolivianos'];
            $agrupador['plazo_anio_media'] = max($agrupador['plazo_anio_media'],$value['plazo_anio_media']);
            $agrupador['contador'] = $agrupador['contador']+1;
            $agrupador['tasa_media'] = $agrupador['tasa_media'] + $value['tasa_media'];
            $agrupador['total_ponderado'] = $agrupador['total_ponderado'] + $value['total_ponderado'];
            $agrupador['total_ponderado_vigente'] = $agrupador['total_ponderado_vigente'] + $value['total_ponderado_vigente'];
            if(($value['monto_bolivianos'] == $value['monto']) and $value['codigo'] == "\$us" and $value['monto_bolivianos'] != 0){
                $agrupador['is_cambio'] = true;
            }else{
                $agrupador['is_cambio'] = false;
            }

            if( ($siguiente['nombre'] == $value['nombre'] and $value['tipo_deuda'] == 'banco') or
                ($siguiente['id_linea_credito'] == $value['id_linea_credito'] and $value['tipo_deuda'] == 'bono')){
                $addFila = false;
            }else{
                $addFila = true;
            }

            if($addFila or $sumando){
                if($value['tipo_deuda'] == 'banco'){
                    $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,$fila,$value['nombre']);
                }elseif($value['tipo_deuda'] == 'bono'){
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
                            $nombreEntidad = $value['nombre_institucion'];
                    }
                    $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,$fila,$nombreEntidad);
                }else{
                    $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,$fila,$value['nombre'].' ('.$value['descripcion_contrato'].')');
                }
                $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,$fila,$value['codigo']);
                $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,$fila,$agrupador['monto_bolivianos']);
                $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,$fila,$agrupador['saldo_bolivianos']);
                $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$fila,$agrupador['plazo_anio_media']);
                $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,$fila,($agrupador['tasa_media']/$agrupador['contador']));
                $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,$fila,(($agrupador['total_ponderado']/$agrupador['monto_bolivianos'])*100));
                if($agrupador['saldo_bolivianos'] > 0){
                    $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$fila,(($agrupador['total_ponderado_vigente']/$agrupador['saldo_bolivianos'])*100));
                }else{
                    $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$fila,0);
                }
                if($agrupador['is_cambio']){
                    $this->docexcel->getActiveSheet()->getStyle("C$fila:C$fila")->applyFromArray($styleArrayGroupCg22);
                }


                $this->docexcel->getActiveSheet()->getStyle("C$fila:H$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);
                if($value['tipo_deuda'] == 'public'){
                    $totalPublica['monto_bolivianos'] = $totalPublica['monto_bolivianos'] + $agrupador['monto_bolivianos'];
                    $totalPublica['saldo_bolivianos'] = $totalPublica['saldo_bolivianos'] + $agrupador['saldo_bolivianos'];
                    $totalPublica['plazo_anio_media'] = $totalPublica['plazo_anio_media'] + $agrupador['plazo_anio_media'];
                    $totalPublica['count'] = $totalPublica['count'] + 1;
                    $totalPublica['tasa_media'] = $totalPublica['tasa_media'] + $agrupador['tasa_media'];
                    $totalPublica['tasa_ponderada'] = $totalPublica['tasa_ponderada'] +($agrupador['monto_bolivianos']*(($agrupador['tasa_media']/$agrupador['contador'])/100));
                    $totalPublica['tasa_ponderada_vigente'] = $totalPublica['tasa_ponderada_vigente'] +($agrupador['saldo_bolivianos']*(($agrupador['tasa_media']/$agrupador['contador'])/100));
                }elseif ($value['tipo_deuda'] == 'banco'){
                    $totalBanco['monto_bolivianos'] = $totalBanco['monto_bolivianos'] + $agrupador['monto_bolivianos'];
                    $totalBanco['saldo_bolivianos'] = $totalBanco['saldo_bolivianos'] + $agrupador['saldo_bolivianos'];
                    $totalBanco['plazo_anio_media'] = $totalBanco['plazo_anio_media'] + $agrupador['plazo_anio_media'];
                    $totalBanco['count'] = $totalBanco['count'] + 1;
                    $totalBanco['tasa_media'] = $totalBanco['tasa_media'] + $agrupador['tasa_media'];
                    $totalBanco['tasa_ponderada'] = $totalBanco['tasa_ponderada'] + ($agrupador['monto_bolivianos']*(($agrupador['tasa_media']/$agrupador['contador'])/100));
                    $totalBanco['tasa_ponderada_vigente'] = $totalBanco['tasa_ponderada_vigente'] +($agrupador['saldo_bolivianos']*(($agrupador['tasa_media']/$agrupador['contador'])/100));
                }elseif ($value['tipo_deuda'] == 'bono'){
                    $totalBono['monto_bolivianos'] = $totalBono['monto_bolivianos'] + $agrupador['monto_bolivianos'];
                    $totalBono['saldo_bolivianos'] = $totalBono['saldo_bolivianos'] + $agrupador['saldo_bolivianos'];
                    $totalBono['plazo_anio_media'] = $totalBono['plazo_anio_media'] + $agrupador['plazo_anio_media'];
                    $totalBono['count'] = $totalBono['count'] + 1;
                    $totalBono['tasa_media'] = $totalBono['tasa_media'] + $agrupador['tasa_media'];
                    $totalBono['tasa_ponderada'] = $totalBono['tasa_ponderada'] +($agrupador['monto_bolivianos']*(($agrupador['tasa_media']/$agrupador['contador'])/100));
                    $totalBono['tasa_ponderada_vigente'] = $totalBono['tasa_ponderada_vigente'] +($agrupador['saldo_bolivianos']*(($agrupador['tasa_media']/$agrupador['contador'])/100));
                }
                $agrupador = null;
                $fila++;
            }
            $tmp_rec = $value;
        }

        if($totalPublica['count'] > 0){
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,$totalPublica['fila'],$totalPublica['monto_bolivianos']);
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,$totalPublica['fila'],$totalPublica['saldo_bolivianos']);
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$totalPublica['fila'],($totalPublica['plazo_anio_media']/$totalPublica['count']));
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,$totalPublica['fila'],($totalPublica['tasa_media']/$totalPublica['count']));
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,$totalPublica['fila'],(($totalPublica['tasa_ponderada']/$totalPublica['monto_bolivianos'])*100));
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$totalPublica['fila'],(($totalPublica['tasa_ponderada_vigente']/$totalPublica['saldo_bolivianos'])*100));
            $this->docexcel->getActiveSheet()->getStyle("A".$totalPublica['fila'].":H".$totalPublica['fila'])->applyFromArray($styleArrayGroupCg);
            $this->docexcel->getActiveSheet()->getStyle("C".$totalPublica['fila'].":H".$totalPublica['fila']."")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);

            $totalTotales['monto_bolivianos'] = $totalTotales['monto_bolivianos'] + $totalPublica['monto_bolivianos'];
            $totalTotales['saldo_bolivianos'] = $totalTotales['saldo_bolivianos'] + $totalPublica['saldo_bolivianos'];
            $totalTotales['plazo_anio_media'] = $totalTotales['plazo_anio_media'] + $totalPublica['plazo_anio_media'];
            $totalTotales['count'] = $totalTotales['count'] + $totalPublica['count'];
            $totalTotales['tasa_media'] = $totalTotales['tasa_media'] + $totalPublica['tasa_media'];
            $totalTotales['tasa_ponderada'] = $totalTotales['tasa_ponderada'] +($totalPublica['monto_bolivianos']*($totalPublica['tasa_ponderada']/$totalPublica['monto_bolivianos']));
            $totalTotales['tasa_ponderada_vigente'] = $totalTotales['tasa_ponderada_vigente'] +($totalPublica['saldo_bolivianos']*($totalPublica['tasa_ponderada_vigente']/$totalPublica['saldo_bolivianos']));
        }

        if($totalBanco['count'] > 0){
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,$totalBanco['fila'],$totalBanco['monto_bolivianos']);
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,$totalBanco['fila'],$totalBanco['saldo_bolivianos']);
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$totalBanco['fila'],($totalBanco['plazo_anio_media']/$totalBanco['count']));
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,$totalBanco['fila'],($totalBanco['tasa_media']/$totalBanco['count']));
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,$totalBanco['fila'],(($totalBanco['tasa_ponderada']/$totalBanco['monto_bolivianos'])*100));
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$totalBanco['fila'],(($totalBanco['tasa_ponderada_vigente']/$totalBanco['saldo_bolivianos'])*100));
            $this->docexcel->getActiveSheet()->getStyle("A".$totalBanco['fila'].":H".$totalBanco['fila'])->applyFromArray($styleArrayGroupCg);
            $this->docexcel->getActiveSheet()->getStyle("C".$totalBanco['fila'].":H".$totalBanco['fila']."")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);

            $totalTotales['monto_bolivianos'] = $totalTotales['monto_bolivianos'] + $totalBanco['monto_bolivianos'];
            $totalTotales['saldo_bolivianos'] = $totalTotales['saldo_bolivianos'] + $totalBanco['saldo_bolivianos'];
            $totalTotales['plazo_anio_media'] = $totalTotales['plazo_anio_media'] + $totalBanco['plazo_anio_media'];
            $totalTotales['count'] = $totalTotales['count'] + $totalBanco['count'];
            $totalTotales['tasa_media'] = $totalTotales['tasa_media'] + $totalBanco['tasa_media'];
            $totalTotales['tasa_ponderada'] = $totalTotales['tasa_ponderada'] +($totalBanco['monto_bolivianos']*($totalBanco['tasa_ponderada']/$totalBanco['monto_bolivianos']));
            $totalTotales['tasa_ponderada_vigente'] = $totalTotales['tasa_ponderada_vigente'] +($totalBanco['saldo_bolivianos']*($totalBanco['tasa_ponderada_vigente']/$totalBanco['saldo_bolivianos']));
        }

        if($totalBono['count'] > 0){
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,$totalBono['fila'],$totalBono['monto_bolivianos']);
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,$totalBono['fila'],$totalBono['saldo_bolivianos']);
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$totalBono['fila'],($totalBono['plazo_anio_media']/$totalBono['count']));
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,$totalBono['fila'],($totalBono['tasa_media']/$totalBono['count']));
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,$totalBono['fila'],(($totalBono['tasa_ponderada']/$totalBono['monto_bolivianos'])*100));
            $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$totalBono['fila'],(($totalBono['tasa_ponderada_vigente']/$totalBono['saldo_bolivianos'])*100));
            $this->docexcel->getActiveSheet()->getStyle("A".$totalBono['fila'].":H".$totalBono['fila'])->applyFromArray($styleArrayGroupCg);
            $this->docexcel->getActiveSheet()->getStyle("C".$totalBono['fila'].":H".$totalBono['fila']."")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);

            $totalTotales['monto_bolivianos'] = $totalTotales['monto_bolivianos'] + $totalBono['monto_bolivianos'];
            $totalTotales['saldo_bolivianos'] = $totalTotales['saldo_bolivianos'] + $totalBono['saldo_bolivianos'];
            $totalTotales['plazo_anio_media'] = $totalTotales['plazo_anio_media'] + $totalBono['plazo_anio_media'];
            $totalTotales['count'] = $totalTotales['count'] + $totalBono['count'];
            $totalTotales['tasa_media'] = $totalTotales['tasa_media'] + $totalBono['tasa_media'];
            $totalTotales['tasa_ponderada'] = $totalTotales['tasa_ponderada'] +($totalBono['monto_bolivianos']*($totalBono['tasa_ponderada']/$totalBono['monto_bolivianos']));
            $totalTotales['tasa_ponderada_vigente'] = $totalTotales['tasa_ponderada_vigente'] +($totalBono['saldo_bolivianos']*($totalBono['tasa_ponderada_vigente']/$totalBono['saldo_bolivianos']));
        }

        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,$fila,'TOTAL');
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,$fila,$totalTotales['monto_bolivianos']);
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,$fila,$totalTotales['saldo_bolivianos']);
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$fila, $totalTotales['count'] > 0 ? ($totalTotales['plazo_anio_media']/$totalTotales['count']) : 0);
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,$fila, $totalTotales['count'] > 0 ? ($totalTotales['tasa_media']/$totalTotales['count']) : 0);
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,$fila, $totalTotales['monto_bolivianos'] > 0 ? (($totalTotales['tasa_ponderada']/$totalTotales['monto_bolivianos'])*100) : 0);
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$fila, $totalTotales['saldo_bolivianos'] > 0 ? (($totalTotales['tasa_ponderada_vigente']/$totalTotales['saldo_bolivianos'])*100) : 0);
        $this->docexcel->getActiveSheet()->getStyle("A$fila:H$fila")->applyFromArray($styleArrayGroupCg);
        $this->docexcel->getActiveSheet()->getStyle("C$fila:H$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);

        $fila = $fila+2;
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,$fila,'Tasa Promedio Nuevo Financiamiento');
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,$fila,0);
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,$fila,0);
        $this->docexcel->getActiveSheet()->getStyle("A$fila:A$fila")->applyFromArray($styleArrayGroupCg);
        $this->docexcel->getActiveSheet()->getStyle("B$fila:C$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat :: FORMAT_NUMBER_COMMA_SEPARATED1);


        $this->docexcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
        $this->docexcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        foreach(range('C','H') as $columnID) {
            $this->docexcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(14);
        }

        $this->docexcel->getActiveSheet()->getStyle('B1:B'.$this->docexcel->getActiveSheet()->getHighestRow())
            ->getAlignment()->setWrapText(true);

        $this->docexcel->getActiveSheet()->getStyle('C1:C'.$this->docexcel->getActiveSheet()->getHighestRow())
            ->getAlignment()->setWrapText(true);
    }

    function imprimeTitulo($sheet){
        $titulo = "RESUMEN ESTADO DE FINANCIAMIENTO";

        $sheet->getStyle('B3')->getFont()->applyFromArray(array('bold'=>true,
            'size'=>12,
            'name'=>'Arial'));

        $sheet->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValueByColumnAndRow(1,3,strtoupper($titulo));
        $sheet->mergeCells('B3:E3');

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath(dirname(__FILE__).'/../../lib/imagenes/logos/logo.jpg');

        $objDrawing->setHeight(60);
        $objDrawing->setWorksheet($this->docexcel->setActiveSheetIndex(0));
    }

    function setFechas($fecha_inicio, $fecha_fin){

        $this->primerAnio = $fecha_inicio;
        $this->ultimoAnio = $fecha_fin;

    }

    function generarReporte(){


        $this->imprimeTitulo($this->docexcel->setActiveSheetIndex(0));
        $this->imprimeDatos();

        $this->docexcel->setActiveSheetIndex(0);
        $this->objWriter = PHPExcel_IOFactory::createWriter($this->docexcel, 'Excel5');
        $this->objWriter->save($this->url_archivo);

    }


}

?>