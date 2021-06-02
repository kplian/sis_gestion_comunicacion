/*****************************I-DAT-JRR-GECOM-0-27/07/2014*************************************/

select pxp.f_insert_tgui ('GECOM', '', 'GECOM', 'si', 1 , '', 1, '', '', 'GECOM');
select pxp.f_insert_tgui ('Registro de Servicios', 'Registro de Servicios', 'REGSER', 'si', 2, 'sis_gestion_comunicacion/vista/servicio/Servicio.php', 2, '', 'Servicio', 'GECOM');
select pxp.f_insert_tgui ('Registro de Números', 'Registro de Números', 'REGNUM', 'si', 1, 'sis_gestion_comunicacion/vista/numero_celular/NumeroCelular.php', 2, '', 'NumeroCelular', 'GECOM');
select pxp.f_insert_tgui ('Asignación de Números', 'Asignación de Números', 'ASIGNUM', 'si', 3, 'sis_gestion_comunicacion/vista/funcionario_celular/FuncionarioCelular.php', 3, '', 'FuncionarioCelular', 'GECOM');
select pxp.f_insert_tgui ('Proveedor', 'Proveedor', 'REGSER.1', 'no', 0, 'sis_parametros/vista/proveedor/Proveedor.php', 3, '', 'proveedor', 'GECOM');
select pxp.f_insert_tgui ('Items/Servicios ofertados', 'Items/Servicios ofertados', 'REGSER.1.1', 'no', 0, 'sis_parametros/vista/proveedor_item_servicio/ProveedorItemServicio.php', 4, '', '50%', 'GECOM');
select pxp.f_insert_tgui ('Personas', 'Personas', 'REGSER.1.2', 'no', 0, 'sis_seguridad/vista/persona/Persona.php', 4, '', 'persona', 'GECOM');
select pxp.f_insert_tgui ('Instituciones', 'Instituciones', 'REGSER.1.3', 'no', 0, 'sis_parametros/vista/institucion/Institucion.php', 4, '', 'Institucion', 'GECOM');
select pxp.f_insert_tgui ('Subir foto', 'Subir foto', 'REGSER.1.2.1', 'no', 0, 'sis_seguridad/vista/persona/subirFotoPersona.php', 5, '', 'subirFotoPersona', 'GECOM');
select pxp.f_insert_tgui ('Personas', 'Personas', 'REGSER.1.3.1', 'no', 0, 'sis_seguridad/vista/persona/Persona.php', 5, '', 'persona', 'GECOM');
select pxp.f_insert_tgui ('Subir foto', 'Subir foto', 'REGSER.1.3.1.1', 'no', 0, 'sis_seguridad/vista/persona/subirFotoPersona.php', 6, '', 'subirFotoPersona', 'GECOM');
select pxp.f_insert_tgui ('Servicios por Número', 'Servicios por Número', 'REGNUM.1', 'no', 0, 'sis_gestion_comunicacion/vista/numero_servicio/NumeroServicio.php', 3, '', '40%', 'GECOM');
select pxp.f_insert_tgui ('Consumo X Número', 'Consumo X Número', 'REGNUM.2', 'no', 0, 'sis_gestion_comunicacion/vista/consumo/Consumo.php', 3, '', '90%', 'GECOM');
select pxp.f_insert_tgui ('Subir Consumo de Números', 'Subir Consumo de Números', 'REGNUM.3', 'no', 0, 'sis_gestion_comunicacion/vista/consumo/ConsumoCsv.php', 3, '', 'ConsumoCsv', 'GECOM');
select pxp.f_insert_tgui ('Proveedor', 'Proveedor', 'REGNUM.4', 'no', 0, 'sis_parametros/vista/proveedor/Proveedor.php', 3, '', 'proveedor', 'GECOM');
select pxp.f_insert_tgui ('Items/Servicios ofertados', 'Items/Servicios ofertados', 'REGNUM.4.1', 'no', 0, 'sis_parametros/vista/proveedor_item_servicio/ProveedorItemServicio.php', 4, '', '50%', 'GECOM');
select pxp.f_insert_tgui ('Personas', 'Personas', 'REGNUM.4.2', 'no', 0, 'sis_seguridad/vista/persona/Persona.php', 4, '', 'persona', 'GECOM');
select pxp.f_insert_tgui ('Instituciones', 'Instituciones', 'REGNUM.4.3', 'no', 0, 'sis_parametros/vista/institucion/Institucion.php', 4, '', 'Institucion', 'GECOM');
select pxp.f_insert_tgui ('Subir foto', 'Subir foto', 'REGNUM.4.2.1', 'no', 0, 'sis_seguridad/vista/persona/subirFotoPersona.php', 5, '', 'subirFotoPersona', 'GECOM');
select pxp.f_insert_tgui ('Personas', 'Personas', 'REGNUM.4.3.1', 'no', 0, 'sis_seguridad/vista/persona/Persona.php', 5, '', 'persona', 'GECOM');
select pxp.f_insert_tgui ('Subir foto', 'Subir foto', 'REGNUM.4.3.1.1', 'no', 0, 'sis_seguridad/vista/persona/subirFotoPersona.php', 6, '', 'subirFotoPersona', 'GECOM');


