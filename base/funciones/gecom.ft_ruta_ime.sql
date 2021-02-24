CREATE OR REPLACE FUNCTION gecom.ft_ruta_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Lineas Telefonicas
 FUNCION: 		gecom.ft_ruta_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.truta'
 AUTOR: 		 (breydi.vasquez)
 FECHA:	        25-11-2020 18:07:20
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				25-11-2020 18:07:20								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.truta'
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_ruta	integer;

BEGIN

    v_nombre_funcion = 'gecom.ft_ruta_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'GC_GRUTA_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		breydi.vasquez
 	#FECHA:		25-11-2020 18:07:20
	***********************************/

	if(p_transaccion='GC_GRUTA_INS')then

        begin
        	--Sentencia de la insercion
        	insert into gecom.truta(
			estado_reg,
			nro_ruta,
			cod_compania,
			salida,
			id_concepto_ingas,
			id_proveedor,
			id_usuario_reg,
			fecha_reg,
			id_usuario_ai,
			usuario_ai,
			id_usuario_mod,
			fecha_mod,
            id_gestion,
            --25-01-2021 (may)
            id_numero_celular

          	) values(
			'activo',
			v_parametros.nro_ruta,
			v_parametros.cod_compania,
			v_parametros.salida,
			v_parametros.id_concepto_ingas,
			v_parametros.id_proveedor,
			p_id_usuario,
			now(),
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			null,
			null,
			v_parametros.id_gestion,
            --25-01-2021 (may)
            v_parametros.id_numero_celular

			)RETURNING id_ruta into v_id_ruta;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Rutas almacenado(a) con exito (id_ruta'||v_id_ruta||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ruta',v_id_ruta::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'GC_GRUTA_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		breydi.vasquez
 	#FECHA:		25-11-2020 18:07:20
	***********************************/

	elsif(p_transaccion='GC_GRUTA_MOD')then

		begin
			--Sentencia de la modificacion
			update gecom.truta set
			nro_ruta = v_parametros.nro_ruta,
			cod_compania = v_parametros.cod_compania,
			salida = v_parametros.salida,
			id_concepto_ingas = v_parametros.id_concepto_ingas,
			id_proveedor = v_parametros.id_proveedor,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
            id_gestion = v_parametros.id_gestion,
            --25-01-2021 (may)
            id_numero_celular = v_parametros.id_numero_celular

			where id_ruta=v_parametros.id_ruta;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Rutas modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ruta',v_parametros.id_ruta::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'GC_GRUTA_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		breydi.vasquez
 	#FECHA:		25-11-2020 18:07:20
	***********************************/

	elsif(p_transaccion='GC_GRUTA_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from gecom.truta
            where id_ruta=v_parametros.id_ruta;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Rutas eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ruta',v_parametros.id_ruta::varchar);

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

ALTER FUNCTION gecom.ft_ruta_ime (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;
