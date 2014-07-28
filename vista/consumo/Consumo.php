<?php
/**
*@package pXP
*@file gen-Consumo.php
*@author  (jrivera)
*@date 24-07-2014 19:17:04
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Consumo=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Consumo.superclass.constructor.call(this,config);
		
		this.init();
		this.iniciarEventos();
		this.load({params:{start:0, limit:this.tam_pag,id_numero_celular : this.maestro.id_numero_celular}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_consumo'
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
	   				name : 'id_gestion',
	   				origen : 'GESTION',
	   				fieldLabel : 'Gestion',
	   				allowBlank : false,
	   				gdisplayField : 'gestion',//mapea al store del grid
	   				gwidth : 100,
		   			renderer : function (value, p, record){return String.format('{0}', record.data['gestion']);}
	       	     },
	   			type : 'ComboRec',
	   			id_grupo : 0,
	   			filters : {	
			        pfiltro : 'ges.gestion',
					type : 'numeric'
				},
	   		   
	   			grid : true,
	   			form : true
	   	},
		{
	   			config:{
	   				name : 'id_periodo',
	   				origen : 'PERIODO',
	   				fieldLabel : 'Periodo',
	   				allowBlank : true,
	   				gdisplayField : 'periodo',//mapea al store del grid
	   				gwidth : 100,
		   			renderer : function (value, p, record){return String.format('{0}', record.data['periodo']);}
	       	     },
	   			type : 'ComboRec',
	   			id_grupo : 0,
	   			filters : {	
			        pfiltro : 'per.periodo',
					type : 'numeric'
				},
	   		   
	   			grid : true,
	   			form : true
	   	},
		
		
		{
			config: {
				name: 'id_servicio',
				fieldLabel: 'Servicio',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_gestion_comunicacion/control/Servicio/listarServicio',
					id: 'id_servicio',
					root: 'datos',
					sortInfo: {
						field: 'nombre_servicio',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_servicio', 'nombre_servicio', 'codigo_servicio'],
					remoteSort: true,
					baseParams: {par_filtro: 'SER.nombre_servicio#SER.codigo_servicio'}
				}),
				valueField: 'id_servicio',
				displayField: 'nombre_servicio',
				gdisplayField: 'nombre_servicio',
				hiddenName: 'id_servicio',
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
					return String.format('{0}', record.data['nombre_servicio']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'SER.nombre_servicio',type: 'string'},
			grid: true,
			form: true
		},
		
		{
			config:{
				name: 'consumo',
				fieldLabel: 'Consumo',
				allowBlank: false,
				anchor: '60%',
				gwidth: 130,
				maxLength:1179650,
				allowDecimals : true,
				allowNegative:false,
				decimalPrecision : 2
			},
				type:'NumberField',
				filters:{pfiltro:'con.consumo',type:'numeric'},
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
				filters:{pfiltro:'con.observaciones',type:'string'},
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
				filters:{pfiltro:'con.estado_reg',type:'string'},
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
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'con.fecha_reg',type:'date'},
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
				filters:{pfiltro:'con.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'con.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'con.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Consumo por Número',
	ActSave:'../../sis_gestion_comunicacion/control/Consumo/insertarConsumo',
	ActDel:'../../sis_gestion_comunicacion/control/Consumo/eliminarConsumo',
	ActList:'../../sis_gestion_comunicacion/control/Consumo/listarConsumo',
	id_store:'id_consumo',
	fields: [
		{name:'id_consumo', type: 'numeric'},
		{name:'id_numero_celular', type: 'numeric'},
		{name:'id_periodo', type: 'numeric'},
		{name:'periodo', type: 'numeric'},
		{name:'gestion', type: 'numeric'},
		{name:'id_gestion', type: 'numeric'},
		{name:'id_servicio', type: 'numeric'},
		{name:'nombre_servicio', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'nombre_servicio', type: 'string'},
		{name:'observaciones', type: 'string'},
		{name:'consumo', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_periodo',
		direction: 'DESC'
	},
	bdel:true,
	bsave:true,
	iniciarEventos : function() {			
		this.Cmp.id_gestion.on('select',function(c,r,i){
			this.Cmp.id_periodo.reset();
			this.Cmp.id_periodo.store.baseParams.id_gestion = r.data.id_gestion;
			this.Cmp.id_periodo.modificado = true;
		},this);		
	},
	loadValoresIniciales:function()
    {
    	this.Cmp.id_numero_celular.setValue(this.maestro.id_numero_celular);      
        Phx.vista.Consumo.superclass.loadValoresIniciales.call(this);
               
    }
	}
)
</script>
		
		