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
			id_proveedor,
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
			tipo
          	) values(
			v_parametros.id_proveedor,
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
			v_parametros.tipo
							
			
			
			)RETURNING id_numero_celular into v_id_numero_celular;
            
            for v_registros in (select * from gecom.tservicio s 
            					where s.defecto = 'si' and 
                                	id_proveedor = v_parametros.id_proveedor) loop
            	insert into gecom.tnumero_servicio (id_usuario_reg,id_servicio,id_numero_celular,fecha_inicio)
                values(p_id_usuario,v_registros.id_servicio, v_id_numero_celular, now());
            end loop;
			
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
			--Sentencia de la modificacion
			update gecom.tnumero_celular set
			id_proveedor = v_parametros.id_proveedor,
			numero = v_parametros.numero,
			observaciones = v_parametros.observaciones,
			roaming = v_parametros.roaming,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
			tipo = v_parametros.tipo
			where id_numero_celular=v_parametros.id_numero_celular;
               
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
			--Sentencia de la eliminacion
			delete from gecom.tnumero_celular
            where id_numero_celular=v_parametros.id_numero_celular;
               
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
COST 100;