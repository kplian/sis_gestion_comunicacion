<?php
/****************************************************************************************
*@package pXP
*@file gen-NumeroCelularHistorico.php
*@author  (ymedina)
*@date 12-05-2021 12:47:30
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                12-05-2021 12:47:30    ymedina            Creacion    
 #   

*******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.NumeroCelularHistorico=Ext.extend(Phx.gridInterfaz,{

    constructor:function(config){
        this.maestro=config.maestro;
        //llama al constructor de la clase padre
        Phx.vista.NumeroCelularHistorico.superclass.constructor.call(this,config);
        this.init();
        //this.load({params:{start:0, limit:this.tam_pag}})
        var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
        if(dataPadre){
            this.onEnablePanel(this, dataPadre);
        }
        else
        {
            this.bloquearMenus();
        }
    },
            
    Atributos:[
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_numero_celular_his'
            },
            type:'Field',
            form:true 
        },
        {
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_numero_celular'
            },
            type:'Field',
            form:true
        },
        {
            config:{
                name: 'estado_reg',
                fieldLabel: 'Estado Reg.',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:10
            },
                type:'TextField',
                filters:{pfiltro:'hnum.estado_reg',type:'string'},
                id_grupo:1,
                grid:true,
                form:false
		},
        {
            config:{
                name: 'numero',
                fieldLabel: 'numero',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:20
            },
                type:'TextField',
                filters:{pfiltro:'hnum.numero',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'roaming',
                fieldLabel: 'roaming',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:2
            },
                type:'TextField',
                filters:{pfiltro:'hnum.roaming',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'observaciones',
                fieldLabel: 'observaciones',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:-5
            },
                type:'TextField',
                filters:{pfiltro:'hnum.observaciones',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name:'id_proveedor',
                hiddenName: 'id_proveedor',
                origen:'PROVEEDOR',
                fieldLabel:'Proveedor',
                allowBlank:true,
                tinit:false,
                gwidth:200,
                valueField: 'id_proveedor',
                gdisplayField: 'desc_proveedor',
                renderer:function(value, p, record){return String.format('{0}', record.data['desc_proveedor']);}
            },
            type:'ComboRec',//ComboRec
            id_grupo:0,
            filters:{pfiltro:'pro.desc_proveedor',type:'string'},
            grid:true,
            form:true
        },
        {
            config:{
                name: 'tipo',
                fieldLabel: 'tipo',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:20
            },
                type:'TextField',
                filters:{pfiltro:'hnum.tipo',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'estado',
                fieldLabel: 'estado',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:20
            },
                type:'TextField',
                filters:{pfiltro:'hnum.estado',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'credito',
                fieldLabel: 'credito',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:-5
            },
                type:'NumberField',
                filters:{pfiltro:'hnum.credito',type:'numeric'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'limite_consumo',
                fieldLabel: 'limite_consumo',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:-5
            },
                type:'NumberField',
                filters:{pfiltro:'hnum.limite_consumo',type:'numeric'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'sim',
                fieldLabel: 'sim',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:4
            },
                type:'NumberField',
                filters:{pfiltro:'hnum.sim',type:'numeric'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config: {
                name: 'id_cuenta',
                fieldLabel: 'Cuenta Proveedor',
                allowBlank: true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_gestion_comunicacion/control/CuentaProveedor/listarCuentaProveedor',
                    id: 'id_cuenta',
                    root: 'datos',
                    sortInfo: {
                        field: 'nro_cuenta',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_cuenta', 'nro_cuenta'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'cup.nro_cuenta'}
                }),
                valueField: 'id_cuenta',
                displayField: 'nro_cuenta',
                gdisplayField: 'desc_nro_cuenta',
                hiddenName: 'id_cuenta',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '80%',
                gwidth: 100,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['desc_nro_cuenta']);
                },
                listeners: {
                    beforequery: function(qe){
                        delete qe.combo.lastQuery;
                    }
                },
            },
            type: 'ComboBox',
            id_grupo: 0,
            grid: true,
            form: true
        },
        {
            config:{
                name: 'desc_tipo_cc',
                fieldLabel: 'Centro de Costo',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:150
            },
            type:'TextField',
            filters:{pfiltro:'desc_tipo_cc',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'operacion',
                fieldLabel: 'operacion',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:15
            },
                type:'TextField',
                filters:{pfiltro:'hnum.operacion',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'observacion_operacion',
                fieldLabel: 'observacion_operacion',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:200
            },
                type:'TextField',
                filters:{pfiltro:'hnum.observacion_operacion',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'usr_reg',
                fieldLabel: 'Creado por',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:4
            },
                type:'Field',
                filters:{pfiltro:'usu1.cuenta',type:'string'},
                id_grupo:1,
                grid:true,
                form:false
		},
        {
            config:{
                name: 'fecha_reg',
                fieldLabel: 'Fecha creación',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                            format: 'd/m/Y', 
                            renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
            },
                type:'DateField',
                filters:{pfiltro:'hnum.fecha_reg',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		},
        {
            config:{
                name: 'id_usuario_ai',
                fieldLabel: 'Fecha creación',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:4
            },
                type:'Field',
                filters:{pfiltro:'hnum.id_usuario_ai',type:'numeric'},
                id_grupo:1,
                grid:false,
                form:false
		},
        {
            config:{
                name: 'usuario_ai',
                fieldLabel: 'Funcionaro AI',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:300
            },
                type:'TextField',
                filters:{pfiltro:'hnum.usuario_ai',type:'string'},
                id_grupo:1,
                grid:true,
                form:false
		},
        {
            config:{
                name: 'usr_mod',
                fieldLabel: 'Modificado por',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:4
            },
                type:'Field',
                filters:{pfiltro:'usu2.cuenta',type:'string'},
                id_grupo:1,
                grid:true,
                form:false
		},
        {
            config:{
                name: 'fecha_mod',
                fieldLabel: 'Fecha Modif.',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                            format: 'd/m/Y', 
                            renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
            },
                type:'DateField',
                filters:{pfiltro:'hnum.fecha_mod',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		}
    ],
    tam_pag:50,    
    title:'Historico numero',
    ActSave:'../../sis_gestion_comunicacion/control/NumeroCelularHistorico/insertarNumeroCelularHistorico',
    ActDel:'../../sis_gestion_comunicacion/control/NumeroCelularHistorico/eliminarNumeroCelularHistorico',
    ActList:'../../sis_gestion_comunicacion/control/NumeroCelularHistorico/listarNumeroCelularHistorico',
    id_store:'id_numero_celular_his',
    fields: [
		{name:'id_numero_celular_his', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_numero_celular', type: 'numeric'},
		{name:'numero', type: 'string'},
		{name:'roaming', type: 'string'},
		{name:'observaciones', type: 'string'},
		{name:'id_proveedor', type: 'numeric'},
		{name:'tipo', type: 'string'},
		{name:'estado', type: 'string'},
		{name:'credito', type: 'numeric'},
		{name:'limite_consumo', type: 'numeric'},
		{name:'sim', type: 'numeric'},
		{name:'id_cuenta', type: 'numeric'},
		{name:'operacion', type: 'string'},
		{name:'observacion_operacion', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        {name:'desc_proveedor', type: 'string'},
        {name:'desc_nro_cuenta', type: 'string'},
        {name:'id_tipo_cc', type: 'numeric'},
        {name:'desc_tipo_cc', type: 'string'},
    ],
    sortInfo:{
        field: 'id_numero_celular_his',
        direction: 'ASC'
    },
    bdel: false,
    bedit: false,
    bnew: false,
    bsave: false,
    onReloadPage:function(m){
        this.maestro=m;
        this.store.baseParams={id_numero_celular: this.maestro.id_numero_celular}
        this.load({params:{start:0, limit:this.tam_pag}})
    },
    loadValoresIniciales:function()
    {
        Phx.vista.NumeroCelularHistorico.superclass.loadValoresIniciales.call(this);
        this.getComponente('id_numero_celular').setValue(this.maestro.id_numero_celular);
    },
    }
)
</script>
        
        