/*****************************F-DAT-JRR-GECOM-0-27/07/2014*************************************/


/*****************************I-DAT-JRR-GECOM-0-29/07/2014*************************************/

select pxp.f_insert_trol ('Registro de Servicios Telefónicos', 'Registro de Servicios', 'GECOM');
select pxp.f_insert_trol ('Registro de Números Corporativos', 'Registro de Números Corporativos', 'GECOM');
select pxp.f_insert_trol ('Asignación de Números Corporativos', 'Asignación de Números Corporativos', 'GECOM');
select pxp.f_insert_trol ('Registro de Consumo Corporativo', 'Registro de Consumo Corporativo', 'GECOM');


/*****************************F-DAT-JRR-GECOM-0-29/07/2014*************************************/

/*****************************I-DAT-YMR-GECOM-1-30/05/2021*************************************/

--select pxp.f_insert_tgui ('GESTIÓN DE DISPOSITIVOS', '', 'GECOM', 'si', 1, '', 1, '', '', 'GECOM');
select pxp.f_insert_tgui ('Reporte', 'Reporte', 'REPGE', 'si', 6, 'sis_gestion_comunicacion/vista/reporte/Reporte.php', 2, '', 'Reporte', 'GECOM');
select pxp.f_insert_tgui ('Dispositivos Móviles', 'Dispositivos Móviles', 'DISP_MOV', 'si', 1, '', 2, '', '', 'GECOM');
select pxp.f_insert_tgui ('Equipos Informáticos', 'Equipos Informáticos', 'EQU_INF', 'si', 2, '', 2, '', '', 'GECOM');
select pxp.f_insert_tgui ('Registro de Lineas', 'Registro de Lineas', 'REGNUM', 'si', 1, 'sis_gestion_comunicacion/vista/numero_celular/NumeroCelular.php', 3, '', 'NumeroCelular', 'GECOM');
select pxp.f_insert_tgui ('Servicios', 'Servicios', 'REGSERR', 'si', 8, 'sis_gestion_comunicacion/vista/servicio/Servicio.php', 3, '', 'Servicio', 'GECOM');
select pxp.f_insert_tgui ('Asignación Equipos', 'Asignación Equipos', 'ASIGNUMM', 'si', 3, 'sis_gestion_comunicacion/vista/equipo/DatosGenerales.php', 3, '', 'DatosGenerales', 'GECOM');
select pxp.f_insert_tgui ('Registro de TELCOS', 'Registro de TELCOS', 'CUPP', 'si', 3, 'sis_gestion_comunicacion/vista/cuenta_proveedor/CuentaProveedor.php', 3, '', 'CuentaProveedor', 'GECOM');
select pxp.f_insert_tgui ('Asignacion Lineas', 'Asignacion Lineas', 'ASGNUMM', 'si', 5, 'sis_gestion_comunicacion/vista/numero_celular/DatosGenerales.php', 3, '', 'DatosGenerales', 'GECOM');
select pxp.f_insert_tgui ('Registro de Equipos', 'Registro de Equipos', 'EQUU', 'si', 1, 'sis_gestion_comunicacion/vista/equipo/Equipo.php', 3, '', 'Equipo', 'GECOM');
select pxp.f_insert_tgui ('Registro de Dispositivos Moviles', 'Registro de Dispositivos Moviles', 'DISMOV', 'si', 2, 'sis_gestion_comunicacion/vista/numero_celular/EquipoMovil.php', 3, '', 'EquipoMovil', 'GECOM');

select param.f_import_tcatalogo_tipo ('insert','tipo_equipo','GECOM','tequipo');
select param.f_import_tcatalogo ('insert','GECOM','Portatil','laptop','tipo_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Computador Escritorio','pc','tipo_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Telefono IP','telfip','tipo_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Workstation','work','tipo_equipo',NULL);


select param.f_import_tcatalogo_tipo ('insert','tipo_servicio','GECOM','tservicio');
select param.f_import_tcatalogo ('insert','GECOM','Servicio Internet','ser_int','tipo_servicio',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Servicio Telefonia','ser_tel','tipo_servicio',NULL);

select param.f_import_tcatalogo_tipo ('insert','tipo_gama','GECOM','tequipo');
select param.f_import_tcatalogo ('insert','GECOM','Gama Alta','g_alta','tipo_gama',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Gama Media Alta','g_malta','tipo_gama',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Gama Media Baja','g_mbaja','tipo_gama',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Gama Baja','g_baja','tipo_gama',NULL);

select param.f_import_tcatalogo_tipo ('insert','tipo_equipo_movil','GECOM','tequipo');
select param.f_import_tcatalogo ('insert','GECOM','Celular','movil','tipo_equipo_movil',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Dongle','dongle','tipo_equipo_movil',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Geolocalización','gps','tipo_equipo_movil',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Central Telefónica','centel','tipo_equipo_movil',NULL);

/*****************************F-DAT-YMR-GECOM-1-30/05/2021*************************************/