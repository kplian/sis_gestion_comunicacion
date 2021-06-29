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

/***********************************I-SCP-JRR-GECOM-0-24/09/2014****************************************/
ALTER TABLE gecom.tnumero_celular
  ADD COLUMN tipo VARCHAR(20) DEFAULT 'celular' NOT NULL;

COMMENT ON COLUMN gecom.tnumero_celular.tipo
IS 'El Tipo puede ser celular|4g|fijo';

/***********************************F-SCP-JRR-GECOM-0-24/09/2014****************************************/

/***********************************I-SCP-JRR-GECOM-0-12/12/2016****************************************/
ALTER TABLE gecom.tfuncionario_celular
ADD COLUMN tipo_asignacion VARCHAR(20) DEFAULT 'personal' NOT NULL;

COMMENT ON COLUMN gecom.tfuncionario_celular.tipo_asignacion
IS 'El Tipo puede ser personal|compartido';

/***********************************F-SCP-JRR-GECOM-0-12/12/2016****************************************/

/***********************************I-SCP-YMR-GECOM-1-30/05/2021****************************************/

CREATE TABLE gecom.tcuenta_proveedor (
                                         id_cuenta SERIAL,
                                         id_proveedor INTEGER NOT NULL,
                                         nro_cuenta INTEGER,
                                         id_uo INTEGER,
                                         CONSTRAINT tcuenta_pkey PRIMARY KEY(id_cuenta),
                                         CONSTRAINT fk_tcuenta__id_proveedor FOREIGN KEY (id_proveedor)
                                             REFERENCES param.tproveedor(id_proveedor)
                                             MATCH FULL
                                             ON DELETE NO ACTION
                                             ON UPDATE NO ACTION
                                             NOT DEFERRABLE
) INHERITS (pxp.tbase)
WITH (oids = false);

CREATE TABLE gecom.tcuenta_proveedor_historico (
                                                   id_cuenta_historico SERIAL,
                                                   id_cuenta INTEGER,
                                                   id_proveedor INTEGER NOT NULL,
                                                   nro_cuenta INTEGER,
                                                   id_tipo_cc INTEGER,
                                                   id_uo INTEGER,
                                                   operacion VARCHAR(15),
                                                   observaciones VARCHAR(200)
) INHERITS (pxp.tbase)
WITH (oids = false);

DROP TABLE gecom.tnumero_celular cascade;
DROP TABLE gecom.tfuncionario_celular cascade;

CREATE TABLE gecom.tnumero_celular (
                                       id_numero_celular SERIAL,
                                       numero VARCHAR(20) NOT NULL,
                                       roaming VARCHAR(2) DEFAULT 'no'::character varying NOT NULL,
                                       observaciones TEXT,
                                       id_proveedor INTEGER,
                                       tipo VARCHAR(20) DEFAULT 'celular'::character varying NOT NULL,
                                       estado VARCHAR(20),
                                       credito NUMERIC,
                                       limite_consumo NUMERIC,
                                       sim INTEGER,
                                       id_cuenta INTEGER,
                                       id_tipo_cc INTEGER,
                                       CONSTRAINT tnumero_celular_pkey PRIMARY KEY(id_numero_celular),
                                       CONSTRAINT fk_tnumero_celular__id_proveedor FOREIGN KEY (id_proveedor)
                                           REFERENCES param.tproveedor(id_proveedor)
                                           MATCH FULL
                                           ON DELETE NO ACTION
                                           ON UPDATE NO ACTION
                                           NOT DEFERRABLE,
                                       CONSTRAINT fk_tnumero_celular__id_tipo_cc FOREIGN KEY (id_tipo_cc)
                                           REFERENCES param.ttipo_cc(id_tipo_cc)
                                           MATCH FULL
                                           ON DELETE NO ACTION
                                           ON UPDATE NO ACTION
                                           NOT DEFERRABLE,
                                       CONSTRAINT fk_tnumero_celular_id_cuenta FOREIGN KEY (id_cuenta)
                                           REFERENCES gecom.tcuenta_proveedor(id_cuenta)
                                           MATCH FULL
                                           ON DELETE NO ACTION
                                           ON UPDATE NO ACTION
                                           NOT DEFERRABLE
) INHERITS (pxp.tbase)
WITH (oids = false);

