CREATE OR REPLACE FUNCTION gecom.ft_equipo_historico_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestión de Comunicación
 FUNCION:         gecom.ft_equipo_historico_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.tequipo_historico'
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

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_equipo_historico    INTEGER;
                
BEGIN

    v_nombre_funcion = 'gecom.ft_equipo_historico_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'GC_DETEQU_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        ymedina    
     #FECHA:        10-05-2021 16:01:12
    ***********************************/

    IF (p_transaccion='GC_DETEQU_INS') THEN
                    
        BEGIN
            --Sentencia de la insercion
            INSERT INTO gecom.tequipo_historico(
            estado_reg,
            id_equipo,
            tipo,
            marca,
            modelo,
            num_serie,
            estado_fisico,
            estado,
            observaciones,
            operacion,
            id_usuario_reg,
            fecha_reg,
            id_usuario_ai,
            usuario_ai,
            id_usuario_mod,
            fecha_mod
              ) VALUES (
            'activo',
            v_parametros.id_equipo,
            v_parametros.tipo,
            v_parametros.marca,
            v_parametros.modelo,
            v_parametros.num_serie,
            v_parametros.estado_fisico,
            v_parametros.estado,
            v_parametros.observaciones,
            v_parametros.operacion,
            p_id_usuario,
            now(),
            v_parametros._id_usuario_ai,
            v_parametros._nombre_usuario_ai,
            null,
            null            
            ) RETURNING id_equipo_historico into v_id_equipo_historico;
            
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle Equipos almacenado(a) con exito (id_equipo_historico'||v_id_equipo_historico||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo_historico',v_id_equipo_historico::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************    
     #TRANSACCION:  'GC_DETEQU_MOD'
     #DESCRIPCION:    Modificacion de registros
     #AUTOR:        ymedina    
     #FECHA:        10-05-2021 16:01:12
    ***********************************/

    ELSIF (p_transaccion='GC_DETEQU_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE gecom.tequipo_historico SET
            id_equipo = v_parametros.id_equipo,
            tipo = v_parametros.tipo,
            marca = v_parametros.marca,
            modelo = v_parametros.modelo,
            num_serie = v_parametros.num_serie,
            estado_fisico = v_parametros.estado_fisico,
            estado = v_parametros.estado,
            observaciones = v_parametros.observaciones,
            operacion = v_parametros.operacion,
            id_usuario_mod = p_id_usuario,
            fecha_mod = now(),
            id_usuario_ai = v_parametros._id_usuario_ai,
            usuario_ai = v_parametros._nombre_usuario_ai
            WHERE id_equipo_historico=v_parametros.id_equipo_historico;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle Equipos modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo_historico',v_parametros.id_equipo_historico::varchar);
               
            --Devuelve la respuesta
            RETURN v_resp;
            
        END;

    /*********************************    
     #TRANSACCION:  'GC_DETEQU_ELI'
     #DESCRIPCION:    Eliminacion de registros
     #AUTOR:        ymedina    
     #FECHA:        10-05-2021 16:01:12
    ***********************************/

    ELSIF (p_transaccion='GC_DETEQU_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM gecom.tequipo_historico
            WHERE id_equipo_historico=v_parametros.id_equipo_historico;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle Equipos eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo_historico',v_parametros.id_equipo_historico::varchar);
              
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
