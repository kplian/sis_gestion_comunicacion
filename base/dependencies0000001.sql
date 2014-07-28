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
select pxp.f_insert_tprocedimiento_gui ('GC_SER_INS', 'REGSER', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_SER_MOD', 'REGSER', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_SER_ELI', 'REGSER', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_SER_SEL', 'REGSER', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PROVEEV_SEL', 'REGSER', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_SERVIC_SEL', 'REGSER.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SAL_ITEMNOTBASE_SEL', 'REGSER.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_LUG_SEL', 'REGSER.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_LUG_ARB_SEL', 'REGSER.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PROVEE_INS', 'REGSER.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PROVEE_MOD', 'REGSER.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PROVEE_ELI', 'REGSER.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PROVEE_SEL', 'REGSER.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PROVEEV_SEL', 'REGSER.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_SEL', 'REGSER.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSONMIN_SEL', 'REGSER.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_INSTIT_SEL', 'REGSER.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SAL_ITEM_SEL', 'REGSER.1.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SAL_ITEMNOTBASE_SEL', 'REGSER.1.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SAL_ITMALM_SEL', 'REGSER.1.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_SERVIC_SEL', 'REGSER.1.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PRITSE_INS', 'REGSER.1.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PRITSE_MOD', 'REGSER.1.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PRITSE_ELI', 'REGSER.1.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PRITSE_SEL', 'REGSER.1.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_INS', 'REGSER.1.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_MOD', 'REGSER.1.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_ELI', 'REGSER.1.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSONMIN_SEL', 'REGSER.1.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_UPFOTOPER_MOD', 'REGSER.1.2.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_INSTIT_INS', 'REGSER.1.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_INSTIT_MOD', 'REGSER.1.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_INSTIT_ELI', 'REGSER.1.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_INSTIT_SEL', 'REGSER.1.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_SEL', 'REGSER.1.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSONMIN_SEL', 'REGSER.1.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_INS', 'REGSER.1.3.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_MOD', 'REGSER.1.3.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_ELI', 'REGSER.1.3.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSONMIN_SEL', 'REGSER.1.3.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_UPFOTOPER_MOD', 'REGSER.1.3.1.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_NUMCEL_INS', 'REGNUM', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_NUMCEL_MOD', 'REGNUM', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_NUMCEL_ELI', 'REGNUM', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_NUMCEL_SEL', 'REGNUM', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PROVEEV_SEL', 'REGNUM', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_SER_SEL', 'REGNUM.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_NUMSER_INS', 'REGNUM.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_NUMSER_MOD', 'REGNUM.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_NUMSER_ELI', 'REGNUM.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_NUMSER_SEL', 'REGNUM.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_SER_SEL', 'REGNUM.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_CON_INS', 'REGNUM.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_CON_MOD', 'REGNUM.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_CONCSV_UPD', 'REGNUM.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_CON_ELI', 'REGNUM.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_CON_SEL', 'REGNUM.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_GES_SEL', 'REGNUM.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PER_SEL', 'REGNUM.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_CONCSV_UPD', 'REGNUM.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_GES_SEL', 'REGNUM.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PER_SEL', 'REGNUM.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_SERVIC_SEL', 'REGNUM.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('SAL_ITEMNOTBASE_SEL', 'REGNUM.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_LUG_SEL', 'REGNUM.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_LUG_ARB_SEL', 'REGNUM.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PROVEE_INS', 'REGNUM.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PROVEE_MOD', 'REGNUM.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PROVEE_ELI', 'REGNUM.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PROVEE_SEL', 'REGNUM.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PROVEEV_SEL', 'REGNUM.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_SEL', 'REGNUM.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSONMIN_SEL', 'REGNUM.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_INSTIT_SEL', 'REGNUM.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('SAL_ITEM_SEL', 'REGNUM.4.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SAL_ITEMNOTBASE_SEL', 'REGNUM.4.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SAL_ITMALM_SEL', 'REGNUM.4.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_SERVIC_SEL', 'REGNUM.4.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PRITSE_INS', 'REGNUM.4.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PRITSE_MOD', 'REGNUM.4.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PRITSE_ELI', 'REGNUM.4.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_PRITSE_SEL', 'REGNUM.4.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_INS', 'REGNUM.4.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_MOD', 'REGNUM.4.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_ELI', 'REGNUM.4.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSONMIN_SEL', 'REGNUM.4.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_UPFOTOPER_MOD', 'REGNUM.4.2.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_INSTIT_INS', 'REGNUM.4.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_INSTIT_MOD', 'REGNUM.4.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_INSTIT_ELI', 'REGNUM.4.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_INSTIT_SEL', 'REGNUM.4.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_SEL', 'REGNUM.4.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSONMIN_SEL', 'REGNUM.4.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_INS', 'REGNUM.4.3.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_MOD', 'REGNUM.4.3.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_ELI', 'REGNUM.4.3.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSONMIN_SEL', 'REGNUM.4.3.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_UPFOTOPER_MOD', 'REGNUM.4.3.1.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_NUMCEL_SEL', 'ASIGNUM', 'no');
select pxp.f_insert_tprocedimiento_gui ('OR_CARGO_SEL', 'ASIGNUM', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_FUNCEL_INS', 'ASIGNUM', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_FUNCEL_MOD', 'ASIGNUM', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_FUNCEL_ELI', 'ASIGNUM', 'no');
select pxp.f_insert_tprocedimiento_gui ('GC_FUNCEL_SEL', 'ASIGNUM', 'no');
select pxp.f_insert_tprocedimiento_gui ('RH_FUNCIOCAR_SEL', 'ASIGNUM', 'no');

/***********************************F-DEP-JRR-GECOM-0-27/07/2014****************************************/