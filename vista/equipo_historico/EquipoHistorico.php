<?php
/****************************************************************************************
*@package pXP
*@file gen-EquipoHistorico.php
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
Phx.vista.EquipoHistorico=Ext.extend(Phx.gridInterfaz,{

    constructor:function(config){
        this.maestro=config.maestro;
        //llama al constructor de la clase padre
        Phx.vista.EquipoHistorico.superclass.constructor.call(this,config);
        this.init();
        this.store.baseParams={id_usuario:Phx.CP.config_ini.id_usuario,nombreVista: this.nombreVista};
        var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
        if (dataPadre) {
            this.onEnablePanel(this, dataPadre);
        } else {
            this.bloquearMenus();
        }
    },
            
    Atributos:[
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_equipo_historico'
            },
            type:'Field',
            form:true 
        },
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
            config:{
                name: 'observaciones',
                fieldLabel: 'observaciones',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:-5
            },
            type:'TextField',
            filters:{pfiltro:'detequ.observaciones',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'operacion',
                fieldLabel: 'operacion',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:15
            },
            type:'TextField',
            filters:{pfiltro:'detequ.operacion',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config: {
                labelSeparator: '',
                inputType: 'hidden',
                name: 'id_equipo'
            },
            type: 'Field',
            form: true
        },
        {
            config:{
                name: 'tipo',
                fieldLabel: 'tipo',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:150
            },
                type:'TextField',
                filters:{pfiltro:'detequ.tipo',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'marca',
                fieldLabel: 'marca',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:200
            },
                type:'TextField',
                filters:{pfiltro:'detequ.marca',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'modelo',
                fieldLabel: 'modelo',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:200
            },
                type:'TextField',
                filters:{pfiltro:'detequ.modelo',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'num_serie',
                fieldLabel: 'num_serie',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:300
            },
                type:'TextField',
                filters:{pfiltro:'detequ.num_serie',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'estado_fisico',
                fieldLabel: 'estado_fisico',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:-5
            },
                type:'TextField',
                filters:{pfiltro:'detequ.estado_fisico',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'estado',
                fieldLabel: 'estado',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:50
            },
                type:'TextField',
                filters:{pfiltro:'detequ.estado',type:'string'},
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
                filters:{pfiltro:'detequ.fecha_reg',type:'date'},
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
                filters:{pfiltro:'detequ.id_usuario_ai',type:'numeric'},
                id_grupo:1,
                grid:false,
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
            filters:{pfiltro:'detequ.estado_reg',type:'string'},
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
                filters:{pfiltro:'detequ.usuario_ai',type:'string'},
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
                filters:{pfiltro:'detequ.fecha_mod',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		}
    ],
    tam_pag:50,    
    title:'Detalle Equipos',
    ActSave:'../../sis_gestion_comunicacion/control/EquipoHistorico/insertarEquipoHistorico',
    ActDel:'../../sis_gestion_comunicacion/control/EquipoHistorico/eliminarEquipoHistorico',
    ActList:'../../sis_gestion_comunicacion/control/EquipoHistorico/listarEquipoHistorico',
    id_store:'id_equipo_historico',
    fields: [
		{name:'id_equipo_historico', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_equipo', type: 'numeric'},
		{name:'tipo', type: 'string'},
		{name:'marca', type: 'string'},
		{name:'modelo', type: 'string'},
		{name:'num_serie', type: 'string'},
		{name:'estado_fisico', type: 'string'},
		{name:'estado', type: 'string'},
		{name:'observaciones', type: 'string'},
		{name:'operacion', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        {name:'id_funcionario_celular', type: 'numeric'},
    ],
    sortInfo:{
        field: 'id_equipo_historico',
        direction: 'ASC'
    },
    bdel: false,
    bedit: false,
    bnew: false,
    bsave: false,
    onReloadPage: function (m) {
        this.maestro = m;
        this.store.baseParams = {id_equipo: this.maestro.id_equipo, id_funcionario_celular: this.maestro.id_funcionario_celular};
        this.load({params: {start: 0, limit: this.tam_pag}});

        console.log('entra por reload');
    },
    loadValoresIniciales: function () {
        Phx.vista.EquipoHistorico.superclass.loadValoresIniciales.call(this);
        this.store.baseParams={id_usuario:Phx.CP.config_ini.id_usuario};
        this.getComponente('id_equipo').setValue(this.maestro.id_equipo);
        this.getComponente('id_funcionario_celular').setValue(this.maestro.id_funcionario_celular);
        console.log('entra dpor inicial');
    },
    onButtonNew:function(){
        Phx.vista.EquipoHistorico.superclass.onButtonNew.call(this);
        this.ocultarGrupo(1);
    }
    }
)
</script>
        
        