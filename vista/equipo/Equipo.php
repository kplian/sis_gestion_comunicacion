<?php
/****************************************************************************************
*@package pXP
*@file gen-Equipo.php
*@author  (ymedina)
*@date 06-05-2021 16:01:48
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                06-05-2021 16:01:48    ymedina            Creacion    
 #   

*******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Equipo=Ext.extend(Phx.gridInterfaz,{

    constructor:function(config){
        this.maestro=config.maestro;
        //llama al constructor de la clase padre
        Phx.vista.Equipo.superclass.constructor.call(this,config);
        this.init();
        this.iniciarEventos();
        this.load({params:{start:0, limit:this.tam_pag, tipo: 'otros'}})
    },
    iniciarEventos:function () {
        this.Cmp.tipo.on('select',function(c,r,i) {
            if(r.data.codigo == 'movil'){
                this.Cmp.id_numero_celular.show();
                this.Cmp.color.show();
                this.Cmp.imei.show();
                this.Cmp.sn.show();
                this.Cmp.tamano_pantalla.hide();
                this.Cmp.tarjeta_video.hide();
                this.Cmp.teclado.hide();
                this.Cmp.procesador.hide();
                this.Cmp.memoria_ram.hide();
                this.Cmp.almacenamiento.hide();
                this.Cmp.sistema_operativo.hide();
            }else if (["laptop", "pc"].includes(r.data.codigo)){
                this.Cmp.id_numero_celular.hide();
                this.Cmp.color.hide();
                this.Cmp.imei.hide();
                this.Cmp.sn.hide();
                if(r.data.codigo == 'laptop'){
                    this.Cmp.tamano_pantalla.show();
                }else{
                    this.Cmp.tamano_pantalla.hide();
                }
                this.Cmp.tarjeta_video.show();
                this.Cmp.teclado.show();
                this.Cmp.procesador.show();
                this.Cmp.memoria_ram.show();
                this.Cmp.almacenamiento.show();
                this.Cmp.sistema_operativo.show();
            }else{
                this.Cmp.id_numero_celular.hide();
                this.Cmp.color.hide();
                this.Cmp.imei.hide();
                this.Cmp.sn.hide();
                this.Cmp.tamano_pantalla.hide();
                this.Cmp.tarjeta_video.hide();
                this.Cmp.teclado.hide();
                this.Cmp.procesador.hide();
                this.Cmp.memoria_ram.hide();
                this.Cmp.almacenamiento.hide();
                this.Cmp.sistema_operativo.hide();
            }
        },this);
    },
    Atributos:[
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_equipo'
            },
            type:'Field',
            form:true 
        },
        {
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_equipo_movil'
            },
            type:'Field',
            form:true
        },
        {
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_equipo_pc'
            },
            type:'Field',
            form:true
        },
        {
            config : {
                name:'tipo',
                fieldLabel : 'Tipo',
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
                anchor: '80%',
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
            config: {
                name: 'id_numero_celular',
                fieldLabel: 'Número Celular',
                allowBlank: true,
                hidden: true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_gestion_comunicacion/control/NumeroCelular/listarNumeroCelular',
                    id: 'id_numero_celular',
                    root: 'datos',
                    sortInfo: {
                        field: 'numero',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_numero_celular', 'numero', 'desc_proveedor'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'numcel.numero', disponibles: 'SI'}
                }),
                valueField: 'id_numero_celular',
                displayField: 'numero',
                gdisplayField: 'numero',
                hiddenName: 'id_numero_celular',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '60%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['numero']);
                },
                listeners: {
                    beforequery: function(qe){
                        delete qe.combo.lastQuery;
                    }
                },
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'numcel.numero',type: 'string'},
            grid: true,
            form: true
        },
        {
            config:{
                name: 'estado_fisico',
                fieldLabel: 'estado_fisico',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:30
            },
                type:'TextField',
                filters:{pfiltro:'equ.estado_fisico',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},

        {
            config:{
                name: 'marca',
                fieldLabel: 'marca',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:200
            },
                type:'TextField',
                filters:{pfiltro:'equ.marca',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'modelo',
                fieldLabel: 'modelo',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:200
            },
                type:'TextField',
                filters:{pfiltro:'equ.modelo',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'estado',
                fieldLabel: 'Estado',
                allowBlank:false,
                emptyText:'Tipo...',
                typeAhead: false,
                triggerAction: 'all',
                lazyRender:true,
                mode: 'local',
                anchor: '50%',
                gwidth: 100,
                store:['disponible','almacen'],
                value:'no'
            },
            type:'ComboBox',
            filters:{pfiltro:'equ.estado',
                type: 'list',
                options: ['disponible','almacen']
            },
            id_grupo:1,
            valorInicial: 'disponible',
            grid:true,
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
                filters:{pfiltro:'equ.estado_reg',type:'string'},
                id_grupo:1,
                grid:true,
                form:false
		},
        {
            config:{
                name: 'num_serie',
                fieldLabel: 'num_serie',
                allowBlank: false,
                anchor: '80%',
                gwidth: 100,
            	maxLength:300
            },
                type:'TextField',
                filters:{pfiltro:'equ.num_serie',type:'string'},
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
                maxLength:500
            },
            type:'TextField',
            filters:{pfiltro:'equ.observaciones',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'color',
                fieldLabel: 'Color',
                allowBlank: true,
                hidden: true,
                anchor: '80%',
                gwidth: 100
            },
            type:'TextField',
            filters:{pfiltro:'equ.color',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'imei',
                fieldLabel: 'IMEI',
                allowBlank: true,
                hidden: true,
                anchor: '80%',
                gwidth: 100
            },
            type:'TextField',
            filters:{pfiltro:'equ.imei',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'sn',
                fieldLabel: 'SN',
                allowBlank: true,
                hidden: true,
                anchor: '80%',
                gwidth: 100
            },
            type:'TextField',
            filters:{pfiltro:'equ.sn',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'tamano_pantalla',
                fieldLabel: 'Tamaño Pantalla',
                allowBlank: true,
                hidden: true,
                anchor: '80%',
                gwidth: 100
            },
            type:'TextField',
            filters:{pfiltro:'equ.tamano_pantalla',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'tarjeta_video',
                fieldLabel: 'Tarjeta Video',
                allowBlank: true,
                hidden: true,
                anchor: '80%',
                gwidth: 100
            },
            type:'TextField',
            filters:{pfiltro:'equ.tarjeta_video',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'teclado',
                fieldLabel: 'Teclado',
                allowBlank: true,
                hidden: true,
                anchor: '80%',
                gwidth: 100
            },
            type:'TextField',
            filters:{pfiltro:'equ.teclado',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'procesador',
                fieldLabel: 'Procesador',
                allowBlank: true,
                hidden: true,
                anchor: '80%',
                gwidth: 100
            },
            type:'TextField',
            filters:{pfiltro:'equ.procesador',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'memoria_ram',
                fieldLabel: 'Memoria RAM',
                allowBlank: true,
                hidden: true,
                anchor: '80%',
                gwidth: 100
            },
            type:'TextField',
            filters:{pfiltro:'equ.sn',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'almacenamiento',
                fieldLabel: 'Almacenamiento',
                allowBlank: true,
                hidden: true,
                anchor: '80%',
                gwidth: 100
            },
            type:'TextField',
            filters:{pfiltro:'equ.almacenamiento',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'sistema_operativo',
                fieldLabel: 'Sistema Operativo',
                allowBlank: true,
                hidden: true,
                anchor: '80%',
                gwidth: 100
            },
            type:'TextField',
            filters:{pfiltro:'equ.sistema_operativo',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'accesorios',
                fieldLabel: 'Accesorios',
                allowBlank: true,
                hidden: true,
                anchor: '80%',
                gwidth: 100
            },
            type:'TextField',
            filters:{pfiltro:'equ.accesorios',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'id_usuario_ai',
                fieldLabel: '',
                allowBlank: true,
                hidden: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:4
            },
                type:'Field',
                filters:{pfiltro:'equ.id_usuario_ai',type:'numeric'},
                id_grupo:1,
                grid:false,
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
                filters:{pfiltro:'equ.fecha_reg',type:'date'},
                id_grupo:1,
                grid:true,
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
                filters:{pfiltro:'equ.usuario_ai',type:'string'},
                id_grupo:1,
                grid:true,
                form:false
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
                name: 'fecha_mod',
                fieldLabel: 'Fecha Modif.',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                            format: 'd/m/Y', 
                            renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
            },
                type:'DateField',
                filters:{pfiltro:'equ.fecha_mod',type:'date'},
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
		}
    ],
    tam_pag:50,    
    title:'Equipos',
    ActSave:'../../sis_gestion_comunicacion/control/Equipo/insertarEquipo',
    ActDel:'../../sis_gestion_comunicacion/control/Equipo/eliminarEquipo',
    ActList:'../../sis_gestion_comunicacion/control/Equipo/listarEquipoPc',
    id_store:'id_equipo',
    fields: [
		{name:'id_equipo', type: 'numeric'},
		{name:'estado_fisico', type: 'string'},
		{name:'observaciones', type: 'string'},
		{name:'marca', type: 'string'},
		{name:'tipo', type: 'string'},
        {name:'tipo_desc', type: 'string'},
		{name:'modelo', type: 'string'},
		{name:'estado', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'num_serie', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        {name:'id_equipo_movil', type: 'numeric'},
        {name:'color', type: 'string'},
        {name:'imei', type: 'string'},
        {name:'sn', type: 'string'},
        {name:'id_equipo_pc', type: 'numeric'},
        {name:'tamano_pantalla', type: 'string'},
        {name:'tarjeta_video', type: 'string'},
        {name:'teclado', type: 'string'},
        {name:'procesador', type: 'string'},
        {name:'memoria_ram', type: 'string'},
        {name:'almacenamiento', type: 'string'},
        {name:'sistema_operativo', type: 'string'},
        {name:'accesorios', type: 'string'},
        {name:'id_numero_celular', type: 'numeric'},
        {name:'numero', type: 'string'},

    ],
    sortInfo:{
        field: 'id_equipo',
        direction: 'ASC'
    },
    bdel:true,
    bsave:true,
    onButtonNew:function(){
        Phx.vista.Equipo.superclass.onButtonNew.call(this);
        this.Cmp.id_numero_celular.hide();
        this.Cmp.color.hide();
        this.Cmp.imei.hide();
        this.Cmp.sn.hide();
        this.Cmp.tamano_pantalla.hide();
        this.Cmp.tarjeta_video.hide();
        this.Cmp.teclado.hide();
        this.Cmp.procesador.hide();
        this.Cmp.memoria_ram.hide();
        this.Cmp.almacenamiento.hide();
        this.Cmp.sistema_operativo.hide();
        this.Cmp.accesorios.hide();
    },
    onButtonEdit: function() {
        Phx.vista.Equipo.superclass.onButtonEdit.call(this);
        var sel = this.sm.getSelected().data;

        if(sel.tipo == 'movil'){
            this.Cmp.id_numero_celular.show();
            this.Cmp.color.show();
            this.Cmp.imei.show();
            this.Cmp.sn.show();
            this.Cmp.tamano_pantalla.hide();
            this.Cmp.tarjeta_video.hide();
            this.Cmp.teclado.hide();
            this.Cmp.procesador.hide();
            this.Cmp.memoria_ram.hide();
            this.Cmp.almacenamiento.hide();
            this.Cmp.sistema_operativo.hide();
            this.Cmp.accesorios.hide();
        }else if (["laptop", "pc"].includes(sel.tipo)){
            this.Cmp.id_numero_celular.hide();
            this.Cmp.color.hide();
            this.Cmp.imei.hide();
            this.Cmp.sn.hide();
            if(sel.tipo == 'laptop'){
                this.Cmp.tamano_pantalla.show();
            }else{
                this.Cmp.tamano_pantalla.hide();
            }
            this.Cmp.tarjeta_video.show();
            this.Cmp.teclado.show();
            this.Cmp.procesador.show();
            this.Cmp.memoria_ram.show();
            this.Cmp.almacenamiento.show();
            this.Cmp.sistema_operativo.show();
            this.Cmp.accesorios.show();
        }else{
            this.Cmp.id_numero_celular.hide();
            this.Cmp.color.hide();
            this.Cmp.imei.hide();
            this.Cmp.sn.hide();
            this.Cmp.tamano_pantalla.hide();
            this.Cmp.tarjeta_video.hide();
            this.Cmp.teclado.hide();
            this.Cmp.procesador.hide();
            this.Cmp.memoria_ram.hide();
            this.Cmp.almacenamiento.hide();
            this.Cmp.sistema_operativo.hide();
            this.Cmp.accesorios.hide();
        }
    },
    tabsouth: [{
        url: '../../../sis_gestion_comunicacion/vista/accesorio/Accesorio.php',
        title: 'Detalle Accesorios',
        height: '40%',
        cls: 'Accesorio'
    }],
    }
)
</script>
        
        