CREATE OR REPLACE FUNCTION gecom.ft_servicio_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Gestión de Comunicación
 FUNCION: 		gecom.ft_servicio_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.tservicio'
 AUTOR: 		 (jrivera)
 FECHA:	        23-07-2014 22:43:19
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
	v_id_servicio	integer;
			    
BEGIN

    v_nombre_funcion = 'gecom.ft_servicio_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'GC_SER_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		jrivera	
 	#FECHA:		23-07-2014 22:43:19
	***********************************/

	if(p_transaccion='GC_SER_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into gecom.tservicio(
			id_proveedor,
			trafico_adicional,
			tarifa,
			estado_reg,
			nombre_servicio,
			observaciones,
			codigo_servicio,
			trafico_libre,
			fecha_reg,
			usuario_ai,
			id_usuario_reg,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod,
            defecto,
            tipo_servicio
          	) values(
			v_parametros.id_proveedor,
			v_parametros.trafico_adicional,
			v_parametros.tarifa,
			'activo',
			v_parametros.nombre_servicio,
			v_parametros.observaciones,
			v_parametros.codigo_servicio,
			v_parametros.trafico_libre,
			now(),
			v_parametros._nombre_usuario_ai,
			p_id_usuario,
			v_parametros._id_usuario_ai,
			null,
			null,
			v_parametros.defecto,
			v_parametros.tipo_servicio
			)RETURNING id_servicio into v_id_servicio;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Servicio almacenado(a) con exito (id_servicio'||v_id_servicio||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_servicio',v_id_servicio::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'GC_SER_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		jrivera	
 	#FECHA:		23-07-2014 22:43:19
	***********************************/

	elsif(p_transaccion='GC_SER_MOD')then

		begin
			--Sentencia de la modificacion
			update gecom.tservicio set
			id_proveedor = v_parametros.id_proveedor,
			trafico_adicional = v_parametros.trafico_adicional,
			tarifa = v_parametros.tarifa,
			nombre_servicio = v_parametros.nombre_servicio,
			observaciones = v_parametros.observaciones,
			codigo_servicio = v_parametros.codigo_servicio,
			trafico_libre = v_parametros.trafico_libre,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
            defecto = v_parametros.defecto,
            tipo_servicio = v_parametros.tipo_servicio
			where id_servicio=v_parametros.id_servicio;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Servicio modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_servicio',v_parametros.id_servicio::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'GC_SER_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		jrivera	
 	#FECHA:		23-07-2014 22:43:19
	***********************************/

	elsif(p_transaccion='GC_SER_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from gecom.tservicio
            where id_servicio=v_parametros.id_servicio;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Servicio eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_servicio',v_parametros.id_servicio::varchar);
              
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
