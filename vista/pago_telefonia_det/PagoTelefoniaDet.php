<?php
/**
*@package pXP
*@file gen-PagoTelefoniaDet.php
*@author  (breydi.vasquez)
*@date 24-11-2020 16:26:28
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.PagoTelefoniaDet=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.PagoTelefoniaDet.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},

	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_pago_telefonia_det'
			},
			type:'Field',
			form:true
		},
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
				name: 'fecha',
				fieldLabel: 'Fecha',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y',
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'detpagte.fecha',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'hora',
				fieldLabel: 'Hora',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				renderer: (value, p, record) => {
					return  String.format('<div style="text-align:center;">{0}</div>', value);
				}
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.hora',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'anexo',
				fieldLabel: 'Anexo',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.anexo',type:'string'},
				bottom_filter:true,
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'cod_empleado',
				fieldLabel: 'Código Empleado',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.cod_empleado',type:'string'},
				bottom_filter:true,
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nombre_empleado',
				fieldLabel: 'Nombre Empleado',
				allowBlank: true,
				anchor: '80%',
				gwidth: 150
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.nombre_empleado',type:'string'},
				bottom_filter:true,
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nro_telefono',
				fieldLabel: 'N° Télefono',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.nro_telefono',type:'string'},
				bottom_filter:true,
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nombre_telefono',
				fieldLabel: 'Nombre Télefono',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.nombre_telefono',type:'string'},
				bottom_filter:true,
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'duracion_real',
				fieldLabel: 'Duración Real',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				renderer: (value, p, record) => {
					return  String.format('<div style="text-align:center;">{0}</div>', value);
				}
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.duracion_real',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'costo_llamada',
				fieldLabel: 'Costo Llamada',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				renderer: (value, p, record) => {
					return  String.format('<div style="text-align:center;font-weight:bold;">{0}</div>', value);
				}
			},
				type:'NumberField',
				filters:{pfiltro:'detpagte.costo_llamada',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'factor_porcentual',
				fieldLabel: 'Factor Porcentual',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				renderer: (value, p, record) => {
						if(value!=null){
							return  String.format('<div style="text-align:center;font-weight:bold;">{0}</div>', value);
						}else {
							return '';
						}
				}
			},
				type:'NumberField',
				filters:{pfiltro:'detpagte.factor_porcentual',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'servicio_llamada',
				fieldLabel: 'Servicio Llamada',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.servicio_llamada',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'cod_sucursal',
				fieldLabel: 'Código Sucursal',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.cod_sucursal',type:'string'},
				bottom_filter:true,
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'sucursal',
				fieldLabel: 'Sucursal',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.sucursal',type:'string'},
				bottom_filter:true,
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'ruta',
				fieldLabel: 'Ruta',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'NumberField',
				filters:{pfiltro:'detpagte.ruta',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'cod_compania',
				fieldLabel: 'Código Compania',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.cod_compania',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'troncal',
				fieldLabel: 'Troncal',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,

			},
				type:'NumberField',
				filters:{pfiltro:'detpagte.troncal',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'cod_usuario',
				fieldLabel: 'Código Usuario',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.cod_usuario',type:'string'},
				bottom_filter:true,
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'cod_organizacion',
				fieldLabel: 'Código Organización',
				allowBlank: true,
				anchor: '80%',
				gwidth: 150,
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.cod_organizacion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'organizacion',
				fieldLabel: 'Organización',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.organizacion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'cod_centro_costo',
				fieldLabel: 'Código Centro Costo',
				allowBlank: true,
				anchor: '80%',
				gwidth: 120
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.cod_centro_costo',type:'string'},
				bottom_filter:true,
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'centro_costo',
				fieldLabel: 'Centro Costo',
				allowBlank: true,
				anchor: '80%',
				gwidth: 180
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.centro_costo',type:'string'},
				bottom_filter:true,
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nro_origen',
				fieldLabel: 'N° Origen',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.nro_origen',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'cod_ciudad',
				fieldLabel: 'Código Ciudad',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.cod_ciudad',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'ciudad',
				fieldLabel: 'Ciudad',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.ciudad',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'cod_pais',
				fieldLabel: 'Código Pais',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.cod_pais',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'pais',
				fieldLabel: 'Pais',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.pais',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'duracion_llamada',
				fieldLabel: 'Duración Llamada',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'NumberField',
				filters:{pfiltro:'detpagte.duracion_llamada',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'globa_l',
				fieldLabel: 'Global',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.globa_l',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'tipo_resp_llamada',
				fieldLabel: 'Tipo Resp. Llamada',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.tipo_resp_llamada',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'transferir_a',
				fieldLabel: 'Transferir A',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.transferir_a',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'transferir_desde',
				fieldLabel: 'Transferir Desde',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.transferir_desde',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'evento',
				fieldLabel: 'Evento',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.evento',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'posicion_memoria',
				fieldLabel: 'Posicion Memoria',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.posicion_memoria',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'tiempo_timbrado',
				fieldLabel: 'Tiempo Timbrado',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				renderer: (value, p, record) => {
					return  String.format('<div style="text-align:center;">{0}</div>', value);
				}
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.tiempo_timbrado',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'cod_grupo_base_destino',
				fieldLabel: 'Código Grupo Base Destino',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.cod_grupo_base_destino',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'grupo_base_destino',
				fieldLabel: 'Grupo Base Destino',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.grupo_base_destino',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'grupo_destino',
				fieldLabel: 'Grupo Destino',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.grupo_destino',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'cod_interno',
				fieldLabel: 'Código Interno',
				allowBlank: true,
				anchor: '80%',
				gwidth: 130
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.cod_interno',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'fac',
				fieldLabel: 'Fac',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.fac',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'desv_de_desv_a',
				fieldLabel: 'Desv. De Desv. A',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.desv_de_desv_a',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
				config:{
						name:'id_centro_costo',
						origen:'CENTROCOSTO',
						fieldLabel: 'Centro de Costos',
						url: '../../sis_parametros/control/CentroCosto/listarCentroCostoFiltradoXDepto',
						emptyText : 'Centro Costo...',
						allowBlank:false,
						gdisplayField:'desc_centro_costo',//mapea al store del grid
						gwidth:300,
						anchor: '100%',
						listWidth:460,
						baseParams:{filtrar:'grupo_ep'},
						renderer:function (value, p, record){return String.format('{0}', record.data['desc_centro_costo'])},
						msgTarget: 'side'
				},
				type:'ComboRec',
				id_grupo:0,
				filters:{pfiltro:'cc.codigo_cc',type:'string'},
				grid:true,
				form:false
		},
		{
				config:{
						name: 'id_concepto_ingas',
						fieldLabel: 'Concepto',
						allowBlank: false,
						emptyText : 'Concepto...',
						store : new Ext.data.JsonStore({
								url:'../../sis_parametros/control/ConceptoIngas/listarConceptoIngasMasPartida',
								id : 'id_concepto_ingas',
								root: 'datos',
								sortInfo:{
										field: 'desc_ingas',
										direction: 'ASC'
								},
								totalProperty: 'total',
								fields: ['id_concepto_ingas','tipo','desc_ingas','movimiento','desc_partida','id_grupo_ots','filtro_ot','requiere_ot'],
								remoteSort: true,
								baseParams:{par_filtro:'desc_ingas#par.codigo',movimiento:'gasto', autorizacion: 'adquisiciones'}
						}),
						valueField: 'id_concepto_ingas',
						displayField: 'desc_ingas',
						gdisplayField: 'desc_concepto_ingas',
						hiddenName: 'id_concepto_ingas',
						forceSelection:true,
						typeAhead: false,
						triggerAction: 'all',
						listWidth:460,
						resizable:true,
						lazyRender:true,
						mode:'remote',
						pageSize:15,
						queryDelay:1000,
						// width:350,
						gwidth:400,
						minChars:20,
						anchor: '100%',
						qtip:'Si el conceto de gasto que necesita no existe por favor  comuniquese con el área de presupuestos para solictar la creación',
						tpl: '<tpl for="."><div class="x-combo-list-item"><p><b>{desc_ingas}</b></p><strong>{tipo}</strong><p>PARTIDA: {desc_partida}</p></div></tpl>',
						renderer:function(value, p, record){return String.format('{0}', record.data['desc_concepto_ingas']);},
						msgTarget: 'side'
				},
				type:'ComboBox',
				filters:{pfiltro:'cig.desc_ingas',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},

        {
            config:{
                name: 'salida',
                fieldLabel: 'Salida',
                allowBlank: true,
                anchor: '80%',
                gwidth:300
            },
            type:'TextField',
            filters:{pfiltro:'gruta.salida',type:'string'},
            id_grupo:1,
            grid:true,
            form:false
        },
        {
            config:{
                name:'id_numero_celular',
                fieldLabel:'Número',
                allowBlank:true,
                emptyText:'Número...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_gestion_comunicacion/control/NumeroCelular/listarNumeroCelular',
                    id: 'id_numero_celular',
                    root: 'datos',
                    sortInfo:{
                        field: 'numero',
                        direction: 'DESC'
                    },
                    totalProperty: 'total',
                    fields: ['id_numero_celular','numero','tipo','desc_proveedor'],
                    remoteSort: true,
                    baseParams:{par_filtro:'numero'}
                }),
                valueField: 'id_numero_celular',
                displayField: 'numero',
                hiddenName: 'id_numero_celular',
                forceSelection:true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender:true,
                mode:'remote',
                pageSize:5,
                queryDelay:1000,
                listWidth:200,
                resizable:true,
                anchor: '60%',
                gwidth: 100,
                tpl: '<tpl for="."><div class="x-combo-list-item"><p><b>{numero}</b></p><p>TIPO: {tipo}</p><p>PROV.: {desc_proveedor}</p></div></tpl>',
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['numero']);
                }
            },
            type:'ComboBox',
            id_grupo:0,
            filters:{
                pfiltro:'nucel.numero',
                type:'string'
            },
            grid:true,
            form:false
        },

        {
            config: {
                name: 'id_proveedor',
                hiddenName: 'id_proveedor',
                origen: 'PROVEEDOR',
                fieldLabel: 'Empresa',
                allowBlank: false,
                tinit: false,
                gwidth:300,
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
            form: false
        },

		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
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
				filters:{pfiltro:'detpagte.fecha_reg',type:'date'},
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
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.estado_reg',type:'string'},
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
				gwidth: 100
			},
				type:'Field',
				filters:{pfiltro:'detpagte.id_usuario_ai',type:'numeric'},
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
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'detpagte.usuario_ai',type:'string'},
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
				gwidth: 100
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
				filters:{pfiltro:'detpagte.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,
	title:'Detalle pago telefonia',
	ActSave:'../../sis_gestion_comunicacion/control/PagoTelefoniaDet/insertarPagoTelefoniaDet',
	ActDel:'../../sis_gestion_comunicacion/control/PagoTelefoniaDet/eliminarPagoTelefoniaDet',
	ActList:'../../sis_gestion_comunicacion/control/PagoTelefoniaDet/listarPagoTelefoniaDet',
	id_store:'id_pago_telefonia_det',
	fields: [
		{name:'id_pago_telefonia_det', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_pago_telefonia', type: 'numeric'},
		{name:'fecha', type: 'date',dateFormat:'Y-m-d'},
		{name:'hora', type: 'string'},
		{name:'anexo', type: 'string'},
		{name:'cod_empleado', type: 'string'},
		{name:'nombre_empleado', type: 'string'},
		{name:'nro_telefono', type: 'string'},
		{name:'nombre_telefono', type: 'string'},
		{name:'duracion_real', type: 'string'},
		{name:'costo_llamada', type: 'numeric'},
		{name:'servicio_llamada', type: 'string'},
		{name:'cod_sucursal', type: 'string'},
		{name:'sucursal', type: 'string'},
		{name:'ruta', type: 'numeric'},
		{name:'troncal', type: 'numeric'},
		{name:'cod_usuario', type: 'string'},
		{name:'cod_organizacion', type: 'string'},
		{name:'organizacion', type: 'string'},
		{name:'cod_centro_costo', type: 'string'},
		{name:'centro_costo', type: 'string'},
		{name:'nro_origen', type: 'string'},
		{name:'cod_ciudad', type: 'string'},
		{name:'ciudad', type: 'string'},
		{name:'cod_pais', type: 'string'},
		{name:'pais', type: 'string'},
		{name:'duracion_llamada', type: 'numeric'},
		{name:'globa_l', type: 'string'},
		{name:'tipo_resp_llamada', type: 'string'},
		{name:'transferir_a', type: 'string'},
		{name:'transferir_desde', type: 'string'},
		{name:'evento', type: 'string'},
		{name:'posicion_memoria', type: 'string'},
		{name:'cod_compania', type: 'string'},
		{name:'tiempo_timbrado', type: 'string'},
		{name:'cod_grupo_base_destino', type: 'string'},
		{name:'grupo_base_destino', type: 'string'},
		{name:'grupo_destino', type: 'string'},
		{name:'cod_interno', type: 'string'},
		{name:'fac', type: 'string'},
		{name:'desv_de_desv_a', type: 'string'},
		{name:'factor_porcentual', type: 'numeric'},
		{name:'id_centro_costo', type: 'numeric'},
		{name:'id_concepto_ingas', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'desc_centro_costo', type: 'string'},
		{name:'salida', type: 'string'},
		{name:'id_numero_celular', type: 'numeric'},
		{name:'numero', type: 'string'},
		{name:'desc_proveedor', type: 'string'},


	],
	sortInfo:{
		field: 'id_pago_telefonia_det',
		direction: 'ASC'
	},
	bdel:false,
	bsave:false,
	bnew:false,
	bedit:false,

	onReloadPage:function(m) {
		this.maestro=m;
		this.store.baseParams={id_pago_telefonia:this.maestro.id_pago_telefonia};
		this.load({params:{start:0, limit:this.tam_pag}});
	},
	loadValoresIniciales:function()
	{
		Phx.vista.PagoTelefoniaDet.superclass.loadValoresIniciales.call(this);
		this.getComponente('id_pago_telefonia').setValue(this.maestro.id_pago_telefonia);
	},


	})
</script>
