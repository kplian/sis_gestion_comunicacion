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
select pxp.f_insert_tgui ('Accesorios', 'Accesorios', 'ACCSE', 'si', 5, 'sis_gestion_comunicacion/vista/accesorio/Accesorio.php', 2, '', 'Accesorio', 'GECOM');

select param.f_import_tcatalogo_tipo ('insert','tipo_equipo','GECOM','tequipo');
select param.f_import_tcatalogo ('insert','GECOM','Portatil','laptop','tipo_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Computador Escritorio','pc','tipo_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Telefono IP','telfip','tipo_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Workstation','work','tipo_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Impresora','impresora','tipo_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Escáner','escaner','tipo_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','UPS','ups','tipo_equipo',NULL);


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

select param.f_import_tcatalogo_tipo ('insert','marca','GECOM','tequipo');
select param.f_import_tcatalogo ('insert','GECOM','Samsung','samsung','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Lenovo','lenovo','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Huawei','huawei','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Apple','apple','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Asus','asus','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Dell','dell','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Toshiba','toshiba','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','HP','hp','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Generica','generica','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Grandstream','grandstream','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Logitech','logitech','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Leopard','leopard','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Genius','genius','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Poly','poly','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','LG','lg','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Epson','epson','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Canon','canon','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','AOC','aoc','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','SURE','sure','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Lexmark','lexmark','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Xerox','xerox','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Konica Minolta','konicaminolta','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Fujitsu','fujitsu','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','TP-Link','tplink','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Cisco AP','ciscoap','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Cisco','cisco','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Nokia','nokia','marca',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Alcatel','alcatel','marca',NULL);

select param.f_import_tcatalogo_tipo ('insert','pantalla','GECOM','tequipo');
select param.f_import_tcatalogo ('insert','GECOM','13','13','pantalla',NULL);
select param.f_import_tcatalogo ('insert','GECOM','14','14','pantalla',NULL);
select param.f_import_tcatalogo ('insert','GECOM','15','15','pantalla',NULL);
select param.f_import_tcatalogo ('insert','GECOM','17','17','pantalla',NULL);
select param.f_import_tcatalogo ('insert','GECOM','22','22','pantalla',NULL);
select param.f_import_tcatalogo ('insert','GECOM','24','24','pantalla',NULL);
select param.f_import_tcatalogo ('insert','GECOM','27','27','pantalla',NULL);
select param.f_import_tcatalogo ('insert','GECOM','65','65','pantalla',NULL);
select param.f_import_tcatalogo ('insert','GECOM','70','70','pantalla',NULL);

select param.f_import_tcatalogo_tipo ('insert','teclado','GECOM','tequipo');
select param.f_import_tcatalogo ('insert','GECOM','Normal','normal','teclado',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Numerico','numerico','teclado',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Multimedia','multimedia','teclado',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Inalambrico','inalambrico','teclado',NULL);

select param.f_import_tcatalogo_tipo ('insert','teclado_idioma','GECOM','tequipo');
select param.f_import_tcatalogo ('insert','GECOM','Español','esp','teclado_idioma',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Ingles','ingles','teclado_idioma',NULL);

select param.f_import_tcatalogo_tipo ('insert','ram','GECOM','tequipo');
select param.f_import_tcatalogo ('insert','GECOM','DDR','ddr','ram',NULL);
select param.f_import_tcatalogo ('insert','GECOM','DDR2','ddr2','ram',NULL);
select param.f_import_tcatalogo ('insert','GECOM','DDR3','ddr3','ram',NULL);
select param.f_import_tcatalogo ('insert','GECOM','DDR4','ddr4','ram',NULL);
select param.f_import_tcatalogo ('insert','GECOM','DIMM','dimm','ram',NULL);

select param.f_import_tcatalogo_tipo ('insert','almacenamiento','GECOM','tequipo');
select param.f_import_tcatalogo ('insert','GECOM','HDD','hdd','almacenamiento',NULL);
select param.f_import_tcatalogo ('insert','GECOM','SSD','ssd','almacenamiento',NULL);
select param.f_import_tcatalogo ('insert','GECOM','M2','m2','almacenamiento',NULL);
select param.f_import_tcatalogo ('insert','GECOM','NVME','nvme','almacenamiento',NULL);

select param.f_import_tcatalogo_tipo ('insert','so','GECOM','tequipo');
select param.f_import_tcatalogo ('insert','GECOM','WINDOWS XP','winxp','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','WINDOWS NT','winnt','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','WINDOWS 2003','win2003','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','WINDOWS 7','wip7','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','WINDOWS 8','win8','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','WINDOWS 10','wip10','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Debian 6','debian6','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Debian 7','debian7','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Debian 8','debian8','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Debian 9','debian9','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Debian 10','debian10','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','CentOS 5','centos5','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','CentOS 6','centos6','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','CentOS 7','centos7','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','CentOS 8','centos8','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','WINDOWS SERVER 2003','wipser2003','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','WINDOWS SERVER 2008','winser2008','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','WINDOWS SERVER 2012','wipser2012','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','WINDOWS SERVER 2012 R2','wipser2012r2','so',NULL);

select param.f_import_tcatalogo_tipo ('insert','estado_fisico','GECOM','tequipo');
select param.f_import_tcatalogo ('insert','GECOM','Nuevo','nuevo','estado_fisico',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Usado','usado','estado_fisico',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Deposito','deposito','estado_fisico',NULL);

select param.f_import_tcatalogo_tipo ('insert','accesorio_telefono','GECOM','taccesorio');
select param.f_import_tcatalogo ('insert','GECOM','Cable de Datos','cable_datos','accesorio_telefono',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Manos Libres','manos_libres','accesorio_telefono',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Cargador','cargador_movil','accesorio_telefono',NULL);

select param.f_import_tcatalogo_tipo ('insert','accesorio_equipo','GECOM','taccesorio');
select param.f_import_tcatalogo ('insert','GECOM','Cargador','cargador','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Mochila','mochila','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Mouse','mouse','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Monitor','monitor','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Headset','headset','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Adaptador Multipuerto','adaptadormulti','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Adaptador de red, usd','adaptadorred','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Docking Station','dockingstation','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Base con ventilador para laptop','baselaptop','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Lector de cd externo','lector','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Lector de Código de Barras','lectorbarras','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Parlantes','parlantes','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Regleta','regleta','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Switch','switch','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Disco Duro Externo','discoduro','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Jabra','jabra','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Camara Web','camaraweb','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Microfono','microfono','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Hub Usb','hubusb','accesorio_equipo',NULL);

select pxp.f_insert_tgui ('Accesorio Movil', 'Accesorio Movil', 'ACCMOV', 'si', 6, 'sis_gestion_comunicacion/vista/accesorio/AccesorioMovil.php', 3, '', 'AccesorioMovil', 'GECOM');
select pxp.f_insert_tgui ('Accesorio Escritorio', 'Accesorio Escritorio', 'ACCESC', 'si', 3, 'sis_gestion_comunicacion/vista/accesorio/AccesorioEscritorio.php', 3, '', 'AccesorioEscritorio', 'GECOM');

/*****************************F-DAT-YMR-GECOM-1-30/05/2021*************************************/

/*****************************I-DAT-YMR-GECOM-8-20/07/2021*************************************/

select param.f_import_tcatalogo_tipo ('insert','procesador','GECOM','tequipo');
select param.f_import_tcatalogo ('insert','GECOM','AMD Ryzen 9','AMDRYZEN9','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','AMD Ryzen 7','AMDRYZEN7','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Intel Core i9','INTELCOREI9','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Intel Core i7','INTELCOREI7','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','AMD Ryzen 5','AMDRYZEN5','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Intel Xeon','INTELXEON','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Intel Core i5','INTELCOREI5','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','AMD Ryzen 3','AMDRYZEN3','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Intel Core i3','INTELCOREI3','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','AMD Athlon Silver','AMDATHLONSILVER','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','AMD A12-9720P','AMDA12-9720P','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','AMD 3020E','AMD3020E','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Intel Core m3','INTELCOREM3','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Intel Celeron','INTELCELERON','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Intel Core m5','INTELCOREM5','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','AMD A10','AMDA10','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Intel Pentium 4','INTELPENTIUM4','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Intel Pentium','INTELPENTIUM','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Intel Core','INTELCORE','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','AMD A9','AMDA9','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','AMD A6','AMDA6','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Intel Atom','INTELATOM','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','AMD FX','AMDFX','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','AMD Phenom II','AMDPHENOMII','procesador',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Otro','otro','procesador',NULL);

select param.f_import_tcatalogo ('insert','GECOM','Otro','otro_equipo','accesorio_equipo',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Otro','otro_movil','accesorio_telefono',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Otro','otro','so',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Otro','otro','almacenamiento',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Otro','otro','ram',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Otro','otro','teclado_idioma',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Otro','otro','teclado',NULL);
select param.f_import_tcatalogo ('insert','GECOM','Otro','otro','marca',NULL);


/*****************************F-DAT-YMR-GECOM-8-20/07/2021*************************************/