<?php
/****************************************************************************************
 *@package pXP
 *@file gen-EquipoAsignado.php
 *@author  (ymedina)
 *@date 10-05-2021 16:01:12
 *@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
#0                10-05-2021 16:01:12    ymedina            Creacion
#

 *******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.NumeroAsignado=Ext.extend(Phx.gridInterfaz,{

            constructor:function(config){
                this.maestro=config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.NumeroAsignado.superclass.constructor.call(this,config);
                this.init();
                //this.load({params:{start:0, limit:this.tam_pag}})
                this.addButton('btnDevolucion',
                    {
                        text: 'Devolución',
                        grupo:[0],
                        iconCls: 'bchecklist',
                        disabled: true,
                        handler: this.Devolucion,
                        tooltip: '<b>Retornar Equipo</b><br/> o Numero.'
                    }
                );

                this.addButton('btnCambio',
                    {
                        text: 'Cambio Equipo',
                        grupo:[0],
                        iconCls: 'bchecklist',
                        disabled: true,
                        handler: this.CambioEquipo,
                        tooltip: '<b>Cambio de Equipo</b>.'
                    }
                );

                this.addButton('btnFormAsignacion', {
                    text : 'Formulario Asignación',
                    iconCls : 'bexport',
                    disabled : true,
                    handler : this.BVerDocumentoAsignacion,
                    tooltip : '<b>Reporte Formulario Asignación</b>'
                });

                this.addButton('btnFormDevolucion', {
                    text : 'Formulario Devolución',
                    iconCls : 'bexport',
                    disabled : true,
                    handler : this.BVerDocumentoDevolucion,
                    tooltip : '<b>Reporte Formulario Asignación</b>'
                });

                this.getBoton('btnFormAsignacion').hide();
                this.getBoton('btnFormDevolucion').hide();
                this.getBoton('btnCambio').hide();
                this.iniciarEventos();

            },
            Devolucion : function(rec)
            {   var sel = this.sm.getSelected();
                Phx.CP.loadWindows('../../../sis_gestion_comunicacion/vista/equipo/DevolucionEquipo.php',
                    'Retorno de Equipo o Numero',
                    {
                        modal:true,
                        width:450,
                        height:250
                    },sel,this.idContenedor,'DevolucionEquipo');

            },
            CambioEquipo : function(rec)
            {   var sel = this.sm.getSelected();
                Phx.CP.loadWindows('../../../sis_gestion_comunicacion/vista/equipo/CambioEquipo.php',
                    'Cambio de Equipo',
                    {
                        modal:true,
                        width:450,
                        height:250
                    },sel,this.idContenedor,'CambioEquipo');

            },
            BVerDocumentoAsignacion : function() {
                var data=this.sm.getSelected().data;

                Ext.Ajax.request({
                    url : '../../sis_gestion_comunicacion/control/Equipo/reporteFuncionarioDos',
                    params : {'id_funcionario': data.id_funcionario, 'id_funcionario_celular': data.id_funcionario_celular, 'tipo': 'asignacion'},
                    success : this.successExport,
                    failure : this.conexionFailure,
                    timeout : this.timeout,
                    scope : this
                });
            },
            BVerDocumentoDevolucion : function() {
                var data=this.sm.getSelected().data;

                Ext.Ajax.request({
                    url : '../../sis_gestion_comunicacion/control/Equipo/reporteFuncionarioDos',
                    params : {'id_funcionario': data.id_funcionario, 'id_funcionario_celular': data.id_funcionario_celular, 'tipo': 'devolucion'},
                    success : this.successExport,
                    failure : this.conexionFailure,
                    timeout : this.timeout,
                    scope : this
                });
            },
            iniciarEventos: function (){
                var me = this;
                var cmbCatTipo=this.getComponente('id_numero_celular');
                var cmbEquipo=this.getComponente('id_equipo');

                this.Cmp.tipo_servicio.on('select', function( combo, record, index){
                    cmbCatTipo.setValue(null);
                    cmbEquipo.setValue(null);
                    cmbCatTipo.store.baseParams.tipo_servi = record.data.codigo;
                    cmbEquipo.store.baseParams.tipo_servi = record.data.codigo;
                    cmbCatTipo.store.baseParams.funcionario_gerencia = this.maestro.id_uo;
                },this);
            },
            Atributos:[
                {
                    //configuracion del componente
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_funcionario_celular'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_funcionario'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_cargo'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'tipo_asignacion_equipo',
                        value:'numero'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'codigo_inmovilizado'
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
                    filters:{pfiltro:'funcel.estado_reg',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
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
                        name: 'id_numero_celular',
                        fieldLabel: 'Número',
                        allowBlank: false,
                        hidden: false,
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
                        anchor: '80%',
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
                    config: {
                        name: 'id_equipo',
                        fieldLabel: 'Equipo',
                        allowBlank: false,
                        hidden: false,
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
                            baseParams: {par_filtro: 'nombre', tipo_movil: 'SI'}
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
                        anchor: '80%',
                        gwidth: 150,
                        minChars: 2,
                        renderer : function(value, p, record) {
                            return String.format('{0}', record.data['nombre']);
                        },
                        listeners: {
                            beforequery: function(qe){
                                delete qe.combo.lastQuery;
                            }
                        },
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'nombre',type: 'string'},
                    grid: true,
                    form: true
                },
                {
                    config:{
                        name: 'fecha_inicio',
                        fieldLabel: 'Fecha Asignación',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
                    },
                    type:'DateField',
                    filters:{pfiltro:'funcel.fecha_inicio',type:'date'},
                    id_grupo:1,
                    grid:true,
                    form:true
                },
                {
                    config:{
                        name: 'fecha_fin',
                        fieldLabel: 'Fecha Devolución',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
                    },
                    type:'DateField',
                    filters:{pfiltro:'funcel.fecha_fin',type:'date'},
                    id_grupo:1,
                    grid:true,
                    form:true
                },
				{
                    config: {
                        name: 'id_accesorios',
                        fieldLabel: 'Accesorios',
                        allowBlank: true,
                        emptyText: 'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_gestion_comunicacion/control/Accesorio/listarAccesorio',
                            id: 'id_accesorio',
                            root: 'datos',
                            sortInfo: {
                                field: 'resumen',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_accesorio', 'resumen', 'marca'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'acc.id_accesorio#acc.resumen', disponibles: 'SI'}
                        }),
                        tpl:'<tpl for="."><div class="x-combo-list-item" ><div class="awesomecombo-item {checked}"><p><b></b>{resumen}</p></div>\</div></tpl>',
                        valueField: 'id_accesorio',
                        displayField: 'resumen',
                        gdisplayField: 'resumen',
                        hiddenName: 'id_accesorios',
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
                        enableMultiSelect:true,
                        renderer : function(value, p, record) {
                            return String.format('{0}', record.data['desc_accesorios']);
                        },
						listeners: {
                            beforequery: function(qe){
                                delete qe.combo.lastQuery;
                            }
                        },
                    },
                    type: 'AwesomeCombo',
                    id_grupo: 0,
                    filters: {pfiltro: 'desc_accesorios',type: 'string'},
                    grid: true,
                    form: true
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
                    filters:{pfiltro:'funcel.fecha_reg',type:'date'},
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
                    filters:{pfiltro:'funcel.fecha_mod',type:'date'},
                    id_grupo:1,
                    grid:true,
                    form:false
                }
            ],
            tam_pag:50,
            title:'Detalle Numero',
            ActSave:'../../sis_gestion_comunicacion/control/FuncionarioCelular/insertarFuncionarioCelularMovil',
            ActDel:'../../sis_gestion_comunicacion/control/FuncionarioCelular/eliminarFuncionarioCelular',
            ActList:'../../sis_gestion_comunicacion/control/FuncionarioCelular/listarNumeroAsignado',
            id_store:'id_funcionario_celular',
            fields: [
                {name:'id_funcionario_celular', type: 'numeric'},
                {name:'id_funcionario', type: 'numeric'},
                {name:'id_equipo', type: 'numeric'},
                {name:'id_cargo', type: 'numeric'},
                {name:'estado_reg', type: 'string'},
                {name:'id_numero_celular', type: 'numeric'},
                {name:'numero', type: 'string'},
                {name:'codigo_inmovilizado', type: 'string'},
                {name:'fecha_inicio', type: 'date',dateFormat:'Y-m-d'},
                {name:'fecha_fin', type: 'date',dateFormat:'Y-m-d'},
                {name:'observaciones', type: 'string'},
                {name:'id_usuario_reg', type: 'numeric'},
                {name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
                {name:'id_usuario_mod', type: 'numeric'},
                {name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
                {name:'usr_reg', type: 'string'},
                {name:'usr_mod', type: 'string'},
                {name:'tipo_asignacion_equipo', type: 'string'},
                {name:'tipo_servicio', type: 'string'},
                {name:'tipo_servicio_desc', type: 'string'},
                {name:'nombre', type: 'string'},
				{name:'id_accesorios', type: 'string'},
				{name:'desc_accesorios', type: 'string'},
            ],
            sortInfo:{
                field: 'id_funcionario_celular',
                direction: 'ASC'
            },
            bdel:true,
            bnew: true,
            bsave: false,
            onReloadPage:function(m){
                this.maestro=m;
                console.log(this.maestro);
                this.store.baseParams={id_funcionario: this.maestro.id_funcionario, id_cargo: this.maestro.id_cargo};

                //this.Cmp.idioma.store.baseParams.id_funcionario = this.maestro.id_funcionario;
                this.load({params:{start:0, limit:this.tam_pag}});
                this.getBoton('btnFormAsignacion').hide();
                this.getBoton('btnFormDevolucion').hide();
                this.getBoton('btnCambio').hide();
            },
            loadValoresIniciales:function()
            {
                Phx.vista.NumeroAsignado.superclass.loadValoresIniciales.call(this);
                this.getComponente('id_funcionario').setValue(this.maestro.id_funcionario);
                this.getComponente('id_cargo').setValue(this.maestro.id_cargo);
                this.getComponente('tipo_asignacion_equipo').setValue('numero');
            },
            preparaMenu:function(n){
                var data = this.getSelectedData();
                console.log('hoyyy',data);
                var tb =this.tbar;
                Phx.vista.NumeroAsignado.superclass.preparaMenu.call(this,n);
                this.getBoton('btnFormAsignacion').hide();
                this.getBoton('btnFormDevolucion').hide();
                this.getBoton('btnCambio').hide();

                if(data.estado_reg == 'activo'){
                    this.getBoton('btnDevolucion').enable();
                    this.getBoton('btnCambio').enable();
                    this.getBoton('edit').enable();
                    this.getBoton('del').enable();
                    this.getBoton('btnFormAsignacion').show();
                    if(data.tipo_asignacion_equipo == 'numero'){
                        this.getBoton('btnCambio').show();
                    }
                }else{
                    this.getBoton('btnDevolucion').disable();
                    this.getBoton('btnCambio').disable();
                    this.getBoton('edit').disable();
                    this.getBoton('del').disable();
                    this.getBoton('btnFormDevolucion').show();
                }

                return tb
            },
			onButtonNew:function(){
				Phx.vista.NumeroAsignado.superclass.onButtonNew.call(this);
				this.Cmp.id_accesorios.store.baseParams.id_equip =  0;
				
			},
			onButtonEdit:function(){
					  
			   Phx.vista.NumeroAsignado.superclass.onButtonEdit.call(this);
			   var sel = this.sm.getSelected().data;
			   this.Cmp.id_accesorios.store.baseParams.id_equip =  sel.id_equipo;
			   
			},
            liberaMenu:function(){
                var tb = Phx.vista.NumeroAsignado.superclass.liberaMenu.call(this);
                if(tb){
                    this.getBoton('btnDevolucion').disable();
                    this.getBoton('btnCambio').disable();
                    this.getBoton('edit').disable();
                    this.getBoton('del').disable();
                }
                return tb
            },
            tabeast:[
                {
                    url:'../../../sis_gestion_comunicacion/vista/equipo_historico/EquipoHistorico.php',
                    title:'Historico Equipo',
                    width:450,
                    cls:'EquipoHistorico'
                }
            ]
        }
    )
</script>

        