CREATE OR REPLACE FUNCTION gecom.ft_funcionario_celular_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
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
	v_id_uo				INTEGER;		    
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
    		
    		end if;
    		
    		--Sentencia de la consulta
			v_consulta:='select funcel.* from ( select
						funcel.id_funcionario,
      					funcel.id_cargo,
                        fun.desc_funcionario1,
                        cargo.nombre as nombre_cargo  
						from gecom.tfuncionario_celular funcel
						left join gecom.tnumero_celular numcel on numcel.id_numero_celular = funcel.id_numero_celular
						left join orga.vfuncionario fun on fun.id_funcionario = funcel.id_funcionario
						left join orga.tcargo cargo on cargo.id_cargo = funcel.id_cargo
						left join gecom.tequipo equ on funcel.id_equipo = equ.id_equipo
						inner join segu.tusuario usu1 on usu1.id_usuario = funcel.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = funcel.id_usuario_mod
                        where  funcel.estado_reg = ''activo''
                        group by funcel.id_funcionario, funcel.id_cargo, fun.desc_funcionario1, nombre_cargo 
                        ) funcel
				        where 0 = 0';
			
			--Definicion de la respuesta
			--v_consulta:=v_consulta||v_parametros.filtro;
			--v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

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
			v_consulta:='select count(funcel.*) from ( select
						funcel.id_funcionario,
      					funcel.id_cargo       
						from gecom.tfuncionario_celular funcel
						left join gecom.tnumero_celular numcel on numcel.id_numero_celular = funcel.id_numero_celular
						left join orga.vfuncionario fun on fun.id_funcionario = funcel.id_funcionario
						left join orga.tcargo cargo on cargo.id_cargo = funcel.id_cargo
						left join gecom.tequipo equ on funcel.id_equipo = equ.id_equipo
						inner join segu.tusuario usu1 on usu1.id_usuario = funcel.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = funcel.id_usuario_mod
                        where  funcel.estado_reg = ''activo''
                        group by funcel.id_funcionario, funcel.id_cargo
                        ) funcel
				        where 0= 0 ';
			
			--Definicion de la respuesta		    
			--v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
        
    /*********************************    
 	#TRANSACCION:  'GC_FUNEQU_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		jrivera	
 	#FECHA:		24-07-2014 00:10:05
	***********************************/

	elsif(p_transaccion='GC_FUNEQU_SEL')then
     				
    	begin
    		
    		--Sentencia de la consulta
			v_consulta:=' select funcel.id_funcionario_celular,
                          funcel.id_funcionario,
                          funcel.id_cargo,
                          funcel.estado_reg,
                          funcel.id_equipo,
                          funcel.tipo_asignacion_equipo,
                          funcel.id_numero_celular,
                          nc.numero,
                          (( select c.descripcion
                               from param.tcatalogo c
                               LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                              WHERE c.codigo = e.tipo
                                and ct.tabla = ''tequipo''
                                and (CASE
                                        when e.tipo = ''movil'' then
                                         ct.nombre = ''tipo_equipo_movil''
                                        ELSE
                                         ct.nombre = ''tipo_equipo''
                                     END)) || '' '' || e.marca || '' '' || e.modelo || '' - '' || e.num_serie)::varchar as nombre,
                          funcel.codigo_inmovilizado,
                          funcel.fecha_inicio,
                          funcel.fecha_fin,
                          funcel.tipo_asignacion,
                          funcel.observaciones,
                          funcel.id_usuario_reg,
                          funcel.fecha_reg,
                          funcel.id_usuario_mod,
                          funcel.fecha_mod,
                          usu1.cuenta as usr_reg,
                          usu2.cuenta as usr_mod,
                          funcel.tipo_servicio,
                          (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = funcel.tipo_servicio and ct.tabla = ''tservicio'' and ct.nombre = ''tipo_servicio'') AS tipo_servicio_desc
                      from gecom.tfuncionario_celular funcel
                      JOIN segu.tusuario usu1 ON usu1.id_usuario = funcel.id_usuario_reg
                      LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = funcel.id_usuario_mod
                      LEFT JOIN gecom.tnumero_celular nc on funcel.id_numero_celular = nc.id_numero_celular
                      LEFT JOIN gecom.tequipo e on funcel.id_equipo = e.id_equipo 
                      where ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'GC_FUNEQU_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		jrivera	
 	#FECHA:		24-07-2014 00:10:05
	***********************************/

	elsif(p_transaccion='GC_FUNEQU_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(*)   
                        from gecom.tfuncionario_celular funcel
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = funcel.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = funcel.id_usuario_mod
                        LEFT JOIN gecom.tnumero_celular nc on funcel.id_numero_celular = nc.id_numero_celular
                        LEFT JOIN gecom.tequipo e on funcel.id_equipo = e.id_equipo 
                        WHERE ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
        
    /*********************************
         #TRANSACCION:  'GC_FUNUNI_SEL'
         #DESCRIPCION:    Consulta de datos
         #AUTOR:        ymedina
         #FECHA:        14-07-2020 20:40:32
        ***********************************/

    ELSIF (p_transaccion='GC_FUNUNI_SEL') THEN

        BEGIN
            --Sentencia de la consulta
            v_consulta:='select uo.id_uo,
                                uo.nombre_unidad,
                                uo.codigo
                         from orga.tuo uo
                         where uo.estado_reg = ''activo'' and
                               uo.id_nivel_organizacional <= 4 ';


            --Devuelve la respuesta
            RETURN v_consulta;

        END;
        
    /*******************************
     #TRANSACCION:  GC_FUNUO_SEL
     #DESCRIPCION:	Listado de funcionarios
     #AUTOR:
     #FECHA:		23/05/11
    ***********************************/
    ELSIF(p_transaccion='GC_FUNUO_SEL')then

      BEGIN

      	if (pxp.f_existe_parametro(p_tabla,'id_uo')) then
			v_id_uo := v_parametros.id_uo;
        else
        	v_id_uo := -1;
		end if;

        v_consulta:='select FUNCIO.id_funcionario,
        FUNCIO.codigo,
        FUNCIO.estado_reg,
        FUNCIO.fecha_reg,
        FUNCIO.id_persona,
        FUNCIO.id_usuario_reg,
        FUNCIO.fecha_mod,
        FUNCIO.id_usuario_mod,
        FUNCIO.email_empresa,
        FUNCIO.interno,
        FUNCIO.fecha_ingreso,
        PERSON.nombre_completo2 AS desc_person,
        usu1.cuenta as usr_reg,
        usu2.cuenta as usr_mod,
        PERSON.ci,
        PERSON.num_documento,
        PERSON.telefono1,
        PERSON.celular1,
        PERSON.correo,
        FUNCIO.telefono_ofi,
        FUNCIO.antiguedad_anterior,
        PERSON2.estado_civil,
        PERSON2.genero,
        PERSON2.fecha_nacimiento,
        PERSON2.id_lugar,
        LUG.nombre as nombre_lugar,
        PERSON2.nacionalidad,
        PERSON2.discapacitado,
        PERSON2.carnet_discapacitado,
        FUNCIO.id_auxiliar,
        aux.nombre_auxiliar as desc_auxiliar,
        cat.descripcion as profesion,
        FUNCIO.codigo_rciva,
        FUNCIO.fecha_quinquenio,
        PERSON2.foto,
        PERSON2.nombre_archivo_foto,
        fc.descripcion_cargo,
        tuofun.id_uo ';

        if v_id_uo != -1 then

        	v_consulta := v_consulta || '
            	 from (
          select * from (
           with recursive arbol_funcionario as (
              select euo.id_uo_hijo, euo.id_uo_padre, euo.id_usuario_reg, euo.id_usuario_mod
              from orga.testructura_uo euo
              where euo.id_uo_padre = '|| v_id_uo || '  UNION
              select huo.id_uo_hijo, huo.id_uo_padre, huo.id_usuario_reg, huo.id_usuario_mod
              from orga.testructura_uo huo
              inner join arbol_funcionario ar on ar.id_uo_padre = huo.id_uo_padre or ar.id_uo_hijo = huo.id_uo_padre
           )
           select af.*
           from  arbol_funcionario af
          UNION
           select euo.id_uo_hijo,
                  euo.id_uo_padre,
                  euo.id_usuario_reg,
                  euo.id_usuario_mod
           from orga.testructura_uo euo
           where euo.id_uo_hijo = '||v_id_uo||') as uos
           left join  orga.tuo uo on uos.id_uo_hijo = uo.id_uo
           where uo.estado_reg=''activo'' ) as tuos
           LEFT join (SELECT id_uo, id_funcionario
                    FROM orga.tuo_funcionario
                    where estado_reg !=''inactivo''
                    GROUP BY id_funcionario,id_uo  )UOFUNC ON tuos.id_uo_hijo=UOFUNC.id_uo
           left join orga.tfuncionario FUNCIO ON FUNCIO.id_funcionario=UOFUNC.id_funcionario
                      ';
                  else
                      v_consulta := v_consulta || ' from  orga.tfuncionario FUNCIO ';
                  end if;

          v_consulta := v_consulta || '
            INNER JOIN SEGU.vpersona PERSON ON PERSON.id_persona = FUNCIO.id_persona
            INNER JOIN SEGU.tpersona PERSON2 ON PERSON2.id_persona = FUNCIO.id_persona
            inner join segu.tusuario usu1 on usu1.id_usuario = FUNCIO.id_usuario_reg
            LEFT JOIN conta.tauxiliar aux on aux.id_auxiliar = FUNCIO.id_auxiliar
            LEFT JOIN param.tlugar LUG on LUG.id_lugar = PERSON2.id_lugar
                left join segu.tusuario usu2 on usu2.id_usuario = FUNCIO.id_usuario_mod
                left join param.tcatalogo cat on cat.codigo = funcio.profesion
            left join orga.vfuncionario_cargo fc on FUNCIO.id_funcionario = fc.id_funcionario
            join orga.tuo_funcionario tuofun on FUNCIO.id_funcionario = tuofun.id_funcionario    
           WHERE  ';

       v_consulta := v_consulta || v_parametros.filtro;
       
       if v_parametros.id_tipo_empleados = 1 then
         v_consulta := v_consulta || 'and now()::date between tuofun.fecha_asignacion and COALESCE(tuofun.fecha_finalizacion, (now()::date + interval ''1 year'')::date)';
       end if;
       
       v_consulta := v_consulta || '  group by funcio.id_funcionario, PERSON.id_persona, person.nombre_completo2, person.nombre_completo1, usu1.id_usuario, usu2.id_usuario, person.ci,
                                      PERSON.num_documento, PERSON.telefono1, PERSON.celular1, PERSON.correo, PERSON2.estado_civil, PERSON2.genero,
                                      PERSON2.fecha_nacimiento, PERSON2.id_lugar, LUG.nombre, PERSON2.nacionalidad, PERSON2.discapacitado, PERSON2.carnet_discapacitado,
                                      aux.nombre_auxiliar, cat.descripcion, PERSON2.foto, PERSON2.nombre_archivo_foto, fc.descripcion_cargo, tuofun.id_uo ';

       v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' OFFSET ' || v_parametros.puntero;

        raise notice '%',v_consulta;
        return v_consulta;


      END;

    /*******************************
     #TRANSACCION:  GC_FUNUO_CONT
     #DESCRIPCION:	Conteo de funcionarios
     #AUTOR:
     #FECHA:		23/05/11
    ***********************************/
    ELSIF(p_transaccion='GC_FUNUO_CONT')then

      BEGIN

      	if (pxp.f_existe_parametro(p_tabla,'id_uo')) then
			v_id_uo := v_parametros.id_uo;
        else
        	v_id_uo := -1;
		end if;

        v_consulta:='select count(funcionarios.*) from ( 
        			 select funcio.id_funcionario';

        if v_id_uo != -1 then
        v_consulta := v_consulta || '
            	 from (
        select * from (
         with recursive arbol_funcionario as (
            select euo.id_uo_hijo, euo.id_uo_padre, euo.id_usuario_reg, euo.id_usuario_mod
            from orga.testructura_uo euo
            where euo.id_uo_padre = '|| v_id_uo || '  UNION
            select huo.id_uo_hijo, huo.id_uo_padre, huo.id_usuario_reg, huo.id_usuario_mod
            from orga.testructura_uo huo
            inner join arbol_funcionario ar on ar.id_uo_padre = huo.id_uo_padre or ar.id_uo_hijo = huo.id_uo_padre
         )
         select af.*
         from  arbol_funcionario af
        UNION
         select euo.id_uo_hijo,
                euo.id_uo_padre,
                euo.id_usuario_reg,
                euo.id_usuario_mod
         from orga.testructura_uo euo
         where euo.id_uo_hijo = '||v_id_uo||') as uos
         left join  orga.tuo uo on uos.id_uo_hijo = uo.id_uo
         where uo.estado_reg=''activo'' ) as tuos
         LEFT join (SELECT id_uo, id_funcionario
                  FROM orga.tuo_funcionario
                  where estado_reg !=''inactivo''
                  GROUP BY id_funcionario,id_uo  )UOFUNC ON tuos.id_uo_hijo=UOFUNC.id_uo
         left join orga.tfuncionario FUNCIO ON FUNCIO.id_funcionario=UOFUNC.id_funcionario
                    ';
                else
                    v_consulta := v_consulta || ' from  orga.tfuncionario FUNCIO ';
                end if;


          v_consulta := v_consulta || '
          INNER JOIN SEGU.vpersona PERSON ON PERSON.id_persona = FUNCIO.id_persona
          INNER JOIN SEGU.tpersona PERSON2 ON PERSON2.id_persona = FUNCIO.id_persona
          inner join segu.tusuario usu1 on usu1.id_usuario = FUNCIO.id_usuario_reg
          LEFT JOIN conta.tauxiliar aux on aux.id_auxiliar = FUNCIO.id_auxiliar
          LEFT JOIN param.tlugar LUG on LUG.id_lugar = PERSON2.id_lugar
              left join segu.tusuario usu2 on usu2.id_usuario = FUNCIO.id_usuario_mod
              left join param.tcatalogo cat on cat.codigo = funcio.profesion
          left join orga.vfuncionario_cargo fc on FUNCIO.id_funcionario = fc.id_funcionario    
          join orga.tuo_funcionario tuofun on FUNCIO.id_funcionario = tuofun.id_funcionario    
         WHERE FUNCIO.estado_reg = ''activo'' ';
         
         if v_parametros.id_tipo_empleados = 1 then
           v_consulta := v_consulta || 'and now()::date between tuofun.fecha_asignacion and COALESCE(tuofun.fecha_finalizacion, (now()::date + interval ''1 year'')::date)';
         end if;
         
         v_consulta := v_consulta || ' group by funcio.id_funcionario ) as funcionarios ';
         

        return v_consulta;
      END;
    
					
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
