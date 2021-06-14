

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
        <td width="25%" style="background-color: #BDD7EE; font-size: 10px;">MARCA</td>
        <td width="25%"><?= $this->datos_persona[0]['marca'];?></td>
        <td width="25%" style="background-color: #BDD7EE; font-size: 10px;">IDIOMA TECLADO</td>
        <td width="25%"><?= $this->datos_persona[0]['teclado'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 10px;">MODELO</td>
        <td><?= $this->datos_persona[0]['modelo'];?></td>
        <td style="background-color: #BDD7EE; font-size: 10px;">MEMORIA RAM</td>
        <td><?= $this->datos_persona[0]['memoria_ram'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 10px;">NUMERO DE SERIE</td>
        <td><?= $this->datos_persona[0]['num_serie'];?></td>
        <td style="background-color: #BDD7EE; font-size: 10px;">DISPOSITIVOS DE ALMACENAMIENTO</td>
        <td><?= $this->datos_persona[0]['almacenamiento'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 10px;">TAMAÑO PANTALLA</td>
        <td><?= $this->datos_persona[0]['tamano_pantalla'];?></td>
        <td style="background-color: #BDD7EE; font-size: 10px;">SISTEMA OPERATIVO</td>
        <td><?= $this->datos_persona[0]['sistema_operativo'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 10px;">VIDEO</td>
        <td><?= $this->datos_persona[0]['tarjeta_video'];?></td>
        <td style="background-color: #BDD7EE; font-size: 10px;">ESTADO FISICO</td>
        <td><?= $this->datos_persona[0]['estado_fisico'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 10px;">PROCESADOR</td>
        <td><?= $this->datos_persona[0]['procesador'];?></td>
        <td style="background-color: #BDD7EE; font-size: 10px;">OBSERVACIONES</td>
        <td><?= $this->datos_persona[0]['observaciones'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; font-size: 10px;">TECLADO</td>
        <td><?= $this->datos_persona[0]['teclado'];?></td>
        <td style="background-color: #BDD7EE; font-size: 10px;">NUMERO DE INMOVILIZADO</td>
        <td><?= $this->datos_persona[0]['codigo_inmovilizado'];?></td>
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
        <td rowspan="2" style="font-size: 10px;">CONFORMIDAD DE ASIGNACION</td>
        <td><br><br><br></td>
        <td rowspan="2" style="font-size: 10px;">FECHA DE ENTREGA</td>
        <td><?= $this->datos_persona[0]['fecha_entrega'];?></td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE;"><?= $this->datos_persona[0]['asignador'];?></td>
        <td style="background-color: #BDD7EE; ">&nbsp;</td>
    </tr>
    <tr>
        <td rowspan="2" style="font-size: 10px;">CONFORMIDAD DE RECEPCION</td>
        <td><br><br><br></td>
        <td rowspan="2" colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td style="background-color: #BDD7EE; "><?= $this->datos_persona[0]['solicitante'];?></td>
    </tr>
    </tbody>
</table>
</font>
<p style="font-size: 10px;">A partir de la fecha de asignación, el RECEPTOR se hace UNICO RESPONSABLE del equipo y accesorios que se le entrega bajo este documento.</p>
<h5>Nota:</h5>
<p style="font-size: 10px;"><b>Importante: </b>En caso de pérdida del equipo debe reportarse a Departamento de Tecnologías de Información, posteriormente el equipo debe ser repuesto con uno de caraterísticas iguales o superiores, de igual forma en caso de daño al equipo o sus accesorios.</p>
<br>
<h5>Recomendaciones generales en cuanto a cobertura del Seguro:</h5>
<p style="font-size: 10px;">- Estos equipos pueden ser  trasladados de un lugar a otro, porque son considerados móviles y/o portátiles y cuentan con cobertura de seguro ante posibles daños; pero se deben tomar las medidas de seguridad necesarias para su resguardo y protección; como cualquier otro bien que la Empresa pone a disposición de su personal.
    - En circunstancias donde las computadoras fueran robadas, encontrándose en el interior de un vehículo, lamentablemente la Póliza de Seguro no podrá ser activada, porque queda excluida de la cobertura de robos cuando las pérdidas de los bienes se hallen descuidados y/o abandonados, en cualquier lugar , incluyendo el interior de vehículos motorizados, aun cuando sea dejado por breves minutos. Así mismo si se deja por descuido dentro de un taxi, trufi, transporte público, restaurantes, entre otros.
    - En circunstancias de que pueda ser robada del interior de su vivienda, se debe realizar la respectiva denuncia a la FELCC, documento imprescindible para realizar las gestiones con la Cía. De Seguros para la reposición de la computadora portátil.

    Ante cualquier daño y/o problema de este tipo, agradeceremos comunicarse con el Depto. de Tecnologías de Información.</p>



