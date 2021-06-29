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
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        );

        //*************************************Cabecera*****************************************
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,5,'Fecha:');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,6,'Nombre:');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,7,'C.I.:');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,8,'Codigo:');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,9,'Email:');
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,5,date("d-m-Y", strtotime("now")));
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,6,$datos[0]['fnombre']);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,7,$datos[0]['fci']);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,8,$datos[0]['fcodigo']);
        $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,9,$datos[0]['femail_empresa']);
        $this->docexcel->getActiveSheet()->getStyle("A5:A9")->applyFromArray($styleArrayGroup);
        $this->docexcel->getActiveSheet()->getStyle("B5:B9")->applyFromArray($styleArrayGroupCg22);
        $fila++;
        $this->docexcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,$fila,'EQUIPOS');
        $this->docexcel->setActiveSheetIndex(0)->mergeCells("A".($fila).":P".($fila));
        $this->docexcel->getActiveSheet()->getStyle("A$fila:P$fila")->applyFromArray($styleArrayGroup);
        $fila++;

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
        $this->docexcel->getActiveSheet()->getStyle("A$fila:P$fila")->applyFromArray($styleArrayGroupCg);

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

            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,$value['tipo_desc']);
            if ($value['estado_reg'] == 'activo'){
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,'Asignado');
            }else{
                $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,'Devuelto');
            }
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,$value['marca']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(3,$fila,$value['modelo']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(4,$fila,$value['estado_fisico']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(5,$fila,$value['observaciones']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(6,$fila,$value['color']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(7,$fila,$value['imei']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(8,$fila,$value['tamano_pantalla']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(9,$fila,$value['tarjeta_video']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(10,$fila,$value['teclado']." - ".$value['teclado_idioma']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(11,$fila,$value['procesador']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(12,$fila,$value['memoria_ram']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(13,$fila,$value['almacenamiento']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(14,$fila,$value['sistema_operativo']);
            $this->docexcel->getActiveSheet()->setCellValueByColumnAndRow(15,$fila,$value['accesorios']);

            $fila++;
        }



        $this->docexcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
        $this->docexcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        foreach(range('C','P') as $columnID) {
            $this->docexcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(20);
        }
        $this->docexcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $this->docexcel->getActiveSheet()->getStyle("A5:P$fila".$this->docexcel->getActiveSheet()->getHighestRow())
            ->getAlignment()->setWrapText(true);

    }

    function imprimeTitulo($sheet){
        $titulo = "GERENCIA DE ADMINISTRACIÓN Y FINANZAS";

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