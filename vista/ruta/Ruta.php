<?php
/**
*@package pXP
*@file gen-Ruta.php
*@author  (breydi.vasquez)
*@date 25-11-2020 18:07:20
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Ruta=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		this.tbarItems = ['-','<b style="color: green;">Gestion:</b>','-','-',this.cmbGestion,'-'];
		Phx.vista.Ruta.superclass.constructor.call(this,config);
		this.init();
		this.iniciarEventos();
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

		this.load({params:{start:0, limit:this.tam_pag}})
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
					name: 'id_ruta'
			},
			type:'Field',
			form:true
		},
		{
			config:{
				name: 'nro_ruta',
				fieldLabel: 'N° Ruta',
				allowBlank: true,
				anchor: '80%',
				gwidth: 50
			},
				type:'NumberField',
				filters:{pfiltro:'gruta.nro_ruta',type:'numeric'},
				bottom_filter: true,
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'cod_compania',
				fieldLabel: 'Código Compañia',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'gruta.cod_compania',type:'string'},
				bottom_filter: true,
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'salida',
				fieldLabel: 'Salida',
				allowBlank: true,
				anchor: '80%',
				gwidth: 340
			},
				type:'TextField',
				filters:{pfiltro:'gruta.salida',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
				config: {
						name: 'id_proveedor',
						hiddenName: 'id_proveedor',
						origen: 'PROVEEDOR',
						fieldLabel: 'Empresa',
						allowBlank: false,
						tinit: false,
						gwidth: 350,
						valueField: 'id_proveedor',
						gdisplayField: 'desc_proveedor',
						renderer: function (value, p, record) {
								return String.format('{0}', record.data['desc_proveedor']);
						},
						msgTarget: 'side',
						anchor: '60%'
				},
				type: 'ComboRec',
        filters:{pfiltro:'provee.desc_proveedor',type:'string'},
				id_grupo: 0,
				bottom_filter: true,
				grid: true,
				form: true
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
							return String.format('{0}', record.data['desc_gestion']);
						}
				},
				type:'ComboBox',
				id_grupo:0,
				filters:{
						pfiltro:'gestion',
						type:'string'
				},
				grid:false,
				form:true
		},
		{
				config: {
						name: 'id_concepto_ingas',
						fieldLabel: 'Concepto',
						allowBlank: false,
						emptyText: 'Concepto...',
						store: new Ext.data.JsonStore({
								url: '../../sis_parametros/control/ConceptoIngas/listarConceptoIngasMasPartida',
								id: 'id_concepto_ingas',
								root: 'datos',
								sortInfo: {
										field: 'desc_ingas',
										direction: 'ASC'
								},
								totalProperty: 'total',
								fields: ['id_concepto_ingas', 'tipo', 'desc_ingas', 'movimiento', 'desc_partida', 'id_grupo_ots', 'filtro_ot', 'requiere_ot', 'desc_gestion'],
								remoteSort: true,
								baseParams: {par_filtro: 'desc_ingas#par.codigo'}
						}),
						valueField: 'id_concepto_ingas',
						displayField: 'desc_ingas',
						gdisplayField: 'desc_ingas',
						hiddenName: 'id_concepto_ingas',
						forceSelection: true,
						typeAhead: false,
						triggerAction: 'all',
						listWidth: 430,
						resizable: true,
						lazyRender: true,
						mode: 'remote',
						pageSize: 10,
						queryDelay: 1000,
						width: 430,
						gwidth: 430,
						minChars: 2,
						qtip: 'Si el concepto de gasto que necesita no existe por favor  comuniquese con el área de presupuestos para solicitar la creación.',
						tpl: '<tpl for="."><div class="x-combo-list-item"><p><b>{desc_ingas}</b></p><strong>{tipo}</strong><p>PARTIDA: {desc_partida} - ({desc_gestion})</p></div></tpl>',
						renderer: function (value, p, record) {
								if(record.data.desc_ingas != ''){
										return String.format('{0} <br/><b>{1} - ({2}) </b>', record.data['desc_ingas'], record.data['desc_partida'], record.data['gestion']);
								}else{
										return  String.format('<div style="vertical-align:middle;text-align:right;"><span ><b>Total</b></span></div>',(parseFloat(value)));
								}
						}
				},
				type: 'ComboBox',
				bottom_filter: true,
				filters: {pfiltro: 'cig.desc_ingas#par.codigo', type: 'string'},
				id_grupo: 1,
				grid: true,
				form: true
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
				filters:{pfiltro:'gruta.fecha_reg',type:'date'},
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
				filters:{pfiltro:'gruta.estado_reg',type:'string'},
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
				filters:{pfiltro:'gruta.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'gruta.usuario_ai',type:'string'},
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
				filters:{pfiltro:'gruta.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,
	title:'Rutas',
	ActSave:'../../sis_gestion_comunicacion/control/Ruta/insertarRuta',
	ActDel:'../../sis_gestion_comunicacion/control/Ruta/eliminarRuta',
	ActList:'../../sis_gestion_comunicacion/control/Ruta/listarRuta',
	id_store:'id_ruta',
	fields: [
		{name:'id_ruta', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'nro_ruta', type: 'numeric'},
		{name:'cod_compania', type: 'string'},
		{name:'salida', type: 'string'},
		{name:'id_concepto_ingas', type: 'numeric'},
		{name:'id_proveedor', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'desc_ingas', type: 'string'},
		{name:'desc_partida', type: 'string'},
		{name:'gestion', type: 'string'},
		{name:'id_gestion', type: 'numeric'},
		{name:'desc_proveedor', type: 'string'},


	],
	sortInfo:{
		field: 'id_ruta',
		direction: 'ASC'
	},
	bdel:true,
	bsave:false,

	iniciarEventos:function(){

			this.Cmp.id_gestion.on('select',function(c,r,n){
					this.Cmp.id_concepto_ingas.reset();
					this.Cmp.id_concepto_ingas.store.baseParams.id_gestion = r.data.id_gestion;
					this.Cmp.id_concepto_ingas.modificado=true;

			},this);

	}


})
</script>
