CREATE OR REPLACE FUNCTION gecom.ft_numero_celular_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Gestión de Comunicación
 FUNCION: 		gecom.ft_numero_celular_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.tnumero_celular'
 AUTOR: 		 (jrivera)
 FECHA:	        23-07-2014 22:43:16
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

	v_nombre_funcion = 'gecom.ft_numero_celular_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'GC_NUMCEL_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		jrivera	
 	#FECHA:		23-07-2014 22:43:16
	***********************************/

	if(p_transaccion='GC_NUMCEL_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						numcel.id_numero_celular,
						numcel.numero,
						numcel.observaciones,
						numcel.roaming,
						numcel.estado_reg,
						numcel.id_usuario_ai,
						numcel.id_usuario_reg,
						numcel.fecha_reg,
						numcel.usuario_ai,
						numcel.fecha_mod,
						numcel.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        pro.desc_proveedor,
                        numcel.tipo,
                        numcel.estado,
                        cp.id_cuenta,
                        cp.nro_cuenta::varchar as desc_nro_cuenta,
                        equ.id_equipo,
                        ((select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = equ.tipo and ct.tabla = ''tequipo'' and ct.nombre = ''tipo_equipo_movil'') ||'' ''|| equ.marca ||'' ''|| equ.modelo)::varchar  as nombre_equipo,
                        numcel.id_tipo_cc,
                        (tcc.descripcion || '' - '' || tcc.codigo)::varchar as desc_tipo_cc      
                        from gecom.tnumero_celular numcel
						inner join segu.tusuario usu1 on usu1.id_usuario = numcel.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = numcel.id_usuario_mod
                        left join gecom.tcuenta_proveedor cp on numcel.id_cuenta = cp.id_cuenta
                        left join param.vproveedor pro on pro.id_proveedor = cp.id_proveedor
                        left join gecom.tequipo_movil em on numcel.id_numero_celular = em.id_numero_celular and em.estado_reg = ''activo''
                        left join gecom.tequipo equ on em.id_equipo = equ.id_equipo
                        LEFT JOIN param.vtipo_cc  tcc ON numcel.id_tipo_cc = tcc.id_tipo_cc
                        left join gecom.tnumero_servicio ns on numcel.id_numero_celular = ns.id_numero_celular
						left join gecom.tservicio s on ns.id_servicio = s.id_servicio
				        where numcel.estado_reg = ''activo'' and ';
		
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' group by numcel.id_numero_celular, usu1.cuenta, usu2.cuenta, pro.desc_proveedor, cp.id_cuenta, equ.id_equipo, tcc.descripcion, tcc.codigo ';
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'GC_NUMCEL_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		jrivera	
 	#FECHA:		23-07-2014 22:43:16
	***********************************/

	elsif(p_transaccion='GC_NUMCEL_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(numcel.id_numero_celular)
            			from ( select numcel.*
					    from gecom.tnumero_celular numcel
						inner join segu.tusuario usu1 on usu1.id_usuario = numcel.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = numcel.id_usuario_mod
                        left join gecom.tcuenta_proveedor cp on numcel.id_cuenta = cp.id_cuenta
                        left join param.vproveedor pro on pro.id_proveedor = cp.id_proveedor
                        left join gecom.tequipo_movil em on numcel.id_numero_celular = em.id_numero_celular and em.estado_reg = ''activo''
                        left join gecom.tequipo equ on em.id_equipo = equ.id_equipo
                        LEFT JOIN param.vtipo_cc  tcc ON numcel.id_tipo_cc = tcc.id_tipo_cc
                        left join gecom.tnumero_servicio ns on numcel.id_numero_celular = ns.id_numero_celular
						left join gecom.tservicio s on ns.id_servicio = s.id_servicio
				        where numcel.estado_reg = ''activo'' and '||v_parametros.filtro;
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||' 
            group by numcel.id_numero_celular
            ) as numcel ';

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
