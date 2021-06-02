CREATE OR REPLACE FUNCTION gecom.ft_equipo_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestión de Comunicación
 FUNCION:         gecom.ft_equipo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.tequipo'
 AUTOR:          (ymedina)
 FECHA:            06-05-2021 16:01:48
 COMENTARIOS:    
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                06-05-2021 16:01:48    ymedina             Creacion    
 #
 ***************************************************************************/

DECLARE

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_equipo    INTEGER;
    v_tipo			VARCHAR;     
    v_id_funcionario_celular	integer;
    v_funcionario_celular		record;
    v_funcionario_numero		record;
    v_equipo 					record;
    v_funcionario_celular_old	record;       
BEGIN

    v_nombre_funcion = 'gecom.ft_equipo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'GC_EQU_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        ymedina    
     #FECHA:        06-05-2021 16:01:48
    ***********************************/

    IF (p_transaccion='GC_EQU_INS') THEN
                    
        BEGIN
            --Sentencia de la insercion
            INSERT INTO gecom.tequipo(
            estado_fisico,
            observaciones,
            marca,
            tipo,
            modelo,
            estado_reg,
            num_serie,
            id_usuario_ai,
            fecha_reg,
            usuario_ai,
            id_usuario_reg,
            estado
              ) VALUES (
            v_parametros.estado_fisico,
            v_parametros.observaciones,
            v_parametros.marca,
            v_parametros.tipo,
            v_parametros.modelo,
            'activo',
            v_parametros.num_serie,
            v_parametros._id_usuario_ai,
            now(),
            v_parametros._nombre_usuario_ai,
            p_id_usuario,
            v_parametros.estado
            ) RETURNING id_equipo into v_id_equipo;
            
            if v_parametros.tipo in ('movil','dongle','gps','centel') then
            	INSERT INTO gecom.tequipo_movil (
                    id_usuario_reg,
                    fecha_reg,
                    estado_reg,
                    id_equipo,
                    color,
                    imei,
                    sn,
                    id_numero_celular,
                    gama,
                    imei2,
                    tipo_servicio
                  )
                  VALUES (
                    p_id_usuario,
                    now(),
                    'activo',
                    v_id_equipo,
                    v_parametros.color,
                    v_parametros.imei,
                    v_parametros.sn,
                    v_parametros.id_numero_celular,
                    v_parametros.gama,
                    v_parametros.imei2,
                    v_parametros.tipo_servicio
                  );
                  
            end if;
            
            if v_parametros.tipo in ('laptop','pc') then
            	INSERT INTO gecom.tequipo_pc (
                  id_usuario_reg,
                  fecha_reg,
                  estado_reg,
                  id_equipo,
                  tamano_pantalla,
                  tarjeta_video,
                  teclado,
                  procesador,
                  memoria_ram,
                  almacenamiento,
                  sistema_operativo,
                  accesorios
                )
                VALUES (
                  p_id_usuario,
                  now(),
                  'activo',
                  v_id_equipo,
                  v_parametros.tamano_pantalla,
                  v_parametros.tarjeta_video,
                  v_parametros.teclado,
                  v_parametros.procesador,
                  v_parametros.memoria_ram,
                  v_parametros.almacenamiento,
                  v_parametros.sistema_operativo,
                  v_parametros.accesorios
                );
            end if;
            
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Equipos almacenado(a) con exito (id_equipo'||v_id_equipo||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo',v_id_equipo::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************    
     #TRANSACCION:  'GC_EQU_MOD'
     #DESCRIPCION:    Modificacion de registros
     #AUTOR:        ymedina    
     #FECHA:        06-05-2021 16:01:48
    ***********************************/

    ELSIF (p_transaccion='GC_EQU_MOD') THEN

        BEGIN
        	select e.*, em.id_equipo_movil, em.id_numero_celular into v_equipo 
            from gecom.tequipo e
            join gecom.tequipo_movil em on e.id_equipo = em.id_equipo and em.estado_reg = 'activo'
            where e.id_equipo = v_parametros.id_equipo;
            
            --Sentencia de la modificacion
            UPDATE gecom.tequipo SET
            estado_fisico = v_parametros.estado_fisico,
            observaciones = v_parametros.observaciones,
            marca = v_parametros.marca,
            tipo = v_parametros.tipo,
            modelo = v_parametros.modelo,
            num_serie = v_parametros.num_serie,
            fecha_mod = now(),
            id_usuario_mod = p_id_usuario,
            id_usuario_ai = v_parametros._id_usuario_ai,
            usuario_ai = v_parametros._nombre_usuario_ai,
            estado = v_parametros.estado
            WHERE id_equipo=v_parametros.id_equipo;
            
            if v_parametros.tipo = 'movil' then
                  UPDATE  gecom.tequipo_movil 
                  SET id_usuario_mod = p_id_usuario,
                      fecha_mod = now(),
                      color = v_parametros.color,
                      imei = v_parametros.imei,
                      sn = v_parametros.sn,
                      id_numero_celular = v_parametros.id_numero_celular,
                      gama = v_parametros.gama,
                      imei2 = v_parametros.imei2,
                      tipo_servicio = v_parametros.tipo_servicio
                  WHERE  id_equipo_movil = v_parametros.id_equipo_movil;
            end if;
            
            if v_parametros.tipo in ('laptop','pc') then
                UPDATE gecom.tequipo_pc 
                SET id_usuario_mod = p_id_usuario,
                    fecha_mod = now(),
                    --id_equipo_historico = ?id_equipo_historico,
                    tamano_pantalla = v_parametros.tamano_pantalla,
                    tarjeta_video = v_parametros.tarjeta_video,
                    teclado = v_parametros.teclado,
                    procesador = v_parametros.procesador,
                    memoria_ram = v_parametros.memoria_ram,
                    almacenamiento = v_parametros.almacenamiento,
                    sistema_operativo = v_parametros.sistema_operativo,
                    accesorios = v_parametros.accesorios
                WHERE id_equipo_pc = v_parametros.id_equipo_pc;
            end if;
            
            select fc.id_funcionario_celular into v_id_funcionario_celular 
            from gecom.tfuncionario_celular fc 
            where fc.id_equipo = v_parametros.id_equipo and fc.estado_reg = 'activo';
            
            INSERT INTO gecom.tequipo_historico
            (
              id_usuario_reg,
              fecha_reg,
              estado_reg,
              id_equipo,
              tipo,
              marca,
              modelo,
              num_serie,
              estado_fisico,
              observaciones,
              operacion,
              id_funcionario_celular
            ) VALUES (
              p_id_usuario,
              now(),
              'activo',
              v_parametros.id_equipo,
              v_parametros.tipo,
              v_parametros.marca,
              v_parametros.modelo,
              v_parametros.num_serie,
              v_parametros.estado_fisico,
              v_parametros.observaciones,
              'modificacion',
              v_id_funcionario_celular
            );
            
            
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Equipos modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo',v_parametros.id_equipo::varchar);
               
            --Devuelve la respuesta
            RETURN v_resp;
            
        END;

    /*********************************    
     #TRANSACCION:  'GC_EQU_ELI'
     #DESCRIPCION:    Eliminacion de registros
     #AUTOR:        ymedina    
     #FECHA:        06-05-2021 16:01:48
    ***********************************/

    ELSIF (p_transaccion='GC_EQU_ELI') THEN

        BEGIN
        	select e.tipo into v_tipo from gecom.tequipo e where e.id_equipo = v_parametros.id_equipo;
        	if v_tipo = 'movil' then
                  DELETE FROM gecom.tequipo_movil 
                  WHERE id_equipo = v_parametros.id_equipo;
            end if;
            
            if v_tipo in ('laptop','pc') then
                DELETE FROM gecom.tequipo_pc
                WHERE  id_equipo = v_parametros.id_equipo;
            end if;
            
            --Sentencia de la eliminacion
            DELETE FROM gecom.tequipo
            WHERE id_equipo=v_parametros.id_equipo;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Equipos eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo',v_parametros.id_equipo::varchar);
              
            --Devuelve la respuesta
            RETURN v_resp;

        END;
    
    /*********************************    
     #TRANSACCION:  'GC_EQU_RET'
     #DESCRIPCION:  Devolicion de equipo o numeros
     #AUTOR:        ymedina    
     #FECHA:        06-05-2021 16:01:48
    ***********************************/

    ELSIF (p_transaccion='GC_EQU_RET') THEN

        BEGIN
        	select fc.tipo_asignacion_equipo,
            	   fc.id_funcionario_celular,
                   fc.id_equipo,
                   fc.id_numero_celular,
                   e.tipo,
                   e.marca,
                   e.modelo,
                   e.num_serie,
                   e.estado_fisico
            into v_funcionario_celular
            from gecom.tfuncionario_celular fc 
            left join gecom.tequipo e on fc.id_equipo = e.id_equipo 
            where fc.id_funcionario_celular = v_parametros.id_funcionario_celular;
        	
        	update gecom.tfuncionario_celular fc
            set estado_reg = 'inactivo',
            	fecha_fin = v_parametros.fecha_fin
            where fc.id_funcionario_celular = v_parametros.id_funcionario_celular;
            
            if v_funcionario_celular.tipo_asignacion_equipo = 'equipo' then
            	update gecom.tequipo e
                set estado = 'disponible'
                where e.id_equipo = v_funcionario_celular.id_equipo;
            
            	INSERT INTO gecom.tequipo_historico
                (
                  id_usuario_reg,
                  fecha_reg,
                  estado_reg,
                  id_equipo,
                  tipo,
                  marca,
                  modelo,
                  num_serie,
                  estado_fisico,
                  observaciones,
                  operacion,
                  id_funcionario_celular
                ) VALUES (
                  p_id_usuario,
                  now(),
                  'activo',
                  v_funcionario_celular.id_equipo,
                  v_funcionario_celular.tipo,
                  v_funcionario_celular.marca,
                  v_funcionario_celular.modelo,
                  v_funcionario_celular.num_serie,
                  v_funcionario_celular.estado_fisico,
                  v_parametros.observaciones,
                  'devolucion',
                  v_parametros.id_funcionario_celular
                );
                
                select fc.id_funcionario_celular, em.id_numero_celular into v_funcionario_numero
                from gecom.tequipo_movil em
                join gecom.tfuncionario_celular fc on em.id_numero_celular = fc.id_numero_celular and fc.estado_reg = 'activo'  
                where em.estado_reg = 'activo'
                and em.id_equipo = v_funcionario_celular.id_equipo;
                
                if v_funcionario_numero.id_funcionario_celular is not null then
                	/*update gecom.tfuncionario_celular fc
                    set estado_reg = 'inactivo',
                        fecha_fin = v_parametros.fecha_fin
                    where fc.id_funcionario_celular = v_funcionario_numero.id_funcionario_celular;
                    
                    update gecom.tnumero_celular n 
                    set estado = 'activo'
                    where n.id_numero_celular = v_funcionario_numero.id_numero_celular;*/
                    update gecom.tequipo_movil em 
                    set id_numero_celular = null
                    where em.id_equipo = v_funcionario_celular.id_equipo and em.estado_reg = 'activo';
                end if;
            end if;
            
            if v_funcionario_celular.tipo_asignacion_equipo = 'numero' then
            	update gecom.tnumero_celular n 
                set estado = 'activo'
                where n.id_numero_celular = v_funcionario_celular.id_numero_celular;
                
                select fc.id_funcionario_celular, em.id_equipo, e.* into v_funcionario_numero
                from gecom.tequipo_movil em
                join gecom.tfuncionario_celular fc on em.id_equipo = fc.id_equipo and fc.estado_reg = 'activo'
                join gecom.tequipo e on em.id_equipo = e.id_equipo 
                where em.estado_reg = 'activo' 
                and em.id_numero_celular = v_funcionario_celular.id_numero_celular;
                
                if v_funcionario_numero.id_funcionario_celular is not null then
                	update gecom.tfuncionario_celular fc
                    set estado_reg = 'inactivo',
                        fecha_fin = v_parametros.fecha_fin
                    where fc.id_funcionario_celular = v_funcionario_numero.id_funcionario_celular;
                    
                    update gecom.tequipo e
                    set estado = 'disponible'
                    where e.id_equipo = v_funcionario_numero.id_equipo;
                    
                    INSERT INTO gecom.tequipo_historico
                      (
                        id_usuario_reg,
                        fecha_reg,
                        estado_reg,
                        id_equipo,
                        tipo,
                        marca,
                        modelo,
                        num_serie,
                        estado_fisico,
                        observaciones,
                        operacion,
                        id_funcionario_celular
                      ) VALUES (
                        p_id_usuario,
                        now(),
                        'activo',
                        v_funcionario_numero.id_equipo,
                        v_funcionario_numero.tipo,
                        v_funcionario_numero.marca,
                        v_funcionario_numero.modelo,
                        v_funcionario_numero.num_serie,
                        v_funcionario_numero.estado_fisico,
                        v_parametros.observaciones,
                        'devolucion',
                        v_funcionario_numero.id_funcionario_celular
                      );
                end if;
                
            end if;
            
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Equipos devuelto'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo',v_funcionario_celular.id_equipo::varchar);
              
            --Devuelve la respuesta
            RETURN v_resp;

        END;
    /*********************************    
     #TRANSACCION:  'GC_EQU_CAM'
     #DESCRIPCION:  Devolicion de equipo
     #AUTOR:        ymedina    
     #FECHA:        06-05-2021 16:01:48
    ***********************************/

    ELSIF (p_transaccion='GC_EQU_CAM') THEN

        BEGIN
        	select  fi.id_funcionario_celular, e.* into v_funcionario_celular_old
             from gecom.tfuncionario_celular fcc
             join gecom.tequipo_movil em on fcc.id_numero_celular = em.id_numero_celular and em.estado_reg = 'activo'
             join gecom.tfuncionario_celular fi on em.id_equipo = fi.id_equipo and fi.estado_reg = 'activo'
             join gecom.tequipo e on em.id_equipo = e.id_equipo
             where fcc.id_funcionario_celular = v_parametros.id_funcionario_celular
               and fcc.estado_reg = 'activo';
            
            select fc.* into v_funcionario_celular
            from gecom.tfuncionario_celular fc 
            where fc.id_funcionario_celular = v_parametros.id_funcionario_celular;
            
            update gecom.tequipo_movil em 
            set id_numero_celular = null
            where em.id_numero_celular = v_funcionario_celular.id_numero_celular;
            
            --EQUIPO ANTIGUO
            update gecom.tfuncionario_celular fc
            set estado_reg = 'inactivo',
            	fecha_fin = now()
            where fc.id_funcionario_celular = v_funcionario_celular_old.id_funcionario_celular;
            
            update gecom.tequipo e
                set estado = 'disponible'
                where e.id_equipo = v_funcionario_celular_old.id_equipo;
            
            	INSERT INTO gecom.tequipo_historico
                (
                  id_usuario_reg,
                  fecha_reg,
                  estado_reg,
                  id_equipo,
                  tipo,
                  marca,
                  modelo,
                  num_serie,
                  estado_fisico,
                  observaciones,
                  operacion,
                  id_funcionario_celular
                ) VALUES (
                  p_id_usuario,
                  now(),
                  'activo',
                  v_funcionario_celular_old.id_equipo,
                  v_funcionario_celular_old.tipo,
                  v_funcionario_celular_old.marca,
                  v_funcionario_celular_old.modelo,
                  v_funcionario_celular_old.num_serie,
                  v_funcionario_celular_old.estado_fisico,
                  v_funcionario_celular_old.observaciones,
                  'devolucion',
                  v_funcionario_celular_old.id_funcionario_celular
                );
            --EQUIPO ANTIGUO
            
            --EQUIPO NUEVO
            select e.id_equipo,
                  e.tipo,
                  e.marca,
                  e.modelo,
                  e.num_serie,
                  e.estado_fisico,
                  e.estado,
                  em.imei,
                  em.imei2,
                  em.id_equipo_movil
            into v_equipo 
            from gecom.tequipo e
            join gecom.tequipo_movil em on e.id_equipo = em.id_equipo
            where e.id_equipo = v_parametros.id_equipo;
            
            update gecom.tequipo_movil em 
            set id_numero_celular = v_funcionario_celular.id_numero_celular
            where em.id_equipo_movil = v_equipo.id_equipo_movil;
            
            INSERT INTO gecom.tfuncionario_celular
                (
                  id_usuario_reg,
                  fecha_reg,
                  estado_reg,
                  id_funcionario,
                  fecha_inicio,
                  fecha_fin,
                  observaciones,
                  id_equipo,
                  codigo_inmovilizado,
                  tipo_asignacion_equipo,
                  tipo_servicio
                ) VALUES (
                  p_id_usuario,
                  now(),
                  'activo',
                  v_funcionario_celular.id_funcionario,
                  now(),
                  v_parametros.fecha_fin,
                  v_parametros.observaciones,
                  v_equipo.id_equipo,
                  v_funcionario_celular.codigo_inmovilizado,
                  'equipo',
                  'ser_tel'
                )RETURNING id_funcionario_celular into v_id_funcionario_celular;
                
                UPDATE gecom.tequipo e 
                set estado = 'asignado'
                where e.id_equipo = v_equipo.id_equipo;
                
              INSERT INTO gecom.tequipo_historico
                (
                  id_usuario_reg,
                  fecha_reg,
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
                  id_funcionario_celular
                ) VALUES (
                  p_id_usuario,
                  now(),
                  'activo',
                  v_equipo.id_equipo,
                  v_equipo.tipo,
                  v_equipo.marca,
                  v_equipo.modelo,
                  v_equipo.num_serie,
                  v_equipo.estado_fisico,
                  v_equipo.estado,
                  v_parametros.observaciones,
                  'asignacion',
                  v_id_funcionario_celular
                );
            --EQUIPO NUEVO
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Equipos devuelto'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo',v_funcionario_celular.id_equipo::varchar);
              
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
