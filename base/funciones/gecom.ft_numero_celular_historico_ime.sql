CREATE OR REPLACE FUNCTION gecom.ft_numero_celular_historico_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestión de Comunicación
 FUNCION:         gecom.ft_numero_celular_historico_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.tnumero_celular_historico'
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

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_numero_celular_his    INTEGER;
                
BEGIN

    v_nombre_funcion = 'gecom.ft_numero_celular_historico_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'GC_HNUM_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        ymedina    
     #FECHA:        12-05-2021 12:47:30
    ***********************************/

    IF (p_transaccion='GC_HNUM_INS') THEN
                    
        BEGIN
            --Sentencia de la insercion
            INSERT INTO gecom.tnumero_celular_historico(
            estado_reg,
            id_numero_celular,
            numero,
            roaming,
            observaciones,
            id_proveedor,
            tipo,
            estado,
            credito,
            limite_consumo,
            sim,
            id_cuenta,
            operacion,
            observacion_operacion,
            id_usuario_reg,
            fecha_reg,
            id_usuario_ai,
            usuario_ai,
            id_usuario_mod,
            fecha_mod
              ) VALUES (
            'activo',
            v_parametros.id_numero_celular,
            v_parametros.numero,
            v_parametros.roaming,
            v_parametros.observaciones,
            v_parametros.id_proveedor,
            v_parametros.tipo,
            v_parametros.estado,
            v_parametros.credito,
            v_parametros.limite_consumo,
            v_parametros.sim,
            v_parametros.id_cuenta,
            v_parametros.operacion,
            v_parametros.observacion_operacion,
            p_id_usuario,
            now(),
            v_parametros._id_usuario_ai,
            v_parametros._nombre_usuario_ai,
            null,
            null            
            ) RETURNING id_numero_celular_his into v_id_numero_celular_his;
            
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Historico numero almacenado(a) con exito (id_numero_celular_his'||v_id_numero_celular_his||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_numero_celular_his',v_id_numero_celular_his::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************    
     #TRANSACCION:  'GC_HNUM_MOD'
     #DESCRIPCION:    Modificacion de registros
     #AUTOR:        ymedina    
     #FECHA:        12-05-2021 12:47:30
    ***********************************/

    ELSIF (p_transaccion='GC_HNUM_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE gecom.tnumero_celular_historico SET
            id_numero_celular = v_parametros.id_numero_celular,
            numero = v_parametros.numero,
            roaming = v_parametros.roaming,
            observaciones = v_parametros.observaciones,
            id_proveedor = v_parametros.id_proveedor,
            tipo = v_parametros.tipo,
            estado = v_parametros.estado,
            credito = v_parametros.credito,
            limite_consumo = v_parametros.limite_consumo,
            sim = v_parametros.sim,
            id_cuenta = v_parametros.id_cuenta,
            operacion = v_parametros.operacion,
            observacion_operacion = v_parametros.observacion_operacion,
            id_usuario_mod = p_id_usuario,
            fecha_mod = now(),
            id_usuario_ai = v_parametros._id_usuario_ai,
            usuario_ai = v_parametros._nombre_usuario_ai
            WHERE id_numero_celular_his=v_parametros.id_numero_celular_his;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Historico numero modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_numero_celular_his',v_parametros.id_numero_celular_his::varchar);
               
            --Devuelve la respuesta
            RETURN v_resp;
            
        END;

    /*********************************    
     #TRANSACCION:  'GC_HNUM_ELI'
     #DESCRIPCION:    Eliminacion de registros
     #AUTOR:        ymedina    
     #FECHA:        12-05-2021 12:47:30
    ***********************************/

    ELSIF (p_transaccion='GC_HNUM_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM gecom.tnumero_celular_historico
            WHERE id_numero_celular_his=v_parametros.id_numero_celular_his;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Historico numero eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_numero_celular_his',v_parametros.id_numero_celular_his::varchar);
              
            --Devuelve la respuesta
            RETURN v_resp;

        END;
         
    ELSE
     
        RAISE EXCEPTION 'Transaccion inexistente: %',p_transaccion;

    END IF;

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
