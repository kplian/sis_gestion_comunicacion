<?php
/**
 *@package pXP
 *@file    SubirArchivo.php
 *@author  Yamil Medina
 *@date    22-05-2021
 *@description permites subir archivos a la tabla de documento_sol
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.DevolucionEquipo=Ext.extend(Phx.frmInterfaz,{
            ActSave:'../../sis_gestion_comunicacion/control/Equipo/retornarEquipo',

            constructor:function(config)
            {
                Phx.vista.DevolucionEquipo.superclass.constructor.call(this,config);
                this.init();
                this.loadValoresIniciales();
            },

            loadValoresIniciales:function()
            {   console.log('yamilllllllllllllll',this.data);
                Phx.vista.DevolucionEquipo.superclass.loadValoresIniciales.call(this);
                this.getComponente('id_funcionario_celular').setValue(this.data.id_funcionario_celular);
                this.getComponente('id_funcionario').setValue(this.data.id_funcionario);
                this.getComponente('fecha_fin').setValue(this.data.fecha_fin);
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
                        name: 'id_funcionario_celular'
                    },
                    type:'Field',
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
                    id_grupo:1,
                    grid:true,
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
                    id_grupo:1,
                    grid:false,
                    form:true
                },
            ],
            title:'Devolucion',
        }
    )
</script>