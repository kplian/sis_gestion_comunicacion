CREATE OR REPLACE FUNCTION gecom.ft_accesorio_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestión de Comunicación
 FUNCION:         gecom.ft_accesorio_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.taccesorio'
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

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_accesorio    INTEGER;
                
BEGIN

    v_nombre_funcion = 'gecom.ft_accesorio_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'GC_ACC_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        ymedina    
     #FECHA:        29-05-2021 16:19:41
    ***********************************/

    IF (p_transaccion='GC_ACC_INS') THEN
                    
        BEGIN
            --Sentencia de la insercion
            INSERT INTO gecom.taccesorio(
            estado_reg,
            nombre,
            marca,
            num_serie,
            estado_fisico,
            observaciones,
            id_usuario_reg,
            fecha_reg,
            id_usuario_ai,
            usuario_ai,
            id_usuario_mod,
            fecha_mod,
            id_equipo,
            tipo,
            modelo
              ) VALUES (
            'activo',
            v_parametros.nombre,
            v_parametros.marca,
            v_parametros.num_serie,
            v_parametros.estado_fisico,
            v_parametros.observaciones,
            p_id_usuario,
            now(),
            v_parametros._id_usuario_ai,
            v_parametros._nombre_usuario_ai,
            null,
            null,
            v_parametros.id_equipo,
            v_parametros.tipo,
            v_parametros.modelo
            ) RETURNING id_accesorio into v_id_accesorio;
            
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Accesorios almacenado(a) con exito (id_accesorio'||v_id_accesorio||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_accesorio',v_id_accesorio::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************    
     #TRANSACCION:  'GC_ACC_MOD'
     #DESCRIPCION:    Modificacion de registros
     #AUTOR:        ymedina    
     #FECHA:        29-05-2021 16:19:41
    ***********************************/

    ELSIF (p_transaccion='GC_ACC_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE gecom.taccesorio SET
            nombre = v_parametros.nombre,
            marca = v_parametros.marca,
            num_serie = v_parametros.num_serie,
            estado_fisico = v_parametros.estado_fisico,
            observaciones = v_parametros.observaciones,
            id_usuario_mod = p_id_usuario,
            fecha_mod = now(),
            id_usuario_ai = v_parametros._id_usuario_ai,
            usuario_ai = v_parametros._nombre_usuario_ai,
            id_equipo = v_parametros.id_equipo,
            tipo = v_parametros.tipo,
            modelo = v_parametros.modelo
            WHERE id_accesorio=v_parametros.id_accesorio;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Accesorios modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_accesorio',v_parametros.id_accesorio::varchar);
               
            --Devuelve la respuesta
            RETURN v_resp;
            
        END;

    /*********************************    
     #TRANSACCION:  'GC_ACC_ELI'
     #DESCRIPCION:    Eliminacion de registros
     #AUTOR:        ymedina    
     #FECHA:        29-05-2021 16:19:41
    ***********************************/

    ELSIF (p_transaccion='GC_ACC_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM gecom.taccesorio
            WHERE id_accesorio=v_parametros.id_accesorio;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Accesorios eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_accesorio',v_parametros.id_accesorio::varchar);
              
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

