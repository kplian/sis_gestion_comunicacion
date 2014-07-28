/***********************************I-SCP-JRR-GECOM-0-21/07/2014****************************************/


INSERT INTO segu.tsubsistema ("codigo", "nombre", "fecha_reg", "prefijo", "estado_reg", "nombre_carpeta", "id_subsis_orig")
VALUES (E'GECOM', E'Gestión de Comunicación', E'2014-07-21', E'GC', E'activo', E'gestion_comunicacion', NULL);

CREATE TABLE gecom.tnumero_celular (
  id_numero_celular SERIAL NOT NULL, 
  numero VARCHAR(20) NOT NULL, 
  roaming VARCHAR(2) NOT NULL, 
  observaciones TEXT, 
  id_proveedor INTEGER NOT NULL, 
  PRIMARY KEY(id_numero_celular)
) INHERITS (pxp.tbase)
WITHOUT OIDS;

ALTER TABLE gecom.tnumero_celular 
  ALTER COLUMN roaming SET DEFAULT 'no';


CREATE TABLE gecom.tservicio (
  id_servicio SERIAL NOT NULL, 
  id_proveedor INTEGER NOT NULL, 
  codigo_servicio VARCHAR(50) NOT NULL, 
  nombre_servicio VARCHAR(200) NOT NULL, 
  observaciones TEXT, 
  tarifa NUMERIC(18,2) NOT NULL,
  trafico_libre NUMERIC(18,2) NOT NULL,
  trafico_adicional NUMERIC(18,2) NOT NULL,
  defecto VARCHAR(2) NOT NULL,  
  PRIMARY KEY(id_servicio)
) INHERITS (pxp.tbase)
WITHOUT OIDS;

ALTER TABLE gecom.tservicio 
  ALTER COLUMN trafico_libre SET DEFAULT 0;
  
ALTER TABLE gecom.tservicio 
  ALTER COLUMN trafico_adicional SET DEFAULT 0;

CREATE TABLE gecom.tnumero_servicio (
  id_numero_servicio SERIAL NOT NULL, 
  id_servicio INTEGER NOT NULL, 
  id_numero_celular INTEGER NOT NULL,  
  fecha_inicio DATE NOT NULL,
  fecha_fin DATE, 
  observaciones TEXT,    
  PRIMARY KEY(id_numero_servicio)
) INHERITS (pxp.tbase)
WITHOUT OIDS;

CREATE TABLE gecom.tfuncionario_celular (
  id_funcionario_celular SERIAL NOT NULL, 
  id_funcionario INTEGER, 
  id_cargo INTEGER, 
  id_numero_celular INTEGER NOT NULL,  
  fecha_inicio DATE NOT NULL,
  fecha_fin DATE, 
  observaciones TEXT,    
  PRIMARY KEY(id_funcionario_celular)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


CREATE TABLE gecom.tconsumo (
  id_consumo SERIAL NOT NULL, 
  id_numero_celular INTEGER NOT NULL, 
  id_periodo INTEGER NOT NULL, 
  id_gestion INTEGER NOT NULL,  
  id_servicio INTEGER,
  observaciones TEXT, 
  consumo NUMERIC (18,2) NOT NULL,   
  PRIMARY KEY(id_consumo)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


/***********************************F-SCP-JRR-GECOM-0-21/07/2014****************************************/