

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
        <td><?= $this->datos_persona[0]['solicitante'];?></td>
        <td style="background-color: #BDD7EE; font-size: 10px;">GERENCIA</td>
        <td><?= $this->datos_persona[0]['nombre_unidad'];?></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center ; background-color: #34495E; color: white; font-size: 10px; ">DATOS DEL EQUIPO</td>
    </tr>
    <tr>
        <td width="25%" style="background-color: #BDD7EE; font-size: 10px;">TIPO</td>
        <td width="25%"><?= $this->datos_persona[0]['tipo_desc'];?></td>
		<td style="background-color: #BDD7EE; font-size: 10px;">NUMERO DE SERIE</td>
        <td><?= $this->datos_persona[0]['num_serie'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 10px;">MARCA</td>
        <td><?= $this->datos_persona[0]['marca'];?></td>
		<td style="background-color: #BDD7EE; font-size: 10px;">MAC</td>
        <td><?= $this->datos_persona[0]['mac'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 10px;">MODELO</td>
        <td><?= $this->datos_persona[0]['modelo'];?></td>
        <td style="background-color: #BDD7EE; font-size: 10px;">OBSERVACIONES</td>
        <td><?= $this->datos_persona[0]['observaciones'];?></td>
    </tr>
    <tr>
		<td style="background-color: #BDD7EE; font-size: 10px;">ESTADO FISICO</td>
        <td><?= $this->datos_persona[0]['estado_fisico'];?></td>
		<td style="background-color: #BDD7EE; font-size: 10px;"></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center ; background-color: #34495E; color: white; font-size: 10px;">ACCESORIOS</td>
    </tr>
    <tr>
        <td colspan="4"><br><?= $this->datos_persona[0]['accesorios2'];?><br></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE;">&nbsp;</td>
        <td style="background-color: #BDD7EE; font-size: 10px;">FIRMA</td>
        <td style="background-color: #BDD7EE;">&nbsp;</td>
        <td style="background-color: #BDD7EE; font-size: 10px;">FECHA</td>
    </tr>
    <tr>
        <td rowspan="2" style="font-size: 10px;">CONFORMIDAD DE RECEPCION</td>
        <td><br><br><br></td>
        <td rowspan="2" style="font-size: 10px;">FECHA DE ENTREGA</td>
        <td><?=  date("d-m-Y", strtotime($this->datos_persona[0]['fecha_entrega']));?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE;"><?= $this->datos_persona[0]['solicitante'];?></td>
        <td style="background-color: #BDD7EE; ">&nbsp;</td>
    </tr>
    <tr>
        <td rowspan="2" style="font-size: 10px;">CONFORMIDAD DE ENTREGA</td>
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
<br>



