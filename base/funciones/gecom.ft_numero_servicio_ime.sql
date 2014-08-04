CREATE OR REPLACE FUNCTION "gecom"."ft_numero_servicio_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Gestión de Comunicación
 FUNCION: 		gecom.ft_numero_servicio_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.tnumero_servicio'
 AUTOR: 		 (jrivera)
 FECHA:	        01-08-2014 23:15:28
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
	v_id_numero_servicio	integer;
			    
BEGIN

    v_nombre_funcion = 'gecom.ft_numero_servicio_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'GC_NUMSER_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		jrivera	
 	#FECHA:		01-08-2014 23:15:28
	***********************************/

	if(p_transaccion='GC_NUMSER_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into gecom.tnumero_servicio(
			id_numero_celular,
			id_servicio,
			observaciones,
			estado_reg,
			fecha_inicio,
			fecha_fin,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.id_numero_celular,
			v_parametros.id_servicio,
			v_parametros.observaciones,
			'activo',
			v_parametros.fecha_inicio,
			v_parametros.fecha_fin,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_numero_servicio into v_id_numero_servicio;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Numero de Servicio almacenado(a) con exito (id_numero_servicio'||v_id_numero_servicio||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_numero_servicio',v_id_numero_servicio::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'GC_NUMSER_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		jrivera	
 	#FECHA:		01-08-2014 23:15:28
	***********************************/

	elsif(p_transaccion='GC_NUMSER_MOD')then

		begin
			--Sentencia de la modificacion
			update gecom.tnumero_servicio set
			id_numero_celular = v_parametros.id_numero_celular,
			id_servicio = v_parametros.id_servicio,
			observaciones = v_parametros.observaciones,
			fecha_inicio = v_parametros.fecha_inicio,
			fecha_fin = v_parametros.fecha_fin,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_numero_servicio=v_parametros.id_numero_servicio;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Numero de Servicio modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_numero_servicio',v_parametros.id_numero_servicio::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'GC_NUMSER_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		jrivera	
 	#FECHA:		01-08-2014 23:15:28
	***********************************/

	elsif(p_transaccion='GC_NUMSER_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from gecom.tnumero_servicio
            where id_numero_servicio=v_parametros.id_numero_servicio;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Numero de Servicio eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_numero_servicio',v_parametros.id_numero_servicio::varchar);
              
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
ALTER FUNCTION "gecom"."ft_numero_servicio_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
