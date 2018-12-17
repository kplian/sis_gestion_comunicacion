/***********************************I-DEP-JRR-GECOM-0-21/07/2014****************************************/

ALTER TABLE gecom.tnumero_celular
  ADD CONSTRAINT fk_tnumero_celular__id_proveedor FOREIGN KEY (id_proveedor)
    REFERENCES param.tproveedor(id_proveedor)
    MATCH FULL
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    

ALTER TABLE gecom.tservicio
  ADD CONSTRAINT fk_tservicio__id_proveedor FOREIGN KEY (id_proveedor)
    REFERENCES param.tproveedor(id_proveedor)
    MATCH FULL
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
ALTER TABLE gecom.tnumero_servicio
  ADD CONSTRAINT fk_tnumero_servicio__id_servicio FOREIGN KEY (id_servicio)
    REFERENCES gecom.tservicio(id_servicio)
    MATCH FULL
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
ALTER TABLE gecom.tnumero_servicio
  ADD CONSTRAINT fk_tnumero_servicio__id_numero_celular FOREIGN KEY (id_numero_celular)
    REFERENCES gecom.tnumero_celular(id_numero_celular)
    MATCH FULL
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
ALTER TABLE gecom.tfuncionario_celular
  ADD CONSTRAINT fk_tfuncionario_celular__id_numero_celular FOREIGN KEY (id_numero_celular)
    REFERENCES gecom.tnumero_celular(id_numero_celular)
    MATCH FULL
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

ALTER TABLE gecom.tfuncionario_celular
  ADD CONSTRAINT fk_tfuncionario_celular__id_funcionario FOREIGN KEY (id_funcionario)
    REFERENCES orga.tfuncionario(id_funcionario)
    MATCH FULL
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

ALTER TABLE gecom.tfuncionario_celular
  ADD CONSTRAINT fk_tfuncionario_celular__id_cargo FOREIGN KEY (id_cargo)
    REFERENCES orga.tcargo(id_cargo)
    MATCH FULL
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

ALTER TABLE gecom.tconsumo
  ADD CONSTRAINT fk_tconsumo__id_numero_celular FOREIGN KEY (id_numero_celular)
    REFERENCES gecom.tnumero_celular(id_numero_celular)
    MATCH FULL
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
ALTER TABLE gecom.tconsumo
  ADD CONSTRAINT fk_tconsumo__id_periodo FOREIGN KEY (id_periodo)
    REFERENCES param.tperiodo(id_periodo)
    MATCH FULL
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
ALTER TABLE gecom.tconsumo
  ADD CONSTRAINT fk_tconsumo__id_gestion FOREIGN KEY (id_gestion)
    REFERENCES param.tgestion(id_gestion)
    MATCH FULL
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
ALTER TABLE gecom.tconsumo
  ADD CONSTRAINT fk_tconsumo__id_servicio FOREIGN KEY (id_servicio)
    REFERENCES gecom.tservicio(id_servicio)
    MATCH FULL
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

/***********************************F-DEP-JRR-GECOM-0-21/07/2014****************************************/

/***********************************I-DEP-JRR-GECOM-0-27/07/2014****************************************/
select pxp.f_insert_testructura_gui ('GECOM', 'SISTEMA');
select pxp.f_insert_testructura_gui ('REGSER', 'GECOM');
select pxp.f_insert_testructura_gui ('REGNUM', 'GECOM');
select pxp.f_delete_testructura_gui ('ASIGNUM', 'REGNUM');
select pxp.f_insert_testructura_gui ('ASIGNUM', 'GECOM');
select pxp.f_insert_testructura_gui ('REGSER.1', 'REGSER');
select pxp.f_insert_testructura_gui ('REGSER.1.1', 'REGSER.1');
select pxp.f_insert_testructura_gui ('REGSER.1.2', 'REGSER.1');
select pxp.f_insert_testructura_gui ('REGSER.1.3', 'REGSER.1');
select pxp.f_insert_testructura_gui ('REGSER.1.2.1', 'REGSER.1.2');
select pxp.f_insert_testructura_gui ('REGSER.1.3.1', 'REGSER.1.3');
select pxp.f_insert_testructura_gui ('REGSER.1.3.1.1', 'REGSER.1.3.1');
select pxp.f_insert_testructura_gui ('REGNUM.1', 'REGNUM');
select pxp.f_insert_testructura_gui ('REGNUM.2', 'REGNUM');
select pxp.f_insert_testructura_gui ('REGNUM.3', 'REGNUM');
select pxp.f_insert_testructura_gui ('REGNUM.4', 'REGNUM');
select pxp.f_insert_testructura_gui ('REGNUM.4.1', 'REGNUM.4');
select pxp.f_insert_testructura_gui ('REGNUM.4.2', 'REGNUM.4');
select pxp.f_insert_testructura_gui ('REGNUM.4.3', 'REGNUM.4');
select pxp.f_insert_testructura_gui ('REGNUM.4.2.1', 'REGNUM.4.2');
select pxp.f_insert_testructura_gui ('REGNUM.4.3.1', 'REGNUM.4.3');
select pxp.f_insert_testructura_gui ('REGNUM.4.3.1.1', 'REGNUM.4.3.1');

/***********************************F-DEP-JRR-GECOM-0-27/07/2014****************************************/
