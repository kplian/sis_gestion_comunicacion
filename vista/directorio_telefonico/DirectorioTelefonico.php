<?php
/**
 *@package pXP
 *@file gen-Reporte.php
 *@author  (admin)
 *@date 12-10-2016 19:21:51
 *@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.DirectorioTelefonico= Ext.extend(Phx.frmInterfaz, {
        Atributos : [

            {
                config:{
                    name: 'oficina',
                    fieldLabel: 'Oficina',
                    grupo: [0, 1, 2],
                    allowBlank: false,
                    emptyText:'Filtro...',
                    store : new Ext.data.JsonStore({
                        url:'../../sis_organigrama/control/Oficina/listarOficina',
                        id : 'nombre',
                        root: 'datos',
                        sortInfo:{
                            field: 'codigo',
                            direction: 'ASC'
                        },
                        totalProperty: 'total',
                        fields: ['id_oficina', 'nombre', 'codigo'],
                        remoteSort: true,
                        baseParams: {par_filtro: 'ofi.nombre#ofi.codigo#lug.nombre',_adicionar:'si'}
                    }),
                    valueField : 'nombre',
                    displayField : 'nombre',
                    hiddenName : 'codigo',
                    enableMultiSelect : true,
                    triggerAction : 'all',
                    lazyRender : true,
                    mode : 'remote',
                    pageSize : 20,
                    gwidth:200,
                    anchor : '50%',
                    listWidth : '280',
                    resizable : true,
                    minChars : 2
                },
                type:'AwesomeCombo',
                id_grupo:0,
                filters:{
                    pfiltro:'ofi.nombre#ofi.codigo',
                    type:'string'
                },
                form:true
            },
            {
                config:{
                    name:'id_uo',
                    hiddenName: 'id_uo',
                    origen:'UO',
                    fieldLabel:'UO',
                    gdisplayField:'desc_uo',//mapea al store del grid
                    gwidth:200,
                    emptyText:'Filtro...',
                    anchor: '50%',
                    baseParams: {gerencia: 'si',_adicionar:'si'},
                    allowBlank:true,
                    renderer:function (value, p, record){return String.format('{0}', record.data['desc_uo']);}
                },
                type:'ComboRec',
                id_grupo:0,
                filters:{
                    pfiltro:'uo.codigo#uo.nombre_unidad',
                    type:'string'
                },
                grid:true,
                form:true
            },
            {
                config:{
                    name:'tipo_numero',
                    fieldLabel:'Tipo Número',
                    typeAhead: true,
                    allowBlank:false,
                    enableMultiSelect : true,
                    triggerAction: 'all',
                    emptyText:'Tipo...',
                    anchor: '50%',
                    selectOnFocus:true,
                    mode:'local',
                    store:new Ext.data.ArrayStore({
                        fields: ['ID', 'valor'],
                        data :	[
                            ['interno','Interno'],
                            ['linea directa','Linea Directa'],
                            ['movil','Movil']
                        ]
                    }),
                    valueField:'ID',
                    displayField:'valor',
                    gwidth:200

                },
                type:'AwesomeCombo',
                id_grupo:0,
                form:true
            }

        ],
        title : 'Generar Reporte',
        ActSave : '../../sis_gestion_comunicacion/control/NumeroCelular/reporteDirectorioTelefonico',
        topBar : true,
        botones : false,
        labelSubmit : 'Imprimir',
        tooltipSubmit : '<b>Generar PDF</b>',
        constructor : function(config) {
            this.Grupos = [
                {
                    layout: 'column',
                    border: true,
                    autoHeight : false,
                    defaults: {
                        border: false,
                        bodyStyle: 'padding:4px'
                    },
                    items: [
                        {
                            xtype: 'fieldset',
                            columnWidth: 0.5,
                            defaults: {
                                anchor: '-5' // leave room for error icon
                            },
                            title: 'Datos del Reporte',
                            items: [],
                            id_grupo: 0,
                            flex:1,
                            autoHeight : true,
                            margins:'2 2 2 2'
                        }
                    ]
                }];
            Phx.vista.DirectorioTelefonico.superclass.constructor.call(this, config);
            this.init();
        },
        tipo : 'reporte',
        clsSubmit : 'bprint',



        agregarArgsExtraSubmit: function() {

            this.argumentExtraSubmit.uo = this.Cmp.id_uo.getRawValue();
        }

    })
</script>
