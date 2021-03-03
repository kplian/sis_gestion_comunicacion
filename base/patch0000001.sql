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
/***********************************I-SCP-BVP-GECOM-0-12/12/2020****************************************/

CREATE TABLE gecom.tpago_telefonia (
  id_pago_telefonia SERIAL,
  id_gestion INTEGER,
  id_periodo INTEGER,
  descripcion TEXT,
  estado VARCHAR(20),
  CONSTRAINT tpago_telefonia_pkey PRIMARY KEY(id_pago_telefonia)
) INHERITS (pxp.tbase)
WITH (oids = false);

COMMENT ON TABLE gecom.tpago_telefonia
IS 'tabla padre para registro de pago de telefonia por periodo y gestion';

COMMENT ON COLUMN gecom.tpago_telefonia.estado
IS 'Estados(registrado, cargado, calulado)';

ALTER TABLE gecom.tpago_telefonia
  OWNER TO postgres;

CREATE TABLE gecom.tpago_telefonia_det (
  id_pago_telefonia_det SERIAL,
  id_pago_telefonia INTEGER NOT NULL,
  fecha DATE NOT NULL,
  hora TIME WITHOUT TIME ZONE NOT NULL,
  anexo VARCHAR(20),
  cod_empleado VARCHAR(50),
  nombre_empleado VARCHAR(150),
  nro_telefono VARCHAR(100),
  nombre_telefono VARCHAR(150),
  duracion_real TIME WITHOUT TIME ZONE,
  costo_llamada NUMERIC(18,2),
  servicio_llamada VARCHAR(100),
  cod_sucursal VARCHAR(10),
  sucursal VARCHAR(100),
  ruta INTEGER,
  troncal INTEGER,
  cod_usuario VARCHAR,
  cod_organizacion VARCHAR(150),
  organizacion VARCHAR(200),
  cod_centro_costo VARCHAR(30),
  centro_costo VARCHAR(150),
  nro_origen VARCHAR(100),
  cod_ciudad VARCHAR(10),
  ciudad VARCHAR(100),
  cod_pais VARCHAR(10),
  pais VARCHAR(100),
  duracion_llamada NUMERIC,
  global VARCHAR(20),
  tipo_resp_llamada VARCHAR(10),
  transferir_a VARCHAR,
  transferir_desde VARCHAR,
  evento VARCHAR,
  posicion_memoria VARCHAR,
  cod_compania VARCHAR(100),
  tiempo_timbrado TIME WITHOUT TIME ZONE,
  cod_grupo_base_destino VARCHAR(10),
  grupo_base_destino VARCHAR(100),
  grupo_destino VARCHAR(10),
  cod_interno VARCHAR(150),
  fac VARCHAR(100),
  desv_de_desv_a VARCHAR,
  factor_porcentual NUMERIC(18,2),
  id_centro_costo INTEGER,
  id_concepto_ingas INTEGER,
  fecha_hora TIMESTAMP WITHOUT TIME ZONE,
  id_proveedor INTEGER,
  CONSTRAINT tpago_telefonia_det_pkey PRIMARY KEY(id_pago_telefonia_det),
  CONSTRAINT tpago_telefonia_det_fk FOREIGN KEY (id_pago_telefonia)
    REFERENCES gecom.tpago_telefonia(id_pago_telefonia)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
    NOT DEFERRABLE
) INHERITS (pxp.tbase)
WITH (oids = false);

COMMENT ON TABLE gecom.tpago_telefonia_det
IS 'Detalle de excel cargado, para calculo de pago de telefonia';

COMMENT ON COLUMN gecom.tpago_telefonia_det.cod_empleado
IS 'Codigo empleado';

COMMENT ON COLUMN gecom.tpago_telefonia_det.nro_telefono
IS 'Numero de telefono o celular';

COMMENT ON COLUMN gecom.tpago_telefonia_det.cod_sucursal
IS 'Codigo de sucursal';

COMMENT ON COLUMN gecom.tpago_telefonia_det.cod_usuario
IS 'Codigo usuario';

COMMENT ON COLUMN gecom.tpago_telefonia_det.cod_organizacion
IS 'Codigo organizacion';

