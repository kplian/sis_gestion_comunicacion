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
select pxp.f_insert_tfuncion ('gecom.ft_numero_celular_ime', 'Funcion para tabla     ', 'GECOM');
select pxp.f_insert_tfuncion ('gecom.ft_servicio_ime', 'Funcion para tabla     ', 'GECOM');
select pxp.f_insert_tfuncion ('gecom.ft_numero_celular_sel', 'Funcion para tabla     ', 'GECOM');
select pxp.f_insert_tfuncion ('gecom.ft_servicio_sel', 'Funcion para tabla     ', 'GECOM');
select pxp.f_insert_tfuncion ('gecom.ft_numero_servicio_sel', 'Funcion para tabla     ', 'GECOM');
select pxp.f_insert_tfuncion ('gecom.ft_numero_servicio_ime', 'Funcion para tabla     ', 'GECOM');
select pxp.f_insert_tfuncion ('gecom.ft_funcionario_celular_sel', 'Funcion para tabla     ', 'GECOM');
select pxp.f_insert_tfuncion ('gecom.ft_funcionario_celular_ime', 'Funcion para tabla     ', 'GECOM');
select pxp.f_insert_tfuncion ('gecom.ft_consumo_sel', 'Funcion para tabla     ', 'GECOM');
select pxp.f_insert_tfuncion ('gecom.ft_consumo_ime', 'Funcion para tabla     ', 'GECOM');
select pxp.f_insert_tprocedimiento ('GC_NUMCEL_INS', 'Insercion de registros', 'si', '', '', 'gecom.ft_numero_celular_ime');
select pxp.f_insert_tprocedimiento ('GC_NUMCEL_MOD', 'Modificacion de registros', 'si', '', '', 'gecom.ft_numero_celular_ime');
select pxp.f_insert_tprocedimiento ('GC_NUMCEL_ELI', 'Eliminacion de registros', 'si', '', '', 'gecom.ft_numero_celular_ime');
select pxp.f_insert_tprocedimiento ('GC_SER_INS', 'Insercion de registros', 'si', '', '', 'gecom.ft_servicio_ime');
select pxp.f_insert_tprocedimiento ('GC_SER_MOD', 'Modificacion de registros', 'si', '', '', 'gecom.ft_servicio_ime');
select pxp.f_insert_tprocedimiento ('GC_SER_ELI', 'Eliminacion de registros', 'si', '', '', 'gecom.ft_servicio_ime');
select pxp.f_insert_tprocedimiento ('GC_NUMCEL_SEL', 'Consulta de datos', 'si', '', '', 'gecom.ft_numero_celular_sel');
select pxp.f_insert_tprocedimiento ('GC_NUMCEL_CONT', 'Conteo de registros', 'si', '', '', 'gecom.ft_numero_celular_sel');
select pxp.f_insert_tprocedimiento ('GC_SER_SEL', 'Consulta de datos', 'si', '', '', 'gecom.ft_servicio_sel');
select pxp.f_insert_tprocedimiento ('GC_SER_CONT', 'Conteo de registros', 'si', '', '', 'gecom.ft_servicio_sel');
select pxp.f_insert_tprocedimiento ('GC_NUMSER_SEL', 'Consulta de datos', 'si', '', '', 'gecom.ft_numero_servicio_sel');
select pxp.f_insert_tprocedimiento ('GC_NUMSER_CONT', 'Conteo de registros', 'si', '', '', 'gecom.ft_numero_servicio_sel');
select pxp.f_insert_tprocedimiento ('GC_NUMSER_INS', 'Insercion de registros', 'si', '', '', 'gecom.ft_numero_servicio_ime');
select pxp.f_insert_tprocedimiento ('GC_NUMSER_MOD', 'Modificacion de registros', 'si', '', '', 'gecom.ft_numero_servicio_ime');
select pxp.f_insert_tprocedimiento ('GC_NUMSER_ELI', 'Eliminacion de registros', 'si', '', '', 'gecom.ft_numero_servicio_ime');
select pxp.f_insert_tprocedimiento ('GC_FUNCEL_SEL', 'Consulta de datos', 'si', '', '', 'gecom.ft_funcionario_celular_sel');
select pxp.f_insert_tprocedimiento ('GC_FUNCEL_CONT', 'Conteo de registros', 'si', '', '', 'gecom.ft_funcionario_celular_sel');
select pxp.f_insert_tprocedimiento ('GC_FUNCEL_INS', 'Insercion de registros', 'si', '', '', 'gecom.ft_funcionario_celular_ime');
select pxp.f_insert_tprocedimiento ('GC_FUNCEL_MOD', 'Modificacion de registros', 'si', '', '', 'gecom.ft_funcionario_celular_ime');
select pxp.f_insert_tprocedimiento ('GC_FUNCEL_ELI', 'Eliminacion de registros', 'si', '', '', 'gecom.ft_funcionario_celular_ime');
select pxp.f_insert_tprocedimiento ('GC_CON_SEL', 'Consulta de datos', 'si', '', '', 'gecom.ft_consumo_sel');
select pxp.f_insert_tprocedimiento ('GC_CON_CONT', 'Conteo de registros', 'si', '', '', 'gecom.ft_consumo_sel');
select pxp.f_insert_tprocedimiento ('GC_CON_INS', 'Insercion de registros', 'si', '', '', 'gecom.ft_consumo_ime');
select pxp.f_insert_tprocedimiento ('GC_CON_MOD', 'Modificacion de registros', 'si', '', '', 'gecom.ft_consumo_ime');
select pxp.f_insert_tprocedimiento ('GC_CONCSV_UPD', 'Modificacion consumo valor csv', 'si', '', '', 'gecom.ft_consumo_ime');
select pxp.f_insert_tprocedimiento ('GC_CON_ELI', 'Eliminacion de registros', 'si', '', '', 'gecom.ft_consumo_ime');

