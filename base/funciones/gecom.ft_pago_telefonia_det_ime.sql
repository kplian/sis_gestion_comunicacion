CREATE OR REPLACE FUNCTION gecom.ft_pago_telefonia_det_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Lineas Telefonicas
 FUNCION: 		gecom.ft_pago_telefonia_det_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.tpago_telefonia_det'
 AUTOR: 		 (breydi.vasquez)
 FECHA:	        24-11-2020 16:26:28
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				24-11-2020 16:26:28								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.tpago_telefonia_det'
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_pago_telefonia_det	integer;
    v_id_centro_costo		integer;


BEGIN

    v_nombre_funcion = 'gecom.ft_pago_telefonia_det_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'GC_DETPAGTE_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		breydi.vasquez
 	#FECHA:		24-11-2020 16:26:28
	***********************************/

	if(p_transaccion='GC_DETPAGTE_INS')then

        begin

            select cec.id_centro_costo
            	into v_id_centro_costo
            from param.ttipo_cc cc
            inner join param.tcentro_costo cec on cec.id_tipo_cc =  cc.id_tipo_cc
            inner join param.tgestion ges ON ges.id_gestion = cec.id_gestion
            where cc.codigo = v_parametros.cod_centro_costo
            and ges.gestion = extract(year from now()::date);


        	--Sentencia de la insercion
        	insert into gecom.tpago_telefonia_det(
			estado_reg,
			id_pago_telefonia,
			fecha,
			hora,
			anexo,
			cod_empleado,
			nombre_empleado,
			nro_telefono,
			nombre_telefono,
			duracion_real,
			costo_llamada,
			servicio_llamada,
			cod_sucursal,
			sucursal,
			ruta,
			troncal,
			cod_usuario,
			cod_organizacion,
			organizacion,
			cod_centro_costo,
			centro_costo,
			nro_origen,
			cod_ciudad,
			ciudad,
			cod_pais,
			pais,
			duracion_llamada,
			globa_l,
			tipo_resp_llamada,
			transferir_a,
			transferir_desde,
			evento,
			posicion_memoria,
			cod_compania,
			tiempo_timbrado,
			cod_grupo_base_destino,
			grupo_base_destino,
			grupo_destino,
			cod_interno,
			fac,
			desv_de_desv_a,
			id_centro_costo,
			id_concepto_ingas,
			id_usuario_reg,
			fecha_reg,
			id_usuario_ai,
			usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			'activo',
			v_parametros.id_pago_telefonia,
			v_parametros.fecha,
			v_parametros.hora,
			v_parametros.anexo,
			v_parametros.cod_empleado,
			v_parametros.nombre_empleado,
			v_parametros.nro_telefono,
			v_parametros.nombre_telefono,
			v_parametros.duracion_real,
			v_parametros.costo_llamada,
			v_parametros.servicio_llamada,
			v_parametros.cod_sucursal,
			v_parametros.sucursal,
			v_parametros.ruta,
			v_parametros.troncal,
			v_parametros.cod_usuario,
			v_parametros.cod_organizacion,
			v_parametros.organizacion,
			v_parametros.cod_centro_costo,
			v_parametros.centro_costo,
			v_parametros.nro_origen,
			v_parametros.cod_ciudad,
			v_parametros.ciudad,
			v_parametros.cod_pais,
			v_parametros.pais,
			v_parametros.duracion_llamada,
			v_parametros.globa_l,
			v_parametros.tipo_resp_llamada,
			v_parametros.transferir_a,
			v_parametros.transferir_desde,
			v_parametros.evento,
			v_parametros.posicion_memoria,
			v_parametros.cod_compania,
			v_parametros.tiempo_timbrado,
			v_parametros.cod_grupo_base_destino,
			v_parametros.grupo_base_destino,
			v_parametros.grupo_destino,
			v_parametros.cod_interno,
			v_parametros.fac,
			v_parametros.desv_de_desv_a,
			v_id_centro_costo,
            NULL,
			p_id_usuario,
			now(),
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			null,
			null



			)RETURNING id_pago_telefonia_det into v_id_pago_telefonia_det;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle pago telefonia almacenado(a) con exito (id_pago_telefonia_det'||v_id_pago_telefonia_det||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_pago_telefonia_det',v_id_pago_telefonia_det::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'GC_DETPAGTE_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		breydi.vasquez
 	#FECHA:		24-11-2020 16:26:28
	***********************************/

	elsif(p_transaccion='GC_DETPAGTE_MOD')then

		begin
			--Sentencia de la modificacion
			update gecom.tpago_telefonia_det set
			id_pago_telefonia = v_parametros.id_pago_telefonia,
			fecha = v_parametros.fecha,
			hora = v_parametros.hora,
			anexo = v_parametros.anexo,
			cod_empleado = v_parametros.cod_empleado,
			nombre_empleado = v_parametros.nombre_empleado,
			nro_telefono = v_parametros.nro_telefono,
			nombre_telefono = v_parametros.nombre_telefono,
			duracion_real = v_parametros.duracion_real,
			costo_llamada = v_parametros.costo_llamada,
			servicio_llamada = v_parametros.servicio_llamada,
			cod_sucursal = v_parametros.cod_sucursal,
			sucursal = v_parametros.sucursal,
			ruta = v_parametros.ruta,
			troncal = v_parametros.troncal,
			cod_usuario = v_parametros.cod_usuario,
			cod_organizacion = v_parametros.cod_organizacion,
			organizacion = v_parametros.organizacion,
			cod_centro_costo = v_parametros.cod_centro_costo,
			centro_costo = v_parametros.centro_costo,
			nro_origen = v_parametros.nro_origen,
			cod_ciudad = v_parametros.cod_ciudad,
			ciudad = v_parametros.ciudad,
			cod_pais = v_parametros.cod_pais,
			pais = v_parametros.pais,
			duracion_llamada = v_parametros.duracion_llamada,
			globa_l = v_parametros.globa_l,
			tipo_resp_llamada = v_parametros.tipo_resp_llamada,
			transferir_a = v_parametros.transferir_a,
			transferir_desde = v_parametros.transferir_desde,
			evento = v_parametros.evento,
			posicion_memoria = v_parametros.posicion_memoria,
			cod_compania = v_parametros.cod_compania,
			tiempo_timbrado = v_parametros.tiempo_timbrado,
			cod_grupo_base_destino = v_parametros.cod_grupo_base_destino,
			grupo_base_destino = v_parametros.grupo_base_destino,
			grupo_destino = v_parametros.grupo_destino,
			cod_interno = v_parametros.cod_interno,
			fac = v_parametros.fac,
			desv_de_desv_a = v_parametros.desv_de_desv_a,
			factor_porcentual = v_parametros.factor_porcentual,
			id_centro_costo = v_parametros.id_centro_costo,
			id_concepto_ingas = v_parametros.id_concepto_ingas,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_pago_telefonia_det=v_parametros.id_pago_telefonia_det;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle pago telefonia modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_pago_telefonia_det',v_parametros.id_pago_telefonia_det::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'GC_DETPAGTE_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		breydi.vasquez
 	#FECHA:		24-11-2020 16:26:28
	***********************************/

	elsif(p_transaccion='GC_DETPAGTE_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from gecom.tpago_telefonia_det
            where id_pago_telefonia_det=v_parametros.id_pago_telefonia_det;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle pago telefonia eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_pago_telefonia_det',v_parametros.id_pago_telefonia_det::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'GC_PGTELUP_IME'
 	#DESCRIPCION:	Cambio de estado pago telefonia
 	#AUTOR:		breydi.vasquez
 	#FECHA:		25-11-2020 16:26:28
	***********************************/

	elsif(p_transaccion='GC_PGTELUP_IME')then

		begin
			--Sentencia de la eliminacion
			update gecom.tpago_telefonia set
            estado = 'cargado'
            where id_pago_telefonia = v_parametros.id_pago_telefonia;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle pago telefonia eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'success','exito');

            --Devuelve la respuesta
            return v_resp;

		end;


	else

    	raise exception 'Transaccion inexistente: %',p_transaccion;

	end if;

EXCEPTION

	WHEN OTHERS THEN
		v_resp='';
		v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
		v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
		v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
		raise exception '%',v_resp;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

ALTER FUNCTION gecom.ft_pago_telefonia_det_ime (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;
