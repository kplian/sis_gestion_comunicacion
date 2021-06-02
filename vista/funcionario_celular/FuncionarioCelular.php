<?php
/**
*@package pXP
*@file gen-FuncionarioCelular.php
*@author  (jrivera)
*@date 24-07-2014 00:10:05
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.FuncionarioCelular=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
		
		this.historico = 'no';
        this.tbarItems = ['-',{
            text: 'Histórico',
            enableToggle: true,
            pressed: false,
            toggleHandler: function(btn, pressed) {
               
                if(pressed){
                    this.historico = 'si';                     
                }
                else{
                   this.historico = 'no' 
                }
                
                this.store.baseParams.historico = this.historico;
                this.onButtonAct();
             },
            scope: this
           }];
           
    	//llama al constructor de la clase padre
		Phx.vista.FuncionarioCelular.superclass.constructor.call(this,config);
		this.init();
		this.iniciarEventos();
		this.store.baseParams.historico = this.historico;
        this.load({params:{start:0, limit:this.tam_pag}}); 		
	},
    iniciarEventos:function() {
        this.Cmp.fecha_inicio.on('change',function() {

            this.Cmp.id_numero_celular.enable();
            this.Cmp.id_numero_celular.reset();
            this.Cmp.id_numero_celular.store.baseParams.fecha =
                this.Cmp.fecha_inicio.getValue().dateFormat(this.Cmp.fecha_inicio.format);
            this.Cmp.id_numero_celular.modificado = true;

            this.Cmp.id_funcionario.enable();
            this.Cmp.id_funcionario.store.baseParams.fecha =
                this.Cmp.fecha_inicio.getValue().dateFormat(this.Cmp.fecha_inicio.format);
            this.Cmp.id_funcionario.reset();
            this.Cmp.id_funcionario.modificado = true;

        },this);

        this.Cmp.tipo.on('select',function(c,r,i) {
            if ( this.Cmp.tipo.getValue() == 'funcionario') {

                if (this.Cmp.fecha_inicio.getValue()!= '') {
                    this.Cmp.fecha_inicio.fireEvent('change');
                }

                this.Cmp.id_cargo.disable();
                this.Cmp.id_cargo.reset();
                this.Cmp.id_funcionario.allowBlank = false;
                this.Cmp.id_cargo.allowBlank = true;
                this.Cmp.id_funcionario.show();
                this.Cmp.id_cargo.hide();
            }
            if (this.Cmp.tipo.getValue() == 'cargo') {
                this.Cmp.id_cargo.enable();
                this.Cmp.id_cargo.reset();
                this.Cmp.id_funcionario.disable();
                this.Cmp.id_funcionario.allowBlank = true;
                this.Cmp.id_cargo.allowBlank = false;
                //this.Cmp.id_funcionario.reset();
                this.Cmp.id_funcionario.hide();
                this.Cmp.id_cargo.show();
            }
        },this);

        this.Cmp.tipo_asignacion_equipo.on('select',function(c,r,i) {
            if(r.data.field1 == 'numero'){
                this.Cmp.id_numero_celular.show();
                this.Cmp.id_equipo.hide();
                this.Cmp.id_numero_celular.allowBlank = false;
                this.Cmp.id_equipo.allowBlank = true;
            }else if (r.data.field1 == 'equipo'){
                this.Cmp.id_numero_celular.hide();
                this.Cmp.id_equipo.show();
                this.Cmp.id_numero_celular.allowBlank = true;
                this.Cmp.id_equipo.allowBlank = false;
            }else{
                this.Cmp.id_numero_celular.hide();
                this.Cmp.id_equipo.hide();
                this.Cmp.id_numero_celular.allowBlank = false;
                this.Cmp.id_equipo.allowBlank = false;
            }
        },this);

    },
	Atributos:[
		{
			config:{
				name: 'fecha_inicio',
				fieldLabel: 'Fecha Asignación',
				allowBlank: false,
				anchor: '50%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'funcel.fecha_inicio',type:'date'},
				id_grupo:1,
				grid:false,
				form:true
		},
        {
            config:{
                name: 'fecha_fin',
                fieldLabel: 'Fecha Devolución',
                allowBlank: true,
                anchor: '50%',
                gwidth: 100,
                format: 'd/m/Y',
                renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
            type:'DateField',
            filters:{pfiltro:'funcel.fecha_fin',type:'date'},
            id_grupo:1,
            grid:false,
            form:true
        },
        {
            config:{
                name: 'tipo_asignacion',
                fieldLabel: 'Tipo Asignacion',
                allowBlank:false,
                emptyText:'Tipo...',
                typeAhead: false,
                triggerAction: 'all',
                lazyRender:true,
                mode: 'local',
                anchor: '50%',
                gwidth: 100,
                store:['personal','compartido'],
                value:'no'
            },
            type:'ComboBox',
            filters:{pfiltro:'funcel.tipo_asignacion',
                type: 'list',
                options: ['personal','compartido']
            },
            id_grupo:1,
            grid:false,
            form:true
        },
		{
			config:{
				name: 'tipo',
				fieldLabel: 'Asignar a',
				allowBlank:false,
				emptyText:'tipo...',
	       		typeAhead: false,
	       		triggerAction: 'all',
	       		lazyRender:true,
	       		mode: 'local',
                anchor: '50%',
				gwidth: 100,
				store:['funcionario','cargo'],
				value:'no'
			},
				type:'ComboBox',				
				id_grupo:1,
				grid:false,
				form:true
		},
        {
            config:{
                name:'id_funcionario',
                hiddenName: 'id_funcionario',
                origen:'FUNCIONARIOCAR',
                fieldLabel:'Funcionario',
                allowBlank:false,
                anchor: '50%',
                gwidth:300,
                valueField: 'id_funcionario',
                gdisplayField: 'desc_funcionario1',
                disabled:true,
                renderer:function(value, p, record){return String.format('{0}', record.data['desc_funcionario1']);}
            },
            type:'ComboRec',//ComboRec
            id_grupo:0,
            filters:{pfiltro:'fun.desc_funcionario1',type:'string'},
            grid:true,
            form:true
        },
        {
            config: {
                name: 'id_cargo',
                fieldLabel: 'Cargo',
                allowBlank: true,
                disabled:true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_organigrama/control/Cargo/listarCargo',
                    id: 'id_cargo',
                    root: 'datos',
                    sortInfo: {
                        field: 'cargo.nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_cargo', 'nombre', 'codigo'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'cargo.nombre#cargo.codigo'}
                }),
                valueField: 'id_cargo',
                displayField: 'nombre',
                gdisplayField: 'nombre',
                hiddenName: 'id_cargo',
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
                    return String.format('{0}', record.data['nombre_cargo']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'cargo.nombre',type: 'string'},
            grid: true,
            form: true
        },
        {
            config:{
                name: 'tipo_asignacion_equipo',
                fieldLabel: 'Tipo Equipo',
                allowBlank:false,
                emptyText:'Tipo...',
                typeAhead: false,
                triggerAction: 'all',
                lazyRender:true,
                mode: 'local',
                anchor: '50%',
                gwidth: 100,
                store:['numero','equipo'],
                value:'no'
            },
            type:'ComboBox',
            filters:{pfiltro:'funcel.tipo_asignacion_equipo',
                type: 'list',
                options: ['numero','equipo']
            },
            id_grupo:1,
            grid:false,
            form:true
        },
		{
			config: {
				name: 'id_numero_celular',
				fieldLabel: 'Número Asignado',
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
					baseParams: {par_filtro: 'numcel.numero'}
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
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'numcel.numero',type: 'string'},
			grid: false,
			form: true
		},
        {
            config: {
                name: 'id_equipo',
                fieldLabel: 'Equipo Asignado',
                allowBlank: true,
                hidden: true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_gestion_comunicacion/control/Equipo/listarEquipoCombo',
                    id: 'id_equipo',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_equipo', 'nombre'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'nombre'}
                }),
                valueField: 'id_equipo',
                displayField: 'nombre',
                gdisplayField: 'nombre',
                hiddenName: 'id_equipo',
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
                    return String.format('{0}', record.data['nombre']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'nombre',type: 'string'},
            grid: false,
            form: true
        },
        {
            config:{
                name: 'codigo_inmovilizado',
                fieldLabel: 'Codigo Inmovilizado',
                allowBlank: true,
                anchor: '50%',
                gwidth: 100,
                maxLength:200
            },
            type:'TextField',
            filters:{pfiltro:'funcel.codigo_inmovilizado',type:'string'},
            id_grupo:1,
            grid:false,
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
            filters:{pfiltro:'funcel.observaciones',type:'string'},
            id_grupo:1,
            grid:false,
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
				filters:{pfiltro:'funcel.estado_reg',type:'string'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'funcel.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'funcel.fecha_reg',type:'date'},
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
				filters:{pfiltro:'funcel.usuario_ai',type:'string'},
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
				grid:false,
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
				filters:{pfiltro:'funcel.fecha_mod',type:'date'},
				id_grupo:1,
				grid:false,
				form:false
		}
	],
	tam_pag:50,	
	title:'Asignación de Números',
	ActSave:'../../sis_gestion_comunicacion/control/FuncionarioCelular/insertarFuncionarioCelular',
	ActDel:'../../sis_gestion_comunicacion/control/FuncionarioCelular/eliminarFuncionarioCelular',
	ActList:'../../sis_gestion_comunicacion/control/FuncionarioCelular/listarFuncionarioCelular',
	id_store:'id_funcionario',
	fields: [

		{name:'id_numero_celular', type: 'numeric'},
		{name:'numero', type: 'string'},
		{name:'id_funcionario', type: 'numeric'},
		{name:'desc_funcionario1', type: 'string'},
        {name:'tipo_asignacion', type: 'string'},
		{name:'id_cargo', type: 'numeric'},
		{name:'nombre_cargo', type: 'string'},
		{name:'fecha_inicio', type: 'date',dateFormat:'Y-m-d'},
		{name:'estado_reg', type: 'string'},
		{name:'fecha_fin', type: 'date',dateFormat:'Y-m-d'},
		{name:'observaciones', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'tipo', type: 'string'},
        {name:'id_equipo', type: 'numeric'},
        {name:'nombre', type: 'string'},
        {name:'tipo_asignacion_equipo', type: 'string'},
        {name:'codigo_inmovilizado', type: 'string'},

	],
	sortInfo:{
		field: 'id_funcionario',
		direction: 'DESC'
	},
	bedit:false,
	bsave:false,
    bdel:false,
    tabsouth: [{
        url: '../../../sis_gestion_comunicacion/vista/equipo/EquipoAsignado.php',
        title: 'Detalle Equipos',
        height: '40%',
        cls: 'EquipoAsignado',
        params: { nombre_tabla: 'orga.tfuncionario', tabla_id: 'id_funcionario'}
    },],
	loadValoresIniciales:function()
    {
    	this.Cmp.fecha_inicio.enable();
    	this.Cmp.tipo.enable();
    	/*this.Cmp.tipo.setValue('funcionario');
    	this.Cmp.tipo.fireEvent('select');	*/
        Phx.vista.FuncionarioCelular.superclass.loadValoresIniciales.call(this);
               
    },
    onButtonNew:function(){
        Phx.vista.FuncionarioCelular.superclass.onButtonNew.call(this);
        this.Cmp.id_funcionario.hide();
        this.Cmp.id_cargo.hide();
        this.Cmp.id_numero_celular.hide();
        this.Cmp.id_equipo.hide();
    },
    onButtonEdit:function(){
       this.Cmp.fecha_inicio.disable();
       this.Cmp.tipo.disable();
       this.Cmp.id_funcionario.disable();
       this.Cmp.id_cargo.disable();
       this.Cmp.id_numero_celular.disable();
              
       Phx.vista.FuncionarioCelular.superclass.onButtonEdit.call(this);
       if (this.Cmp.id_funcionario.getValue() != '') {
       		this.Cmp.tipo.setValue('funcionario');
       } else {
       		this.Cmp.tipo.setValue('cargo');
       }
       
    },
	}
)
</script>
		
		