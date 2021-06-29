CREATE OR REPLACE FUNCTION gecom.ft_cuenta_proveedor_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestión de Comunicación
 FUNCION:         gecom.ft_cuenta_proveedor_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.tcuenta_proveedor'
 AUTOR:          (ymedina)
 FECHA:            12-05-2021 08:13:06
 COMENTARIOS:    
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                12-05-2021 08:13:06    ymedina             Creacion    
 #
 ***************************************************************************/

DECLARE

    v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;
                
BEGIN

    v_nombre_funcion = 'gecom.ft_cuenta_proveedor_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'GC_CUP_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        ymedina    
     #FECHA:        12-05-2021 08:13:06
    ***********************************/

    IF (p_transaccion='GC_CUP_SEL') THEN
                     
        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        cup.id_cuenta,
                        cup.estado_reg,
                        cup.id_proveedor,
                        cup.nro_cuenta,
                        cup.id_uo,
                        cup.id_usuario_reg,
                        cup.fecha_reg,
                        cup.id_usuario_ai,
                        cup.usuario_ai,
                        cup.id_usuario_mod,
                        cup.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        pro.desc_proveedor,
                        uo.nombre_unidad as desc_nombre_unidad,
                        (cup.nro_cuenta || '' - '' || pro.desc_proveedor || '' - '' || uo.nombre_unidad)::varchar as desc_cuenta_prov
                        FROM gecom.tcuenta_proveedor cup
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = cup.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = cup.id_usuario_mod
                        join param.vproveedor pro on pro.id_proveedor = cup.id_proveedor
                        LEFT JOIN orga.tuo uo on cup.id_uo = uo.id_uo
                        WHERE  ';
            
            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;      
        END;

    /*********************************    
     #TRANSACCION:  'GC_CUP_CONT'
     #DESCRIPCION:    Conteo de registros
     #AUTOR:        ymedina    
     #FECHA:        12-05-2021 08:13:06
    ***********************************/

    ELSIF (p_transaccion='GC_CUP_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(id_cuenta)
                         FROM gecom.tcuenta_proveedor cup
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = cup.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = cup.id_usuario_mod
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
