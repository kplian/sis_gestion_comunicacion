CREATE OR REPLACE FUNCTION gecom.ft_equipo_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestión de Comunicación
 FUNCION:         gecom.ft_equipo_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'gecom.tequipo'
 AUTOR:          (ymedina)
 FECHA:            06-05-2021 16:01:48
 COMENTARIOS:    
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                06-05-2021 16:01:48    ymedina             Creacion    
 #
 ***************************************************************************/

DECLARE

    v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;
    v_id_funcionario_celular integer;
                 
BEGIN

    v_nombre_funcion = 'gecom.ft_equipo_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'GC_EQU_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        ymedina    
     #FECHA:        06-05-2021 16:01:48
    ***********************************/

    IF (p_transaccion='GC_EQU_SEL') THEN
                     
        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        equ.id_equipo,
                        equ.estado_fisico,
                        equ.observaciones,
                        equ.marca,
                        equ.tipo,
                        case
                        	when equ.tipo in (''movil'',''dongle'',''gps'',''centel'') then
                            	(select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = equ.tipo and ct.tabla = ''tequipo'' and ct.nombre = ''tipo_equipo_movil'')
                            else
                            	(select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = equ.tipo and ct.tabla = ''tequipo'' and ct.nombre = ''tipo_equipo'')
                        end::varchar AS tipo_desc,
                        equ.modelo,
                        equ.estado,
                        equ.estado_reg,
                        equ.num_serie,
                        equ.id_usuario_ai,
                        equ.fecha_reg,
                        equ.usuario_ai,
                        equ.id_usuario_reg,
                        equ.fecha_mod,
                        equ.id_usuario_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        em.id_equipo_movil,
                        em.color,
                        em.imei,
                        em.sn,
                        ep.id_equipo_pc,
                        ep.tamano_pantalla,
                        ep.tarjeta_video,
                        ep.teclado,
                        ep.procesador,
                        ep.memoria_ram,
                        ep.almacenamiento,
                        ep.sistema_operativo,
                        ep.accesorios,
                        ((select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = equ.tipo and ct.tabla = ''tequipo'' and ct.nombre = ''tipo_equipo'') ||'' ''|| equ.marca ||'' ''|| equ.modelo)::varchar  as nombre,
                        numcel.id_numero_celular,
                        numcel.numero,
                        em.gama,
                        (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = em.gama and ct.tabla = ''tequipo'' and ct.nombre = ''tipo_gama'') AS gama_desc,
                        em.imei2,
                        em.tipo_servicio,
                        (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = em.tipo_servicio and ct.tabla = ''tservicio'' and ct.nombre = ''tipo_servicio'') AS tipo_servicio_desc,
                        ep.teclado_idioma,
                        ep.mac,
                        (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = equ.marca and ct.tabla = ''tequipo'' and ct.nombre = ''marca'')::varchar AS marca_desc,
                        (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = equ.estado_fisico and ct.tabla = ''tequipo'' and ct.nombre = ''estado_fisico'')::varchar AS estado_fisico_desc,
                        (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = ep.tamano_pantalla and ct.tabla = ''tequipo'' and ct.nombre = ''pantalla'')::varchar AS tamano_pantalla_desc,
                        (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = ep.teclado and ct.tabla = ''tequipo'' and ct.nombre = ''teclado'')::varchar AS teclado_desc,
                        (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = ep.teclado_idioma and ct.tabla = ''tequipo'' and ct.nombre = ''teclado_idioma'')::varchar AS teclado_idioma_desc,          
                        ep.tipo_memoria_ram,
                        (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = ep.tipo_memoria_ram and ct.tabla = ''tequipo'' and ct.nombre = ''ram'')::varchar AS tipo_memoria_ram_desc,
                        ep.tipo_almacenamiento,
                        (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = ep.tipo_almacenamiento and ct.tabla = ''tequipo'' and ct.nombre = ''almacenamiento'')::varchar AS tipo_almacenamiento_desc,
                        (select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = ep.sistema_operativo and ct.tabla = ''tequipo'' and ct.nombre = ''so'')::varchar AS sistema_operativo_desc
                        FROM gecom.tequipo equ
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = equ.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = equ.id_usuario_mod
                        LEFT JOIN gecom.tequipo_movil em ON equ.id_equipo = em.id_equipo
                        LEFT JOIN gecom.tequipo_pc ep ON equ.id_equipo = ep.id_equipo
                        LEFT JOIN gecom.tnumero_celular numcel ON em.id_numero_celular = numcel.id_numero_celular
                        WHERE  ';
  
  
            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;
                        
        END;

    /*********************************    
     #TRANSACCION:  'GC_EQU_CONT'
     #DESCRIPCION:    Conteo de registros
     #AUTOR:        ymedina    
     #FECHA:        06-05-2021 16:01:48
    ***********************************/

    ELSIF (p_transaccion='GC_EQU_CONT') THEN

        BEGIN
        
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(equ.id_equipo)
                         FROM gecom.tequipo equ
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = equ.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = equ.id_usuario_mod
                         LEFT JOIN gecom.tequipo_movil em ON equ.id_equipo = em.id_equipo
                         LEFT JOIN gecom.tequipo_pc ep ON equ.id_equipo = ep.id_equipo
                         LEFT JOIN gecom.tnumero_celular numcel ON em.id_numero_celular = numcel.id_numero_celular
                         WHERE ';
            
            --Definicion de la respuesta            
            v_consulta:=v_consulta||v_parametros.filtro;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;
    
    /*********************************    
     #TRANSACCION:  'GC_EQUCMB_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        ymedina    
     #FECHA:        06-05-2021 16:01:48
    ***********************************/

    ELSIF (p_transaccion='GC_EQUCMB_SEL') THEN
                     
        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT equ.* 
                          from (select
                                equ.id_equipo,
                                (CASE
                                    WHEN equ.tipo in (''movil'',''dongle'',''gps'',''centel'') THEN 
                                        (select c.descripcion
                                          from param.tcatalogo c
                                          LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                          WHERE c.codigo = equ.tipo and ct.tabla = ''tequipo'' and ct.nombre = ''tipo_equipo_movil'')
                                    ELSE 
                                        (select c.descripcion
                                          from param.tcatalogo c
                                          LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                          WHERE c.codigo = equ.tipo and ct.tabla = ''tequipo'' and ct.nombre = ''tipo_equipo'')
                                 END
                                 ||'' ''|| equ.marca ||'' ''|| equ.modelo ||'' - ''|| equ.num_serie     
                                 )::varchar  as nombre,
                                equ.estado,
                                equ.tipo,
                                em.id_numero_celular,
                                em.tipo_servicio
                                FROM gecom.tequipo equ
                                LEFT JOIN gecom.tequipo_movil em ON equ.id_equipo = em.id_equipo
                                LEFT JOIN gecom.tequipo_pc ep ON equ.id_equipo = ep.id_equipo 
                          ) as equ
                          WHERE equ.estado = ''disponible'' and ';
  
  
            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;
                        
        END;

    /*********************************    
     #TRANSACCION:  'GC_EQUCMB_CONT'
     #DESCRIPCION:    Conteo de registros
     #AUTOR:        ymedina    
     #FECHA:        06-05-2021 16:01:48
    ***********************************/

    ELSIF (p_transaccion='GC_EQUCMB_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:=' SELECT COUNT(equ.id_equipo) from (select
                        equ.id_equipo,
                        (CASE
                                    WHEN equ.tipo in (''movil'',''dongle'',''gps'',''centel'') THEN 
                                        (select c.descripcion
                                          from param.tcatalogo c
                                          LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                          WHERE c.codigo = equ.tipo and ct.tabla = ''tequipo'' and ct.nombre = ''tipo_equipo_movil'')
                                    ELSE 
                                        (select c.descripcion
                                          from param.tcatalogo c
                                          LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                          WHERE c.codigo = equ.tipo and ct.tabla = ''tequipo'' and ct.nombre = ''tipo_equipo'')
                                 END
                                 ||'' ''|| equ.marca ||'' ''|| equ.modelo ||'' - ''|| equ.num_serie     
                                 )::varchar  as nombre,
                        equ.estado,
                        equ.tipo,
                        em.id_numero_celular,
                        em.tipo_servicio
                        FROM gecom.tequipo equ
                        LEFT JOIN gecom.tequipo_movil em ON equ.id_equipo = em.id_equipo
                        LEFT JOIN gecom.tequipo_pc ep ON equ.id_equipo = ep.id_equipo ) as equ
                        WHERE equ.estado = ''disponible'' and 
                         ';
            
            --Definicion de la respuesta            
            v_consulta:=v_consulta||v_parametros.filtro;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;
    
    /*********************************
 	#TRANSACCION:  'GC_TIPREP_SEL'
 	#DESCRIPCION:	Consulta de datos para reporte
 	#AUTOR:		Yamil Medina
 	#FECHA:		07-05-2021 10:10:19
	***********************************/

	elsif(p_transaccion='GC_TIPREP_SEL')then

    	begin
    		--Sentencia de la consulta
			v_consulta:= 'select e.id_equipo,
            					 e.tipo,
                                 e.marca,
                                 e.modelo,
                                 e.estado_fisico,
                                 e.estado,
                                 e.observaciones,
                                 em.color,
                                 em.imei,
                                 ep.tamano_pantalla,
                                 ep.tarjeta_video,
                                 ep.teclado,
                                 ep.procesador,
                                 ep.memoria_ram,
                                 ep.almacenamiento,
                                 ep.sistema_operativo,
                                 ep.accesorios,
                                 vp.desc_funcionario1::varchar as fnombre,
                                 vp.ci::varchar                as fci,
                                 vp.codigo::varchar            as fcodigo,
                                 vp.email_empresa::varchar     as femail_empresa
                            from gecom.tequipo e
                            left join gecom.tequipo_movil em on e.id_equipo = em.id_equipo
                            left join gecom.tequipo_pc ep on e.id_equipo = ep.id_equipo
                            left join gecom.tfuncionario_celular fc on e.id_equipo = fc.id_equipo
                             and fc.estado_reg = ''activo''
                            left join orga.vfuncionario_persona vp on fc.id_funcionario = vp.id_funcionario
                           where e.tipo = '''||v_parametros.tipo||''' ';

            --v_consulta:=v_consulta||' order by d.id_institucion, d.id_deuda, d.monto_solicitado, p.fecha ';
			v_consulta:=v_consulta||' order by e.tipo, e.estado ';
            
			--Devuelve la respuesta
			return v_consulta;

		end;
        
    /*********************************
 	#TRANSACCION:  'GC_TIPRFUN_SEL'
 	#DESCRIPCION:	Consulta de datos para reporte
 	#AUTOR:		Yamil Medina
 	#FECHA:		07-05-2021 10:10:19
	***********************************/

	elsif(p_transaccion='GC_TIPRFUN_SEL')then

    	begin
    		--Sentencia de la consulta
			v_consulta:= 'select e.id_equipo,
                                 e.tipo,
                                 (select c.descripcion
                                    from param.tcatalogo c
                                    LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                    WHERE c.codigo = e.marca and ct.tabla = ''tequipo'' and ct.nombre = ''marca'')::varchar as marca,
                                 e.modelo,
                                 e.estado_fisico,
                                 e.estado,
                                 e.observaciones,
                                 em.color,
                                 em.imei,
                                 ep.tamano_pantalla,
                                 ep.tarjeta_video,
                                 ep.teclado,
                                 ep.procesador,
                                 (ep.memoria_ram ||'' GB ''|| (select c.descripcion
                                                            from param.tcatalogo c
                                                            LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                                            WHERE c.codigo = ep.tipo_memoria_ram and ct.tabla = ''tequipo'' and ct.nombre = ''ram''))::varchar as memoria_ram,
                                 (ep.almacenamiento ||'' GB ''|| (select c.descripcion
                                                            from param.tcatalogo c
                                                            LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                                            WHERE c.codigo = ep.tipo_almacenamiento and ct.tabla = ''tequipo'' and ct.nombre = ''almacenamiento''))::varchar as almacenamiento,
                                 (select c.descripcion
                                    from param.tcatalogo c
                                    LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                    WHERE c.codigo = ep.sistema_operativo and ct.tabla = ''tequipo'' and ct.nombre = ''so'')::varchar as sistema_operativo,
                                 (SELECT  array_to_string(array_agg(ac.resumen), '' | ''::text)::character varying
                                   from 
                                   (select ac.*,
                                           (ac.nombre||'' ''||ac.marca||'' ''||ac.modelo||'' - ''||ac.num_serie)::varchar as resumen
                                    from gecom.taccesorio ac) as ac
                                   where ac.id_accesorio  in ( SELECT element::integer
                                                                  FROM UNNEST( string_to_array(fc.id_accesorios,'',''))
                                                                  as element)
                                   ) as accesorios,
                                 vp.desc_funcionario1::varchar as fnombre,
                                 vp.ci::varchar                as fci,
                                 vp.codigo::varchar            as fcodigo,
                                 vp.email_empresa::varchar     as femail_empresa,
                                 fc.estado_reg,
                                 case
                                  when e.tipo in (''movil'',''dongle'',''gps'',''centel'') then
                                      (select c.descripcion
                                        from param.tcatalogo c
                                        LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                        WHERE c.codigo = e.tipo and ct.tabla = ''tequipo'' and ct.nombre = ''tipo_equipo_movil'')
                                  else
                                      (select c.descripcion
                                        from param.tcatalogo c
                                        LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                        WHERE c.codigo = e.tipo and ct.tabla = ''tequipo'' and ct.nombre = ''tipo_equipo'')
                              	end::varchar AS tipo_desc,
                                ep.teclado_idioma
                            from gecom.tequipo e
                            left join gecom.tequipo_movil em on e.id_equipo = em.id_equipo
                            left join gecom.tequipo_pc ep on e.id_equipo = ep.id_equipo
                            left join gecom.tfuncionario_celular fc on e.id_equipo = fc.id_equipo
                            left join orga.vfuncionario_persona vp on fc.id_funcionario = vp.id_funcionario
                           where fc.id_funcionario = '||v_parametros.id_funcionario||' ';

            --v_consulta:=v_consulta||' order by d.id_institucion, d.id_deuda, d.monto_solicitado, p.fecha ';
			v_consulta:=v_consulta||' order by fc.estado_reg, e.tipo, e.estado ';
            
			--Devuelve la respuesta
			return v_consulta;

		end;    
    
    /*********************************
 	#TRANSACCION:  'GC_TIPASI_SEL'
 	#DESCRIPCION:	Consulta de datos para reporte asignacion
 	#AUTOR:		Yamil Medina
 	#FECHA:		07-05-2021 10:10:19
	***********************************/

	elsif(p_transaccion='GC_TIPASI_SEL')then

    	begin
        	if exists (select 1
                         from gecom.tfuncionario_celular fc
                         where fc.id_funcionario_celular = v_parametros.id_funcionario_celular
                         and fc.tipo_asignacion_equipo = 'numero') then
                         
               select ne.id_funcionario_celular_equipo into v_id_funcionario_celular
               from gecom.tnumero_equipo ne 
               where ne.id_funcionario_celular_numero = v_parametros.id_funcionario_celular
               order by ne.fecha_reg desc LIMIT 1;
            	 
            else
            	v_id_funcionario_celular = v_parametros.id_funcionario_celular;
            end if;
        	
    		--Sentencia de la consulta
			v_consulta:= ' select f.desc_funcionario1::varchar as solicitante,
                           nc.numero,
                           e.marca,
                           e.modelo,
                           e.num_serie,
                           em.imei,
                           e.estado_fisico,
                           e.observaciones,
                           ''cables''::varchar as accesorios,
                           pro.desc_proveedor as telco,
                           cp.nro_cuenta as cuenta_telco,
                           (tcc.descripcion || '' - '' || tcc.codigo)::varchar as cuenta_gasto,
                           (p.nombre || '' '' || p.apellido_paterno || '' '' || p.apellido_materno)::varchar as asignador,
                           fc.fecha_inicio as fecha_entrega,
                           ( select array_to_string(array_agg(ac.resumen), ''<br>'' ::text) ::character varying
                                from (select ac.*,
                                             (ac.nombre || '' '' || ac.marca || '' '' || ac.modelo ||'' - '' || ac.num_serie) ::varchar as resumen
                                        from gecom.taccesorio ac) as ac
                               where ac.id_accesorio in
                                     (SELECT element ::integer
                                        FROM UNNEST(string_to_array(fc.id_accesorios, '','')) as element)) as accesorios2,
                           fc.estado_reg as estado_equipo,
                           fcn.estado_reg as estado_numero             
                      from gecom.tfuncionario_celular fc
                      join orga.vfuncionario f on fc.id_funcionario = f.id_funcionario
                      join gecom.tequipo e on fc.id_equipo = e.id_equipo
                      left join gecom.tequipo_movil em on e.id_equipo = em.id_equipo and em.estado_reg = ''activo''
                      left join gecom.tnumero_equipo ne on fc.id_funcionario_celular = ne.id_funcionario_celular_equipo
                      left join gecom.tfuncionario_celular fcn on ne.id_funcionario_celular_numero = fcn.id_funcionario_celular
                      left join gecom.tnumero_celular nc on fcn.id_numero_celular = nc.id_numero_celular
                      left join gecom.tcuenta_proveedor cp on nc.id_cuenta = cp.id_cuenta
                      left join param.vproveedor pro on pro.id_proveedor = cp.id_proveedor
                      LEFT JOIN param.vtipo_cc tcc ON nc.id_tipo_cc = tcc.id_tipo_cc
                      join segu.tusuario u on fc.id_usuario_reg = u.id_usuario
                      join segu.tpersona p on u.id_persona = p.id_persona
                     where fc.id_funcionario_celular = '||v_id_funcionario_celular;

            --v_consulta:=v_consulta||' order by d.id_institucion, d.id_deuda, d.monto_solicitado, p.fecha ';
			v_consulta:=v_consulta||' order by fc.id_funcionario_celular ';
            
			--Devuelve la respuesta
			return v_consulta;

		end;
    
    /*********************************
 	#TRANSACCION:  'GC_DISMOV_SEL'
 	#DESCRIPCION:	Consulta de datos para reporte asignacion
 	#AUTOR:		Yamil Medina
 	#FECHA:		07-05-2021 10:10:19
	***********************************/

	elsif(p_transaccion='GC_DISMOV_SEL')then

    	begin
        	
    		--Sentencia de la consulta
			v_consulta:= ' select e.id_equipo,
                                 f.desc_funcionario1 ::varchar,
                                 uo.nombre_unidad::varchar,
                                 uo2.nombre_unidad::varchar as nombre_departamento,
                                 tco.nombre::varchar as tipo_contrato,
                                 e.tipo,
                                 (select c.descripcion
                                    from param.tcatalogo c
                                    LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                   WHERE c.codigo = e.tipo
                                     and ct.tabla = ''tequipo''
                                     and ct.nombre = ''tipo_equipo_movil'')::varchar AS tipo_desc,
                                 e.marca,
                                 e.modelo,
                                 e.num_serie,
                                 em.color,
                                 ''''::varchar as rom,
                                 ''''::varchar as ram,
                                 em.imei,
                                 em.imei2,
                                 (SELECT array_to_string(array_agg(ac.resumen), ''<br>'' ::text) ::character varying
                                    from (select ac.*,
                                                 (ac.nombre || '' '' || ac.marca || '' '' || ac.modelo ||
                                                 '' - '' || ac.num_serie) ::varchar as resumen
                                            from gecom.taccesorio ac) as ac
                                   where ac.id_accesorio in
                                         (SELECT element ::integer
                                            FROM UNNEST(string_to_array(fc.id_accesorios, '','')) as element)) as desc_accesorios,
                                 e.estado_fisico,
                                 (select eh.fecha_reg
                                    from gecom.tequipo_historico eh
                                   where eh.id_equipo = e.id_equipo
                                     and eh.id_funcionario_celular = fc.id_funcionario_celular
                                     and eh.operacion = ''asignacion'') as fecha_asignacion,
                                 (select eh.fecha_reg
                                    from gecom.tequipo_historico eh
                                   where eh.id_equipo = e.id_equipo
                                     and eh.id_funcionario_celular = fc.id_funcionario_celular
                                     and eh.operacion = ''devolucion'') as fecha_devolucion,
                                 e.estado,
                                 (p.nombre || '' '' || p.apellido_paterno || '' '' || p.apellido_materno) ::varchar as asignador,
                                 e.observaciones
                            from gecom.tequipo e
                            left join gecom.tequipo_movil em on e.id_equipo = em.id_equipo
                            
                            left join gecom.tfuncionario_celular fc on e.id_equipo = fc.id_equipo and fc.estado_reg = ''activo''
                            left join orga.vfuncionario_persona vp on fc.id_funcionario = vp.id_funcionario
                            left join segu.tusuario u on fc.id_usuario_reg = u.id_usuario
                            left join segu.tpersona p on u.id_persona = p.id_persona
                            left join orga.vfuncionario f on fc.id_funcionario = f.id_funcionario
                            left join orga.tuo_funcionario tuofun on fc.id_funcionario = tuofun.id_funcionario
                            and tuofun.id_uo_funcionario =
                                 (select max(tu.id_uo_funcionario)
                                    from orga.tuo_funcionario tu
                                   where tu.id_funcionario = fc.id_funcionario
                                     and now()::date between tu.fecha_asignacion 
                                     and COALESCE(tu.fecha_finalizacion, (now() ::date + interval ''1 year'') ::date))
                            left join orga.tuo uo on orga.f_get_uo_gerencia(tuofun.id_uo, NULL, NULL) = uo.id_uo
                             
                            left join orga.tuo uo2 on orga.f_get_uo_departamento(tuofun.id_uo, fc.id_funcionario, NULL) = uo2.id_uo 
                            left join orga.tcargo tcar on tcar.id_cargo = tuofun.id_cargo
                            left join orga.ttipo_contrato tco on tco.id_tipo_contrato = tcar.id_tipo_contrato
                           where e.tipo in (''movil'', ''dongle'', ''gps'', ''centel'') ';

            --v_consulta:=v_consulta||' order by d.id_institucion, d.id_deuda, d.monto_solicitado, p.fecha ';
			v_consulta:=v_consulta||' order by fc.estado_reg ';
            
			--Devuelve la respuesta
			return v_consulta;

		end;
    /*********************************
 	#TRANSACCION:  'GC_TIPEQU_SEL'
 	#DESCRIPCION:	Consulta de datos para reporte asignacion
 	#AUTOR:		Yamil Medina
 	#FECHA:		07-05-2021 10:10:19
	***********************************/

	elsif(p_transaccion='GC_TIPEQU_SEL')then

    	begin
        
    		--Sentencia de la consulta
			v_consulta:= ' select e.marca,
                            fc.codigo_inmovilizado,
                            e.modelo,
                            e.num_serie,
                            ep.procesador,
                            e.estado_fisico,
                            ep.memoria_ram,
                            ep.almacenamiento,
                            ep.tamano_pantalla,
                            e.observaciones,
                            ep.tarjeta_video,
                            ep.accesorios,
                            f.desc_funcionario1::varchar as solicitante,
                            uo.nombre_unidad,
        					ep.teclado,
                            ep.sistema_operativo,
                            (p.nombre || '' '' || p.apellido_paterno || '' '' || p.apellido_materno)::varchar as asignador,
                      		fc.fecha_inicio as fecha_entrega,
                            ( select array_to_string(array_agg(ac.resumen), ''<br>'' ::text) ::character varying
                                from (select ac.*,
                                             (ac.nombre || '' '' || ac.marca || '' '' || ac.modelo ||'' - '' || ac.num_serie) ::varchar as resumen
                                        from gecom.taccesorio ac) as ac
                               where ac.id_accesorio in
                                     (SELECT element ::integer
                                        FROM UNNEST(string_to_array(fc.id_accesorios, '','')) as element)) as accesorios2,
                            ep.teclado_idioma,
                            ( select a.marca
                                from gecom.taccesorio a
                               where a.tipo = ''monitor''
                                 and a.id_accesorio in
                                     (SELECT element ::integer
                                        FROM UNNEST(string_to_array(fc.id_accesorios, '','')) as element) LIMIT 1) as monitor_marca,
                            ( select a.modelo
                                from gecom.taccesorio a
                               where a.tipo = ''monitor''
                                 and a.id_accesorio in
                                     (SELECT element ::integer
                                        FROM UNNEST(string_to_array(fc.id_accesorios, '','')) as element) LIMIT 1) as monitor_modelo,
                            ( select a.num_serie
                                from gecom.taccesorio a
                               where a.tipo = ''monitor''
                                 and a.id_accesorio in
                                     (SELECT element ::integer
                                        FROM UNNEST(string_to_array(fc.id_accesorios, '','')) as element) LIMIT 1) as monitor_num_serie,
                            ( select a.observaciones
                                from gecom.taccesorio a
                               where a.tipo = ''monitor''
                                 and a.id_accesorio in
                                     (SELECT element ::integer
                                        FROM UNNEST(string_to_array(fc.id_accesorios, '','')) as element) LIMIT 1) as monitor_observaciones,
                            ( select a.estado_fisico
                                from gecom.taccesorio a
                               where a.tipo = ''monitor''
                                 and a.id_accesorio in
                                     (SELECT element ::integer
                                        FROM UNNEST(string_to_array(fc.id_accesorios, '','')) as element) LIMIT 1) as monitor_estado_fisico,
                           case
                        	when e.tipo in (''movil'',''dongle'',''gps'',''centel'') then
                            	(select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = e.tipo and ct.tabla = ''tequipo'' and ct.nombre = ''tipo_equipo_movil'')
                            else
                            	(select c.descripcion
                                  from param.tcatalogo c
                                  LEFT JOIN param.tcatalogo_tipo ct ON c.id_catalogo_tipo = ct.id_catalogo_tipo
                                  WHERE c.codigo = e.tipo and ct.tabla = ''tequipo'' and ct.nombre = ''tipo_equipo'')
                           end::varchar AS tipo_desc,
                           ep.mac
                      from gecom.tequipo e
                      join gecom.tfuncionario_celular fc on e.id_equipo = fc.id_equipo
                      join orga.vfuncionario f on fc.id_funcionario = f.id_funcionario
                      left join gecom.tequipo_pc ep on e.id_equipo = ep.id_equipo
                      join orga.tuo_funcionario tuofun on f.id_funcionario = tuofun.id_funcionario
                       join orga.tuo uo on orga.f_get_uo_gerencia(tuofun.id_uo, NULL, NULL) = uo.id_uo
                        and tuofun.id_uo_funcionario =
                            (select max(tu.id_uo_funcionario)
                               from orga.tuo_funcionario tu
                              where tu.id_funcionario = f.id_funcionario
                                and now()::date between tu.fecha_asignacion and COALESCE(tu.fecha_finalizacion, (now() ::date + interval ''1 year'') ::date))
                      join segu.tusuario u on fc.id_usuario_reg = u.id_usuario
                      join segu.tpersona p on u.id_persona = p.id_persona
                      where fc.id_funcionario_celular = '||v_parametros.id_funcionario_celular;

            --v_consulta:=v_consulta||' order by d.id_institucion, d.id_deuda, d.monto_solicitado, p.fecha ';
			v_consulta:=v_consulta||' order by fc.id_funcionario_celular ';
            
			--Devuelve la respuesta
			return v_consulta;

		end;
                                    
    ELSE
                         
        RAISE EXCEPTION 'Transaccion inexistente';
                             
    END IF;
                    
EXCEPTION
                    
    WHEN OTHERS THEN
            v_resp='';
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
            v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
            v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
            RAISE EXCEPTION '%',v_resp;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
PARALLEL UNSAFE
COST 100;
