<?php
/**
 *@package pXP
 *@file Auxiliar.php
 *@author  Manuel Guerra
 *@date 30-07-2018 16:04:52
 *@description
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.Reporte=Ext.extend(Phx.frmInterfaz,{

        constructor:function(config){
            Phx.vista.Reporte.superclass.constructor.call(this,config);
            this.init();
            this.iniciarEventos();
        },
        iniciarEventos : function () {

        },
        Atributos:[
            {
                config:{
                    name: 'tipo_reporte',
                    fieldLabel: 'Tipo Reporte',
                    allowBlank:false,
                    emptyText:'Tipo...',
                    typeAhead: false,
                    triggerAction: 'all',
                    lazyRender:true,
                    mode: 'local',
                    anchor: '100%',
                    gwidth: 200,
                    store:['Formulario','otros'],
                },
                type:'ComboBox',
                id_grupo:1,
                valorInicial: 'Formulario',
                grid:false,
                form:true
            },
            {
                config : {
                    name:'tipo',
                    fieldLabel : 'Tipo de Equipo',
                    resizable:true,
                    allowBlank:true,
                    emptyText:'Elija una opción...',
                    store: new Ext.data.JsonStore({
                        url: '../../sis_parametros/control/Catalogo/listarCatalogoCombo',
                        id: 'id_catalogo',
                        root: 'datos',
                        sortInfo:{
                            field: 'orden',
                            direction: 'ASC'
                        },
                        totalProperty: 'total',
                        fields: ['id_catalogo','codigo','descripcion'],
                        // turn on remote sorting
                        remoteSort: true,
                        baseParams: {par_filtro:'descripcion',cod_subsistema:'GECOM',catalogo_tipo:'tipo_equipo'}
                    }),
                    enableMultiSelect:true,
                    valueField: 'codigo',
                    displayField: 'descripcion',
                    gdisplayField: 'escribe_desc',
                    triggerAction: 'all',
                    lazyRender:true,
                    mode:'remote',
                    pageSize:15,
                    queryDelay: 1000,
                    anchor: '100%',
                    gwidth: 100,
                    renderer : function(value, p, record) {
                        return String.format('{0}', record.data['tipo_desc']);
                    },
                    listeners: {
                        beforequery: function(qe){
                            delete qe.combo.lastQuery;
                        }
                    },
                },
                type:'ComboBox',
                filters:{pfiltro:'equ.tipo',type:'string'},
                id_grupo:0,
                grid:true,
                form:true
            }
        ],
        title : 'Reporte de Reporte',
        topBar : true,
        botones : false,
        labelSubmit : 'Generar',
        tooltipSubmit : '<b>Reporte de Reporte</b>',
        ActSave:'../../sis_gestion_comunicacion/control/Equipo/reportesEquipo',
        tipo : 'reporte',
        clsSubmit : 'bprint',
        Grupos : [{
            layout : 'column',
            items : [{
                xtype : 'fieldset',
                layout : 'form',
                border : true,
                title : 'Datos para el reporte',
                bodyStyle : 'padding:0 10px 0;',
                columnWidth : '500px',
                items : [],
                id_grupo : 0,
                collapsible : true
            }]
        }],
        successSave :function(resp){

            Phx.CP.loadingHide();
            var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            if (reg.ROOT.error) {
                alert('error al procesar');
                return
            }
            var nomRep = reg.ROOT.detalle.archivo_generado;
            if(Phx.CP.config_ini.x==1){
                nomRep = Phx.CP.CRIPT.Encriptar(nomRep);
            }

            window.open('../../../reportes_generados/'+nomRep+'?t='+new Date().toLocaleTimeString())


        }


    })
</script>