CREATE OR REPLACE FUNCTION gecom.ft_pago_telefonia_det_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Lineas Telefonicas
 FUNCION: 		gecom.ft_pago_telefonia_det_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.tpago_telefonia_det'
 AUTOR: 		 (breydi.vasquez)
 FECHA:	        24-11-2020 16:26:28
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				24-11-2020 16:26:28								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.tpago_telefonia_det'
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'gecom.ft_pago_telefonia_det_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'GC_DETPAGTE_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		breydi.vasquez
 	#FECHA:		24-11-2020 16:26:28
	***********************************/

	if(p_transaccion='GC_DETPAGTE_SEL')then

    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						detpagte.id_pago_telefonia_det,
						detpagte.estado_reg,
						detpagte.id_pago_telefonia,
						detpagte.fecha,
						detpagte.hora,
						detpagte.anexo,
						detpagte.cod_empleado,
						detpagte.nombre_empleado,
						detpagte.nro_telefono,
						detpagte.nombre_telefono,
						detpagte.duracion_real,
						detpagte.costo_llamada,
						detpagte.servicio_llamada,
						detpagte.cod_sucursal,
						detpagte.sucursal,
						detpagte.ruta,
						detpagte.troncal,
						detpagte.cod_usuario,
						detpagte.cod_organizacion,
						detpagte.organizacion,
						detpagte.cod_centro_costo,
						detpagte.centro_costo,
						detpagte.nro_origen,
						detpagte.cod_ciudad,
						detpagte.ciudad,
						detpagte.cod_pais,
						detpagte.pais,
						detpagte.duracion_llamada,
						detpagte.globa_l,
						detpagte.tipo_resp_llamada,
						detpagte.transferir_a,
						detpagte.transferir_desde,
						detpagte.evento,
						detpagte.posicion_memoria,
						detpagte.cod_compania,
						detpagte.tiempo_timbrado,
						detpagte.cod_grupo_base_destino,
						detpagte.grupo_base_destino,
						detpagte.grupo_destino,
						detpagte.cod_interno,
						detpagte.fac,
						detpagte.desv_de_desv_a,
						detpagte.factor_porcentual,
						detpagte.id_centro_costo,
						detpagte.id_concepto_ingas,
						detpagte.id_usuario_reg,
						detpagte.fecha_reg,
						detpagte.id_usuario_ai,
						detpagte.usuario_ai,
						detpagte.id_usuario_mod,
						detpagte.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        cc.codigo_cc as desc_centro_costo,
                        cig.desc_ingas as desc_concepto_ingas,
                        rut.salida,
                        rut.id_numero_celular,
                        numcel.numero,
                        pro.desc_proveedor::varchar

						from gecom.tpago_telefonia_det detpagte
						inner join segu.tusuario usu1 on usu1.id_usuario = detpagte.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = detpagte.id_usuario_mod
                        left join param.vcentro_costo cc on cc.id_centro_costo = detpagte.id_centro_costo
                        left join param.tconcepto_ingas cig on cig.id_concepto_ingas = detpagte.id_concepto_ingas

                        left join gecom.truta rut on rut.nro_ruta = detpagte.ruta and rut.cod_compania = detpagte.cod_compania
                        left join gecom.tnumero_celular numcel on numcel.id_numero_celular = rut.id_numero_celular
                        left join param.vproveedor pro on pro.id_proveedor = numcel.id_proveedor

				        where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  'GC_DETPAGTE_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		breydi.vasquez
 	#FECHA:		24-11-2020 16:26:28
	***********************************/

	elsif(p_transaccion='GC_DETPAGTE_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(detpagte.id_pago_telefonia_det)
					    from gecom.tpago_telefonia_det detpagte
					    inner join segu.tusuario usu1 on usu1.id_usuario = detpagte.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = detpagte.id_usuario_mod
                        left join param.vcentro_costo cc on cc.id_centro_costo = detpagte.id_centro_costo
                        left join param.tconcepto_ingas cig on cig.id_concepto_ingas = detpagte.id_concepto_ingas

                        left join gecom.truta rut on rut.nro_ruta = detpagte.ruta and rut.cod_compania = detpagte.cod_compania
                        left join gecom.tnumero_celular numcel on numcel.id_numero_celular = rut.id_numero_celular
                        left join param.vproveedor pro on pro.id_proveedor = numcel.id_proveedor

					    where ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;

	else

		raise exception 'Transaccion inexistente';

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

ALTER FUNCTION gecom.ft_pago_telefonia_det_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;
