CREATE OR REPLACE FUNCTION gecom.ft_consumo_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Gestión de Comunicación
 FUNCION: 		gecom.ft_consumo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'gecom.tconsumo'
 AUTOR: 		 (jrivera)
 FECHA:	        24-07-2014 19:17:04
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
	v_id_consumo	integer;
	v_id_numero_celular		integer;
			    
BEGIN

    v_nombre_funcion = 'gecom.ft_consumo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'GC_CON_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		jrivera	
 	#FECHA:		24-07-2014 19:17:04
	***********************************/

	if(p_transaccion='GC_CON_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into gecom.tconsumo(
			id_numero_celular,
			id_periodo,
			id_gestion,
			id_servicio,
			estado_reg,
			observaciones,
			consumo,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.id_numero_celular,
			v_parametros.id_periodo,
			v_parametros.id_gestion,
			v_parametros.id_servicio,
			'activo',
			v_parametros.observaciones,
			v_parametros.consumo,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_consumo into v_id_consumo;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Consumo por Número almacenado(a) con exito (id_consumo'||v_id_consumo||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_consumo',v_id_consumo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'GC_CON_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		jrivera	
 	#FECHA:		24-07-2014 19:17:04
	***********************************/

	elsif(p_transaccion='GC_CON_MOD')then

		begin
			--Sentencia de la modificacion
			update gecom.tconsumo set
			id_numero_celular = v_parametros.id_numero_celular,
			id_periodo = v_parametros.id_periodo,
			id_gestion = v_parametros.id_gestion,
			id_servicio = v_parametros.id_servicio,
			observaciones = v_parametros.observaciones,
			consumo = v_parametros.consumo,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_consumo=v_parametros.id_consumo;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Consumo por Número modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_consumo',v_parametros.id_consumo::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;
		
	/*********************************    
 	#TRANSACCION:  'GC_CONCSV_UPD'
 	#DESCRIPCION:	Modificacion consumo valor csv
 	#AUTOR:		admin	
 	#FECHA:		27-01-2014 04:53:54
	***********************************/

	elsif(p_transaccion='GC_CONCSV_UPD')then

		begin
			
            
             /*obtener id_numero_celular*/
            select id_numero_celular
            into v_id_numero_celular
            from gecom.tnumero_celular
            where numero = v_parametros.numero;
            
            
            if (v_id_numero_celular is null) then
            	raise exception 'No se encontro un numero de celular : %', v_parametros.numero;
            end if;
            
            --elimina el consumo si existiera
            delete from gecom.tconsumo
            where id_gestion=v_parametros.id_gestion and
            id_periodo = v_parametros.id_periodo and id_numero_celular = v_id_numero_celular
            and id_servicio is null;            
            
            --Sentencia de la insercion
        	insert into gecom.tconsumo(
			id_numero_celular,
			id_periodo,
			id_gestion,
			id_servicio,
			estado_reg,
			observaciones,
			consumo,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_id_numero_celular,
			v_parametros.id_periodo,
			v_parametros.id_gestion,
			NULL,
			'activo',
			NULL,
			v_parametros.monto,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			v_parametros._id_usuario_ai,
			null,
			null			
			
			)RETURNING id_consumo into v_id_consumo;			
			
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Consumo modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_consumo',v_id_consumo::varchar);            
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'GC_CON_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		jrivera	
 	#FECHA:		24-07-2014 19:17:04
	***********************************/

	elsif(p_transaccion='GC_CON_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from gecom.tconsumo
            where id_consumo=v_parametros.id_consumo;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Consumo por Número eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_consumo',v_parametros.id_consumo::varchar);
              
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
