<?php
/**
 *@package pXP
 *@file    SubirArchivo.php
 *@author  Yamil Medina
 *@date    22-05-2021
 *@description permites subir archivos a la tabla de documento_sol
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.CambioEquipo=Ext.extend(Phx.frmInterfaz,{
            ActSave:'../../sis_gestion_comunicacion/control/Equipo/cambioEquipo',

            constructor:function(config)
            {
                Phx.vista.CambioEquipo.superclass.constructor.call(this,config);
                this.init();
                this.loadValoresIniciales();
            },

            loadValoresIniciales:function()
            {
                Phx.vista.CambioEquipo.superclass.loadValoresIniciales.call(this);
                this.getComponente('id_funcionario_celular').setValue(this.data.id_funcionario_celular);
                this.getComponente('id_funcionario').setValue(this.data.id_funcionario);
                this.getComponente('fecha_fin').setValue(this.data.fecha_fin);

                var cmbEquipo=this.getComponente('id_equipo');
                cmbEquipo.setValue(null);
                cmbEquipo.store.baseParams.tipo_servi = this.data.tipo_servicio;

            },

            successSave:function(resp)
            {
                Phx.CP.loadingHide();
                Phx.CP.getPagina(this.idContenedorPadre).reload();
                this.panel.close();
            },

            Atributos:[
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_funcionario'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_funcionario_celular'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config: {
                        name: 'id_equipo',
                        fieldLabel: 'Nuevo Equipo',
                        allowBlank: false,
                        hidden: false,
                        emptyText: 'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_gestion_comunicacion/control/Equipo/listarEquipoCombo',
                            id: 'id_equipo',
                            root: 'datos',
                            sortInfo: {
                                field: 'nombre',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_equipo', 'nombre'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'nombre', tipo_movil: 'SI'}
                        }),
                        valueField: 'id_equipo',
                        displayField: 'nombre',
                        gdisplayField: 'nombre',
                        hiddenName: 'id_equipo',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 150,
                        minChars: 2
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    grid: true,
                    form: true
                },
				{
                    config: {
                        name: 'id_accesorios',
                        fieldLabel: 'Accesorios',
                        allowBlank: true,
                        emptyText: 'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_gestion_comunicacion/control/Accesorio/listarAccesorio',
                            id: 'id_accesorio',
                            root: 'datos',
                            sortInfo: {
                                field: 'resumen',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_accesorio', 'resumen', 'marca'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'acc.id_accesorio#acc.resumen', disponibles: 'SI', tipo_equipo: 'movil'}
                        }),
                        tpl:'<tpl for="."><div class="x-combo-list-item" ><div class="awesomecombo-item {checked}"><p><b></b>{resumen}</p></div>\</div></tpl>',
                        valueField: 'id_accesorio',
                        displayField: 'resumen',
                        gdisplayField: 'resumen',
                        hiddenName: 'id_accesorios',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 150,
                        minChars: 2,
                        enableMultiSelect:true,
						listeners: {
                            beforequery: function(qe){
                                delete qe.combo.lastQuery;
                            }
                        },
                    },
                    type: 'AwesomeCombo',
                    id_grupo: 0,
                    grid: true,
                    form: true
					
                },
                {
                    config:{
                        name: 'fecha_fin',
                        fieldLabel: 'Fecha Devolución del Nuevo Equipo',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
                    },
                    type:'DateField',
                    id_grupo:1,
                    grid:true,
                    form:true
                },
                {
                    config:{
                        name: 'observaciones',
                        fieldLabel: 'Observaciones',
                        allowBlank: true,
                        anchor: '90%',
                        gwidth: 200
                    },
                    type:'TextArea',
                    id_grupo:1,
                    grid:false,
                    form:true
                },
            ],
            title:'Devolucion',
        }
    )
</script>