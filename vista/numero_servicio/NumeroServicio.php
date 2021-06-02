<?php
/**
*@package pXP
*@file gen-NumeroServicio.php
*@author  (jrivera)
*@date 23-07-2014 23:47:15
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.NumeroServicio=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.NumeroServicio.superclass.constructor.call(this,config);
		this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
        this.iniciarEventos();
	},
    iniciarEventos: function (){
        var me = this;
        var cmbCatTipo=this.getComponente('id_servicio');
        var cmbTarifa=this.getComponente('tarifa');

        this.Cmp.tipo_servicio.on('select', function( combo, record, index){
            cmbCatTipo.setValue(null);
            cmbCatTipo.store.baseParams.tipo_servi = record.data.codigo;
        },this);

        this.Cmp.id_servicio.on('select', function( combo, record, index){
            cmbTarifa.setValue(null);
            cmbTarifa.setValue(record.data.tarifa);
        },this);

    },
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_numero_servicio'
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
            config : {
                name:'tipo_servicio',
                fieldLabel : 'Tipo Servicio',
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
                    baseParams: {par_filtro:'descripcion',cod_subsistema:'GECOM',catalogo_tipo:'tipo_servicio'}
                }),
                enableMultiSelect:true,
                valueField: 'codigo',
                displayField: 'descripcion',
                gdisplayField: 'tipo_servicio_desc',
                triggerAction: 'all',
                lazyRender:true,
                mode:'remote',
                pageSize:15,
                queryDelay: 1000,
                anchor: '80%',
                gwidth: 100,
                renderer:function (value,p,record){return value?'<b style="color: green;">'+record.data['tipo_servicio_desc']+'</b>':''},
                listeners: {
                    beforequery: function(qe){
                        delete qe.combo.lastQuery;
                    }
                },
            },
            type:'ComboBox',
            filters:{pfiltro:'tipo_servicio',type:'string'},
            id_grupo:0,
            grid:true,
            form:true
        },
		{
			config: {
				name: 'id_servicio',
				fieldLabel: 'Servicio',
				allowBlank: false,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_gestion_comunicacion/control/Servicio/listarServicio',
					id: 'id_servicio',
					root: 'datos',
					sortInfo: {
						field: 'nombre_combo',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_servicio', 'nombre_combo', 'codigo_servicio','tarifa'],
					remoteSort: true,
					baseParams: {par_filtro: 'SER.nombre_combo#SER.codigo_servicio'}
				}),
				valueField: 'id_servicio',
				displayField: 'nombre_combo',
				gdisplayField: 'nombre_servicio',
				hiddenName: 'id_servicio',
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
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['nombre_servicio']);
				},
                listeners: {
                    beforequery: function(qe){
                        delete qe.combo.lastQuery;
                    }
                },
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'SER.nombre_combo',type: 'string'},
			grid: true,
			form: true
		},
        {
            config:{
                name: 'tarifa',
                fieldLabel: 'Tarifa',
                allowBlank: true,
                anchor: '80%',
                gwidth: 120,
                maxLength:1179650
            },
            type:'NumberField',
            filters:{pfiltro:'ser.tarifa',type:'numeric'},
            id_grupo:1,
            grid:true,
            form:true
        },
		{
			config:{
				name: 'fecha_inicio',
				fieldLabel: 'Fecha inicio',
				allowBlank: true,
                hidden: true,
				anchor: '80%',
				gwidth: 120,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'numser.fecha_inicio',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'fecha_fin',
				fieldLabel: 'Fecha Fin',
				allowBlank: true,
                hidden: true,
				anchor: '80%',
				gwidth: 120,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'numser.fecha_fin',type:'date'},
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
				gwidth: 100
			},
				type:'TextArea',
				filters:{pfiltro:'numser.observaciones',type:'string'},
				id_grupo:1,
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
				filters:{pfiltro:'numser.estado_reg',type:'string'},
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
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'numser.usuario_ai',type:'string'},
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
				filters:{pfiltro:'numser.fecha_reg',type:'date'},
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
				filters:{pfiltro:'numser.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'numser.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Servicios por Número',
	ActSave:'../../sis_gestion_comunicacion/control/NumeroServicio/insertarNumeroServicio',
	ActDel:'../../sis_gestion_comunicacion/control/NumeroServicio/eliminarNumeroServicio',
	ActList:'../../sis_gestion_comunicacion/control/NumeroServicio/listarNumeroServicio',
	id_store:'id_numero_servicio',
	fields: [
		{name:'id_numero_servicio', type: 'numeric'},
		{name:'id_servicio', type: 'numeric'},
		{name:'id_numero_celular', type: 'numeric'},
		{name:'observaciones', type: 'string'},
		{name:'nombre_servicio', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'fecha_fin', type: 'date',dateFormat:'Y-m-d'},
		{name:'fecha_inicio', type: 'date',dateFormat:'Y-m-d'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        {name:'tipo_servicio', type: 'string'},
        {name:'tipo_servicio_desc', type: 'string'},
        {name:'tarifa', type: 'numeric'},
		
	],
	sortInfo:{
		field: 'id_numero_servicio',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	onReloadPage:function(m){       
		this.maestro=m;
		this.load({params:{start:0, limit:this.tam_pag,id_numero_celular:this.maestro.id_numero_celular}});
		this.Cmp.id_servicio.store.baseParams.id_proveedor = this.maestro.id_proveedor;
		this.Cmp.id_servicio.modificado=true;
		
	},
	loadValoresIniciales:function()
    {    	
    	this.Cmp.id_numero_celular.setValue(this.maestro.id_numero_celular);       
        Phx.vista.NumeroServicio.superclass.loadValoresIniciales.call(this);        
    }
	}
)
</script>
		
		