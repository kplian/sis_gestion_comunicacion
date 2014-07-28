CREATE OR REPLACE FUNCTION "gecom"."ft_numero_servicio_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Gestión de Comunicación
 FUNCION: 		gecom.ft_numero_servicio_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.tnumero_servicio'
 AUTOR: 		 (jrivera)
 FECHA:	        23-07-2014 23:47:15
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

	v_nombre_funcion = 'gecom.ft_numero_servicio_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'GC_NUMSER_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		jrivera	
 	#FECHA:		23-07-2014 23:47:15
	***********************************/

	if(p_transaccion='GC_NUMSER_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						numser.id_numero_servicio,
						numser.id_servicio,
						numser.id_numero_celular,
						numser.observaciones,
						numser.estado_reg,
						numser.fecha_fin,
						numser.fecha_inicio,
						numser.id_usuario_reg,
						numser.usuario_ai,
						numser.fecha_reg,
						numser.id_usuario_ai,
						numser.id_usuario_mod,
						numser.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						ser.nombre_servicio
						from gecom.tnumero_servicio numser
						inner join segu.tusuario usu1 on usu1.id_usuario = numser.id_usuario_reg
						inner join gecom.tservicio ser on ser.id_servicio = numser.id_servicio
						left join segu.tusuario usu2 on usu2.id_usuario = numser.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'GC_NUMSER_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		jrivera	
 	#FECHA:		23-07-2014 23:47:15
	***********************************/

	elsif(p_transaccion='GC_NUMSER_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_numero_servicio)
					    from gecom.tnumero_servicio numser
					    inner join segu.tusuario usu1 on usu1.id_usuario = numser.id_usuario_reg
					    inner join gecom.tservicio ser on ser.id_servicio = numser.id_servicio
						left join segu.tusuario usu2 on usu2.id_usuario = numser.id_usuario_mod
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
ALTER FUNCTION "gecom"."ft_numero_servicio_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
