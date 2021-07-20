<?php
/****************************************************************************************
 *@package pXP
 *@file DeudaPersona.php
 *@author  (ymedina)
 *@date 15-10-2020 19:58:49
 *@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
#0                15-10-2020 19:58:49    ymedina            Creacion    
#   

 *******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.EquipoAccesorio=Ext.extend(Phx.gridInterfaz,{

            constructor:function(config){
                this.config = config;
                //this.maestro=config.maestro;
                Phx.vista.EquipoAccesorio.superclass.constructor.call(this,config);
                this.init();

                this.addButton('btnDevolucion',
                    {
                        text: 'Devolución',
                        grupo:[0],
                        iconCls: 'bchecklist',
                        disabled: true,
                        handler: this.Devolucion,
                        tooltip: '<b>Retornar Accesorio</b>'
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

                var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
                if(dataPadre){
                    this.onEnablePanel(this, dataPadre);
                }
                else
                {
                    this.bloquearMenus();
                }

                this.getBoton('btnFormAsignacion').hide();
                this.getBoton('btnFormDevolucion').hide();
                //this.load({params:{start:0, limit:this.tam_pag, }})
                this.iniciarEventos();

            },
            iniciarEventos: function (){
                var me = this;
                var cmbAccesorio=this.getComponente('id_accesorio');
                var cmbTipo=this.getComponente('tipo');

                this.Cmp.tipo.on('select', function( combo, record, index){
                    cmbAccesorio.setValue(null);
                    cmbAccesorio.store.baseParams.tipo_accesorio = record.data.codigo;
                },this);

                if(this.config.tipo_acc == 'equipo'){
                    cmbTipo.store.baseParams.catalogo_tipo = 'accesorio_equipo';
                    cmbAccesorio.store.baseParams.tipo_equipo = 'escritorio';
                }else if(this.config.tipo_acc == 'movil'){
                    cmbTipo.store.baseParams.catalogo_tipo = 'accesorio_telefono';
                    cmbAccesorio.store.baseParams.tipo_equipo = 'movil';
                }

            },
            BVerDocumentoAsignacion : function() {
                var data=this.sm.getSelected().data;

                Ext.Ajax.request({
                    url : '../../sis_gestion_comunicacion/control/Accesorio/reporteAccesorio',
                    params : {'id_accesorio': data.id_accesorio, 'id_funcionario_celular': data.id_funcionario_celular, 'tipo': 'asignacion'},
                    success : this.successExport,
                    failure : this.conexionFailure,
                    timeout : this.timeout,
                    scope : this
                });
            },
            BVerDocumentoDevolucion : function() {
                var data=this.sm.getSelected().data;

                Ext.Ajax.request({
                    url : '../../sis_gestion_comunicacion/control/Accesorio/reporteAccesorio',
                    params : {'id_accesorio': data.id_accesorio, 'id_funcionario_celular': data.id_funcionario_celular, 'tipo': 'devolucion'},
                    success : this.successExport,
                    failure : this.conexionFailure,
                    timeout : this.timeout,
                    scope : this
                });
            },
            Devolucion : function(rec)
            {   var sel = this.sm.getSelected();
                Phx.CP.loadWindows('../../../sis_gestion_comunicacion/vista/accesorio/DevolucionAccesorio.php',
                    'Retorno de Accesorio',
                    {
                        modal:true,
                        width:450,
                        height:250
                    },sel,this.idContenedor,'DevolucionAccesorio');

            },
            Atributos:[
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_funcionario_celular'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config : {
                        name:'tipo',
                        fieldLabel : 'Tipo',
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
                            baseParams: {par_filtro:'descripcion',cod_subsistema:'GECOM'}
                        }),
                        enableMultiSelect:true,
                        valueField: 'codigo',
                        displayField: 'descripcion',
                        gdisplayField: 'tipo_desc',
                        triggerAction: 'all',
                        lazyRender:true,
                        mode:'remote',
                        pageSize:15,
                        queryDelay: 1000,
                        anchor: '80%',
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
                    bottom_filter : true,
                    filters:{pfiltro:'acc.tipo',type:'string'},
                    id_grupo:0,
                    grid:true,
                    form:true
                },
                {
                    config: {
                        name: 'id_accesorio',
                        fieldLabel: 'Accesorio',
                        allowBlank: false,
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
                        valueField: 'id_accesorio',
                        displayField: 'resumen',
                        gdisplayField: 'resumen',
                        hiddenName: 'id_accesorio',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 100,
                        minChars: 2,
                        renderer : function(value, p, record) {
                            return String.format('{0}', record.data['id_accesorio']);
                        },
                        listeners: {
                            beforequery: function(qe){
                                delete qe.combo.lastQuery;
                            }
                        },
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    grid: false,
                    form: true
                },
                {
                    //configuracion del componente
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_equipo'
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
                    filters:{pfiltro:'acc.estado_reg',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
                {
                    config:{
                        name: 'nombre',
                        fieldLabel: 'nombre',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:200
                    },
                    type:'TextField',
                    bottom_filter : true,
                    filters:{pfiltro:'acc.nombre',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
                {
                    config : {
                        name:'marca',
                        fieldLabel : 'Marca',
                        resizable:true,
                        allowBlank:false,
                        emptyText:'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_parametros/control/Catalogo/listarCatalogoCombo',
                            id: 'id_catalogo',
                            root: 'datos',
                            sortInfo:{
                                field: 'descripcion',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_catalogo','codigo','descripcion'],
                            // turn on remote sorting
                            remoteSort: true,
                            baseParams: {par_filtro:'descripcion',cod_subsistema:'GECOM',catalogo_tipo:'marca'}
                        }),
                        enableMultiSelect:true,
                        valueField: 'codigo',
                        displayField: 'descripcion',
                        gdisplayField: 'marca_desc',
                        triggerAction: 'all',
                        lazyRender:true,
                        mode:'remote',
                        pageSize:15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 100,
                        listeners: {
                            beforequery: function(qe){
                                delete qe.combo.lastQuery;
                            }
                        },
                    },
                    type:'ComboBox',
                    filters:{pfiltro:'marca_desc',type:'string'},
                    id_grupo:0,
                    grid:true,
                    form:false
                },
                {
                    config:{
                        name: 'modelo',
                        fieldLabel: 'Modelo',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:300
                    },
                    type:'TextField',
                    filters:{pfiltro:'acc.modelo',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
                {
                    config:{
                        name: 'num_serie',
                        fieldLabel: 'Número de serie',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:300
                    },
                    type:'TextField',
                    bottom_filter : true,
                    filters:{pfiltro:'acc.num_serie',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
                {
                    config : {
                        name:'estado_fisico',
                        fieldLabel : 'Estado Fisico',
                        resizable:true,
                        allowBlank:false,
                        emptyText:'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_parametros/control/Catalogo/listarCatalogoCombo',
                            id: 'id_catalogo',
                            root: 'datos',
                            sortInfo:{
                                field: 'descripcion',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_catalogo','codigo','descripcion'],
                            // turn on remote sorting
                            remoteSort: true,
                            baseParams: {par_filtro:'descripcion',cod_subsistema:'GECOM',catalogo_tipo:'estado_fisico'}
                        }),
                        enableMultiSelect:true,
                        valueField: 'codigo',
                        displayField: 'descripcion',
                        gdisplayField: 'estado_fisico_desc',
                        triggerAction: 'all',
                        lazyRender:true,
                        mode:'remote',
                        pageSize:15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 100,
                        listeners: {
                            beforequery: function(qe){
                                delete qe.combo.lastQuery;
                            }
                        },
                    },
                    type:'ComboBox',
                    filters:{pfiltro:'estado_fisico_desc',type:'string'},
                    id_grupo:0,
                    grid:true,
                    form:false
                },
                {
                    config:{
                        name: 'codigo_inmovilizado',
                        fieldLabel: 'Codigo Inmovilizado',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:200
                    },
                    type:'TextField',
                    filters:{pfiltro:'codigo_inmovilizado',type:'string'},
                    id_grupo:1,
                    grid:false,
                    form:true
                },
                {
                    config : {
                        name:'tamano',
                        fieldLabel : 'Tamaño Pantalla',
                        resizable:true,
                        allowBlank:true,
                        emptyText:'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_parametros/control/Catalogo/listarCatalogoCombo',
                            id: 'id_catalogo',
                            root: 'datos',
                            sortInfo:{
                                field: 'descripcion',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_catalogo','codigo','descripcion'],
                            // turn on remote sorting
                            remoteSort: true,
                            baseParams: {par_filtro:'descripcion',cod_subsistema:'GECOM',catalogo_tipo:'pantalla'}
                        }),
                        enableMultiSelect:true,
                        valueField: 'codigo',
                        displayField: 'descripcion',
                        gdisplayField: 'tamano',
                        triggerAction: 'all',
                        lazyRender:true,
                        mode:'remote',
                        pageSize:15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 100,
                        listeners: {
                            beforequery: function(qe){
                                delete qe.combo.lastQuery;
                            }
                        },
                    },
                    type:'ComboBox',
                    filters:{pfiltro:'tamano',type:'string'},
                    id_grupo:0,
                    grid:true,
                    form:false
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
                    id_grupo:1,
                    grid:false,
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
                    id_grupo:1,
                    grid:false,
                    form:true
                },
                {
                    config:{
                        name: 'observaciones',
                        fieldLabel: 'Observaciones',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 200,
                        maxLength:500
                    },
                    type:'TextArea',
                    filters:{pfiltro:'acc.observaciones',type:'string'},
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
                    filters:{pfiltro:'acc.fecha_reg',type:'date'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
            ],
            tam_pag:50,
            title:'Accesorios',
            ActSave:'../../sis_gestion_comunicacion/control/Accesorio/insertarAccesorioFuncionario',
            ActDel:'../../sis_gestion_comunicacion/control/Accesorio/eliminarAccesorioFuncionario',
            ActList:'../../sis_gestion_comunicacion/control/Accesorio/listarAccesorioFuncionario',
            id_store:'id_accesorio',
            fields: [
                {name:'id_funcionario_celular', type: 'numeric'},
                {name:'id_accesorio', type: 'numeric'},
                {name:'id_equipo', type: 'numeric'},
                {name:'estado_reg', type: 'string'},
                {name:'nombre', type: 'string'},
                {name:'marca', type: 'string'},
                {name:'modelo', type: 'string'},
                {name:'num_serie', type: 'string'},
                {name:'estado_fisico', type: 'string'},
                {name:'estado_fisico_desc', type: 'string'},
                {name:'codigo_inmovilizado', type: 'string'},
                {name:'tamano', type: 'string'},
                {name:'observaciones', type: 'string'},
                {name:'id_usuario_reg', type: 'numeric'},
                {name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
                {name:'usr_reg', type: 'string'},
                {name:'tipo', type: 'string'},
                {name:'tipo_desc', type: 'string'},
                {name:'marca_desc', type: 'string'},
                {name:'fecha_inicio', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
                {name:'fecha_fin', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
            ],
            sortInfo:{
                field: 'id_accesorio',
                direction: 'ASC'
            },
            bsave:false,
            bedit: false,
            bdel: false,
            onReloadPage:function(m){
                this.maestro=m;
                this.store.baseParams={id_funcionario_celular: this.config.id_funcionario_celular, id_equipo: this.config.id_equipo}
                this.load({params:{start:0, limit:this.tam_pag}});
                this.getBoton('btnFormAsignacion').hide();
                this.getBoton('btnFormDevolucion').hide();

            },
            loadValoresIniciales:function()
            {
                Phx.vista.EquipoAccesorio.superclass.loadValoresIniciales.call(this);
                this.getComponente('id_funcionario_celular').setValue(this.config.id_funcionario_celular);
                this.getComponente('id_equipo').setValue(this.config.id_equipo);
                console.log('inicialeeee');
            },
            preparaMenu:function(n){
                var data = this.getSelectedData();
                var tb =this.tbar;
                Phx.vista.EquipoAccesorio.superclass.preparaMenu.call(this,n);
                this.getBoton('btnFormAsignacion').hide();
                this.getBoton('btnFormDevolucion').hide();

                //if(data.estado_reg == 'activo'){
                if(data.estado_reg == 'activo'){
                    this.getBoton('btnDevolucion').enable();
                    this.getBoton('btnFormAsignacion').enable();
                    this.getBoton('btnFormAsignacion').show();
                }else{
                    this.getBoton('btnDevolucion').disable();
                    this.getBoton('btnFormDevolucion').enable();
                    this.getBoton('btnFormDevolucion').show();
                }

                return tb
            },
            liberaMenu:function(){
                var tb = Phx.vista.EquipoAccesorio.superclass.liberaMenu.call(this);
                console.log('yaya',tb);
                if(tb){
                    this.getBoton('btnDevolucion').disable();
                    this.getBoton('btnFormAsignacion').disable();
                    this.getBoton('btnFormDevolucion').disable();
                }
                if(this.config.estado_reg == 'activo'){
                    this.getBoton('new').enable();
                }else{
                    this.getBoton('new').disable();
                }

                return tb
            },
        }
    )
</script>
        
        