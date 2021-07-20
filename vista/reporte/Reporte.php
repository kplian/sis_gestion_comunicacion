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
            this.Cmp.id_funcionario.hide();
            this.Cmp.id_funcionario.allowBlank=true;

            this.Cmp.tipo_reporte.on('select',function(cmb,r,i) {
                if (r.data.field1 == 'Equipos Persona') {
                    this.Cmp.id_funcionario.show();
                    this.Cmp.id_funcionario.allowBlank=false;
                    this.Cmp.tipo.hide();
                    this.Cmp.tipo.allowBlank=true;
                    this.Cmp.formato_reporte.hide();
                }else if( [ '5-R-510 Registro de computador portatil',
                            '5-R-511 Registro de cpu y monitor',
                            '5-R-512 Registro de accesorios adicionales',
                            '5-R-513 Registro de telefono IP',
                            '5-R-514 Registro de dispositivos moviles',
                            '5-R-515 Registro de lineas corporativas'].includes(r.data.field1)){
                    this.Cmp.tipo.hide();
                    this.Cmp.tipo.allowBlank=true;
                    this.Cmp.id_funcionario.hide();
                    this.Cmp.id_funcionario.allowBlank=true;
                    this.Cmp.formato_reporte.show();
                    this.Cmp.formato_reporte.allowBlank=false;
                }else if(r.data.field1 == 'Formulario'){
                    this.Cmp.tipo.show();
                    this.Cmp.tipo.allowBlank=false;
                    this.Cmp.id_funcionario.hide();
                    this.Cmp.id_funcionario.allowBlank=true;
                    this.Cmp.formato_reporte.hide();
                }else{
                    this.Cmp.id_funcionario.hide();
                    this.Cmp.id_funcionario.allowBlank=true;
                    this.Cmp.formato_reporte.hide();
                }
            },this);
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
                    store:['Formulario',
                           'Equipos Persona',
                           '5-R-510 Registro de computador portatil',
                           '5-R-511 Registro de cpu y monitor',
                           '5-R-512 Registro de accesorios adicionales',
                           '5-R-513 Registro de telefono IP',
                           '5-R-514 Registro de dispositivos moviles',
                           '5-R-515 Registro de lineas corporativas'
                    ],
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
                    allowBlank:false,
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
            },
            {
                config:{
                    name:'id_funcionario',
                    hiddenName: 'id_funcionario',
                    origen:'FUNCIONARIOCAR',
                    fieldLabel:'Funcionario',
                    allowBlank:true,
                    anchor: '100%',
                    gwidth: 100,
                    valueField: 'id_funcionario',
                    gdisplayField: 'desc_funcionario1',
                    baseParams: { es_combo_solicitud : 'si' },
                    renderer:function(value, p, record){return String.format('{0}', record.data['desc_funcionario1']);}
                },
                type:'ComboRec',//ComboRec
                id_grupo:0,
                filters:{pfiltro:'fun.desc_funcionario1',type:'string'},
                bottom_filter:true,
                grid:true,
                form:true
            },
            {
                config:{
                    name:'formato_reporte',
                    fieldLabel:'Formato del Reporte',
                    typeAhead: true,
                    allowBlank:true,
                    hidden:true,
                    triggerAction: 'all',
                    emptyText:'Formato...',
                    selectOnFocus:true,
                    mode:'local',
                    store:new Ext.data.ArrayStore({
                        fields: ['ID', 'valor'],
                        data :[ ['pdf','PDF'],
                            ['csv','CSV']]
                    }),
                    valueField:'ID',
                    displayField:'valor',
                    width:250,
                    anchor:'100%'
                },
                type:'ComboBox',
                id_grupo:1,
                form:true
            },
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