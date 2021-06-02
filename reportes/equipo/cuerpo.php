

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
        <td width="25%" style="background-color: #BDD7EE; font-size: 11px;">MARCA</td>
        <td width="25%"><?= $this->datos_persona[0]['marca'];?></td>
        <td width="25%" style="background-color: #BDD7EE; font-size: 11px;">NRO DE INMOVILIZADO</td>
        <td width="25%"><?= $this->datos_persona[0]['codigo_inmovilizado'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 11px;">MODELO</td>
        <td><?= $this->datos_persona[0]['modelo'];?></td>
        <td style="background-color: #BDD7EE; font-size: 11px;">NRO DE SERIE</td>
        <td><?= $this->datos_persona[0]['num_serie'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 11px;">PROCESADOR</td>
        <td><?= $this->datos_persona[0]['procesador'];?></td>
        <td style="background-color: #BDD7EE; font-size: 11px;">ESTADO</td>
        <td><?= $this->datos_persona[0]['estado_fisico'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE;">MEMORIA RAM</td>
        <td><?= $this->datos_persona[0]['memoria_ram'];?></td>
        <td style="background-color: #BDD7EE;">DISCO</td>
        <td><?= $this->datos_persona[0]['almacenamiento'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE;">PANTALLA</td>
        <td><?= $this->datos_persona[0]['tamano_pantalla'];?></td>
        <td style="background-color: #BDD7EE;">OBSERVACIONES</td>
        <td><?= $this->datos_persona[0]['observaciones'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE;">VIDEO</td>
        <td><?= $this->datos_persona[0]['tarjeta_video'];?></td>
        <td style="background-color: #BDD7EE;"></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center ; background-color: #34495E; color: white;">ACCESORIOS</td>
    </tr>
    <tr>
        <td colspan="4"><br><?= $this->datos_persona[0]['accesorios'];?><br></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 11px;">CONFORMIDAD DE ENTREGA</td>
        <td style="background-color: #BDD7EE; font-size: 11px;">CONFORMIDAD DE RECEPCION</td>
        <td style="background-color: #BDD7EE; font-size: 11px;">CONFORMIDAD DE DEVOLUCION</td>
        <td style="background-color: #BDD7EE; font-size: 11px;">CONFORMIDAD DE RECEPCION</td>
    </tr>
    <tr>
        <td></td>
        <td><br><br><br></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE;"></td>
        <td style="background-color: #BDD7EE; font-size: 11px;"></td>
        <td style="background-color: #BDD7EE;"></td>
        <td style="background-color: #BDD7EE;"></td>
    </tr>
    <tr>
        <td>Fecha de Asignación: </td>
        <td><br><br><br></td>
        <td></td>
        <td></td>
    </tr>
    </tbody>
</table>
</font>
<h5>Nota:</h5>
<p style="font-size: 10px;">A partir de la fecha de asignación, el RECEPTOR se hace UNICO RESPONSABLE del equipo y accesorios que se le entrega bajo este documento.</p>




