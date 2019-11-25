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
	/*********************************    
 	#TRANSACCION:  'GC_COSREP_SEL'
 	#DESCRIPCION:	reporte de telecomunicaciones
 	#AUTOR:		ymedina	
 	#FECHA:		24-07-2014 19:17:04
	***********************************/

	elsif(p_transaccion='GC_COSREP_SEL')then

		begin
			--Sentencia de la consulta de conteo de registros
            
            v_consulta:='select ger.nombre_unidad as gerencia, dep.nombre_unidad as departamento, 
                                oo.nombre::varchar as oficina , ll.nombre::varchar as lugar, vp.nombre_completo1::varchar as usuario, 
                                cc.nombre::varchar as cargo, 
                                mm.*
                          from (select pro.rotulo_comercial, nc.id_numero_celular, nc.observaciones
                               ,ges.gestion
                               ,nc.numero
                               , COALESCE (SUM(c.consumo) FILTER (WHERE p.periodo =  1), 0) enero
                               , COALESCE (SUM(c.consumo) FILTER (WHERE p.periodo =  2), 0) febrero
                               , COALESCE (SUM(c.consumo) FILTER (WHERE p.periodo =  3), 0) marzo
                               , COALESCE (SUM(c.consumo) FILTER (WHERE p.periodo =  4), 0) abril
                               , COALESCE (SUM(c.consumo) FILTER (WHERE p.periodo =  5), 0) mayo
                               , COALESCE (SUM(c.consumo) FILTER (WHERE p.periodo =  6), 0) junio
                               , COALESCE (SUM(c.consumo) FILTER (WHERE p.periodo =  7), 0) julio
                               , COALESCE (SUM(c.consumo) FILTER (WHERE p.periodo =  8), 0) agosto
                               , COALESCE (SUM(c.consumo) FILTER (WHERE p.periodo =  9), 0) septiembre
                               , COALESCE (SUM(c.consumo) FILTER (WHERE p.periodo =  10), 0) octubre
                               , COALESCE (SUM(c.consumo) FILTER (WHERE p.periodo =  11), 0) noviembre
                               , COALESCE (SUM(c.consumo) FILTER (WHERE p.periodo =  12), 0) diciembre
                               , nc.tipo
                          from gecom.tnumero_celular nc
                               inner join param.vproveedor pro on nc.id_proveedor = pro.id_proveedor
                               inner join gecom.tconsumo c on nc.id_numero_celular = c.id_numero_celular
                               inner join param.tgestion ges on c.id_gestion = ges.id_gestion
                               inner join param.tperiodo p on c.id_periodo = p.id_periodo
                          where ';			

             
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||' ges.id_gestion = '||v_parametros.id_gestion||' and nc.tipo = '''||v_parametros.tipo_facturacion||'''';
			v_consulta:=v_consulta||' group by  pro.rotulo_comercial, ges.gestion, nc.numero, nc.id_numero_celular, nc.observaciones) as mm
                                      left join gecom.tfuncionario_celular fc on mm.id_numero_celular = fc.id_numero_celular and fc.estado_reg = ''activo'' 
                                      and fc.fecha_inicio = (select max(fc2.fecha_inicio) 
                                                             from gecom.tfuncionario_celular fc2
                                                             where fc2.id_numero_celular =  mm.id_numero_celular and fc2.estado_reg = ''activo'')
                                      left join orga.tuo_funcionario ul on (ul.id_funcionario = fc.id_funcionario or ul.id_cargo = fc.id_cargo) 
                                      and ul.estado_reg = ''activo'' and ul.tipo=''oficial'' and  (ul.fecha_finalizacion is null or ul.fecha_finalizacion >= now()::date)
                                      left join orga.tuo ger ON ger.id_uo = orga.f_get_uo_gerencia(ul.id_uo, NULL::integer, NULL::date)
                                      left join orga.tuo dep ON dep.id_uo = orga.f_get_uo_departamento(ul.id_uo, NULL::integer, NULL::date)
                                      left join orga.tcargo cc on ul.id_cargo = cc.id_cargo
                                      left join orga.toficina oo on cc.id_oficina = oo.id_oficina
                                      left join param.tlugar ll on oo.id_lugar = ll.id_lugar
                                      left join orga.tfuncionario fun on  ul.id_funcionario = fun.id_funcionario
                                      left join segu.vpersona vp on fun.id_persona = vp.id_persona
                                      order by  ger.nombre_unidad, dep.nombre_unidad, oo.nombre, mm.id_numero_celular';


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
