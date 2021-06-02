CREATE OR REPLACE FUNCTION gecom.ft_servicio_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Gestión de Comunicación
 FUNCION: 		gecom.ft_servicio_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.tservicio'
 AUTOR: 		 (jrivera)
 FECHA:	        23-07-2014 22:43:19
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

	v_nombre_funcion = 'gecom.ft_servicio_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'GC_SER_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		jrivera	
 	#FECHA:		23-07-2014 22:43:19
	***********************************/

	if(p_transaccion='GC_SER_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						ser.id_servicio,
						ser.id_proveedor,
						ser.trafico_adicional,
						ser.tarifa,
						ser.estado_reg,
						ser.nombre_servicio,
						ser.observaciones,
						ser.codigo_servicio,
						ser.trafico_libre,
						ser.fecha_reg,
						ser.usuario_ai,
						ser.id_usuario_reg,
						ser.id_usuario_ai,
						ser.id_usuario_mod,
						ser.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        pro.desc_proveedor,
                        ser.defecto,
                        ser.tipo_servicio,
                        (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = ser.tipo_servicio and ct.tabla = ''tservicio'' and ct.nombre = ''tipo_servicio'') AS tipo_servicio_desc,
                        (ser.nombre_servicio || '' - '' || ser.tarifa)::varchar as nombre_combo
						from gecom.tservicio ser
						inner join segu.tusuario usu1 on usu1.id_usuario = ser.id_usuario_reg
                        left join param.vproveedor pro on pro.id_proveedor = ser.id_proveedor
						left join segu.tusuario usu2 on usu2.id_usuario = ser.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'GC_SER_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		jrivera	
 	#FECHA:		23-07-2014 22:43:19
	***********************************/

	elsif(p_transaccion='GC_SER_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_servicio)
            			from (select ser.*,
                               (ser.nombre_servicio || '' - '' || ser.tarifa)::varchar as nombre_combo
					    from gecom.tservicio ser
					    inner join segu.tusuario usu1 on usu1.id_usuario = ser.id_usuario_reg
                        inner join param.vproveedor pro on pro.id_proveedor = ser.id_proveedor
						left join segu.tusuario usu2 on usu2.id_usuario = ser.id_usuario_mod) as ser
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
PARALLEL UNSAFE
COST 100;