/*****************************F-DAT-JRR-GECOM-0-27/07/2014*************************************/


/*****************************I-DAT-JRR-GECOM-0-29/07/2014*************************************/

select pxp.f_insert_trol ('Registro de Servicios Telefónicos', 'Registro de Servicios', 'GECOM');
select pxp.f_insert_trol ('Registro de Números Corporativos', 'Registro de Números Corporativos', 'GECOM');
select pxp.f_insert_trol ('Asignación de Números Corporativos', 'Asignación de Números Corporativos', 'GECOM');
select pxp.f_insert_trol ('Registro de Consumo Corporativo', 'Registro de Consumo Corporativo', 'GECOM');


/*****************************F-DAT-JRR-GECOM-0-29/07/2014*************************************/

/*****************************I-DAT-JRR-GECOM-0-29/07/2014*************************************/

----------------------------------
--COPY LINES TO data.sql FILE
---------------------------------

select pxp.f_insert_tgui ('GESTIÓN DE MATERIALES', '', 'MAT', 'si', 1, '', 1, '', '', 'MAT');
select pxp.f_insert_tgui ('Requerimiento de Materiales', 'Requerimiento de Materiales', 'REMA', 'si', 1, 'sis_gestion_materiales/vista/solicitud/RegistroSolicitud.php', 2, '', 'RegistroSolicitud', 'MAT');
select pxp.f_insert_tgui ('Visto Bueno Solicitud', 'Visto Bueno Solicitud', 'VBS', 'si', 2, 'sis_gestion_materiales/vista/solicitud/SolicitudVistoBueno.php', 2, '', 'SolicitudVistoBueno', 'MAT');
select pxp.f_insert_tgui ('Abastecimiento', 'Abastecimiento', 'ABS', 'si', 3, 'sis_gestion_materiales/vista/solicitud/AbastecimientoSolicitud.php', 2, '', 'AbastecimientoSolicitud', 'MAT');
select pxp.f_insert_tgui ('Consulta Requerimientos', 'Consulta Requerimientos', 'CR', 'si', 4, 'sis_gestion_materiales/vista/solicitud/ConsultaRequerimientos.php', 2, '', 'ConsultaRequerimientos', 'MAT');
----------------------------------
--COPY LINES TO dependencies.sql FILE
---------------------------------

select pxp.f_insert_testructura_gui ('MAT', 'SISTEMA');
select pxp.f_insert_testructura_gui ('REMA', 'MAT');
select pxp.f_insert_testructura_gui ('VBS', 'MAT');
select pxp.f_insert_testructura_gui ('ABS', 'MAT');
select pxp.f_insert_testructura_gui ('CR', 'MAT');
/*****************************F-DAT-JRR-GECOM-0-29/07/2014*************************************/

/*****************************I-DAT-MMV-GECOM-0-06/06/2017*************************************/
select pxp.f_insert_tgui ('Directorio TelefÃ³nico', 'Directorio Telefonico', 'DIRT', 'si', 4, 'sis_gestion_comunicacion/vista/directorio_telefonico/DirectorioTelefonico.php', 2, '', 'DirectorioTelefonico', 'GECOM');
select pxp.f_insert_testructura_gui ('DIRT', 'GECOM');
/*****************************F-DAT-MMV-GECOM-0-06/06/2017*************************************/