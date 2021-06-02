CREATE OR REPLACE FUNCTION gecom.ft_cuenta_proveedor_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestión de Comunicación
 FUNCION:         gecom.ft_cuenta_proveedor_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.tcuenta_proveedor'
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

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_cuenta    INTEGER;
                
BEGIN

    v_nombre_funcion = 'gecom.ft_cuenta_proveedor_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'GC_CUP_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        ymedina    
     #FECHA:        12-05-2021 08:13:06
    ***********************************/

    IF (p_transaccion='GC_CUP_INS') THEN
                    
        BEGIN
            --Sentencia de la insercion
            INSERT INTO gecom.tcuenta_proveedor(
            estado_reg,
            id_proveedor,
            nro_cuenta,
            id_uo,
            id_usuario_reg,
            fecha_reg,
            id_usuario_ai,
            usuario_ai,
            id_usuario_mod,
            fecha_mod
              ) VALUES (
            'activo',
            v_parametros.id_proveedor,
            v_parametros.nro_cuenta,
            v_parametros.id_uo,
            p_id_usuario,
            now(),
            v_parametros._id_usuario_ai,
            v_parametros._nombre_usuario_ai,
            null,
            null            
            ) RETURNING id_cuenta into v_id_cuenta;
            
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cuenta Proveedor almacenado(a) con exito (id_cuenta'||v_id_cuenta||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_cuenta',v_id_cuenta::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************    
     #TRANSACCION:  'GC_CUP_MOD'
     #DESCRIPCION:    Modificacion de registros
     #AUTOR:        ymedina    
     #FECHA:        12-05-2021 08:13:06
    ***********************************/

    ELSIF (p_transaccion='GC_CUP_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE gecom.tcuenta_proveedor SET
            id_proveedor = v_parametros.id_proveedor,
            nro_cuenta = v_parametros.nro_cuenta,
            id_uo = v_parametros.id_uo,
            id_usuario_mod = p_id_usuario,
            fecha_mod = now(),
            id_usuario_ai = v_parametros._id_usuario_ai,
            usuario_ai = v_parametros._nombre_usuario_ai
            WHERE id_cuenta=v_parametros.id_cuenta;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cuenta Proveedor modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_cuenta',v_parametros.id_cuenta::varchar);
               
            --Devuelve la respuesta
            RETURN v_resp;
            
        END;

    /*********************************    
     #TRANSACCION:  'GC_CUP_ELI'
     #DESCRIPCION:    Eliminacion de registros
     #AUTOR:        ymedina    
     #FECHA:        12-05-2021 08:13:06
    ***********************************/

    ELSIF (p_transaccion='GC_CUP_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM gecom.tcuenta_proveedor
            WHERE id_cuenta=v_parametros.id_cuenta;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cuenta Proveedor eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_cuenta',v_parametros.id_cuenta::varchar);
              
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
