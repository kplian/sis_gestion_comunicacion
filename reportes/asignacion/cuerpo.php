

<br>
<br>
<br>
<font size="10">
<table cellpadding="5" cellspacing="0" border="1" >
    <tbody>
    <tr>
        <td colspan="4" style="text-align: center ; background-color: #34495E; color: white; ">DATOS GENERALES</td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 11px;">NOMBRE DEL SOLICITANTE</td>
        <td><?= $this->datos_persona[0]['solicitante'];?></td>
        <td style="background-color: #BDD7EE; font-size: 11px;">LINEA</td>
        <td><?= $this->datos_persona[0]['numero'];?></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center ; background-color: #34495E; color: white;">DETALLE DEL EQUIPO</td>
    </tr>
    <tr>
        <td width="25%" style="background-color: #BDD7EE; font-size: 11px;">MARCA</td>
        <td width="25%"><?= $this->datos_persona[0]['marca'];?></td>
        <td width="25%" style="background-color: #BDD7EE; font-size: 11px;">CONSUMO CONTROLADO</td>
        <td width="25%"><?= $this->datos_persona[0]['numero'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 11px;">MODELO</td>
        <td><?= $this->datos_persona[0]['modelo'];?></td>
        <td style="background-color: #BDD7EE; font-size: 11px;">TELCO</td>
        <td><?= $this->datos_persona[0]['telco'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 11px;">NUMERO DE SERIE</td>
        <td><?= $this->datos_persona[0]['num_serie'];?></td>
        <td style="background-color: #BDD7EE; font-size: 11px;">CUENTA DE GASTO</td>
        <td><?= $this->datos_persona[0]['cuenta_gasto'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE;">IMEI</td>
        <td><?= $this->datos_persona[0]['imei'];?></td>
        <td style="background-color: #BDD7EE;">CUENTA EN TELCO</td>
        <td><?= $this->datos_persona[0]['cuenta_telco'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE;">ESTADO FISICO</td>
        <td><?= $this->datos_persona[0]['estado_fisico'];?></td>
        <td style="background-color: #BDD7EE;">OBSERVACIONES</td>
        <td><?= $this->datos_persona[0]['observaciones'];?></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center ; background-color: #34495E; color: white;">ACCESORIOS</td>
    </tr>
    <tr>
        <td colspan="4"><br><?= $this->datos_persona[0]['numero'];?><br></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE;">&nbsp;</td>
        <td style="background-color: #BDD7EE; font-size: 11px;">FIRMA</td>
        <td style="background-color: #BDD7EE;">&nbsp;</td>
        <td style="background-color: #BDD7EE;">FECHA</td>
    </tr>
    <tr>
        <td rowspan="2" style="font-size: 11px;">CONFORMIDAD DE ASIGNACION</td>
        <td><br><br><br></td>
        <td rowspan="2" style="font-size: 11px;">FECHA DE ENTREGA</td>
        <td><?= $this->datos_persona[0]['fecha_entrega'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 11px;"><?= $this->datos_persona[0]['asignador'];?></td>
        <td style="background-color: #BDD7EE; font-size: 11px;">&nbsp;</td>
    </tr>
    <tr>
        <td rowspan="2" style="font-size: 11px;">CONFORMIDAD DE RECEPCION</td>
        <td><br><br><br></td>
        <td rowspan="2" colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 11px;"><?= $this->datos_persona[0]['solicitante'];?></td>
    </tr>
    </tbody>
</table>
</font>
<p style="font-size: 10px;">A partir de la fecha de asignación, el RECEPTOR se hace UNICO RESPONSABLE del equipo y accesorios que se le entrega bajo este documento.</p>
<h5>Nota:</h5>
<p style="font-size: 10px;">Importante: En caso de pérdida del equipo debe reportarse al Departamento de Tecnologias de Información, </p>