COMMENT ON COLUMN gecom.tpago_telefonia_det.cod_centro_costo
IS 'Codigo centro de costos';

COMMENT ON COLUMN gecom.tpago_telefonia_det.centro_costo
IS 'Nombre centro de costos';

COMMENT ON COLUMN gecom.tpago_telefonia_det.nro_origen
IS 'Numero de origen';

COMMENT ON COLUMN gecom.tpago_telefonia_det.cod_ciudad
IS 'Codigo ciudad';

COMMENT ON COLUMN gecom.tpago_telefonia_det.cod_pais
IS 'Codigo pais';

COMMENT ON COLUMN gecom.tpago_telefonia_det.tipo_resp_llamada
IS 'Tipo respuesta llamada';

COMMENT ON COLUMN gecom.tpago_telefonia_det.cod_compania
IS 'Codigo compañia';

COMMENT ON COLUMN gecom.tpago_telefonia_det.cod_grupo_base_destino
IS 'Codigo grupo base destino';

ALTER TABLE gecom.tpago_telefonia_det
  OWNER TO postgres;

CREATE TABLE gecom.truta (
  id_ruta SERIAL,
  nro_ruta INTEGER,
  cod_compania VARCHAR,
  salida VARCHAR,
  id_concepto_ingas INTEGER,
  id_gestion INTEGER,
  id_proveedor INTEGER,
  CONSTRAINT truta_pkey PRIMARY KEY(id_ruta)
) INHERITS (pxp.tbase)
WITH (oids = false);

COMMENT ON TABLE gecom.truta
IS 'tabla parametrica para las rutas PCSISTEL para poder identificar el servicio al que debe asignarse el costo';

COMMENT ON COLUMN gecom.truta.nro_ruta
IS 'Numero de ruta';

COMMENT ON COLUMN gecom.truta.cod_compania
IS 'Código de compañia';

COMMENT ON COLUMN gecom.truta.salida
IS 'Descripcion codigo, empresa, ciudad, numero';

COMMENT ON COLUMN gecom.truta.id_concepto_ingas
IS 'Concepto de gasto';

ALTER TABLE gecom.truta
  OWNER TO postgres;
/***********************************F-SCP-BVP-GECOM-0-12/12/2020****************************************/
/***********************************F-SCP-BVP-GECOM-0-12/12/2020****************************************/
ALTER TABLE gecom.tpago_telefonia_det
  RENAME COLUMN global TO globa_l;
/***********************************F-SCP-BVP-GECOM-0-12/12/2020****************************************/

/***********************************F-SCP-MAY-GECOM-0-25/1/2021****************************************/
ALTER TABLE gecom.truta
ADD COLUMN  id_numero_celular INTEGER;

COMMENT ON COLUMN gecom.truta.id_numero_celular
IS 'identificador de la tabla tnumero_celular';
/***********************************F-SCP-MAY-GECOM-0-25/1/2021****************************************/

/***********************************F-SCP-MAY-GECOM-0-24/2/2021****************************************/
CREATE TABLE gecom.tes_temp_prorrateo_ruta (
  id_temp_prorrateo_ruta INTEGER,
  id_funcionario INTEGER,
  id_centro_costo INTEGER,
  monto NUMERIC(18,2),
  descripcion TEXT,
  id_orden_trabajo INTEGER,
  id_tabla INTEGER,
  id_periodo INTEGER,
  ruta VARCHAR
)
WITH (oids = false);

ALTER TABLE gecom.tes_temp_prorrateo_ruta
  OWNER TO postgres;
/***********************************F-SCP-MAY-GECOM-0-24/2/2021****************************************/

/***********************************F-SCP-MAY-GECOM-0-25/2/2021****************************************/
  ALTER TABLE gecom.tes_temp_prorrateo_ruta
ADD COLUMN  id_proveedor INTEGER;
/***********************************F-SCP-MAY-GECOM-0-25/2/2021****************************************/

/***********************************F-SCP-MAY-GECOM-0-03/3/2021****************************************/
  ALTER TABLE gecom.tpago_telefonia
ADD COLUMN  nro_tramite VARCHAR(200);
/***********************************F-SCP-MAY-GECOM-0-03/3/2021****************************************/
