CREATE OR REPLACE FUNCTION gecom.ft_equipo_historico_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestión de Comunicación
 FUNCION:         gecom.ft_equipo_historico_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.tequipo_historico'
 AUTOR:          (ymedina)
 FECHA:            10-05-2021 16:01:12
 COMENTARIOS:    
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                10-05-2021 16:01:12    ymedina             Creacion    
 #
 ***************************************************************************/

DECLARE

    v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;
                
BEGIN

    v_nombre_funcion = 'gecom.ft_equipo_historico_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'GC_DETEQU_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        ymedina    
     #FECHA:        10-05-2021 16:01:12
    ***********************************/

    IF (p_transaccion='GC_DETEQU_SEL') THEN
                     
        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        detequ.id_equipo_historico,
                        detequ.estado_reg,
                        detequ.id_equipo,
                        detequ.tipo,
                        detequ.marca,
                        detequ.modelo,
                        detequ.num_serie,
                        detequ.estado_fisico,
                        detequ.estado,
                        detequ.observaciones,
                        detequ.operacion,
                        detequ.id_usuario_reg,
                        detequ.fecha_reg,
                        detequ.id_usuario_ai,
                        detequ.usuario_ai,
                        detequ.id_usuario_mod,
                        detequ.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        detequ.id_funcionario_celular 
                        FROM gecom.tequipo_historico detequ
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = detequ.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = detequ.id_usuario_mod
                        WHERE  ';
            
            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;
                        
        END;

    /*********************************    
     #TRANSACCION:  'GC_DETEQU_CONT'
     #DESCRIPCION:    Conteo de registros
     #AUTOR:        ymedina    
     #FECHA:        10-05-2021 16:01:12
    ***********************************/

    ELSIF (p_transaccion='GC_DETEQU_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(id_equipo_historico)
                         FROM gecom.tequipo_historico detequ
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = detequ.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = detequ.id_usuario_mod
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