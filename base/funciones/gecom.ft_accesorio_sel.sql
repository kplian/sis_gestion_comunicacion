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
                        case when acc.tipo in (''cargador_movil'',''cable_datos'',''manos_libres'') then
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
                                  WHERE c.codigo = acc.estado_fisico and ct.tabla = ''tequipo'' and ct.nombre = ''estado_fisico'')::varchar AS estado_fisico_desc
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
