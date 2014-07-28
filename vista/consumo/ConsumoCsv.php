<?php
/**
*@package pXP
*@file    SubirArchivo.php
*@author  Freddy Rojas 
*@date    22-03-2012
*@description permites subir archivos a la tabla de documento_sol
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.ConsumoCsv=Ext.extend(Phx.frmInterfaz,{
    ActSave:'../../sis_gestion_comunicacion/control/Consumo/modificarConsumoCsv',

    constructor:function(config)
    {   
        Phx.vista.ConsumoCsv.superclass.constructor.call(this,config);
        this.init();    
        this.iniciarEventos();
        this.loadValoresIniciales();               
        
    },    
    
    iniciarEventos : function() {			
		this.Cmp.id_gestion.on('select',function(c,r,i){
			this.Cmp.id_periodo.reset();
			this.Cmp.id_periodo.store.baseParams.id_gestion = r.data.id_gestion;
			this.Cmp.id_periodo.modificado = true;
		},this);		
	},
    successSave:function(resp)
    {
        Phx.CP.loadingHide();
        Phx.CP.getPagina(this.idContenedorPadre).reload();
        this.panel.close();
    },
                
    
    Atributos:[
        
        {
	   			config:{
	   				name : 'id_gestion',
	   				origen : 'GESTION',
	   				fieldLabel : 'Gestion',
	   				allowBlank : false,
	   				gdisplayField : 'gestion',//mapea al store del grid
	   				gwidth : 100,
		   			renderer : function (value, p, record){return String.format('{0}', record.data['gestion']);}
	       	     },
	   			type : 'ComboRec',
	   			id_grupo : 0,
	   			filters : {	
			        pfiltro : 'ges.gestion',
					type : 'numeric'
				},
	   		   
	   			grid : true,
	   			form : true
	   	},
		{
	   			config:{
	   				name : 'id_periodo',
	   				origen : 'PERIODO',
	   				fieldLabel : 'Periodo',
	   				allowBlank : true,
	   				gdisplayField : 'periodo',//mapea al store del grid
	   				gwidth : 100,
		   			renderer : function (value, p, record){return String.format('{0}', record.data['periodo']);}
	       	     },
	   			type : 'ComboRec',
	   			id_grupo : 0,
	   			filters : {	
			        pfiltro : 'per.periodo',
					type : 'numeric'
				},
	   		   
	   			grid : true,
	   			form : true
	   	},
        {
            config:{
                fieldLabel: "Documento (archivo csv separado por |)",
                gwidth: 130,
                inputType:'file',
                name: 'archivo',
                buttonText: '', 
                maxLength:150,
                anchor:'100%'                   
            },
            type:'Field',
            form:true 
        },      
    ],
    title:'Subir Archivo',    
    fileUpload:true
    
}
)    
</script>