CREATE OR REPLACE FUNCTION gecom.ft_pago_telefonia_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Lineas Telefonicas
 FUNCION: 		gecom.ft_pago_telefonia_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.tpago_telefonia'
 AUTOR: 		 (breydi.vasquez)
 FECHA:	        24-11-2020 16:26:24
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				24-11-2020 16:26:24								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.tpago_telefonia'
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_pago_telefonia		integer;
    v_dupl_pat				record;
    v_id_concepto_ingas		integer;
    v_id_proveedor			integer;
    v_registro				record;
    v_reg					record;
    v_update				record;
    v_reg_calc				record;
    v_data					record;
    v_count					integer;
    v_costo_llamada			numeric;
    v_sum_importe			numeric;

BEGIN

    v_nombre_funcion = 'gecom.ft_pago_telefonia_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'GC_PAGTEL_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		breydi.vasquez
 	#FECHA:		24-11-2020 16:26:24
	***********************************/

	if(p_transaccion='GC_PAGTEL_INS')then

        begin

             select ges.gestion,
                param.f_literal_periodo(co.id_periodo) as periodo
                    into v_dupl_pat
                from gecom.tpago_telefonia co
                inner join param.tgestion ges on ges.id_gestion = co.id_gestion
                where co.id_gestion = v_parametros.id_gestion and
                    co.id_periodo = v_parametros.id_periodo;

            IF v_dupl_pat is not null THEN
                raise exception 'El periodo: % ya esta resgistrado para la gestion: %.',v_dupl_pat.periodo, v_dupl_pat.gestion;
			ELSE

              --Sentencia de la insercion
              insert into gecom.tpago_telefonia(
              estado_reg,
              id_gestion,
              id_periodo,
              descripcion,
              id_usuario_reg,
              fecha_reg,
              id_usuario_ai,
              usuario_ai,
              id_usuario_mod,
              fecha_mod,
              estado
              ) values(
              'activo',
              v_parametros.id_gestion,
              v_parametros.id_periodo,
              v_parametros.descripcion,
              p_id_usuario,
              now(),
              v_parametros._id_usuario_ai,
              v_parametros._nombre_usuario_ai,
              null,
              null,
              'registrado'
              )RETURNING id_pago_telefonia into v_id_pago_telefonia;

              --Definicion de la respuesta
              v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Pago telefonia almacenado(a) con exito (id_pago_telefonia'||v_id_pago_telefonia||')');
              v_resp = pxp.f_agrega_clave(v_resp,'id_pago_telefonia',v_id_pago_telefonia::varchar);

			END IF;

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'GC_PAGTEL_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		breydi.vasquez
 	#FECHA:		24-11-2020 16:26:24
	***********************************/

	elsif(p_transaccion='GC_PAGTEL_MOD')then

		begin
			--Sentencia de la modificacion

			update gecom.tpago_telefonia set
			id_gestion = v_parametros.id_gestion,
			id_periodo = v_parametros.id_periodo,
			descripcion = v_parametros.descripcion,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_pago_telefonia=v_parametros.id_pago_telefonia;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Pago telefonia modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_pago_telefonia',v_parametros.id_pago_telefonia::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'GC_PAGTEL_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		breydi.vasquez
 	#FECHA:		24-11-2020 16:26:24
	***********************************/

	elsif(p_transaccion='GC_PAGTEL_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from gecom.tpago_telefonia
            where id_pago_telefonia=v_parametros.id_pago_telefonia;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Pago telefonia eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_pago_telefonia',v_parametros.id_pago_telefonia::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'GC_CALPAGTEL_IME'
 	#DESCRIPCION:	Calculo porcentual pago telefonia
 	#AUTOR:		breydi.vasquez
 	#FECHA:		26-11-2020 10:26:24
	***********************************/

	elsif(p_transaccion='GC_CALPAGTEL_IME')then

		begin

        	-- verificacion de parametrizacion de rutas para la gestion
            IF (EXISTS (SELECT 1 FROM gecom.truta grt WHERE grt.id_gestion = v_parametros.id_gestion)=false)THEN
            	RAISE 'LAS RUTAS NO ESTAN PARAMETRIZADAS PARA LA GESTION ACTUAL';
            END IF;
			-- Sentencia de actualizacion de datos

            FOR v_update in (  SELECT id_pago_telefonia_det, ruta, cod_compania
            				   FROM gecom.tpago_telefonia_det
                               WHERE id_pago_telefonia = v_parametros.id_pago_telefonia
             			    )
            LOOP
            			SELECT grt.id_concepto_ingas, id_proveedor
            				INTO v_id_concepto_ingas, v_id_proveedor
                        FROM gecom.truta grt
                        WHERE grt.nro_ruta = v_update.ruta
                        AND grt.cod_compania = v_update.cod_compania
                        AND grt.id_gestion = v_parametros.id_gestion;

                        UPDATE gecom.tpago_telefonia_det
                        SET
	                        id_concepto_ingas = v_id_concepto_ingas,
    	                    id_proveedor = v_id_proveedor
                        WHERE id_pago_telefonia_det = v_update.id_pago_telefonia_det;
            END LOOP;

            -- Sentencia de agrupacion y calculo

            FOR v_registro  in (			-- agrupacion por empresa
            					SELECT
                                   id_proveedor
                                FROM gecom.tpago_telefonia_det
                                WHERE id_pago_telefonia = v_parametros.id_pago_telefonia
                                AND id_proveedor is not null
                                GROUP BY id_proveedor
            )
            LOOP
                    FOR v_reg in (			-- agrupacion por concepto
                                  SELECT
                                     id_concepto_ingas
                                  FROM gecom.tpago_telefonia_det
                                  WHERE id_pago_telefonia = v_parametros.id_pago_telefonia
                                  AND id_proveedor = v_registro.id_proveedor
                                  GROUP BY id_concepto_ingas
                    )
                    LOOP
                    		FOR v_data in ( -- agrupacion por centro de costo
											SELECT
                                               id_centro_costo
                                            FROM gecom.tpago_telefonia_det
                                            WHERE id_pago_telefonia = v_parametros.id_pago_telefonia
                                            AND id_concepto_ingas = v_reg.id_concepto_ingas
                                            GROUP BY id_centro_costo
                            )
                            LOOP
                                                SELECT count(id_pago_telefonia_det),
                                                       sum(costo_llamada)
                                                    INTO v_count, v_sum_importe
                                                FROM gecom.tpago_telefonia_det
                                                WHERE id_pago_telefonia = v_parametros.id_pago_telefonia
                                                AND  id_centro_costo = v_data.id_centro_costo;

                                                FOR v_reg_calc in (
                                                					SELECT id_pago_telefonia_det,costo_llamada
                                                                   	FROM gecom.tpago_telefonia_det
                                                                   	WHERE id_pago_telefonia = v_parametros.id_pago_telefonia
                                                                   	AND  id_centro_costo = v_data.id_centro_costo
                                                                   )
                                                LOOP
                                                    UPDATE gecom.tpago_telefonia_det
                                                    SET
                                                        factor_porcentual = (v_reg_calc.costo_llamada * 100) / v_sum_importe
                                                    WHERE id_pago_telefonia_det = v_reg_calc.id_pago_telefonia_det;
                                                END LOOP;
                            END LOOP;
                    END LOOP;

            END LOOP;

            UPDATE gecom.tpago_telefonia
            SET
            	estado = 'calculado'
            WHERE id_pago_telefonia = v_parametros.id_pago_telefonia;


            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Calulo Pago telefonia');
            v_resp = pxp.f_agrega_clave(v_resp,'id_pago_telefonia',v_parametros.id_pago_telefonia::varchar);

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

ALTER FUNCTION gecom.ft_pago_telefonia_ime (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;
