CREATE OR REPLACE FUNCTION "gecom"."ft_funcionario_celular_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Gestión de Comunicación
 FUNCION: 		gecom.ft_funcionario_celular_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.tfuncionario_celular'
 AUTOR: 		 (jrivera)
 FECHA:	        24-07-2014 00:10:05
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
	v_filtro_historico	varchar;
			    
BEGIN

	v_nombre_funcion = 'gecom.ft_funcionario_celular_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'GC_FUNCEL_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		jrivera	
 	#FECHA:		24-07-2014 00:10:05
	***********************************/

	if(p_transaccion='GC_FUNCEL_SEL')then
     				
    	begin
    	
    		if (v_parametros.historico = 'no') then
    			v_filtro_historico = ' (funcel.fecha_fin is null or funcel.fecha_fin >= ''' || now()::date  || ''') and ';
    		else
    			v_filtro_historico = ' 0 = 0 and ';
    		
    		end if;
    		
    		--Sentencia de la consulta
			v_consulta:='select
						funcel.id_funcionario_celular,
						funcel.id_numero_celular,
						funcel.id_funcionario,
						funcel.id_cargo,
						funcel.fecha_inicio,
						funcel.estado_reg,
						funcel.fecha_fin,
						funcel.observaciones,
						funcel.id_usuario_ai,
						funcel.id_usuario_reg,
						funcel.fecha_reg,
						funcel.usuario_ai,
						funcel.id_usuario_mod,
						funcel.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						cargo.nombre as nombre_cargo,
						fun.desc_funcionario1,
						numcel.numero	
						from gecom.tfuncionario_celular funcel
						inner join gecom.tnumero_celular numcel on numcel.id_numero_celular = funcel.id_numero_celular
						left join orga.vfuncionario fun on fun.id_funcionario = funcel.id_funcionario
						left join orga.tcargo cargo on cargo.id_cargo = funcel.id_cargo
						
						inner join segu.tusuario usu1 on usu1.id_usuario = funcel.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = funcel.id_usuario_mod
				        where  funcel.estado_reg = ''activo'' and ' || v_filtro_historico;
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'GC_FUNCEL_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		jrivera	
 	#FECHA:		24-07-2014 00:10:05
	***********************************/

	elsif(p_transaccion='GC_FUNCEL_CONT')then

		begin
			if (v_parametros.historico = 'no') then
    			v_filtro_historico = ' (funcel.fecha_fin is null or funcel.fecha_fin >= ''' || now()::date  || ''') and ';
    		else
    			v_filtro_historico = ' 0 = 0 and ';
    		
    		end if;
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_funcionario_celular)
					    from gecom.tfuncionario_celular funcel
					    inner join gecom.tnumero_celular numcel on numcel.id_numero_celular = funcel.id_numero_celular
						left join orga.vfuncionario fun on fun.id_funcionario = funcel.id_funcionario
						left join orga.tcargo cargo on cargo.id_cargo = funcel.id_cargo
					    inner join segu.tusuario usu1 on usu1.id_usuario = funcel.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = funcel.id_usuario_mod
					    where funcel.estado_reg = ''activo'' and ' || v_filtro_historico;
			
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
ALTER FUNCTION "gecom"."ft_funcionario_celular_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
