CREATE OR REPLACE FUNCTION gecom.ft_accesorio_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestión de Comunicación
 FUNCION:         gecom.ft_accesorio_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.taccesorio'
 AUTOR:          (ymedina)
 FECHA:            29-05-2021 16:19:41
 COMENTARIOS:    
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                29-05-2021 16:19:41    ymedina             Creacion    
 #
 ***************************************************************************/

DECLARE

    v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;
                
BEGIN

    v_nombre_funcion = 'gecom.ft_accesorio_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'GC_ACC_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        ymedina    
     #FECHA:        29-05-2021 16:19:41
    ***********************************/

    IF (p_transaccion='GC_ACC_SEL') THEN
                     
        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        acc.id_accesorio,
                        acc.id_equipo,
                        acc.estado_reg,
                        acc.nombre,
                        acc.marca,
                        acc.num_serie,
                        acc.estado_fisico,
                        acc.observaciones,
                        acc.id_usuario_reg,
                        acc.fecha_reg,
                        acc.id_usuario_ai,
                        acc.usuario_ai,
                        acc.id_usuario_mod,
                        acc.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        acc.tipo,
                        acc.modelo,
                        acc.resumen,
                        case when acc.tipo in (''cargador_movil'',''cable_datos'',''manos_libres'',''otro_movil'') then
                        	(select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = acc.tipo and ct.tabla = ''taccesorio'' and ct.nombre = ''accesorio_telefono'')
                        else
                        	(select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = acc.tipo and ct.tabla = ''taccesorio'' and ct.nombre = ''accesorio_equipo'')
                        end ::varchar AS tipo_desc,
                        (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = acc.marca and ct.tabla = ''tequipo'' and ct.nombre = ''marca'')::varchar AS marca_desc,
                        (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = acc.estado_fisico and ct.tabla = ''tequipo'' and ct.nombre = ''estado_fisico'')::varchar AS estado_fisico_desc,
                        acc.codigo_inmovilizado,
                        acc.tamano         
                        FROM 
                        (select acc.*,
                        		(acc.nombre||'' ''||acc.marca||'' ''||acc.modelo||'' - ''||acc.num_serie)::varchar as resumen
                         from gecom.taccesorio acc) as acc
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = acc.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = acc.id_usuario_mod
                        WHERE  ';
            
            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;
                        
        END;

    /*********************************    
     #TRANSACCION:  'GC_ACC_CONT'
     #DESCRIPCION:    Conteo de registros
     #AUTOR:        ymedina    
     #FECHA:        29-05-2021 16:19:41
    ***********************************/

    ELSIF (p_transaccion='GC_ACC_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(acc.id_accesorio) FROM 
            			 (SELECT acc.*,
                         		 (acc.nombre||'' ''||acc.marca||'' ''||acc.modelo||'' - ''||acc.num_serie)::varchar as resumen
                         FROM gecom.taccesorio acc) as acc
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = acc.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = acc.id_usuario_mod
                         WHERE ';
            
            --Definicion de la respuesta            
            v_consulta:=v_consulta||v_parametros.filtro;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;
    
    /*********************************    
     #TRANSACCION:  'GC_ACCFUN_SEL'
     #DESCRIPCION:    seleccion de registros
     #AUTOR:        ymedina    
     #FECHA:        29-05-2021 16:19:41
    ***********************************/    
    ELSIF (p_transaccion='GC_ACCFUN_SEL') THEN
                     
        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        acc.id_accesorio,
                        fa.id_funcionario_celular,
                        acc.id_equipo,
                        fa.estado_reg,
                        acc.nombre,
                        acc.marca,
                        acc.num_serie,
                        acc.estado_fisico,
                        acc.observaciones,
                        acc.id_usuario_reg,
                        acc.fecha_reg,
                        acc.id_usuario_ai,
                        acc.usuario_ai,
                        acc.id_usuario_mod,
                        acc.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        acc.tipo,
                        acc.modelo,
                        acc.resumen,
                        case when acc.tipo in (''cargador_movil'',''cable_datos'',''manos_libres'',''otro_movil'') then
                        	(select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = acc.tipo and ct.tabla = ''taccesorio'' and ct.nombre = ''accesorio_telefono'')
                        else
                        	(select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = acc.tipo and ct.tabla = ''taccesorio'' and ct.nombre = ''accesorio_equipo'')
                        end ::varchar AS tipo_desc,
                        (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = acc.marca and ct.tabla = ''tequipo'' and ct.nombre = ''marca'')::varchar AS marca_desc,
                        (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = acc.estado_fisico and ct.tabla = ''tequipo'' and ct.nombre = ''estado_fisico'')::varchar AS estado_fisico_desc,
                        acc.codigo_inmovilizado,
                        acc.tamano         
                        FROM 
                        (select acc.*,
                        		(acc.nombre||'' ''||acc.marca||'' ''||acc.modelo||'' - ''||acc.num_serie)::varchar as resumen
                         from gecom.taccesorio acc) as acc
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = acc.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = acc.id_usuario_mod
                        left join gecom.tfuncionario_accesorio fa on acc.id_accesorio = fa.id_accesorio
                        WHERE ';
            
            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;
                        
        END;

    /*********************************    
     #TRANSACCION:  'GC_ACCFUN_CONT'
     #DESCRIPCION:    Conteo de registros
     #AUTOR:        ymedina    
     #FECHA:        29-05-2021 16:19:41
    ***********************************/

    ELSIF (p_transaccion='GC_ACCFUN_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(acc.id_accesorio) FROM 
            			 (SELECT acc.*,
                         		 (acc.nombre||'' ''||acc.marca||'' ''||acc.modelo||'' - ''||acc.num_serie)::varchar as resumen
                         FROM gecom.taccesorio acc) as acc
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = acc.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = acc.id_usuario_mod
                         left join gecom.tfuncionario_accesorio fa on acc.id_accesorio = fa.id_accesorio
                         WHERE ';
            
            --Definicion de la respuesta            
            v_consulta:=v_consulta||v_parametros.filtro;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;    
    
    /*********************************    
     #TRANSACCION:  'GC_ACCREP_SEL'
     #DESCRIPCION:   reporte de asignacion o devolucion del accesorio
     #AUTOR:        ymedina    
     #FECHA:        29-07-2021 16:19:41
    ***********************************/

    ELSIF (p_transaccion='GC_ACCREP_SEL') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:=' select  a.id_accesorio,
                                  f.desc_funcionario1::varchar,
                                  uo.nombre_unidad::varchar,
                                  case when a.tipo in (''cargador_movil'',''cable_datos'',''manos_libres'',''otro_movil'') then
                                      ''Accesorio Movil'' ||'' ''||(select c.descripcion
                                            from param.tcatalogo c
                                            LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                            WHERE c.codigo = a.tipo and ct.tabla = ''taccesorio'' and ct.nombre = ''accesorio_telefono'')
                                  else
                                      ''Accesorio Equipo'' ||'' ''||(select c.descripcion
                                            from param.tcatalogo c
                                            LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                            WHERE c.codigo = a.tipo and ct.tabla = ''taccesorio'' and ct.nombre = ''accesorio_equipo'')
                                  end ::varchar AS tipo,
                                  (select c.descripcion
                                                            from param.tcatalogo c
                                                            LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                                            WHERE c.codigo = a.marca and ct.tabla = ''tequipo'' and ct.nombre = ''marca'') as marca,
                                  a.modelo,
                                  a.num_serie,
                                  (select c.descripcion
                                                            from param.tcatalogo c
                                                            LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                                            WHERE c.codigo = a.estado_fisico and ct.tabla = ''tequipo'' and ct.nombre = ''estado_fisico'') as estado_fisico,
                                  fa.fecha_inicio,
                                  fa.fecha_fin,
                                  (p.nombre || '' '' || p.apellido_paterno || '' '' || p.apellido_materno)::varchar as asignador,
                                  fa.observaciones,
                                  a.codigo_inmovilizado,
                                  fc.fecha_inicio as fecha_entrega                                                                     
                          from gecom.taccesorio a 
                          left join gecom.tfuncionario_accesorio fa on a.id_accesorio = fa.id_accesorio
                          left join gecom.tfuncionario_celular fc on fa.id_funcionario_celular = fc.id_funcionario_celular
                          left join orga.vfuncionario f on fc.id_funcionario = f.id_funcionario
                          left join orga.tuo_funcionario tuofun on fc.id_funcionario = tuofun.id_funcionario
                                                      and tuofun.id_uo_funcionario =
                                                          (select tu.id_uo_funcionario
                                                             from orga.tuo_funcionario tu
                                                            where tu.id_funcionario = fc.id_funcionario
                                                            ORDER BY tu.fecha_asignacion DESC
                                                            LIMIT 1)    
                          left join orga.tuo uo on orga.f_get_uo_gerencia(tuofun.id_uo, NULL, NULL) = uo.id_uo
                          left join segu.tusuario u on fa.id_usuario_reg = u.id_usuario
                          left join segu.tpersona p on u.id_persona = p.id_persona
                          where a.id_accesorio = '||v_parametros.id_accesorio||
                          ' and fa.id_funcionario_celular = '||v_parametros.id_funcionario_celular;
                          
            
            --Definicion de la respuesta            
            --v_consulta:=v_consulta||v_parametros.filtro;

            --Devuelve la respuesta
            RETURN v_consulta;

        END; 
                        
    ELSE
                         
        RAISE EXCEPTION 'Transaccion inexistente';
                             
    END IF;
                    
EXCEPTION
                    
    WHEN OTHERS THEN
            v_resp='';
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
            v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
            v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
            RAISE EXCEPTION '%',v_resp;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
PARALLEL UNSAFE
COST 100;