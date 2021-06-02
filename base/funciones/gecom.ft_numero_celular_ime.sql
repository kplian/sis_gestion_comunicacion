CREATE OR REPLACE FUNCTION gecom.ft_numero_celular_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Gestión de Comunicación
 FUNCION: 		gecom.ft_numero_celular_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.tnumero_celular'
 AUTOR: 		 (jrivera)
 FECHA:	        23-07-2014 22:43:16
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_numero_celular	integer;
    v_registros				record;
    v_numero_celular		record;
    v_equipo				record;
    v_funcionario_equipo	record;
    v_id_funcionario_celular integer;
			    
BEGIN

    v_nombre_funcion = 'gecom.ft_numero_celular_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'GC_NUMCEL_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		jrivera	
 	#FECHA:		23-07-2014 22:43:16
	***********************************/

	if(p_transaccion='GC_NUMCEL_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into gecom.tnumero_celular(
			numero,
			observaciones,
			roaming,
			estado_reg,
			id_usuario_ai,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			fecha_mod,
			id_usuario_mod,
			tipo,
            estado,
            id_cuenta,
            id_tipo_cc
          	) values(
			v_parametros.numero,
			v_parametros.observaciones,
			v_parametros.roaming,
			'activo',
			v_parametros._id_usuario_ai,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			null,
			null,
			v_parametros.tipo,
            v_parametros.estado,
            v_parametros.id_cuenta,
            v_parametros.id_tipo_cc
			)RETURNING id_numero_celular into v_id_numero_celular;
            
            for v_registros in (select * from gecom.tservicio s 
            					where s.defecto = 'si' and 
                                	id_proveedor = (select cp.id_proveedor from gecom.tcuenta_proveedor cp 
                                   					 where cp.id_cuenta = v_parametros.id_cuenta )) loop
            	insert into gecom.tnumero_servicio (id_usuario_reg,id_servicio,id_numero_celular,fecha_inicio)
                values(p_id_usuario,v_registros.id_servicio, v_id_numero_celular, now());
            end loop;
            
            INSERT INTO gecom.tnumero_celular_historico
              (
                id_usuario_reg,
                fecha_reg,
                estado_reg,
                id_numero_celular,
                numero,
                roaming,
                observaciones,
                tipo,
                estado,
                id_cuenta,
                operacion,
            	id_tipo_cc
              )
              VALUES (
                p_id_usuario,
                now(),
                'activo',
                v_id_numero_celular,
                v_parametros.numero,
                v_parametros.roaming,
                v_parametros.observaciones,
                v_parametros.tipo,
                v_parametros.estado,
                v_parametros.id_cuenta,
                'creacion',
                v_parametros.id_tipo_cc
              );
              
			if v_parametros.id_equipo is not null THEN
            	update gecom.tequipo_movil em
                set id_numero_celular = v_id_numero_celular
                where em.id_equipo = v_parametros.id_equipo
                and em.estado_reg = 'activo';
            end if;
            
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Numeros de Celular almacenado(a) con exito (id_numero_celular'||v_id_numero_celular||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_numero_celular',v_id_numero_celular::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'GC_NUMCEL_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		jrivera	
 	#FECHA:		23-07-2014 22:43:16
	***********************************/

	elsif(p_transaccion='GC_NUMCEL_MOD')then

		begin
        	select em.id_equipo into v_equipo
            from gecom.tequipo_movil em 
            where em.id_numero_celular = v_parametros.id_numero_celular 
            and em.estado_reg = 'activo';
            
			--Sentencia de la modificacion
			update gecom.tnumero_celular set
			numero = v_parametros.numero,
			observaciones = v_parametros.observaciones,
			roaming = v_parametros.roaming,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
			tipo = v_parametros.tipo,
            estado = v_parametros.estado,
            id_cuenta = v_parametros.id_cuenta,
            id_tipo_cc = v_parametros.id_tipo_cc
			where id_numero_celular=v_parametros.id_numero_celular;
            
            INSERT INTO gecom.tnumero_celular_historico
              (
                id_usuario_reg,
                fecha_reg,
                estado_reg,
                id_numero_celular,
                numero,
                roaming,
                observaciones,
                tipo,
                estado,
                id_cuenta,
                operacion,
                id_tipo_cc
              )
              VALUES (
                p_id_usuario,
                now(),
                'activo',
                v_parametros.id_numero_celular,
                v_parametros.numero,
                v_parametros.roaming,
                v_parametros.observaciones,
                v_parametros.tipo,
                v_parametros.estado,
                v_parametros.id_cuenta,
                'modificacion',
                v_parametros.id_tipo_cc
              );
            --raise exception 'v_equipoid_equipo %, %',v_equipo.id_equipo, v_parametros.id_equipo;  
            if v_equipo.id_equipo is not null and v_parametros.id_equipo is not null then
              if v_equipo.id_equipo != v_parametros.id_equipo then
                update gecom.tequipo_movil em
                set id_numero_celular = null
                where em.id_equipo = v_equipo.id_equipo
                and em.estado_reg = 'activo';
                
                if v_parametros.id_equipo is not null then
                  update gecom.tequipo_movil em
                  set id_numero_celular = v_parametros.id_numero_celular
                  where em.id_equipo = v_parametros.id_equipo
                  and em.estado_reg = 'activo';
                end if;
              end if; 
            else
            
            	if v_equipo.id_equipo is null and v_parametros.id_equipo is not null  then
                	update gecom.tequipo_movil em
                    set id_numero_celular = v_parametros.id_numero_celular
                    where em.id_equipo = v_parametros.id_equipo
                    and em.estado_reg = 'activo';
                    
                    if v_parametros.estado = 'asignado' then
                        select em.id_equipo,
                                e.tipo,
                                e.marca,
                                e.modelo,
                                e.num_serie,
                                e.estado_fisico,
                                e.estado,
                                fc.id_funcionario,
                                fc.fecha_fin,
                                fc.observaciones
                        into	v_funcionario_equipo     
                        from gecom.tequipo_movil em
                        join gecom.tequipo e on em.id_equipo = e.id_equipo
                        join gecom.tfuncionario_celular fc on em.id_numero_celular = fc.id_numero_celular
                        where em.estado_reg = 'activo'
                        and fc.estado_reg = 'activo'
                        and em.id_numero_celular = v_parametros.id_numero_celular;
                        
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
                          tipo_asignacion_equipo
                        ) VALUES (
                          p_id_usuario,
                          now(),
                          'activo',
                          v_funcionario_equipo.id_funcionario,
                          now(),
                          v_funcionario_equipo.fecha_fin,
                          v_funcionario_equipo.observaciones,
                          v_funcionario_equipo.id_equipo,
                          'equipo'
                        )RETURNING id_funcionario_celular into v_id_funcionario_celular;
                        
                        UPDATE gecom.tequipo e 
                        set estado = 'asignado'
                        where e.id_equipo = v_funcionario_equipo.id_equipo;
                        
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
                          v_funcionario_equipo.id_equipo,
                          v_funcionario_equipo.tipo,
                          v_funcionario_equipo.marca,
                          v_funcionario_equipo.modelo,
                          v_funcionario_equipo.num_serie,
                          v_funcionario_equipo.estado_fisico,
                          v_funcionario_equipo.estado,
                          v_funcionario_equipo.observaciones,
                          'asignacion',
                          v_id_funcionario_celular
                        );
                    end if;
                end if;
                
            	if v_equipo.id_equipo is not null and v_parametros.id_equipo is null then
                	update gecom.tequipo_movil em
                    set id_numero_celular = null
                    where em.id_equipo = v_equipo.id_equipo
                    and em.estado_reg = 'activo';
                end if;
            end if;
             
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Numeros de Celular modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_numero_celular',v_parametros.id_numero_celular::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'GC_NUMCEL_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		jrivera	
 	#FECHA:		23-07-2014 22:43:16
	***********************************/

	elsif(p_transaccion='GC_NUMCEL_ELI')then

		begin
        	select nc.* into v_numero_celular 
            from gecom.tnumero_celular nc 
            where nc.id_numero_celular = v_parametros.id_numero_celular;
			--Sentencia de la eliminacion
			update gecom.tnumero_celular
            set estado_reg = 'inactivo'
            where id_numero_celular=v_parametros.id_numero_celular;
            
            INSERT INTO gecom.tnumero_celular_historico
              (
                id_usuario_reg,
                fecha_reg,
                estado_reg,
                id_numero_celular,
                numero,
                roaming,
                observaciones,
                tipo,
                estado,
                id_cuenta,
                operacion,
            	id_tipo_cc
              )
              VALUES (
                p_id_usuario,
                now(),
                'activo',
                v_parametros.id_numero_celular,
                v_numero_celular.numero,
                v_numero_celular.roaming,
                v_numero_celular.observaciones,
                v_numero_celular.tipo,
                v_numero_celular.estado,
                v_numero_celular.id_cuenta,
                'eliminacion',
                v_numero_celular.id_tipo_cc
              );
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Numeros de Celular eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_numero_celular',v_parametros.id_numero_celular::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
         
	else
     
    	raise exception 'Transaccion inexistente: %',p_transaccion;

	end if;

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
