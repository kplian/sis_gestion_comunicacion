

<br>
<font size="10">
<table cellpadding="5" cellspacing="0" border="1" style="font-size: 9px;" >
    <tbody>
    <tr>
        <td  rowspan="2" style="text-align: center ; font-size: 13px;" ><br><br><b>REGISTRO</b></td>
        <td colspan="2" style="text-align: center ; font-size: 13px;"><b>GERENCIA DE ADMINISTRACIÓN Y FINANZAS</b></td>
        <td rowspan="2" style="text-align: center ; font-size: 17px;" ><br><br><b><?= $this->num_form ?></b></td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: center ; font-size: 13px;"><b><?= $this->datos_estructura ?></b></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center ; background-color: #34495E; color: white; font-size: 10px;">DATOS GENERALES</td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 10px;">NOMBRE DEL SOLICITANTE</td>
        <td><?= $this->datos_persona[0]['desc_funcionario1'];?></td>
        <td style="background-color: #BDD7EE; font-size: 10px;">GERENCIA</td>
        <td><?= $this->datos_persona[0]['nombre_unidad'];?></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center ; background-color: #34495E; color: white; font-size: 10px; ">DATOS DEL EQUIPO</td>
    </tr>
    <tr>
        <td width="25%" style="background-color: #BDD7EE; font-size: 10px;">TIPO</td>
        <td width="25%"><?= $this->datos_persona[0]['tipo'];?></td>
        <td width="25%" style="background-color: #BDD7EE; font-size: 10px;">ESTADO FÍSICO</td>
        <td width="25%"><?= $this->datos_persona[0]['estado_fisico'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 10px;">MARCA</td>
        <td><?= $this->datos_persona[0]['marca'];?></td>
        <td style="background-color: #BDD7EE; font-size: 10px;">OBSERVACIONES</td>
        <td><?= $this->datos_persona[0]['observaciones'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 10px;">MODELO</td>
        <td><?= $this->datos_persona[0]['modelo'];?></td>
        <td style="background-color: #BDD7EE; font-size: 10px;">CODIGO DE INMOVILIZADO (Si corresponde)</td>
        <td><?= $this->datos_persona[0]['codigo_inmovilizado'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE;">&nbsp;</td>
        <td style="background-color: #BDD7EE; font-size: 10px;">FIRMA</td>
        <td style="background-color: #BDD7EE;">&nbsp;</td>
        <td style="background-color: #BDD7EE; font-size: 10px;">FECHA</td>
    </tr>
    <tr>
        <td rowspan="2" style="font-size: 10px;"><?= $this->conformidad_funcionario ?></td>
        <td><br><br><br></td>
        <td rowspan="2" style="font-size: 10px;"><?= $this->conformidad_fecha ?></td>
        <td><?=  date("d-m-Y", strtotime($this->datos_persona[0]['fecha_entrega']));?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE;"><?= $this->datos_persona[0]['desc_funcionario1'];?></td>
        <td style="background-color: #BDD7EE; ">&nbsp;</td>
    </tr>
    <tr>
        <td rowspan="2" style="font-size: 10px;"><?= $this->conformidad_asignador ?></td>
        <td><br><br><br></td>
        <td rowspan="2" colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; "><?= $this->datos_persona[0]['asignador'];?></td>
    </tr>
    </tbody>
</table>
</font>
<p style="font-size: 10px;"><?= $this->datos_mensaje_1 ?></p>
<h5>Nota:</h5>
<p style="font-size: 10px;"><?= $this->datos_mensaje ?></p>



