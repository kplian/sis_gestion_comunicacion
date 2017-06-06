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
    v_oficina			varchar;
    v_gerencia 			varchar;

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
						numcel.id_proveedor,
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
                        numcel.tipo
						from gecom.tnumero_celular numcel
						inner join segu.tusuario usu1 on usu1.id_usuario = numcel.id_usuario_reg
                        inner join param.vproveedor pro on pro.id_proveedor = numcel.id_proveedor
						left join segu.tusuario usu2 on usu2.id_usuario = numcel.id_usuario_mod
				        where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
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
			v_consulta:='select count(id_numero_celular)
					    from gecom.tnumero_celular numcel
					    inner join segu.tusuario usu1 on usu1.id_usuario = numcel.id_usuario_reg
                        inner join param.vproveedor pro on pro.id_proveedor = numcel.id_proveedor
						left join segu.tusuario usu2 on usu2.id_usuario = numcel.id_usuario_mod
					    where ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
    /*********************************
 	#TRANSACCION:  'GC_REPOR_SEL'
 	#DESCRIPCION:	Reporte de directorio telefonico
 	#AUTOR:		Miguel Alejandro Mamani Villegas
 	#FECHA:		02-06-2017
	***********************************/

	elsif(p_transaccion='GC_REPOR_SEL')then
    	begin
        if v_parametros.oficina !='Todos'then
        	if  v_parametros.uo != 'Todos'then
        		v_oficina = 'f.oficina_nombre::text =ANY(string_to_array('''||v_parametros.oficina::text||''','','')) and ger.nombre_unidad ='''||v_parametros.uo||''' and ';
        		else
                v_oficina = 'f.oficina_nombre::text =ANY(string_to_array('''||v_parametros.oficina::text||''','','')) and ';
        	end if;
      	else
        	v_oficina = '';
        end if;

          v_consulta:='SELECT distinct 	  cel.id_funcionario as  id_fun,
                                          f.desc_funcionario1 as nombre_funcionario,
                                          f.nombre_cargo as nombre_cargo_funcionario,
                                          upper(f.oficina_nombre)|| COALESCE('' - NÚMERO PILOTO ''||of.telefono,''  '')::varchar as oficina_nombre,
                                          ger.nombre_unidad as gerencia,
                                          dep.nombre_unidad as departamento,
                                          COALESCE(gecom.f_numero_celular_tipo(cel.id_funcionario,''celular''::varchar),'' - '')as celular,
                                          COALESCE(gecom.f_numero_celular_tipo(cel.id_funcionario,''fijo''::varchar),'' - '')as fijo,
                                          COALESCE(gecom.f_numero_celular_tipo(cel.id_funcionario,''interno''::varchar),'' - '')as interno
                                          FROM gecom.tfuncionario_celular cel
                                          inner join orga.vfuncionario_cargo_lugar f on f.id_funcionario = cel.id_funcionario and cel.fecha_fin is null and cel.estado_reg = ''activo''
                                          inner  join orga.tuo ou on ou.id_uo = f.id_uo and ou.estado_reg =''activo''
                                          inner join orga.toficina of on of.id_oficina = f.id_oficina
                                          JOIN orga.tuo ger ON ger.id_uo = orga.f_get_uo_gerencia(ou.id_uo, NULL::integer, NULL::date)
                                          JOIN orga.tuo dep ON dep.id_uo = orga.f_get_uo_departamento(ou.id_uo, NULL::integer, NULL::date)
                                          where '||v_oficina||' ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||'ORDER BY oficina_nombre, gerencia,departamento ,nombre_funcionario';


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