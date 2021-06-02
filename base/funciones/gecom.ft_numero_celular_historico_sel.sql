CREATE OR REPLACE FUNCTION gecom.ft_numero_celular_historico_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestión de Comunicación
 FUNCION:         gecom.ft_numero_celular_historico_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.tnumero_celular_historico'
 AUTOR:          (ymedina)
 FECHA:            12-05-2021 12:47:30
 COMENTARIOS:    
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                12-05-2021 12:47:30    ymedina             Creacion    
 #
 ***************************************************************************/

DECLARE

    v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;
                
BEGIN

    v_nombre_funcion = 'gecom.ft_numero_celular_historico_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'GC_HNUM_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        ymedina    
     #FECHA:        12-05-2021 12:47:30
    ***********************************/

    IF (p_transaccion='GC_HNUM_SEL') THEN
                     
        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        hnum.id_numero_celular_his,
                        hnum.estado_reg,
                        hnum.id_numero_celular,
                        hnum.numero,
                        hnum.roaming,
                        hnum.observaciones,
                        hnum.id_proveedor,
                        hnum.tipo,
                        hnum.estado,
                        hnum.credito,
                        hnum.limite_consumo,
                        hnum.sim,
                        hnum.id_cuenta,
                        hnum.operacion,
                        hnum.observacion_operacion,
                        hnum.id_usuario_reg,
                        hnum.fecha_reg,
                        hnum.id_usuario_ai,
                        hnum.usuario_ai,
                        hnum.id_usuario_mod,
                        hnum.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        pro.desc_proveedor,
                        cp.nro_cuenta::varchar as desc_nro_cuenta,
                        hnum.id_tipo_cc,
                        (tcc.descripcion || '' - '' || tcc.codigo)::varchar as desc_tipo_cc
                        FROM gecom.tnumero_celular_historico hnum
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = hnum.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = hnum.id_usuario_mod
                        LEFT join param.vproveedor pro on pro.id_proveedor = hnum.id_proveedor
                        left join gecom.tcuenta_proveedor cp on hnum.id_cuenta = cp.id_cuenta
                        LEFT JOIN param.vtipo_cc  tcc ON hnum.id_tipo_cc = tcc.id_tipo_cc
                        WHERE  ';
            
            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;
                        
        END;

    /*********************************    
     #TRANSACCION:  'GC_HNUM_CONT'
     #DESCRIPCION:    Conteo de registros
     #AUTOR:        ymedina    
     #FECHA:        12-05-2021 12:47:30
    ***********************************/

    ELSIF (p_transaccion='GC_HNUM_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(id_numero_celular_his)
                         FROM gecom.tnumero_celular_historico hnum
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = hnum.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = hnum.id_usuario_mod
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
