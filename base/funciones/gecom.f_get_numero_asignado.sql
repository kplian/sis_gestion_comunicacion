CREATE OR REPLACE FUNCTION gecom.f_get_numero_asignado (
  p_tipo varchar,
  p_id_funcionario integer
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Gestión de Comunicación
 FUNCION: 		gecom.f_get_numero_asignado
 DESCRIPCION:   Funcion que recupera el numero asignado a un funcionario.
 AUTOR: 		(franklin.espinoza)
 FECHA:	        14-06-2019 15:15:26
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:
 AUTOR:
 FECHA:
***************************************************************************/

DECLARE

	v_resp		            varchar='';
	v_nombre_funcion        text;
	v_record 				record;
	v_numeros				varchar = '';
BEGIN

    v_nombre_funcion = 'gecom.f_get_numero_asignado';

    select tnc.numero
    into v_numeros
    from gecom.tfuncionario_celular tfc
    inner join gecom.tnumero_celular tnc on tnc.id_numero_celular = tfc.id_numero_celular
    where tfc.id_funcionario = p_id_funcionario and  tnc.tipo = p_tipo and tfc.estado_reg = 'activo';

    RETURN coalesce(v_numeros, 'N/E');

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