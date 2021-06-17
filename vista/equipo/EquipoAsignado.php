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
    Phx.vista.EquipoAsignado=Ext.extend(Phx.gridInterfaz,{

            constructor:function(config){
                this.maestro=config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.EquipoAsignado.superclass.constructor.call(this,config);
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

                this.addButton('btnAsignacion', {
                    text : 'Formulario Asignación',
                    iconCls : 'bexport',
                    disabled : true,
                    handler : this.BVerDocumento,
                    tooltip : '<b>Reporte Formulario Asignación</b>'
                });

                this.addButton('btnFormDevolucion', {
                    text : 'Formulario Devolución',
                    iconCls : 'bexport',
                    disabled : true,
                    handler : this.BVerDocumentoDevolucion,
                    tooltip : '<b>Reporte Formulario Asignación</b>'
                });

                this.getBoton('btnAsignacion').hide();
                this.getBoton('btnFormDevolucion').hide();
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
            BVerDocumento : function() {
                //var rec = this.sm.getSelected();
                var data=this.sm.getSelected().data;

                Ext.Ajax.request({
                    url : '../../sis_gestion_comunicacion/control/Equipo/reporteFuncionarioTres',
                    params : {'id_funcionario': data.id_funcionario, 'id_funcionario_celular': data.id_funcionario_celular, 'tipo': 'asignacion', 'tipo_equipo': data.tipo_equipo},
                    success : this.successExport,
                    failure : this.conexionFailure,
                    timeout : this.timeout,
                    scope : this
                });
            },
            BVerDocumentoDevolucion : function() {
                var data=this.sm.getSelected().data;

                Ext.Ajax.request({
                    url : '../../sis_gestion_comunicacion/control/Equipo/reporteFuncionarioTres',
                    params : {'id_funcionario': data.id_funcionario, 'id_funcionario_celular': data.id_funcionario_celular, 'tipo': 'devolucion', 'tipo_equipo': data.tipo_equipo},
                    success : this.successExport,
                    failure : this.conexionFailure,
                    timeout : this.timeout,
                    scope : this
                });
            },
            iniciarEventos: function (){
                var me = this;
                var cmbEquipo=this.getComponente('id_equipo');
				var cmbAccesorios=this.getComponente('id_accesorios');

                this.Cmp.tipo.on('select', function( combo, record, index){
                    cmbEquipo.setValue(null);
                    cmbEquipo.store.baseParams.tipo_equ = record.data.codigo;
                },this);
				
				/*this.Cmp.id_accesorios.on('select', function( combo, record, index){
                    cmbAccesorios.store.baseParams.id_equip = 5;
                },this);*/
				cmbAccesorios.store.baseParams.id_equip = cmbEquipo.getValue();

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
                        name: 'tipo_servicio'
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
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'tipo_asignacion_equipo',
                        value:'equipo'
                    },
                    type:'Field',
                    form:true
                },
                {
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
                        name:'tipo',
                        fieldLabel : 'Tipo Equipo',
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
                        anchor: '60%',
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
                    grid:false,
                    form:true
                },
                {
                    config: {
                        name: 'id_equipo',
                        fieldLabel: 'Equipo',
                        allowBlank: true,
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
                            baseParams: {par_filtro: 'nombre', tipo_movil: 'NO'}
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
                        anchor: '60%',
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
                        anchor: '60%',
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
                    config:{
                        name: 'codigo_inmovilizado',
                        fieldLabel: 'Codigo Inmovilizado',
                        allowBlank: true,
                        anchor: '60%',
                        gwidth: 100,
                        maxLength:200
                    },
                    type:'TextField',
                    filters:{pfiltro:'funcel.codigo_inmovilizado',type:'string'},
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
                },
				{
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'tipo_equipo'
                    },
                    type:'Field',
                    form:true
                }
            ],
            tam_pag:50,
            title:'Detalle Equipos',
            ActSave:'../../sis_gestion_comunicacion/control/FuncionarioCelular/insertarFuncionarioCelular',
            ActDel:'../../sis_gestion_comunicacion/control/FuncionarioCelular/eliminarFuncionarioCelular',
            ActList:'../../sis_gestion_comunicacion/control/FuncionarioCelular/listarEquipoAsignado',
            id_store:'id_funcionario_celular',
            fields: [
                {name:'id_funcionario_celular', type: 'numeric'},
                {name:'id_funcionario', type: 'numeric'},
                {name:'id_cargo', type: 'numeric'},
                {name:'estado_reg', type: 'string'},
                {name:'id_equipo', type: 'numeric'},
                {name:'tipo_asignacion_equipo', type: 'string'},
                {name:'id_numero_celular', type: 'numeric'},
                {name:'numero', type: 'string'},
                {name:'nombre', type: 'string'},
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
				{name:'tipo_equipo', type: 'string'},
				{name:'tipo_servicio', type: 'string'},
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
                this.getBoton('btnAsignacion').hide();
                this.getBoton('btnFormDevolucion').hide();
            },
            loadValoresIniciales:function()
            {
                Phx.vista.EquipoAsignado.superclass.loadValoresIniciales.call(this);
                this.getComponente('id_funcionario').setValue(this.maestro.id_funcionario);
                this.getComponente('id_cargo').setValue(this.maestro.id_cargo);
                this.getComponente('tipo_asignacion_equipo').setValue('equipo');
            },
			onButtonNew:function(){
				Phx.vista.EquipoAsignado.superclass.onButtonNew.call(this);
				this.Cmp.id_accesorios.store.baseParams.id_equip =  0;
				
			},
			onButtonEdit:function(){
					  
			   Phx.vista.EquipoAsignado.superclass.onButtonEdit.call(this);
			   var sel = this.sm.getSelected().data;
			   this.Cmp.id_accesorios.store.baseParams.id_equip =  sel.id_equipo;
			   /*
			   
			   var cmbAccesorios=this.getComponente('id_accesorios');
			   cmbAccesorios.store.baseParams.id_equip = sel.id_equipo;*/
			   
			},
            preparaMenu:function(n){
                var data = this.getSelectedData();
                var tb =this.tbar;
                Phx.vista.EquipoAsignado.superclass.preparaMenu.call(this,n);
                this.getBoton('btnAsignacion').hide();
                this.getBoton('btnFormDevolucion').hide();

                if(data.estado_reg == 'activo'){
                    this.getBoton('btnDevolucion').enable();
                    this.getBoton('edit').enable();
                    this.getBoton('del').enable();
                    this.getBoton('btnAsignacion').enable();
                    this.getBoton('btnAsignacion').show();
                }else{
                    this.getBoton('btnDevolucion').disable();
                    this.getBoton('edit').disable();
                    this.getBoton('del').disable();
                    this.getBoton('btnAsignacion').disable();
                    this.getBoton('btnFormDevolucion').show();
                }

                return tb
            },
            liberaMenu:function(){
                var tb = Phx.vista.EquipoAsignado.superclass.liberaMenu.call(this);
                if(tb){
                    this.getBoton('btnDevolucion').disable();
                    this.getBoton('edit').disable();
                    this.getBoton('del').disable();
                    this.getBoton('btnAsignacion').disable();
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

        