<?php
/**
*@package pXP
*@file gen-NumeroCelular.php
*@author  (jrivera)
*@date 23-07-2014 22:43:16
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.NumeroCelular=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.NumeroCelular.superclass.constructor.call(this,config);
		this.init();
		this.addButton('btnDetalleConsumo',
            {
                text: ' Detalle Consumo',
                iconCls: 'blist',
                disabled: true,
                handler: this.onBtnDetalleConsumo,
                tooltip: 'Detalle Consumo Mensual'
            }
        );
        this.addButton('btnConsumoCsv',
            {
                text: 'Subir Consumo',
                iconCls: 'blist',
                disabled: false,
                handler: this.onButtonConsumoCsv,
                tooltip: 'Subir consumo desde arhcivo CSV'
            }
        );
        
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
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
				name: 'numero',
				fieldLabel: 'Número',
				allowBlank: false,
				anchor: '80%',
				gwidth: 150,
				maxLength:20
			},
				type:'TextField',
				filters:{pfiltro:'numcel.numero',type:'string'},
				id_grupo:1,
				grid:true,
				bottom_filter:true,
				form:true
		},
		
		{
			config:{
				name: 'tipo',
				fieldLabel: 'Tipo',
				allowBlank:false,
				emptyText:'Tipo...',
	       		typeAhead: false,
	       		triggerAction: 'all',
	       		lazyRender:true,
	       		mode: 'local',
				gwidth: 90,
				store:['celular','4g','fijo','interno'],
				value:'no'
			},
				type:'ComboBox',
				filters:{pfiltro:'numcel.tipo',	
	       		         type: 'list',
	       				 options: ['celular','4g','fijo'],	
	       		 	},
				id_grupo:1,
				grid:true,
				form:true,
				bottom_filter:true
		},

		{
			config:{
				name:'id_proveedor',
				hiddenName: 'id_proveedor',
				origen:'PROVEEDOR',
				fieldLabel:'Proveedor',
				allowBlank:true,
				tinit:false,
				gwidth:400,
				valueField: 'id_proveedor',
				gdisplayField: 'desc_proveedor',
				renderer:function(value, p, record){return String.format('{0}', record.data['desc_proveedor']);}
			},
			type:'ComboRec',//ComboRec
			id_grupo:0,
			filters:{pfiltro:'pro.desc_proveedor',type:'string'},
			grid:true,
			bottom_filter:true,
			form:true
		},
		{
			config:{
				name: 'roaming',
				fieldLabel: 'Roaming',
				allowBlank:false,
				emptyText:'Roaming...',
	       		typeAhead: false,
	       		triggerAction: 'all',
	       		lazyRender:true,
	       		mode: 'local',
				gwidth: 90,
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
				name: 'observaciones',
				fieldLabel: 'Observaciones',
				allowBlank: true,
				anchor: '80%',
				gwidth: 200
			},
				type:'TextArea',
				filters:{pfiltro:'numcel.observaciones',type:'string'},
				id_grupo:1,
				grid:true,
				bottom_filter:true,
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
				filters:{pfiltro:'numcel.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: '',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'numcel.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'numcel.fecha_reg',type:'date'},
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
				filters:{pfiltro:'numcel.usuario_ai',type:'string'},
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
				filters:{pfiltro:'numcel.fecha_mod',type:'date'},
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
	title:'Numeros de Celular',
	ActSave:'../../sis_gestion_comunicacion/control/NumeroCelular/insertarNumeroCelular',
	ActDel:'../../sis_gestion_comunicacion/control/NumeroCelular/eliminarNumeroCelular',
	ActList:'../../sis_gestion_comunicacion/control/NumeroCelular/listarNumeroCelular',
	id_store:'id_numero_celular',
	fields: [
		{name:'id_numero_celular', type: 'numeric'},
		{name:'id_proveedor', type: 'numeric'},
		{name:'numero', type: 'string'},
		{name:'tipo', type: 'string'},
		{name:'desc_proveedor', type: 'string'},
		{name:'observaciones', type: 'string'},
		{name:'roaming', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'numero',
		direction: 'ASC'
	},
	loadValoresIniciales:function()
    {
    	this.Cmp.roaming.setValue('no');  
    	this.Cmp.tipo.setValue('celular');     
        Phx.vista.NumeroCelular.superclass.loadValoresIniciales.call(this);        
    },
	bdel:true,
	bsave:true,
	south:{
		  url:'../../../sis_gestion_comunicacion/vista/numero_servicio/NumeroServicio.php',
		  title:'Servicios por Número', 
		  height:'40%',
		  cls:'NumeroServicio'
	},
	onBtnDetalleConsumo : function() {
		var rec = {maestro: this.sm.getSelected().data};
						      
            Phx.CP.loadWindows('../../../sis_gestion_comunicacion/vista/consumo/Consumo.php',
                    'Consumo X Número',
                    {
                        width:800,
                        height:'90%'
                    },
                    rec,
                    this.idContenedor,
                    'Consumo');
	},
	
	onButtonConsumoCsv : function() {          
        Phx.CP.loadWindows('../../../sis_gestion_comunicacion/vista/consumo/ConsumoCsv.php',
        'Subir Consumo de Números',
        {
            modal:true,
            width:450,
            height:200
        },undefined,this.idContenedor,'ConsumoCsv')
    },
	preparaMenu:function()
    {	        
        this.getBoton('btnDetalleConsumo').enable();            
        Phx.vista.NumeroCelular.superclass.preparaMenu.call(this);
    },
    liberaMenu:function()
    {	
        this.getBoton('btnDetalleConsumo').disable();                  
        Phx.vista.NumeroCelular.superclass.preparaMenu.call(this);
    },
	}
)
</script>
		
		