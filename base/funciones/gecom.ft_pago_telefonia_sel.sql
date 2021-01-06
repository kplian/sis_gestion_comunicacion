CREATE OR REPLACE FUNCTION gecom.ft_pago_telefonia_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Lineas Telefonicas
 FUNCION: 		gecom.ft_pago_telefonia_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.tpago_telefonia'
 AUTOR: 		 (breydi.vasquez)
 FECHA:	        24-11-2020 16:26:24
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				24-11-2020 16:26:24								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.tpago_telefonia'
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'gecom.ft_pago_telefonia_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'GC_PAGTEL_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		breydi.vasquez
 	#FECHA:		24-11-2020 16:26:24
	***********************************/

	if(p_transaccion='GC_PAGTEL_SEL')then

    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						pagtel.id_pago_telefonia,
						pagtel.estado_reg,
						pagtel.id_gestion,
						pagtel.id_periodo,
						pagtel.descripcion,
						pagtel.id_usuario_reg,
						pagtel.fecha_reg,
						pagtel.id_usuario_ai,
						pagtel.usuario_ai,
						pagtel.id_usuario_mod,
						pagtel.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        ges.gestion,
						param.f_literal_periodo(per.id_periodo)  as literal,
                        pagtel.estado
						from gecom.tpago_telefonia pagtel
						inner join segu.tusuario usu1 on usu1.id_usuario = pagtel.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pagtel.id_usuario_mod
                        inner join param.tgestion ges on ges.id_gestion = pagtel.id_gestion
						inner join param.tperiodo per on per.id_periodo  = pagtel.id_periodo
				        where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  'GC_PAGTEL_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		breydi.vasquez
 	#FECHA:		24-11-2020 16:26:24
	***********************************/

	elsif(p_transaccion='GC_PAGTEL_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_pago_telefonia)
					    from gecom.tpago_telefonia pagtel
					    inner join segu.tusuario usu1 on usu1.id_usuario = pagtel.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pagtel.id_usuario_mod
                        inner join param.tgestion ges on ges.id_gestion = pagtel.id_gestion
						inner join param.tperiodo per on per.id_periodo  = pagtel.id_periodo
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

ALTER FUNCTION gecom.ft_pago_telefonia_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;
