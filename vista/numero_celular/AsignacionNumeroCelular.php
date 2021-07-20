<?php
/**
 *@package pXP
 *@file AsignacionNumeroCelular.php
 *@author KPLIAN (admin)
 *@date 14-02-2011
 *@description  Vista para registrar los datos de un funcionario
 *
HISTORIAL DE MODIFICACIONES:

ISSUE            FECHA:              AUTOR                 DESCRIPCION
#0            14-02-2011        RAC                 Creacion
#24           17/06/2019        RAC                 Configuracion de palntillas de grilla
#31           16/07/2019        RAC                 Adciona codigo rcaiva, profesion y fecha quinquenio
#51           20/08/2019        RAC                 solucion de bug al seleccionar funcionario
#60   ETR     10/09/2019        MMV              	  Histórico código de empleado
#89	ETR		04.12.2019		  MZM				  Habilitacion de catalogo profesiones en funcionario
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.AsignacionNumeroCelular=function(config){

        this.Atributos=[
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
                    name: 'id_uo'
                },
                type:'Field',
                form:true
            },
            {
                config:{
                    name:'id_persona',
                    origen:'PERSONA',
                    tinit:true,
                    fieldLabel:'Nombre funcionario',
                    gdisplayField:'desc_person',//mapea al store del grid
                    anchor: '100%',
                    gwidth:200,
                    renderer:function (value, p, record){return String.format('{0}', record.data['desc_person']);}
                },
                type:'ComboRec',
                id_grupo:0,
                bottom_filter : true,
                filters:{
                    pfiltro:'PERSON.nombre_completo2',
                    type:'string'
                },

                grid:true,
                form:true
            },
            {
                config:{
                    fieldLabel: "Cargo",
                    gwidth: 220,
                    name: 'descripcion_cargo',
                    allowBlank:false,
                    maxLength:200,
                    minLength:1,
                    anchor:'100%'
                },
                type:'TextField',
                filters:{
                    pfiltro: 'fc.descripcion_cargo',
                    type:'string'
                },
                bottom_filter : true,
                id_grupo:0,
                grid:true,
                form:true
            },

            {
                config:{
                    fieldLabel: "Foto",
                    gwidth: 130,
                    inputType:'file',
                    name: 'foto',
                    //allowBlank:true,
                    buttonText: '',
                    maxLength:150,
                    anchor:'100%',
                    renderer:function (value, p, record){
                        var momentoActual = new Date();
                        var hora = momentoActual.getHours();
                        var minuto = momentoActual.getMinutes();
                        var segundo = momentoActual.getSeconds();

                        hora_actual = hora+":"+minuto+":"+segundo;
                        var foto = record.data['nombre_archivo_foto'];
                        console.log('fotitoYMR',foto);
                        return String.format('{0}', "<div style='text-align:center'><img src = '../../control/foto_persona/ActionObtenerFoto.php?file=" + foto + "' align='center'  height='70'/></div>");
                    },
                    buttonCfg: {
                        iconCls: 'upload-icon'
                    }
                },
                //type:'FileUploadField',
                type:'Field',
                sortable:false,
                //filters:{type:'string'},
                id_grupo:0,
                grid:true,
                form:false
            },

            {
                config:{
                    fieldLabel: "Nacionalidad",
                    gwidth: 120,
                    name: 'nacionalidad',
                    allowBlank:false,
                    maxLength:200,
                    minLength:1,
                    anchor:'100%'
                },
                type:'TextField',
                filters:{type:'string'},
                bottom_filter : true,
                id_grupo:0,
                grid:true,
                form:true
            },

            {
                config:{
                    fieldLabel: "CI",
                    gwidth: 120,
                    name: 'ci',
                    allowBlank:false,
                    maxLength:20,
                    minLength:1,
                    anchor:'100%'
                },
                type:'TextField',
                filters:{pfiltro:'PERSON.ci',
                    type:'string'},
                id_grupo:0,
                bottom_filter : true,
                grid:true,
                form:false
            },
            {
                config:{
                    fieldLabel: "Correo Empresarial",
                    gwidth: 120,
                    name: 'email_empresa',
                    allowBlank:true,
                    maxLength:100,
                    minLength:1,
                    anchor:'100%'
                },
                type:'TextField',
                id_grupo:0,
                bottom_filter : true,
                filters:{
                    pfiltro:'FUNCIO.email_empresa',
                    type:'string'
                },
                grid:true,
                form:true
            },
            {
                config:{
                    name: 'telefono_ofi',
                    fieldLabel: "Telf. Oficina",
                    gwidth: 120,
                    allowBlank:true,
                    maxLength:50,
                    minLength:1,
                    anchor:'100%'
                },
                type:'TextField',
                filters:{type:'string'},
                id_grupo:0,
                grid:true,
                form:true
            },
            {
                config:{
                    fieldLabel: "Interno",
                    gwidth: 120,
                    name: 'interno',
                    allowBlank:true,
                    maxLength:100,
                    minLength:1,
                    anchor:'100%'
                },
                type:'TextField',
                filters:{type:'string'},
                id_grupo:0,
                grid:true,
                form:true
            },
            {
                config:{
                    fieldLabel: "Teléfono Domicilio",
                    gwidth: 120,
                    name: 'telefono1',
                    allowBlank:true,
                    maxLength:100,
                    minLength:1,
                    anchor:'100%'
                },
                type:'NumberField',
                filters:{type:'string'},
                id_grupo:0,
                grid:true,
                form:false
            },
            {
                config:{
                    fieldLabel: "Celular",
                    gwidth: 120,
                    name: 'celular1',
                    allowBlank:true,

                    maxLength:100,
                    minLength:1,
                    anchor:'100%'
                },
                type:'NumberField',
                filters:{type:'string'},
                id_grupo:0,
                grid:true,
                form:false
            },
            {
                config:{
                    fieldLabel: "Correo",
                    gwidth: 120,
                    name: 'correo',
                    allowBlank:true,
                    vtype:'email',
                    maxLength:50,
                    minLength:1,
                    anchor:'100%'
                },
                type:'TextField',
                id_grupo:0,
                bottom_filter : false,
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
                    format:'d/m/Y',
                    renderer:function (value,p,record){return value?value.dateFormat('d/m/Y h:i:s'):''}
                },
                type:'DateField',
                filters:{pfiltro:'ins.fecha_reg',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
            },
            {
                config:{
                    name:'estado_reg',
                    fieldLabel:'Estado',
                    allowBlank:false,
                    emptyText:'Estado...',

                    typeAhead: true,
                    triggerAction: 'all',
                    lazyRender:true,
                    mode: 'local',
                    valueField: 'estado_reg',
                    // displayField: 'descestilo',
                    store:['activo','inactivo']

                },
                type:'ComboBox',
                id_grupo:0,
                filters:{
                    type: 'list',
                    pfiltro:'FUNCIO.estado_reg',
                    dataIndex: 'size',
                    options: ['activo','inactivo'],
                },
                grid:true,
                form:true
            },
            {
                config:{
                    name: 'id_biometrico',
                    fieldLabel: 'ID Biométrico',
                    allowBlank: true,
                    anchor: '100%',
                    disabled: true,
                    style: 'color: blue; background-color: yellow;',
                    gwidth: 100,
                    maxLength:15
                },
                type:'NumberField',
                filters:{pfiltro:'FUNCIO.id_biometrico',type:'string'},
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
                type:'TextField',
                filters:{pfiltro:'usu1.cuenta',type:'string'},
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
                    renderer:function (value,p,record){return value?value.dateFormat('d/m/Y h:i:s'):''}
                },
                type:'DateField',
                filters:{pfiltro:'ins.fecha_mod',type:'date'},
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
                type:'TextField',
                filters:{pfiltro:'usu2.cuenta',type:'string'},
                id_grupo:1,
                grid:true,
                form:false
            }


        ];

        this.initButtons=[this.cmbDepto,this.cmbActivos];

        Phx.vista.AsignacionNumeroCelular.superclass.constructor.call(this,config);

        this.init();
        this.iniciarEventos();
        //this.load({params:{start:0, limit:50}});

    }

    Ext.extend(Phx.vista.AsignacionNumeroCelular,Phx.gridInterfaz,{
        savePltGrid: true, //#24configura el manejo de plantilla para la grilla
        applyPltGrid: true, //#24
        bottom_filter: true,//#24
        tipoStore: 'GroupingStore',//GroupingStore o JsonStore #24
        //remoteGroup: true,//#24
        //groupField: 'nacionalidad',//#24
        viewGrid: new Ext.grid.GroupingView({
            forceFit:false,
            //groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        }), //#24


        title:'Funcionarios',
        ActSave:'../../sis_organigrama/control/Funcionario/guardarFuncionario',
        ActDel:'../../sis_organigrama/control/Funcionario/eliminarFuncionario',
        ActList:'../../sis_gestion_comunicacion/control/FuncionarioCelular/listarFuncionario',
        id_store:'id_funcionario',
        fields: [
            {name:'id_funcionario'},
            {name:'id_persona'},
            {name:'id_lugar', type: 'numeric'},
            {name:'desc_person',type:'string'},
            {name:'genero',type:'string'},
            {name:'estado_civil',type:'string'},
            {name:'nombre_lugar',type:'string'},
            {name:'nacionalidad',type:'string'},
            {name:'codigo',type:'string'},
            {name:'antiguedad_anterior',type:'numeric'},

            {name:'estado_reg', type: 'string'},

            {name:'ci', type:'string'},
            {name:'documento', type:'string'},
            {name:'correo', type:'string'},
            {name:'celular1'},
            {name:'telefono1'},
            {name:'email_empresa', type: 'string'},
            'interno',
            {name:'fecha_ingreso', type: 'date', dateFormat:'Y-m-d'},
            {name:'fecha_nacimiento', type: 'date', dateFormat:'Y-m-d'},
            {name:'fecha_reg', type: 'date', dateFormat:'Y-m-d'},
            {name:'id_usuario_reg', type: 'numeric'},
            {name:'fecha_mod', type: 'date', dateFormat:'Y-m-d'},
            {name:'id_usuario_mod', type: 'numeric'},
            {name:'usr_reg', type: 'string'},
            {name:'usr_mod', type: 'string'},
            'telefono_ofi',
            'horario1',
            'horario2',
            'horario3',
            'horario4',
            'id_auxiliar',
            'desc_auxiliar',
            {name:'id_biometrico', type: 'numeric'},
            'profesion','codigo_rciva',
            {name:'fecha_quinquenio', type: 'date', dateFormat:'Y-m-d'},
            {name:'nombre_archivo_foto', type: 'string'},
            {name:'descripcion_cargo', type: 'string'},
            {name:'id_uo', type: 'numeric'},
        ],
        sortInfo:{
            field: 'PERSON.nombre_completo1',
            direction: 'ASC'
        },


        // para configurar el panel south para un hijo

        /*
         * south:{
         * url:'../../../sis_seguridad/vista/usuario_regional/usuario_regional.php',
         * title:'Regional', width:150
         *  },
         */
        bdel:true,
        bsave:false,
        fwidth: 500,
        fheight: 480,
        preparaMenu:function()
        {
            Phx.vista.AsignacionNumeroCelular.superclass.preparaMenu.call(this);
        },
        iniciarEventos: function (){
            var me = this;

            /*this.cmbGestion.on('select', function(combo, record, index){
                this.cmbPeriodo.enable();
                this.cmbPeriodo.reset();
                this.store.removeAll();
                me.store.baseParams.id_gestion = this.cmbGestion.getValue();
                this.cmbPeriodo.store.baseParams = Ext.apply(this.cmbPeriodo.store.baseParams, {id_gestion: this.cmbGestion.getValue()});
                this.cmbPeriodo.modificado = true;
                Ext.state.Manager.set( this.grid.stateId+'_id_gestion', this.cmbGestion.getValue() );//grava en cookies la gestion

            },this);*/

            this.cmbDepto.store.load({params:{start:0,limit:this.tam_pag},
                callback : function (r) {
                    console.log('yamil sera ', r);
                    //if (r.length == 1 ) {
                    this.cmbDepto.setValue(r[0].data.id_uo);
                    this.cmbDepto.fireEvent('select', r[0]);
                    //}

                }, scope : this
            });

            this.cmbActivos.setValue(1);

            this.cmbDepto.on('select', function( combo, record, index){
                console.log('llega');
                Ext.state.Manager.set(this.grid.stateId+'_id_uos', this.cmbDepto.getValue());//grava en cookies el periodo
                me.store.baseParams.id_uo = this.cmbDepto.getValue();
                this.capturaFiltros();
            },this);

            this.cmbActivos.on('select', function( combo, record, index){
                console.log('llega2');
                Ext.state.Manager.set(this.grid.stateId+'_id_tipo_empleados', this.cmbDepto.getValue());//grava en cookies el periodo
                me.store.baseParams.id_tipo_empleados = this.cmbActivos.getValue();
                this.capturaFiltros();
            },this);

        },
        capturaFiltros:function(combo, record, index){
            //this.desbloquearOrdenamientoGrid();
            if(this.validarFiltros()){
                this.store.baseParams.id_uo = this.cmbDepto.getValue();
                this.store.baseParams.id_tipo_empleados = this.cmbActivos.getValue();
                this.load();
            }

        },
        validarFiltros : function() {
            if (this.cmbDepto.getValue() != '' && this.cmbActivos.getValue() != '' ) {
                return true;
            } else {
                return false;
            }
        },
        cmbDepto: new Ext.form.ComboBox({
            name: 'id_uo',
            fieldLabel: 'Unidad Organizacional',
            width: 300,
            blankText: 'Unidad',
            typeAhead: false,
            forceSelection: true,
            allowBlank: false,
            disableSearchButton: true,
            emptyText: 'Unidad Org',
            store: new Ext.data.JsonStore({
                url: '../../sis_gestion_comunicacion/control/FuncionarioCelular/listarUnidadOrganizacional',
                id: 'id_uo',
                root: 'datos',
                sortInfo:{
                    field: 'uo.nombre_unidad',
                    direction: 'ASC'
                },
                totalProperty: 'total',
                fields: ['id_uo','nombre_unidad','codigo'],
                // turn on remote sorting
                remoteSort: true,
                baseParams: { par_filtro:'uo.nombre_unidad#uo.codigo'}
            }),
            valueField: 'id_uo',
            displayField: 'nombre_unidad',
            hiddenName: 'id_uo',
            enableMultiSelect: true,
            triggerAction: 'all',
            lazyRender: true,
            mode: 'remote',
            pageSize: 20,
            queryDelay: 200,
            anchor: '100%',
            listWidth:'380',
            resizable:true,
            minChars: 2
        }),
        cmbActivos: new Ext.form.ComboBox({
            fieldLabel: 'Tipo de Empleados',
            allowBlank: false,
            blankText:'Tipo de Empleados',
            emptyText:'Tipo de Empleados...',
            name:'id_tipo_empleados',
            store:new Ext.data.ArrayStore({
                fields: ['ID', 'valor'],
                data :	[[1,'Activos'],
                         [3,'Inactivos'],
                         [2,'Todos']]

            }),
            valueField: 'ID',
            triggerAction: 'all',
            displayField: 'valor',
            mode:'local',
            width:100
        }),
    })
</script>
