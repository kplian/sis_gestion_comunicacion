<?php
/****************************************************************************************
*@package pXP
*@file gen-Accesorio.php
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
Phx.vista.Accesorio=Ext.extend(Phx.gridInterfaz,{

    constructor:function(config){
        this.maestro=config.maestro;
        //llama al constructor de la clase padre
        Phx.vista.Accesorio.superclass.constructor.call(this,config);
        this.init();
        this.load({params:{start:0, limit:this.tam_pag}})
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
            config:{
                name: 'tipo',
                fieldLabel: 'Tipo',
                allowBlank: false,
                anchor: '80%',
                gwidth: 100,
            	maxLength:300
            },
			type:'TextField',
			bottom_filter : true,
			filters:{pfiltro:'acc.tipo',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
        {
            config:{
                name: 'marca',
                fieldLabel: 'marca',
                allowBlank: false,
                anchor: '80%',
                gwidth: 100,
            	maxLength:200
            },
                type:'TextField',
                filters:{pfiltro:'acc.marca',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
		{
            config:{
                name: 'modelo',
                fieldLabel: 'Modelo',
                allowBlank: false,
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
                fieldLabel: 'Numero de Serie',
                allowBlank: false,
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
            config:{
                name: 'estado_fisico',
                fieldLabel: 'Estado Fisico',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:200
            },
                type:'TextField',
                filters:{pfiltro:'acc.estado_fisico',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'observaciones',
                fieldLabel: 'Observaciones',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:400
            },
                type:'TextField',
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
    title:'Accesorios',
    ActSave:'../../sis_gestion_comunicacion/control/Accesorio/insertarAccesorio',
    ActDel:'../../sis_gestion_comunicacion/control/Accesorio/eliminarAccesorio',
    ActList:'../../sis_gestion_comunicacion/control/Accesorio/listarAccesorio',
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
        Phx.vista.Accesorio.superclass.loadValoresIniciales.call(this);
        /*this.getComponente('id_equipo').setValue(this.maestro.id_equipo);*/
    },
    }
)
</script>
        
        