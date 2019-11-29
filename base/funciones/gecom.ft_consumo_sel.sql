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
            
            v_consulta:='SELECT     ger.nombre_unidad                 AS gerencia, 
                                    dep.nombre_unidad                 AS departamento, 
                                    oo.nombre::varchar                AS oficina , 
                                    ll.nombre::varchar                AS lugar, 
                                    vp.nombre_completo1::varchar      AS usuario, 
                                    cc.nombre::varchar                AS cargo, 
                                    mm.*,
                                    ser.nombre_servicio, 
                                    COALESCE (SUM(ser.tarifa) filter (WHERE (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''01''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin >= to_date(mm.gestion||''01'',''YYYYMM''))
                                                                         OR (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''01''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin IS NULL
                                                                         AND ((''01'' <= to_char(NOW(), ''MM'')) OR (mm.gestion != to_char(now(), ''YYYY'')::integer)))
                                                                         ),0) AS ser_ene,
                                    COALESCE (SUM(ser.tarifa) filter (WHERE (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''02''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin >= to_date(mm.gestion||''02'',''YYYYMM''))
                                                                         OR (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''02''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin IS NULL
                                                                         AND ((''02'' <= to_char(NOW(), ''MM'')) OR (mm.gestion != to_char(now(), ''YYYY'')::integer)))
                                                                         ),0) AS ser_feb,
                                    COALESCE (SUM(ser.tarifa) filter (WHERE (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''03''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin >= to_date(mm.gestion||''03'',''YYYYMM''))
                                                                         OR (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''03''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin IS NULL
                                                                         AND ((''03'' <= to_char(NOW(), ''MM'')) OR (mm.gestion != to_char(now(), ''YYYY'')::integer)))
                                                                         ),0) AS ser_mar,                                               
                                    COALESCE (SUM(ser.tarifa) filter (WHERE (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''04''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin >= to_date(mm.gestion||''04'',''YYYYMM''))
                                                                         OR (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''04''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin IS NULL
                                                                         AND ((''04'' <= to_char(NOW(), ''MM'')) OR (mm.gestion != to_char(now(), ''YYYY'')::integer)))
                                                                         ),0) AS ser_abr,                                                 
                                    COALESCE (SUM(ser.tarifa) filter (WHERE (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''05''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin >= to_date(mm.gestion||''05'',''YYYYMM''))
                                                                         OR (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''05''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin IS NULL
                                                                         AND ((''05'' <= to_char(NOW(), ''MM'')) OR (mm.gestion != to_char(now(), ''YYYY'')::integer)))
                                                                         ),0) AS ser_may,       
                                    COALESCE (SUM(ser.tarifa) filter (WHERE (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''06''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin >= to_date(mm.gestion||''06'',''YYYYMM''))
                                                                         OR (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''06''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin IS NULL
                                                                         AND ((''06'' <= to_char(NOW(), ''MM'')) OR (mm.gestion != to_char(now(), ''YYYY'')::integer)))
                                                                         ),0) AS ser_jun, 
                                    COALESCE (SUM(ser.tarifa) filter (WHERE (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''07''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin >= to_date(mm.gestion||''07'',''YYYYMM''))
                                                                         OR (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''07''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin IS NULL
                                                                         AND ((''07'' <= to_char(NOW(), ''MM'')) OR (mm.gestion != to_char(now(), ''YYYY'')::integer)))
                                                                         ),0) AS ser_jul,                                                                                                                                     
                                    COALESCE (SUM(ser.tarifa) filter (WHERE (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''08''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin >= to_date(mm.gestion||''08'',''YYYYMM''))
                                                                         OR (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''08''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin IS NULL
                                                                         AND ((''08'' <= to_char(NOW(), ''MM'')) OR (mm.gestion != to_char(now(), ''YYYY'')::integer)))
                                                                         ),0) AS ser_ago,                                               
                                    COALESCE (SUM(ser.tarifa) filter (WHERE (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''09''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin >= to_date(mm.gestion||''09'',''YYYYMM''))
                                                                         OR (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''09''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin IS NULL
                                                                         AND ((''09'' <= to_char(NOW(), ''MM'')) OR (mm.gestion != to_char(now(), ''YYYY'')::integer)))
                                                                         ),0) AS ser_sep,            
                                    COALESCE (SUM(ser.tarifa) filter (WHERE (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''10''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin >= to_date(mm.gestion||''10'',''YYYYMM''))
                                                                         OR (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''10''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin IS NULL
                                                                         AND ((''10'' <= to_char(NOW(), ''MM'')) OR (mm.gestion != to_char(now(), ''YYYY'')::integer)))
                                                                         ),0) AS ser_oct,            
                                    COALESCE (SUM(ser.tarifa) filter (WHERE (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''11''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin >= to_date(mm.gestion||''11'',''YYYYMM''))
                                                                         OR (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''11''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin IS NULL
                                                                         AND ((''11'' <= to_char(NOW(), ''MM'')) OR (mm.gestion != to_char(now(), ''YYYY'')::integer)))
                                                                         ),0) AS ser_nov,  
                                    COALESCE (SUM(ser.tarifa) filter (WHERE (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''12''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin >= to_date(mm.gestion||''12'',''YYYYMM''))
                                                                         OR (nss.fecha_inicio <= (date_trunc(''MONTH'', (mm.gestion||''12''||''01'')::date) + INTERVAL ''1 MONTH - 1 day'')::DATE AND nss.fecha_fin IS NULL
                                                                         AND ((''12'' <= to_char(NOW(), ''MM'')) OR (mm.gestion != to_char(now(), ''YYYY'')::integer)))
                                                                         ),0) AS ser_dic,
                                    nss.id_numero_servicio                                                                                           
                          FROM      ( 
                                       SELECT     pro.rotulo_comercial, 
                                                  nc.id_numero_celular, 
                                                  nc.observaciones , 
                                                  ges.gestion, 
                                                  nc.numero , 
                                                  COALESCE (SUM(c.consumo) filter (WHERE p.periodo = 1), 0)  enero ,
                                                  COALESCE (SUM(c.consumo) filter (WHERE p.periodo = 2), 0)  febrero ,
                                                  COALESCE (SUM(c.consumo) filter (WHERE p.periodo = 3), 0)  marzo ,
                                                  COALESCE (SUM(c.consumo) filter (WHERE p.periodo = 4), 0)  abril ,
                                                  COALESCE (SUM(c.consumo) filter (WHERE p.periodo = 5), 0)  mayo ,
                                                  COALESCE (SUM(c.consumo) filter (WHERE p.periodo = 6), 0)  junio ,
                                                  COALESCE (SUM(c.consumo) filter (WHERE p.periodo = 7), 0)  julio ,
                                                  COALESCE (SUM(c.consumo) filter (WHERE p.periodo = 8), 0)  agosto ,
                                                  COALESCE (SUM(c.consumo) filter (WHERE p.periodo = 9), 0)  septiembre ,
                                                  COALESCE (SUM(c.consumo) filter (WHERE p.periodo = 10), 0) octubre ,
                                                  COALESCE (SUM(c.consumo) filter (WHERE p.periodo = 11), 0) noviembre ,
                                                  COALESCE (SUM(c.consumo) filter (WHERE p.periodo = 12), 0) diciembre ,
                                                  nc.tipo,
                                                  nc.roaming 
                                       FROM       gecom.tnumero_celular nc 
                                          INNER JOIN param.vproveedor pro ON nc.id_proveedor = pro.id_proveedor 
                                          INNER JOIN gecom.tconsumo c ON nc.id_numero_celular = c.id_numero_celular 
                                          INNER JOIN param.tgestion ges ON c.id_gestion = ges.id_gestion 
                                          INNER JOIN param.tperiodo p ON c.id_periodo = p.id_periodo 
                                       WHERE ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||' ges.id_gestion = '||v_parametros.id_gestion;
            if(v_parametros.tipo_facturacion != 'todos')then
            	v_consulta:=v_consulta||' and nc.tipo = '''||v_parametros.tipo_facturacion||'''';
            end if;
			v_consulta:=v_consulta||' GROUP BY   pro.rotulo_comercial, ges.gestion, nc.id_numero_celular) AS mm 
                                      LEFT JOIN gecom.tfuncionario_celular fc ON mm.id_numero_celular = fc.id_numero_celular AND fc.estado_reg = ''activo'' 
                                          AND fc.fecha_inicio = (  SELECT max(fc2.fecha_inicio) 
                                                                   FROM   gecom.tfuncionario_celular fc2 
                                                                   WHERE  fc2.id_numero_celular = mm.id_numero_celular 
                                                                   AND    fc2.estado_reg = ''activo'') 
                                          AND fc.fecha_reg =   (  SELECT max(fc3.fecha_reg) 
                                                                   FROM   gecom.tfuncionario_celular fc3 
                                                                   WHERE  fc3.id_numero_celular = mm.id_numero_celular 
                                                                   AND    fc3.estado_reg = ''activo'')
                                      LEFT JOIN orga.tuo_funcionario ul ON (ul.id_funcionario = fc.id_funcionario OR ul.id_cargo = fc.id_cargo) 
                                          AND ul.estado_reg = ''activo'' AND ul.tipo=''oficial'' 
                                          AND ( ul.fecha_finalizacion IS NULL OR ul.fecha_finalizacion >= now()::date) 
                                      LEFT JOIN orga.tuo ger ON ger.id_uo = orga.f_get_uo_gerencia(ul.id_uo, NULL::integer, NULL::date) 
                                      LEFT JOIN orga.tuo dep ON dep.id_uo = orga.f_get_uo_departamento(ul.id_uo, NULL::integer, NULL::date) 
                                      LEFT JOIN orga.tcargo cc ON ul.id_cargo = cc.id_cargo 
                                      LEFT JOIN orga.toficina oo ON cc.id_oficina = oo.id_oficina 
                                      LEFT JOIN param.tlugar ll ON oo.id_lugar = ll.id_lugar 
                                      LEFT JOIN orga.tfuncionario fun ON ul.id_funcionario = fun.id_funcionario 
                                      LEFT JOIN segu.vpersona vp ON fun.id_persona = vp.id_persona 
                                      LEFT JOIN gecom.tnumero_servicio nss ON mm.id_numero_celular = nss.id_numero_celular
                                      LEFT JOIN gecom.tservicio ser ON nss.id_servicio = ser.id_servicio 
                                      GROUP BY  nss.id_numero_servicio, ser.id_servicio, ger.nombre_unidad, dep.nombre_unidad, 
                                                oo.nombre, ll.nombre, vp.nombre_completo1, cc.nombre, 
                                                mm.rotulo_comercial, mm.id_numero_celular, mm.observaciones, mm.gestion, mm.numero, 
                                                mm.enero , mm.febrero , mm.marzo , mm.abril , mm.mayo , mm.junio , mm.julio , 
                                                mm.agosto , mm.septiembre , mm.octubre , mm.noviembre , mm.diciembre , 
                                                mm.tipo, mm.roaming
                                      ORDER BY  mm.tipo, ger.nombre_unidad, dep.nombre_unidad, oo.nombre, mm.id_numero_celular';

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
