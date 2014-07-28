CREATE OR REPLACE FUNCTION "gecom"."ft_consumo_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Gestión de Comunicación
 FUNCION: 		gecom.ft_consumo_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.tconsumo'
 AUTOR: 		 (jrivera)
 FECHA:	        24-07-2014 19:17:04
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'gecom.ft_consumo_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'GC_CON_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		jrivera	
 	#FECHA:		24-07-2014 19:17:04
	***********************************/

	if(p_transaccion='GC_CON_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						con.id_consumo,
						con.id_numero_celular,
						con.id_periodo,
						con.id_gestion,
						con.id_servicio,
						con.estado_reg,
						con.observaciones,
						con.consumo,
						con.id_usuario_reg,
						con.fecha_reg,
						con.usuario_ai,
						con.id_usuario_ai,
						con.id_usuario_mod,
						con.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						per.periodo,
						ges.gestion,
						ser.nombre_servicio	
						from gecom.tconsumo con
						inner join param.tperiodo per on per.id_periodo = con.id_periodo
						inner join param.tgestion ges on ges.id_gestion = con.id_gestion
						left join gecom.tservicio ser on ser.id_servicio = con.id_servicio
						inner join segu.tusuario usu1 on usu1.id_usuario = con.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = con.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'GC_CON_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		jrivera	
 	#FECHA:		24-07-2014 19:17:04
	***********************************/

	elsif(p_transaccion='GC_CON_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_consumo)
					    from gecom.tconsumo con
					    inner join param.tperiodo per on per.id_periodo = con.id_periodo
						inner join param.tgestion ges on ges.id_gestion = con.id_gestion
						left join gecom.tservicio ser on ser.id_servicio = con.id_servicio
					    inner join segu.tusuario usu1 on usu1.id_usuario = con.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = con.id_usuario_mod
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "gecom"."ft_consumo_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
