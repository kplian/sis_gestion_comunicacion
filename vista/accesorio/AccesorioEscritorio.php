<?php
/****************************************************************************************
 *@package pXP
 *@file gen-AccesorioMovil.php
 *@author  (ymedina)
 *@date 29-05-2021 16:19:41
 *@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
#0                29-05-2021 16:19:41    ymedina            Creacion
#

 *******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.AccesorioEscritorio=Ext.extend(Phx.gridInterfaz,{

            constructor:function(config){
                this.maestro=config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.AccesorioEscritorio.superclass.constructor.call(this,config);
                this.init();
                this.iniciarEventos();
                this.load({params:{start:0, limit:this.tam_pag}})
            },
            iniciarEventos:function () {
                this.Cmp.tipo.on('select',function(c,r,i) {
                    if(r.data.codigo == 'monitor'){
                        this.Cmp.codigo_inmovilizado.show();
                        this.Cmp.codigo_inmovilizado.allowBlank=false;
                        this.Cmp.tamano.show();
                    }else{
                        this.Cmp.codigo_inmovilizado.hide();
                        this.Cmp.codigo_inmovilizado.allowBlank=true;
                        this.Cmp.tamano.hide();
                    }
                },this);
            },
            Atributos:[
                {
                    //configuracion del componente
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_accesorio'
                    },
                    type:'Field',
                    form:true
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
                            baseParams: {par_filtro:'descripcion',cod_subsistema:'GECOM',catalogo_tipo:'accesorio_equipo'}
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
                    form:true
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
                    form:true
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
                    form:true
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
                    form:true
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
                    form:true
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
                    filters:{pfiltro:'acc.id_usuario_ai',type:'numeric'},
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
                    filters:{pfiltro:'acc.usuario_ai',type:'string'},
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
                    filters:{pfiltro:'acc.fecha_mod',type:'date'},
                    id_grupo:1,
                    grid:true,
                    form:false
                }
            ],
            tam_pag:50,
            title:'Accesorio Escritorio',
            ActSave:'../../sis_gestion_comunicacion/control/Accesorio/insertarAccesorio',
            ActDel:'../../sis_gestion_comunicacion/control/Accesorio/eliminarAccesorio',
            ActList:'../../sis_gestion_comunicacion/control/Accesorio/listarAccesorioEscritorio',
            id_store:'id_accesorio',
            fields: [
                {name:'id_accesorio', type: 'numeric'},
                {name:'id_equipo', type: 'numeric'},
                {name:'estado_reg', type: 'string'},
                {name:'nombre', type: 'string'},
                {name:'marca', type: 'string'},
                {name:'num_serie', type: 'string'},
                {name:'estado_fisico', type: 'string'},
                {name:'observaciones', type: 'string'},
                {name:'id_usuario_reg', type: 'numeric'},
                {name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
                {name:'id_usuario_ai', type: 'numeric'},
                {name:'usuario_ai', type: 'string'},
                {name:'id_usuario_mod', type: 'numeric'},
                {name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
                {name:'usr_reg', type: 'string'},
                {name:'usr_mod', type: 'string'},
                {name:'tipo', type: 'string'},
                {name:'modelo', type: 'string'},
                {name:'tipo_desc', type: 'string'},
                {name:'marca_desc', type: 'string'},
                {name:'estado_fisico_desc', type: 'string'},
                {name:'codigo_inmovilizado', type: 'string'},
                {name:'tamano', type: 'string'},
            ],
            sortInfo:{
                field: 'id_accesorio',
                direction: 'ASC'
            },
            bdel:true,
            bsave:true,
            onReloadPage:function(m){
                /*this.maestro=m;
                console.log(this.maestro);
                this.store.baseParams={id_equipo: this.maestro.id_equipo};*/

                //this.Cmp.idioma.store.baseParams.id_funcionario = this.maestro.id_funcionario;
                this.load({params:{start:0, limit:this.tam_pag}});
            },
            loadValoresIniciales:function()
            {
                Phx.vista.AccesorioEscritorio.superclass.loadValoresIniciales.call(this);
                /*this.getComponente('id_equipo').setValue(this.maestro.id_equipo);*/
            },
            onButtonNew:function(){
                Phx.vista.AccesorioEscritorio.superclass.onButtonNew.call(this);
                this.Cmp.codigo_inmovilizado.hide();
                this.Cmp.tamano.hide();
            },
            onButtonEdit: function() {
                Phx.vista.AccesorioEscritorio.superclass.onButtonEdit.call(this);
                var sel = this.sm.getSelected().data;

                if(sel.tipo == 'monitor'){
                    this.Cmp.codigo_inmovilizado.show();
                    this.Cmp.codigo_inmovilizado.allowBlank=false;
                    this.Cmp.tamano.show();
                }else{
                    this.Cmp.codigo_inmovilizado.hide();
                    this.Cmp.codigo_inmovilizado.allowBlank=true;
                    this.Cmp.tamano.hide();
                }
            },
        }
    )
</script>

