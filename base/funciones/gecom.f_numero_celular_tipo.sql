CREATE OR REPLACE FUNCTION gecom.f_numero_celular_tipo (
  p_id_funcionario integer,
  p_id_cargp integer,
  p_tipo varchar,
  p_observacion varchar
)
RETURNS varchar AS
$body$
DECLARE
  	v_numero    		varchar;
	v_id_funcionario	integer;
	v_nombre_funcion   	text;
	v_resp				varchar;
BEGIN
  	v_nombre_funcion = 'gecom.f_numero_celular_tipo';

    select ce.id_funcionario
    into
    v_id_funcionario
    from gecom.tfuncionario_celular ce
    where ce.id_funcionario = p_id_funcionario;

if v_id_funcionario = p_id_funcionario then
    select 	pxp.aggarray(nu.numero)
    		into
            v_numero
            from  gecom.tnumero_celular nu
            inner join gecom.tfuncionario_celular c on c.id_numero_celular = nu.id_numero_celular
            where	c.id_funcionario = p_id_funcionario
                    and nu.tipo = p_tipo
                    and c.estado_reg = 'activo'
                   	and c.fecha_fin is null;
else
            select 	pxp.aggarray(nu.numero)
    		into
            v_numero
            from  gecom.tnumero_celular nu
            inner join gecom.tfuncionario_celular c on c.id_numero_celular = nu.id_numero_celular
            where	c.id_cargo = p_id_cargp
                    and nu.tipo = p_tipo
                    and c.estado_reg = 'activo'
                   	and c.fecha_fin is null
                    and c.observaciones::VARCHAR = p_observacion;
end if;

            return v_numero;


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