CREATE OR REPLACE FUNCTION gecom.f_get_numeros_asignados (
  p_tipo varchar,
  p_id_funcionario integer
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Gestión de Comunicación
 FUNCION: 		gecom.f_get_numeros_asignados
 DESCRIPCION:   Funcion que recupera los numero asignado a un funcionario.
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
    v_numero				varchar = '';
    v_contador				integer=0;
BEGIN

    v_nombre_funcion = 'gecom.f_get_numeros_asignados';

    for v_numero in select tnc.numero
                    from gecom.tfuncionario_celular tfc
                    inner join gecom.tnumero_celular tnc on tnc.id_numero_celular = tfc.id_numero_celular
                    where tfc.id_funcionario = p_id_funcionario and  tnc.tipo = p_tipo and
                    tfc.estado_reg = 'activo' and tnc.estado_reg = 'activo' loop
		v_contador = v_contador + 1;
        if v_contador > 1 then
        	v_numeros = v_numeros||' - '||v_numero;
        else
        	v_numeros = v_numero;
        end if;
    end loop;

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