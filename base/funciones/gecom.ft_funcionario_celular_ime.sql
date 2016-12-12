CREATE OR REPLACE FUNCTION "gecom"."ft_funcionario_celular_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

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
        
        	if (exists (	select 1 
        					from gecom.tfuncionario_celular
        					where estado_reg = 'activo' and id_numero_celular = v_parametros.id_numero_celular and 
        						fecha_inicio <= v_parametros.fecha_inicio and 
        						(fecha_fin is null or fecha_fin >= v_parametros.fecha_inicio) ))then
        			raise exception 'El nro se encuentra asignado a otro empleado en este momento. Porfavor revise las asignaciones para este numero';				
        	end if;
        	--Sentencia de la insercion
        	insert into gecom.tfuncionario_celular(
			id_numero_celular,
			id_funcionario,
			id_cargo,
			fecha_inicio,
			estado_reg,
			fecha_fin,
			observaciones,
			id_usuario_ai,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_mod,
			fecha_mod,
              tipo_asignacion
          	) values(
			v_parametros.id_numero_celular,
			v_parametros.id_funcionario,
			v_parametros.id_cargo,
			v_parametros.fecha_inicio,
			'activo',
			v_parametros.fecha_fin,
			v_parametros.observaciones,
			v_parametros._id_usuario_ai,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			null,
			null,
      v_parametros.tipo_asignacion
							
			
			
			)RETURNING id_funcionario_celular into v_id_funcionario_celular;
			
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
			--Sentencia de la modificacion
			update gecom.tfuncionario_celular set
			id_numero_celular = v_parametros.id_numero_celular,
			id_funcionario = v_parametros.id_funcionario,
			id_cargo = v_parametros.id_cargo,
			fecha_inicio = v_parametros.fecha_inicio,
			fecha_fin = v_parametros.fecha_fin,
			observaciones = v_parametros.observaciones,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
      tipo_asignacion = v_parametros.tipo_asignacion
			where id_funcionario_celular=v_parametros.id_funcionario_celular;
               
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "gecom"."ft_funcionario_celular_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
