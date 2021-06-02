<?php
/**
*@package pXP
*@file gen-Servicio.php
*@author  (jrivera)
*@date 23-07-2014 22:43:19
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Servicio=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Servicio.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_servicio'
			},
			type:'Field',
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
                anchor: '80%',
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
			config:{
				name: 'codigo_servicio',
				fieldLabel: 'Código',
				allowBlank: true,
                hidden: true,
				anchor: '80%',
				gwidth: 120,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'ser.codigo_servicio',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
        
        {
			config:{
				name: 'nombre_servicio',
				fieldLabel: 'Nombre',
				allowBlank: false,
				anchor: '80%',
				gwidth: 150,
				maxLength:200
			},
				type:'TextField',
				filters:{pfiltro:'ser.nombre_servicio',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
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
				name: 'defecto',
				fieldLabel: 'Asignar por defecto',
				allowBlank:true,
                hidden: true,
				emptyText:'defecto...',
	       		typeAhead: false,
	       		triggerAction: 'all',
	       		lazyRender:true,
	       		mode: 'local',
				gwidth: 120,
				store:['si','no'],
				value:'no'
			},
				type:'ComboBox',
				filters:{	
	       		         type: 'list',
	       				 options: ['si','no'],	
	       		 	},
				id_grupo:1,
				grid:true,
				form:true
		},	
		
		{
			config:{
				name: 'trafico_libre',
				fieldLabel: 'Traf. Libre(MB)',
				allowBlank: false,
				anchor: '80%',
				gwidth: 120,
				maxLength:1179650
			},
				type:'NumberField',
				filters:{pfiltro:'ser.trafico_libre',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'trafico_adicional',
				fieldLabel: 'Traf. Adicional (Bs/MB)',
				allowBlank: false,
				anchor: '80%',
				gwidth: 130,
				maxLength:1179650
			},
				type:'NumberField',
				filters:{pfiltro:'ser.trafico_adicional',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'observaciones',
				fieldLabel: 'Observaciones',
				allowBlank: true,
				anchor: '80%',
				gwidth: 200
			},
				type:'TextArea',
				filters:{pfiltro:'ser.observaciones',type:'string'},
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
				filters:{pfiltro:'ser.estado_reg',type:'string'},
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
				filters:{pfiltro:'ser.fecha_reg',type:'date'},
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
				filters:{pfiltro:'ser.usuario_ai',type:'string'},
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
				name: 'id_usuario_ai',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'ser.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'ser.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Servicio',
	ActSave:'../../sis_gestion_comunicacion/control/Servicio/insertarServicio',
	ActDel:'../../sis_gestion_comunicacion/control/Servicio/eliminarServicio',
	ActList:'../../sis_gestion_comunicacion/control/Servicio/listarServicio',
	id_store:'id_servicio',
	fields: [
		{name:'id_servicio', type: 'numeric'},
		{name:'id_proveedor', type: 'numeric'},
		{name:'trafico_adicional', type: 'numeric'},
		{name:'tarifa', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'defecto', type: 'string'},
		{name:'desc_proveedor', type: 'string'},
		{name:'nombre_servicio', type: 'string'},
		{name:'observaciones', type: 'string'},
		{name:'codigo_servicio', type: 'string'},
		{name:'trafico_libre', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        {name:'tipo_servicio', type: 'string'},
        {name:'tipo_servicio_desc', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_servicio',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    onReloadPage:function(m){
        this.maestro=m;
        console.log(this.maestro);
        //this.store.baseParams={id_proveedor: this.maestro.id_proveedor};
        this.load({params:{start:0, limit:this.tam_pag}})
    },
	loadValoresIniciales:function()
    {
    	this.Cmp.defecto.setValue('no');
    	this.Cmp.trafico_libre.setValue(0);
    	this.Cmp.trafico_adicional.setValue(0);
        Phx.vista.Servicio.superclass.loadValoresIniciales.call(this);
        //this.getComponente('id_proveedor').setValue(this.maestro.id_proveedor);
    },
	}
)
</script>
		
		