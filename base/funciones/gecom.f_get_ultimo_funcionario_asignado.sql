CREATE OR REPLACE FUNCTION gecom.f_get_ultimo_funcionario_asignado (
  p_id_numero_celular integer,
  p_id_periodo integer
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Gestión de Comunicación
 FUNCION: 		gecom.f_get_ultimo_funcionario_asignado
 DESCRIPCION:   Funcion que devuelve id_funcionario con un numero de celular asignado
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

	v_periodo    		record;
	v_id_funcionario	integer;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'gecom.f_get_ultimo_funcionario_asignado';
    select per.* into v_periodo
    from param.tperiodo per
    where id_periodo = p_id_periodo;
    	
	select id_funcionario into v_id_funcionario
	from gecom.tfuncionario_celular fc
	where fc.fecha_inicio <= v_periodo.fecha_fin and (fc.fecha_fin >= v_periodo.fecha_ini or fc.fecha_fin is null)
	and fc.estado_reg = 'activo' and fc.id_numero_celular = p_id_numero_celular
	order by fc.fecha_inicio desc limit 1;

	return v_id_funcionario;
					
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