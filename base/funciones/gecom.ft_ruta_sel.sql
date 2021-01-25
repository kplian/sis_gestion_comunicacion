CREATE OR REPLACE FUNCTION gecom.ft_ruta_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Lineas Telefonicas
 FUNCION: 		gecom.ft_ruta_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.truta'
 AUTOR: 		 (breydi.vasquez)
 FECHA:	        25-11-2020 18:07:20
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				25-11-2020 18:07:20								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.truta'
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'gecom.ft_ruta_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'GC_GRUTA_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		breydi.vasquez
 	#FECHA:		25-11-2020 18:07:20
	***********************************/

	if(p_transaccion='GC_GRUTA_SEL')then

    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						gruta.id_ruta,
						gruta.estado_reg,
						gruta.nro_ruta,
						gruta.cod_compania,
						gruta.salida,
						gruta.id_concepto_ingas,
						gruta.id_usuario_reg,
						gruta.fecha_reg,
						gruta.id_usuario_ai,
						gruta.usuario_ai,
						gruta.id_usuario_mod,
						gruta.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        cig.desc_ingas::varchar as desc_ingas,
                        (par.codigo||'' - ''|| par.nombre_partida)::varchar as desc_partida,
                        ges.gestion::varchar as gestion,
                        gruta.id_gestion,
                        gruta.id_proveedor,
                      	provee.desc_proveedor,

                        gruta.id_numero_celular,
                        nucel.numero


						from gecom.truta gruta
						inner join segu.tusuario usu1 on usu1.id_usuario = gruta.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = gruta.id_usuario_mod
						inner join param.tconcepto_ingas cig on cig.id_concepto_ingas = gruta.id_concepto_ingas
                        inner join pre.tconcepto_partida cp on cp.id_concepto_ingas = gruta.id_concepto_ingas
                        inner join param.tgestion ges on ges.id_gestion = gruta.id_gestion
                        inner join pre.tpartida par on par.id_partida = cp.id_partida and par.id_gestion = gruta.id_gestion
                        left join param.vproveedor2 provee on provee.id_proveedor =  gruta.id_proveedor

                        left join gecom.tnumero_celular nucel on nucel.id_numero_celular = gruta.id_numero_celular

                        where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  'GC_GRUTA_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		breydi.vasquez
 	#FECHA:		25-11-2020 18:07:20
	***********************************/

	elsif(p_transaccion='GC_GRUTA_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(gruta.id_ruta)
					    from gecom.truta gruta
					    inner join segu.tusuario usu1 on usu1.id_usuario = gruta.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = gruta.id_usuario_mod
						inner join param.tconcepto_ingas cig on cig.id_concepto_ingas = gruta.id_concepto_ingas
                        inner join pre.tconcepto_partida cp on cp.id_concepto_ingas = gruta.id_concepto_ingas
                        inner join param.tgestion ges on ges.id_gestion = gruta.id_gestion
                        inner join pre.tpartida par on par.id_partida = cp.id_partida and par.id_gestion = gruta.id_gestion
                        inner join param.vproveedor2 provee on provee.id_proveedor =  gruta.id_proveedor

                        left join gecom.tnumero_celular nucel on nucel.id_numero_celular = gruta.id_numero_celular

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

ALTER FUNCTION gecom.ft_ruta_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;
