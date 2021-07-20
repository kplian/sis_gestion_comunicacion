<?php
// Extend the TCPDF class to create custom MultiRow
class RFormularioR514Pdf extends  ReportePDF {
    var $datos_titulo;
    var $datos_detalle;
    var $ancho_hoja;
    var $gerencia;
    var $numeracion;
    var $ancho_sin_totales;
    var $cantidad_columnas_estaticas;
    var $s1;
    var $t1;
    var $tg1;
    var $total;
    var $datos_entidad;
    var $datos_periodo;
    var $ult_codigo_partida;
    var $ult_concepto;



    function datosHeader ( $detalle ) {
        $this->SetHeaderMargin(4);
        //$this->SetAutoPageBreak(TRUE, 12);
        //$this->ancho_hoja = $this->getPageWidth()-PDF_MARGIN_LEFT-PDF_MARGIN_RIGHT-10;
        $this->datos_detalle = $detalle;
        /*$this->datos_titulo = $totales;
        $this->datos_entidad = $dataEmpresa;
        $this->datos_gestion = $gestion;*/
        $this->subtotal = 0;
        $this->SetMargins(7, 45, 5);


    }

    function Header() {

        $white = array('LTRB' =>array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 255, 255)));
        $black = array('T' =>array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));


        $this->Ln(3);
        //formato de fecha

        //cabecera del reporte
        $this->Image(dirname(__FILE__).'/../../lib/imagenes/logos/logo.jpg', 10,5,35,20);
        $this->ln(5);
        $this->Cell(0,5,"",0,1,'C');

        $this->SetFont('','B',11);
        $this->Cell(0,5,"GERENCIA DE ADMINISTRACIÓN Y FINANZAS",0,1,'C');
        //$this->Cell(0,5,mb_strtoupper($this->datos_entidad['nombre'],'UTF-8'),0,1,'C');
        $this->Cell(0,5,"REGISTRO DE DISPOSITIVOS MOVILES ",0,1,'C');
        //$this->Ln();
        $this->SetFont('','B',9);
        $this->Cell(0,5,"5-R-514/0",0,1,'C');
        $this->Ln(2);


        $this->Cell(0,5,"",0,1,'C');
        $height = 5;
        $width1 = 5;
        $esp_width = 10;
        $width_c1= 55;
        $width_c2= 92;
        $width3 = 40;
        $width4 = 75;



        $this->SetFont('','B',5);
        //$this->generarCabecera();
        //armca caecera de la tabla
        $conf_par_tablewidths=array(10,50,50,80,15,20,15,25);
        $conf_par_tablealigns=array('C','C','C','C','C','C','C','C');
        $conf_par_tablenumbers=array(0,0,0,0,0,0,0,0);
        $conf_tableborders=array();
        $conf_tabletextcolor=array();

        //$this->tablewidths=$conf_par_tablewidths;
        //$this->tablealigns=$conf_par_tablealigns;
        //$this->tablenumbers=$conf_par_tablenumbers;
        //$this->tableborders=$conf_tableborders;
        //$this->tabletextcolor=$conf_tabletextcolor;
        /*$this->Cell(5,4,"Nº",1,0,'C');
        $this->Cell(20,4,"NOMBRE",1,0,'C');
        $this->Cell(20,4,"GERENCIA",1,0,'C');
        $this->Cell(20,4,"DEPARTAMENTO",1,0,'C');
        $this->Cell(15,4,"CONTRATO TRABAJADOR",1,0,'C');
        $this->Cell(15,4,"TIPO",1,0,'C');
        $this->Cell(15,4,"MARCA",1,0,'C');
        $this->Cell(15,4,"MODELO",1,0,'C');
        $this->Cell(20,4,"NUMERO DE SERIE",1,0,'C');
        $this->Cell(15,4,"COLOR",1,0,'C');
        $this->Cell(15,4,"ROM",1,0,'C');
        $this->Cell(15,4,"RAM",1,0,'C');
        $this->Cell(15,4,"IMEI 1",1,0,'C');
        $this->Cell(15,4,"IMEI 2",1,0,'C');
        $this->Cell(15,4,"ACCESORIOS",1,0,'C');
        $this->Cell(20,4,"CONDICION DEL EQUIPO",1,0,'C');
        $this->Cell(25,4,"FECHA DE ASIGNACION",1,0,'C');
        $this->Cell(25,4,"FECHA DE DEVOLUCION",1,0,'C');
        $this->Cell(15,4,"ESTADO",1,0,'C');
        $this->Cell(30,4,"RESPONSABLE DE ASIGNACION",1,0,'C');
        $this->Cell(25,4,"OBSERVACIONES",1,1,'C');*/


        $this->MultiCell(5,5,"Nº", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(25,5,"NOMBRE", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(30,5,"GERENCIA", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(25,5,"DEPARTAMENTO", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(15,5,"CONTRATO TRABAJADOR", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(10,5,"TIPO", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(15,5,"MARCA", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(15,5,"MODELO", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(20,5,"NUMERO DE SERIE", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(15,5,"COLOR", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(15,5,"ROM", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(15,5,"RAM", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(17,5,"IMEI 1", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(17,5,"IMEI 2", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(25,5,"ACCESORIOS", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(20,5,"CONDICION DEL EQUIPO", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(25,5,"FECHA DE ASIGNACION", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(25,5,"FECHA DE DEVOLUCION", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(10,5,"ESTADO", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(30,5,"RESPONSABLE DE ASIGNACION", 1, 'C', 0, 0, '', '', true);
        $this->MultiCell(30,5,"OBSERVACIONES", 1, 'C', 0, 1, '', '', true);

/*
        $this->Cell(10,3,"","LB",0,'C');
        $this->Cell(50,3,"","LB",0,'C');
        $this->Cell(50,3,"","LB",0,'C');
        $this->Cell(80,3,"","LB",0,'C');
        $this->Cell(15,3,"","LB",0,'C');
        $this->Cell(20,3,"","LB",0,'C');
        $this->Cell(15,3,"","LB",0,'C');
        $this->Cell(25,3,"","LBR",0,'C');*/

/*
        $RowArray = array(
            's0'  => 'Nº',
            's1' => 'DEPARTAMENTO',
            's2' => 'CONCEPTO DE GASTO',
            's3' => 'JUSTIFICACION',
            's4' => 'UNIDAD DE MEDIDA',
            's5' => 'COSTO UNITARIO',
            's6' => 'CANT. REQ.',
            's7' => 'TOTAL ESTACIONALIDAD');*/

        //$this-> MultiRow($RowArray,false,1);


    }

    function generarReporte() {
        //$this->setFontSubsetting(false);
        $this->AddPage();

        $sw = false;
        $concepto = '';

        $this->generarCuerpo($this->datos_detalle);


        /*$this->cerrarCuadro();
        $this->Ln(4);
        $this->cerrarConcepto();
        $this->Ln(4);
        $this->cerrarCuadroTotal();*/



        //$this->Ln(4);


    }
    /*function generarCabecera(){



        //armca caecera de la tabla
        $conf_par_tablewidths=array(10,50,50,80,15,20,15,25);
        $conf_par_tablealigns=array('C','C','C','C','C','C','C','C');
        $conf_par_tablenumbers=array(0,0,0,0,0,0,0,0);
        $conf_tableborders=array();
        $conf_tabletextcolor=array();

        $this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;

        $RowArray = array(
            's0'  => 'Nº',
            's1' => 'DEPARTAMENTO',
            's2' => 'CONCEPTO DE GASTO',
            's3' => 'JUSTIFICACION',
            's4' => 'UNIDAD DE MEDIDA',
            's5' => 'COSTO UNITARIO',
            's6' => 'CANT. REQ.',
            's7' => 'TOTAL ESTACIONALIDAD');

        //$this-> MultiRow($RowArray,false,1);


    }*/

    function generarCuerpo($detalle) {

        $count = 1;
        $sw = 0;
        $sw1 = 0;
        $this->ult_codigo_partida = '';
        $this->ult_concepto = '';
        $fill = 0;

        $this->total = count($detalle);

        $this->s1 = 0;
        $this->t1 = 0;
        $this->tg1 = 0;


        foreach ($detalle as $val) {

            /*if($sw == 1){
                if($this->ult_codigo_partida != $val["codigo_partida"]){
                    $sw = 0;
                    $count = 1;
                    $this->cerrarCuadro();
                    $this->Ln(4);
                    //$this->revisarfinPagina();
                }
            }

            if($sw1 == 1){
                if($this->ult_concepto != $val["concepto"]){
                    $sw1 = 0;
                    $this->cerrarConcepto();
                    $this->Ln(4);
                    //$this->revisarfinPagina();
                }
            }*/




            /*if($sw1 == 0){
                $fill = 0;
                $this->imprimirConcepto($val["concepto"],$fill);
                $this->Ln(4);
                $fill = !$fill;
                $sw1 = 1;
                $this->ult_concepto = $val["concepto"];
            }

            if($sw == 0){
                $fill = 0;
                $this->imprimirPartida($val["codigo_partida"]." - ".$val["nombre_partida"],$fill);
                $fill = !$fill;
                $sw = 1;
                $this->ult_codigo_partida = $val["codigo_partida"];
            }*/




            $this->imprimirLinea($val,$count,$fill);
            $fill = !$fill;
            $count = $count + 1;
            $this->total = $this->total -1;
            //$this->revisarfinPagina();

        }



    }

    function imprimirLinea($val,$count,$fill){

        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('','',5);

        $conf_par_tablewidths=array(5,25,30,25,15,10,15,15, 20,15,15,15,17,17,25,20,25,25,10,30,30);
        $conf_par_tablealigns=array('C','L','L','L','R','R','R','R', 'R','R','R','R','R','R','R','R','R','R','R','R','R');
        $conf_par_tablenumbers=array(0,0,0,0,0,0,0,0, 0,0,0,0,0,0,0,0,0,0,0,0,0);
        $conf_tableborders=array('T','T','T','T','T','T','T','T', 'T','T','T','T','T','T','T','T','T','T','T','T','T');

        $this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;

        //$this->caclularMontos($val);

        $newDate = date("d/m/Y", strtotime( $val['fecha']));

        /*$RowArray = array(
            's0' => $count,
            's1' => '',//$val['desc_funcionario1'],
            's2' => '',//$val['nombre_unidad'],
            's3' => '',//$val['nombre_departamento'],
            's4' => '',//$val['tipo_contrato'],
            's5' => '',//$val['tipo_desc'],
            's6' => '',//$val['marca'],
            's7' => '',
            's8' => '');


        $this-> MultiRow($RowArray,$fill,1);*/
        $RowArray = array(
            's0' => $count,
            's1' => $val['desc_funcionario1'],
            's2' => $val['nombre_unidad'],
            's3' => $val['nombre_departamento'],
            's4' => $val['tipo_contrato'],
            's5' => $val['tipo_desc'],
            's6' => $val['marca'],
            's7' => $val['modelo'],

            's8' => $val['num_serie'],
            's9' => $val['color'],
            's10' => $val['rom'],
            's11' => $val['ram'],
            's12' => $val['imei'],
            's13' => $val['imei2'],
            's14' => $val['desc_accesorios'],
            's15' => $val['estado_fisico'],
            's16' => date("d-m-Y", strtotime($val['fecha_asignacion'])),
            's17' => date("d-m-Y", strtotime($val['fecha_devolucion'])),
            's18' => $val['estado'],
            's19' => $val['asignador'],
            's20' => $val['observaciones']);

        $this-> MultiRow($RowArray,$fill,1);

    }



    function imprimirPartida($titulo,$fill){

        $this->SetFont('','B',9);
        $this->tablewidths=array(10+50+50+80+15+20+15+25);
        $this->tablealigns=array('L');
        $this->tablenumbers=array(0);
        $this->tableborders=array('B');
        $this->tabletextcolor=$conf_tabletextcolor;

        $RowArray = array(
            'casa' => $titulo);

        $this-> MultiRow($RowArray,$fill,1);

    }

    function imprimirConcepto($titulo,$fill){
        $conf_par_tablewidths=array(10+50+50+80+15+20+15+25);
        $conf_par_tablealigns=array('L');
        $conf_par_tablenumbers=array(0);
        $conf_tableborders=array('B');
        $this->SetFont('','B',11);


        $this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;

        $RowArray = array(
            'casa' => $titulo);

        $this-> MultiRow($RowArray,$fill,1);

    }



    function caclularMontos($val){

        $this->s1 = $this->s1 + $val['importe'];
        $this->t1 = $this->t1 + $val['importe'];
        $this->tg1 = $this->tg1 + $val['importe'];
    }




    function cerrarCuadro(){


        //si noes inicio termina el cuardro anterior

        $this->tablewidths=array(10+50+50+80+15+20+15,25);
        $this->tablealigns=array('R','R');
        $this->tablenumbers=array(0,2,);
        $this->tableborders=array('T','LRTB');
        $this->SetFont('','B',8);

        $RowArray = array(
            'espacio' => 'TOTAL PARTIDA '.$this->ult_codigo_partida.':',
            's1' => $this->s1
        );

        $this-> MultiRow($RowArray,false,1);

        $this->s1 = 0;

    }

    function cerrarConcepto(){


        //si noes inicio termina el cuardro anterior

        $this->tablewidths=array(10+50+50+80+15+20+15,25);
        $this->tablealigns=array('R','R');
        $this->tablenumbers=array(0,2,);
        $this->tableborders=array('T','LRTB');
        $this->SetFont('','B',8);

        $RowArray = array(
            'espacio' => 'TOTAL '.$this->ult_concepto.':',
            's1' => $this->t1
        );

        $this-> MultiRow($RowArray,false,1);

        $this->t1 = 0;

    }

    function cerrarCuadroTotal(){

        //si noes inicio termina el cuardro anterior
        $this->tablewidths=array(10+50+50+80+15+10+10,40);
        //$this->tablewidths=array(10+50+50+80+15+20+15,25);
        $this->tablealigns=array('C','R');
        $this->tablenumbers=array(0,2);
        $this->tableborders=array('TB','LRTB');
        $this->SetFont('','B',9);
        /*$RowArray = array(
            'espacio' => 'TOTAL GENERAL: ',
            'tg1' => $this->tg1
        );

        $this-> MultiRow($RowArray,false,1);*/

    }


}
?>