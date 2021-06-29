CREATE OR REPLACE FUNCTION gecom.ft_funcionario_celular_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Gestión de Comunicación
 FUNCION: 		gecom.ft_funcionario_celular_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.tfuncionario_celular'
 AUTOR: 		 (jrivera)
 FECHA:	        24-07-2014 00:10:05
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
	v_id_funcionario_celular	integer;
	v_id_equipo				integer;
    v_id_numero_celular		integer;
    v_equipo				record;
    v_numero				record;
    v_asignar_equipo		boolean;
    v_func_cel				record;
    v_asignar_numero		boolean;
    v_numero_celular		record;
    
    v_id_accesorio			integer;
    v_arr_accesorios     	integer[];
    
    v_id_funcionario_celular_movil integer;
    v_id_funcionario_celular_equipo integer;
BEGIN

    v_nombre_funcion = 'gecom.ft_funcionario_celular_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'GC_FUNCEL_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		jrivera	
 	#FECHA:		24-07-2014 00:10:05
	***********************************/

	if(p_transaccion='GC_FUNCEL_INS')then
					
        begin
        	v_asignar_numero = false;
            v_asignar_equipo = false;
            
        	if (exists (	select 1 
        					from gecom.tfuncionario_celular
        					where estado_reg = 'activo' and id_numero_celular = v_parametros.id_numero_celular and 
        						fecha_inicio <= v_parametros.fecha_inicio and 
        						(fecha_fin is null or fecha_fin >= v_parametros.fecha_inicio) ))then
        			raise exception 'El nro se encuentra asignado a otro empleado en este momento. Porfavor revise las asignaciones para este numero';				
        	end if;
            
            if v_parametros.tipo_asignacion_equipo = 'numero' then
            	v_id_numero_celular = v_parametros.id_numero_celular;
                v_id_equipo = null;
                v_asignar_numero = true;
                
            	select e.* into v_equipo
                from gecom.tnumero_celular nc 
                join gecom.tequipo_movil em on nc.id_numero_celular = em.id_numero_celular 
                join gecom.tequipo e 	on em.id_equipo = e.id_equipo
                where nc.id_numero_celular = v_parametros.id_numero_celular;
                
                if v_equipo.id_equipo is not null then
                	v_asignar_equipo = true;
                    v_id_equipo = v_equipo.id_equipo;
                end if;
            elsif v_parametros.tipo_asignacion_equipo = 'equipo' then
            	v_id_numero_celular = null;
                v_id_equipo = v_parametros.id_equipo;
                v_asignar_equipo = true;
                
            	select e.* into v_equipo
                from gecom.tequipo e where e.id_equipo = v_id_equipo;
                
                if v_equipo.tipo = 'movil' then
            		select em.id_numero_celular, fc.id_funcionario_celular into v_numero_celular
                    from gecom.tequipo_movil em
                    left join gecom.tfuncionario_celular fc on em.id_numero_celular = fc.id_numero_celular and fc.estado_reg = 'activo'
                    where em.id_equipo = v_id_equipo;
                    
                    if v_numero_celular.id_numero_celular is not null and v_numero_celular.id_funcionario_celular is null then
                    	v_asignar_numero = true;
                    end if;
                end if;
            end if;
            
            if v_asignar_numero then
            	INSERT INTO gecom.tfuncionario_celular
                    (
                      id_usuario_reg,
                      fecha_reg,
                      estado_reg,
                      id_funcionario,
                      id_cargo,
                      id_numero_celular,
                      fecha_inicio,
                      fecha_fin,
                      observaciones,
                      codigo_inmovilizado,
                      tipo_asignacion_equipo,
                      tipo_servicio,
                      id_accesorios
                    )
                    VALUES (
                      p_id_usuario,
                      now(),
                      'activo',
                      v_parametros.id_funcionario,
                      v_parametros.id_cargo,
                      v_id_numero_celular,
                      v_parametros.fecha_inicio,
                      v_parametros.fecha_fin,
                      v_parametros.observaciones,
                      v_parametros.codigo_inmovilizado,
                      'numero',
                      v_parametros.tipo_servicio,
                      v_parametros.id_accesorios
                    )RETURNING id_funcionario_celular into v_id_funcionario_celular;
                    
                UPDATE gecom.tnumero_celular n 
                set estado = 'asignado'
                where n.id_numero_celular = v_id_numero_celular;
            end if;
            
            if v_asignar_equipo then
            	INSERT INTO gecom.tfuncionario_celular
                (
                  id_usuario_reg,
                  fecha_reg,
                  estado_reg,
                  id_funcionario,
                  id_cargo,
                  fecha_inicio,
                  fecha_fin,
                  observaciones,
                  id_equipo,
                  codigo_inmovilizado,
                  tipo_asignacion_equipo,
                  id_accesorios
                ) VALUES (
                  p_id_usuario,
                  now(),
                  'activo',
                  v_parametros.id_funcionario,
                  v_parametros.id_cargo,
                  v_parametros.fecha_inicio,
                  v_parametros.fecha_fin,
                  v_parametros.observaciones,
                  v_id_equipo,
                  v_parametros.codigo_inmovilizado,
                  'equipo',
                  v_parametros.id_accesorios
                )RETURNING id_funcionario_celular into v_id_funcionario_celular;
                
                UPDATE gecom.tequipo e 
                set estado = 'asignado'
                where e.id_equipo = v_equipo.id_equipo;
                
                if v_parametros.id_accesorios != '' then
                	select COALESCE(regexp_split_to_array(v_parametros.id_accesorios,','),'{0}') into v_arr_accesorios;
                    FOREACH v_id_accesorio IN ARRAY v_arr_accesorios LOOP
                        UPDATE gecom.taccesorio 
                        SET id_equipo = v_id_equipo
                        WHERE id_accesorio = v_id_accesorio;
                    END LOOP;
                end if;
                
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
            end if;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asignación de Números almacenado(a) con exito (id_funcionario_celular'||v_id_funcionario_celular||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_funcionario_celular',v_id_funcionario_celular::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;
	/*********************************    
 	#TRANSACCION:  'GC_FUNMOV_INS'
 	#DESCRIPCION:	Insercion de registros para equipos moviles
 	#AUTOR:		jrivera	
 	#FECHA:		24-07-2014 00:10:05
	***********************************/

	elsif(p_transaccion='GC_FUNMOV_INS')then
					
        begin
        	v_asignar_numero = false;
            v_asignar_equipo = false;
            
        	if (exists (	select 1 
        					from gecom.tfuncionario_celular
        					where estado_reg = 'activo' and id_numero_celular = v_parametros.id_numero_celular and 
        						fecha_inicio <= v_parametros.fecha_inicio and 
        						(fecha_fin is null or fecha_fin >= v_parametros.fecha_inicio) ))then
        			raise exception 'El nro se encuentra asignado a otro empleado en este momento. Porfavor revise las asignaciones para este numero';				
        	end if;
            
            select e.* into v_equipo
            from gecom.tequipo e 
            join gecom.tequipo_movil em on e.id_equipo = em.id_equipo
            where e.id_equipo = v_parametros.id_equipo;
            
            INSERT INTO gecom.tfuncionario_celular
                (
                  id_usuario_reg,
                  fecha_reg,
                  estado_reg,
                  id_funcionario,
                  id_cargo,
                  id_numero_celular,
                  fecha_inicio,
                  fecha_fin,
                  observaciones,
                  codigo_inmovilizado,
                  tipo_asignacion_equipo,
                  tipo_servicio
                )
                VALUES (
                  p_id_usuario,
                  now(),
                  'activo',
                  v_parametros.id_funcionario,
                  v_parametros.id_cargo,
                  v_parametros.id_numero_celular,
                  v_parametros.fecha_inicio,
                  v_parametros.fecha_fin,
                  v_parametros.observaciones,
                  v_parametros.codigo_inmovilizado,
                  'numero',
                  v_parametros.tipo_servicio
                )RETURNING id_funcionario_celular into v_id_funcionario_celular_movil;
                    
            UPDATE gecom.tnumero_celular n 
            set estado = 'asignado'
            where n.id_numero_celular = v_parametros.id_numero_celular;
            
            INSERT INTO gecom.tfuncionario_celular
                (
                  id_usuario_reg,
                  fecha_reg,
                  estado_reg,
                  id_funcionario,
                  id_cargo,
                  fecha_inicio,
                  fecha_fin,
                  observaciones,
                  id_equipo,
                  codigo_inmovilizado,
                  tipo_asignacion_equipo,
                  tipo_servicio,
                  id_accesorios
                ) VALUES (
                  p_id_usuario,
                  now(),
                  'activo',
                  v_parametros.id_funcionario,
                  v_parametros.id_cargo,
                  v_parametros.fecha_inicio,
                  v_parametros.fecha_fin,
                  v_parametros.observaciones,
                  v_parametros.id_equipo,
                  v_parametros.codigo_inmovilizado,
                  'equipo',
                  v_parametros.tipo_servicio,
                  v_parametros.id_accesorios
              )RETURNING id_funcionario_celular into v_id_funcionario_celular_equipo;
                
              UPDATE gecom.tequipo e 
              set estado = 'asignado'
              where e.id_equipo = v_parametros.id_equipo;
              
              if v_parametros.id_accesorios != '' then
                select regexp_split_to_array(v_parametros.id_accesorios,',') into v_arr_accesorios;
                FOREACH v_id_accesorio IN ARRAY v_arr_accesorios LOOP
                    UPDATE gecom.taccesorio 
                    SET id_equipo = v_parametros.id_equipo
                    WHERE id_accesorio = v_id_accesorio;
                END LOOP;
              end if;
              
              UPDATE gecom.tequipo_movil em 
              set id_numero_celular = v_parametros.id_numero_celular
              where em.id_equipo = v_parametros.id_equipo 
              and em.estado_reg = 'activo' ;
              
              INSERT INTO gecom.tnumero_equipo
              (
                id_usuario_reg,
                fecha_reg,
                estado_reg,
                id_funcionario_celular_numero,
                id_funcionario_celular_equipo
              ) VALUES (
                p_id_usuario,
                now(),
                'activo',
                v_id_funcionario_celular_movil,
                v_id_funcionario_celular_equipo
              );
                
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
                  v_id_funcionario_celular_equipo
                );
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asignación de Números almacenado(a) con exito (id_funcionario_celular'||v_id_funcionario_celular||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_funcionario_celular',v_id_funcionario_celular::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'GC_FUNCEL_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		jrivera	
 	#FECHA:		24-07-2014 00:10:05
	***********************************/

	elsif(p_transaccion='GC_FUNCEL_MOD')then

		begin
        	select fc.* into v_func_cel
            from gecom.tfuncionario_celular fc 
            where fc.id_funcionario_celular = v_parametros.id_funcionario_celular;
            
        	if v_parametros.tipo_asignacion_equipo = 'numero' then
            	v_id_numero_celular = v_parametros.id_numero_celular;
                v_id_equipo = null;
                
                if v_func_cel.id_numero_celular is not null then
                	if v_func_cel.id_numero_celular != v_parametros.id_numero_celular then
                    	update gecom.tnumero_celular nc 
                        set nc.estado = 'activo'
                        where nc.id_numero_celular = v_func_cel.id_numero_celular;
                        
                        update gecom.tnumero_celular nc 
                        set nc.estado = 'asignado'
                        where nc.id_numero_celular = v_parametros.id_numero_celular;
                    end if;
                end if;
                
            elsif v_parametros.tipo_asignacion_equipo = 'equipo' then
            	v_id_numero_celular = null;
                v_id_equipo = v_parametros.id_equipo;
            end if;
            
            if v_parametros.id_accesorios != v_func_cel.id_accesorios and v_func_cel.id_accesorios != '' then
            	select regexp_split_to_array(v_func_cel.id_accesorios,',') into v_arr_accesorios;
                FOREACH v_id_accesorio IN ARRAY v_arr_accesorios LOOP
                	UPDATE gecom.taccesorio 
                    SET id_equipo = null
                    WHERE id_accesorio = v_id_accesorio;
                END LOOP;
            end if;
            
			--Sentencia de la modificacion
			update gecom.tfuncionario_celular set
			id_numero_celular = v_id_numero_celular,
			id_funcionario = v_parametros.id_funcionario,
			id_cargo = v_parametros.id_cargo,
			fecha_inicio = v_parametros.fecha_inicio,
			fecha_fin = v_parametros.fecha_fin,
			observaciones = v_parametros.observaciones,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
            tipo_asignacion_equipo = v_parametros.tipo_asignacion_equipo,
            id_equipo = v_id_equipo,
            codigo_inmovilizado = v_parametros.codigo_inmovilizado,
            tipo_servicio = v_parametros.tipo_servicio,
            id_accesorios = v_parametros.id_accesorios
			where id_funcionario_celular=v_parametros.id_funcionario_celular;
            
            if v_parametros.id_accesorios != v_func_cel.id_accesorios and v_parametros.id_accesorios != '' then
            	v_arr_accesorios = null;
            	select regexp_split_to_array(v_parametros.id_accesorios,',') into v_arr_accesorios;
                FOREACH v_id_accesorio IN ARRAY v_arr_accesorios LOOP
                	UPDATE gecom.taccesorio 
                    SET id_equipo = v_id_equipo
                    WHERE id_accesorio = v_id_accesorio;
                END LOOP;
            end if;
            
            if v_parametros.tipo_asignacion_equipo = 'numero' then
            	select e.* into v_equipo
                from gecom.tnumero_celular nc 
                join gecom.tequipo_movil em on nc.id_numero_celular = em.id_numero_celular 
                join gecom.tequipo e 	on em.id_equipo = e.id_equipo
                where nc.id_numero_celular = v_parametros.id_numero_celular;
                
                if v_equipo is not null then
                	v_asignar_equipo = true;
                end if;
            elsif v_parametros.tipo_asignacion_equipo = 'equipo' then
            	select e.* into v_equipo
                from gecom.tequipo e where e.id_equipo = v_id_equipo;
                
                v_asignar_equipo = true;
            end if;
            
            if v_asignar_equipo then
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
                )
                VALUES (
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
                  'modificacion',
                  v_parametros.id_funcionario_celular
                );
            end if;
            
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asignación de Números modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_funcionario_celular',v_parametros.id_funcionario_celular::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'GC_FUNCEL_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		jrivera	
 	#FECHA:		24-07-2014 00:10:05
	***********************************/

	elsif(p_transaccion='GC_FUNCEL_ELI')then

		begin
			--Sentencia de la eliminacion
			update gecom.tfuncionario_celular
			set estado_reg = 'inactivo'
            where id_funcionario_celular=v_parametros.id_funcionario_celular;
            
            select fc.tipo_asignacion_equipo, fc.id_numero_celular, fc.id_equipo into v_func_cel
            from gecom.tfuncionario_celular fc where fc.id_funcionario_celular = v_parametros.id_funcionario_celular;
            
            if v_func_cel.tipo_asignacion_equipo = 'numero' then
            	select e.* into v_equipo
                from gecom.tnumero_celular nc 
                join gecom.tequipo_movil em on nc.id_numero_celular = em.id_numero_celular 
                join gecom.tequipo e 	on em.id_equipo = e.id_equipo
                where nc.id_numero_celular = v_func_cel.id_numero_celular;
                
                if v_equipo is not null then
                	v_asignar_equipo = true;
                end if;
                
                UPDATE gecom.tnumero_celular n 
                set estado = 'activo'
                where n.id_numero_celular = v_func_cel.id_numero_celular;
                
            elsif v_func_cel.tipo_asignacion_equipo = 'equipo' then
            	select e.* into v_equipo
                from gecom.tequipo e where e.id_equipo = v_func_cel.id_equipo;
                
                v_asignar_equipo = true;
            end if;
            
            if v_asignar_equipo then
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
                )
                VALUES (
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
                  v_equipo.observaciones,
                  'eliminacion',
                  v_parametros.id_funcionario_celular
                );
            end if;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asignación de Números eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_funcionario_celular',v_parametros.id_funcionario_celular::varchar);
              
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
