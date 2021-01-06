<?php
/**
*@package pXP
*@file gen-PagoTelefonia.php
*@author  (breydi.vasquez)
*@date 24-11-2020 16:26:24
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<style>
.button-up-excel{
	background-image: url('../../../sis_horas_piloto/media/logo/upload_file.png');
	background-repeat: no-repeat;
	filter: saturate(250%);
	background-size: 60%;
}
</style>

<script>
Phx.vista.PagoTelefonia=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		this.tbarItems = ['-','<b style="color: green;">Gestion:</b>','-','-',this.cmbGestion,'-'];
		Phx.vista.PagoTelefonia.superclass.constructor.call(this,config);
		this.init();
		this.iniciarEventos();


		this.addButton('btnsubir_archivo', {
						text: 'Cargar Excel',
						iconCls:'button-up-excel',
						disabled: false,
						handler: this.subirArchivo,
						tooltip: '<b>Cargar Archivo</b><br/>Carga un Archivo del tipo Excel.'
				}
		);

		this.addButton('btnCalcPagoTel', {
				text: 'Calculo porcentual',
				iconCls: 'bcalculator',
				disabled: false,
				hidden: false,
				handler:this.onCalcPorcentual,
				tooltip: '<b>Calculo porcentual:</b>'
		});

		Ext.Ajax.request({
				url: '../../sis_parametros/control/Gestion/obtenerGestionByFecha',
				params: {fecha: new Date()},
				success: function (resp) {
						var reg = Ext.decode(Ext.util.Format.trim(resp.responseText));
						this.cmbGestion.setValue(reg.ROOT.datos.id_gestion);
						this.cmbGestion.setRawValue(reg.ROOT.datos.anho);
						this.store.baseParams.id_gestion = reg.ROOT.datos.id_gestion;
						this.load({params: {start: 0, limit: this.tam_pag}});
				},
				failure: this.conexionFailure,
				timeout: this.timeout,
				scope: this
		});

		this.cmbGestion.on('select', this.capturarEventos, this);
		this.load({params:{start:0, limit:this.tam_pag}});
	},

	capturarEventos: function () {
			this.store.baseParams.id_gestion = this.cmbGestion.getValue();
			this.load({params: {start: 0, limit: this.tam_pag}});
	},

	cmbGestion: new Ext.form.ComboBox({
			name: 'gestion',
			id: 'gestion_reg',
			fieldLabel: 'Gestion',
			allowBlank: true,
			emptyText:'Gestion...',
			blankText: 'Año',
			store:new Ext.data.JsonStore(
					{
							url: '../../sis_parametros/control/Gestion/listarGestion',
							id: 'id_gestion',
							root: 'datos',
							sortInfo:{
									field: 'gestion',
									direction: 'DESC'
							},
							totalProperty: 'total',
							fields: ['id_gestion','gestion'],
							// turn on remote sorting
							remoteSort: true,
							baseParams:{par_filtro:'gestion'}
					}),
			valueField: 'id_gestion',
			triggerAction: 'all',
			displayField: 'gestion',
			hiddenName: 'id_gestion',
			mode:'remote',
			pageSize:5,
			queryDelay:100,
			listWidth:'220',
			hidden:false,
			width:80
	}),

	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_pago_telefonia'
			},
			type:'Field',
			form:true
		},
		{
				config:{
						name:'id_gestion',
						fieldLabel:'Gestión',
						allowBlank:false,
						emptyText:'Gestión...',
						store: new Ext.data.JsonStore({
								url: '../../sis_parametros/control/Gestion/listarGestion',
								id: 'id_gestion',
								root: 'datos',
								sortInfo:{
										field: 'gestion',
										direction: 'DESC'
								},
								totalProperty: 'total',
								fields: ['id_gestion','gestion','moneda','codigo_moneda'],
								remoteSort: true,
								baseParams:{par_filtro:'gestion'}
						}),
						valueField: 'id_gestion',
						displayField: 'gestion',
						hiddenName: 'id_gestion',
						forceSelection:true,
						typeAhead: false,
						triggerAction: 'all',
						lazyRender:true,
						mode:'remote',
						pageSize:5,
						queryDelay:1000,
						listWidth:200,
						resizable:true,
						anchor:'45%',
						gwidth: 80,
		renderer : function(value, p, record) {
			return String.format('{0}', record.data['gestion']);
		}
				},
				type:'ComboBox',
				id_grupo:0,
				filters:{
						pfiltro:'gestion',
						type:'string'
				},
				grid:true,
				form:true
		},
		{
				config:{
						name:'id_periodo',
						fieldLabel:'Periodo',
						allowBlank:false,
						emptyText:'Periodo...',
						store: new Ext.data.JsonStore({
								url: '../../sis_parametros/control/Periodo/listarPeriodo',
								id: 'id_periodo',
								root: 'datos',
								sortInfo:{
										field: 'id_periodo',
										direction: 'ASC'
								},
								totalProperty: 'total',
								fields: ['id_periodo','literal','periodo','fecha_ini','fecha_fin'],
								remoteSort: true,
								baseParams:{par_filtro:'periodo#literal'}
						}),
						valueField: 'id_periodo',
						displayField: 'literal',
						hiddenName: 'id_periodo',
						forceSelection:true,
						typeAhead: false,
						triggerAction: 'all',
						lazyRender:true,
						mode:'remote',
						pageSize:12,
						queryDelay:1000,
						listWidth:200,
						resizable:true,
						anchor:'45%',
						gwidth: 100,
		renderer : function(value, p, record) {
			return String.format('{0}', record.data['literal']);
		}

				},
				type:'ComboBox',
				id_grupo:0,
				filters:{
						pfiltro:'literal',
						type:'string'
				},
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nombre',
				fieldLabel: 'Nombre',
				allowBlank: true,
				anchor: '80%',
				gwidth: 200,
				renderer : function(value, p, record) {
					return String.format('{0}', 'Pago De Telefonia Mes '+ record.data['literal']);
				}
			},
				type:'TextField',
				filters:{pfiltro:'pagtel.nombre',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'descripcion',
				fieldLabel: 'Observacion',
				allowBlank: true,
				anchor: '80%',
				gwidth: 250,
			},
				type:'TextArea',
				filters:{pfiltro:'pagtel.descripcion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'estado',
				fieldLabel: 'Estado',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				renderer : function(value, p, record) {
					var resp
					if(value=='registrado'){
						resp = '<b style="color:blue;">Registrado</b>'
					}else if(value=='cargado'){
						resp = '<b style="color:orange;">Cargado</b>'
					}else{
						resp = '<b style="color:green;">Calculado</b>'
					}
					return String.format('<div style="text-align:center;">{0}</div>', resp);
				}
			},
				type:'TextField',
				filters:{pfiltro:'pagtel.nombre',type:'string'},
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
				gwidth: 150,
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
				gwidth: 130,
							format: 'd/m/Y',
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'pagtel.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
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
				filters:{pfiltro:'pagtel.estado_reg',type:'string'},
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
				filters:{pfiltro:'pagtel.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'pagtel.usuario_ai',type:'string'},
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
				filters:{pfiltro:'pagtel.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,
	title:'Pago telefonia',
	ActSave:'../../sis_gestion_comunicacion/control/PagoTelefonia/insertarPagoTelefonia',
	ActDel:'../../sis_gestion_comunicacion/control/PagoTelefonia/eliminarPagoTelefonia',
	ActList:'../../sis_gestion_comunicacion/control/PagoTelefonia/listarPagoTelefonia',
	id_store:'id_pago_telefonia',
	fields: [
		{name:'id_pago_telefonia', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_gestion', type: 'numeric'},
		{name:'id_periodo', type: 'numeric'},
		{name:'nombre', type: 'string'},
		{name:'descripcion', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'gestion', type: 'numeric'},
		{name:'literal', type: 'string'},
		{name:'estado', type: 'string'}

	],
	sortInfo:{
		field: 'id_periodo',
		direction: 'DESC'
	},
	bdel:true,
	bsave:false,

	// preparaMenu:function(n){
  //        var data = this.getSelectedData();
  //        Phx.vista.PagoTelefonia.superclass.preparaMenu.call(this,n);
  //        if ( data.estado == 'cargado' ) {
  //            this.getBoton('btnCalcPagoTel').enable();
	// 				 }
	// }
	onButtonNew:function(){
		this.window.setSize(700, 250);
		Phx.vista.PagoTelefonia.superclass.onButtonNew.call(this);
	},

	onButtonEdit:function(){
		this.window.setSize(700, 250);
		Phx.vista.PagoTelefonia.superclass.onButtonEdit.call(this);
		var data = this.getSelectedData();

    this.Cmp.id_periodo.on('focus',function(c,r,n){
	    this.Cmp.id_periodo.reset();
	    this.Cmp.id_periodo.store.baseParams={id_gestion:data.id_gestion, vista: 'reporte'};
	    this.Cmp.id_periodo.modificado=true;
    },this);
	},

	iniciarEventos:function(){

			this.Cmp.id_gestion.on('select',function(c,r,n){
					this.Cmp.id_periodo.reset();
					this.Cmp.id_periodo.store.baseParams={id_gestion:c.value, vista: 'reporte'};
					this.Cmp.id_periodo.modificado=true;

			},this);

	},

	subirArchivo: function () {
			var rec=this.sm.getSelected();
			var NumSelect = this.sm.getCount();
			if(NumSelect != 0){
					Phx.CP.loadWindows('../../../sis_gestion_comunicacion/vista/pago_telefonia/PagoTelfExcel.php',
							`<span style="font-size:15px; font-weight:bold;">CARGAR ARCHIVO EXCEL GESTION ${rec.data.gestion} MES DE ${rec.data.literal.toUpperCase()}`,
							{
									modal:true,
									width:450,
									height:200
							},rec.data,this.idContenedor,'PagoTelfExcel')
			}else{
					Ext.MessageBox.alert('Alerta', 'Antes debe seleccionar un item.');
			}
	},

	onCalcPorcentual: function() {
		var rec=this.sm.getSelected();
			if(rec.data.estado == 'cargado' || rec.data.estado == 'calculado'){
				Ext.Ajax.request({
						url: '../../sis_gestion_comunicacion/control/PagoTelefonia/calculoPagoTelefonia',
						params: {id_pago_telefonia: rec.data.id_pago_telefonia, id_gestion: rec.data.id_gestion},
						success: this.successSaves,
						failure: this.conexionFailure,
						timeout: this.timeout,
						scope: this
				});
			}else{
				Ext.MessageBox.alert('Alerta', 'Para proceder con el calculo favor cargar el excel de pago de telefonia.');
			}
	},

	successSaves: function(resp){
		Phx.CP.loadingHide();
		var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
		if(!reg.ROOT.error){
				this.reload();
		}else{
				alert('ocurrio un error durante el proceso')
		}
	},

	tabsouth:[
		{
				url:'../../../sis_gestion_comunicacion/vista/pago_telefonia_det/PagoTelefoniaDet.php',
				title:'Detalle Pagos telefonia',
				height: '50%',
				cls:'PagoTelefoniaDet'
		}
	]

})
</script>