CREATE TABLE gecom.tequipo (
                               id_equipo SERIAL,
                               tipo VARCHAR(150),
                               marca VARCHAR(200),
                               modelo VARCHAR(200),
                               num_serie VARCHAR(300),
                               estado_fisico VARCHAR,
                               estado VARCHAR(50),
                               observaciones VARCHAR,
                               CONSTRAINT tequipo_pkey PRIMARY KEY(id_equipo)
) INHERITS (pxp.tbase)
WITH (oids = false);


CREATE TABLE gecom.tfuncionario_celular (
                                            id_funcionario_celular SERIAL,
                                            id_funcionario INTEGER,
                                            id_cargo INTEGER,
                                            id_numero_celular INTEGER,
                                            fecha_inicio DATE NOT NULL,
                                            fecha_fin DATE,
                                            observaciones TEXT,
                                            tipo_asignacion VARCHAR(20) DEFAULT 'personal'::character varying NOT NULL,
                                            id_equipo INTEGER,
                                            codigo_inmovilizado VARCHAR(300),
                                            tipo_asignacion_equipo VARCHAR(50),
                                            tipo_servicio VARCHAR(50),
											id_accesorios varchar,
                                            CONSTRAINT tfuncionario_celular_pkey PRIMARY KEY(id_funcionario_celular),
                                            CONSTRAINT fk_tfuncionario_celular__id_cargo FOREIGN KEY (id_cargo)
                                                REFERENCES orga.tcargo(id_cargo)
                                                MATCH FULL
                                                ON DELETE NO ACTION
                                                ON UPDATE NO ACTION
                                                NOT DEFERRABLE,
                                            CONSTRAINT fk_tfuncionario_celular__id_equipo FOREIGN KEY (id_equipo)
                                                REFERENCES gecom.tequipo(id_equipo)
                                                MATCH FULL
                                                ON DELETE NO ACTION
                                                ON UPDATE NO ACTION
                                                NOT DEFERRABLE,
                                            CONSTRAINT fk_tfuncionario_celular__id_funcionario FOREIGN KEY (id_funcionario)
                                                REFERENCES orga.tfuncionario(id_funcionario)
                                                MATCH FULL
                                                ON DELETE NO ACTION
                                                ON UPDATE NO ACTION
                                                NOT DEFERRABLE,
                                            CONSTRAINT fk_tfuncionario_celular__id_numero_celular FOREIGN KEY (id_numero_celular)
                                                REFERENCES gecom.tnumero_celular(id_numero_celular)
                                                MATCH FULL
                                                ON DELETE NO ACTION
                                                ON UPDATE NO ACTION
                                                NOT DEFERRABLE
) INHERITS (pxp.tbase)
WITH (oids = false);

COMMENT ON COLUMN gecom.tfuncionario_celular.tipo_asignacion
IS 'El Tipo puede ser personal|compartido';

CREATE TABLE gecom.tequipo_historico (
                                         id_equipo_historico SERIAL,
                                         id_equipo INTEGER,
                                         tipo VARCHAR(150),
                                         marca VARCHAR(200),
                                         modelo VARCHAR(200),
                                         num_serie VARCHAR(300),
                                         estado_fisico VARCHAR,
                                         estado VARCHAR(50),
                                         observaciones VARCHAR,
                                         operacion VARCHAR(15),
                                         id_funcionario_celular INTEGER,
                                         CONSTRAINT tequipo_historico_pkey PRIMARY KEY(id_equipo_historico),
                                         CONSTRAINT fk_tequipo_historico__id_funcionario_celular FOREIGN KEY (id_funcionario_celular)
                                             REFERENCES gecom.tfuncionario_celular(id_funcionario_celular)
                                             MATCH FULL
                                             ON DELETE NO ACTION
                                             ON UPDATE NO ACTION
                                             NOT DEFERRABLE
) INHERITS (pxp.tbase)
WITH (oids = false);

CREATE TABLE gecom.tequipo_movil (
                                     id_equipo_movil SERIAL,
                                     id_equipo INTEGER,
                                     color VARCHAR(30),
                                     imei VARCHAR(300),
                                     sn VARCHAR(300),
                                     id_numero_celular INTEGER,
                                     gama VARCHAR(50),
                                     imei2 VARCHAR(200),
                                     tipo_servicio VARCHAR(50),
                                     CONSTRAINT tequipo_movil_pkey PRIMARY KEY(id_equipo_movil),
                                     CONSTRAINT fk_tequipo_movil_id_numero_celular FOREIGN KEY (id_numero_celular)
                                         REFERENCES gecom.tnumero_celular(id_numero_celular)
                                         MATCH FULL
                                         ON DELETE NO ACTION
                                         ON UPDATE NO ACTION
                                         NOT DEFERRABLE
) INHERITS (pxp.tbase)
WITH (oids = false);

CREATE TABLE gecom.tequipo_pc (
                                  id_equipo_pc SERIAL,
                                  id_equipo INTEGER,
                                  id_equipo_historico INTEGER,
                                  tamano_pantalla VARCHAR(300),
                                  tarjeta_video VARCHAR(300),
                                  teclado VARCHAR(300),
								  teclado_idioma varchar(200),
                                  procesador VARCHAR(300),
                                  memoria_ram VARCHAR(300),
                                  almacenamiento VARCHAR(300),
                                  sistema_operativo VARCHAR(300),
                                  accesorios VARCHAR(300),
								  mac varchar(500),
                                  tipo_memoria_ram varchar(300),
                                  tipo_almacenamiento varchar(300),
                                  CONSTRAINT tequipo_pc_pkey PRIMARY KEY(id_equipo_pc)
) INHERITS (pxp.tbase)
WITH (oids = false);

CREATE TABLE gecom.tnumero_celular_historico (
                                                 id_numero_celular_his SERIAL,
                                                 id_numero_celular INTEGER,
                                                 numero VARCHAR(20),
                                                 roaming VARCHAR(2),
                                                 observaciones TEXT,
                                                 id_proveedor INTEGER,
                                                 tipo VARCHAR(20),
                                                 estado VARCHAR(20),
                                                 credito NUMERIC,
                                                 limite_consumo NUMERIC,
                                                 sim INTEGER,
                                                 id_cuenta INTEGER,
                                                 operacion VARCHAR(15),
                                                 observacion_operacion VARCHAR(200),
                                                 id_tipo_cc INTEGER,
                                                 CONSTRAINT tnumero_celular_historico_pkey PRIMARY KEY(id_numero_celular_his)
) INHERITS (pxp.tbase)
WITH (oids = false);

CREATE TABLE gecom.taccesorio (
                                  id_accesorio SERIAL,
                                  nombre VARCHAR(200),
                                  marca VARCHAR(200),
                                  num_serie VARCHAR(300),
                                  estado_fisico VARCHAR(200),
                                  observaciones VARCHAR,
                                  id_equipo INTEGER,
								  tipo varchar(300),
								  modelo varchar(300),
                                  CONSTRAINT taccesorio_id_accesorio_pkey PRIMARY KEY(id_accesorio),
                                  CONSTRAINT fk_taccesorio__id_equipo FOREIGN KEY (id_equipo)
                                      REFERENCES gecom.tequipo(id_equipo)
                                      MATCH FULL
                                      ON DELETE NO ACTION
                                      ON UPDATE NO ACTION
                                      NOT DEFERRABLE
) INHERITS (pxp.tbase)
WITH (oids = false);

alter table gecom.tservicio alter column tarifa drop not null;
alter table gecom.tnumero_servicio alter column fecha_inicio drop not null;
alter table gecom.tnumero_servicio add column tarifa numeric;
alter table gecom.tservicio add column tipo_servicio varchar(50);

alter table gecom.tservicio alter column codigo_servicio drop not null;
alter table gecom.tservicio alter column defecto drop not null;

/***********************************F-SCP-YMR-GECOM-1-30/05/2021****************************************/