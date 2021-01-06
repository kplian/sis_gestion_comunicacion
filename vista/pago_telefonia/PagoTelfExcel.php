<script>
    Phx.vista.PagoTelfExcel=Ext.extend(Phx.frmInterfaz,{

            constructor:function(config)
            {
                Phx.vista.PagoTelfExcel.superclass.constructor.call(this,config);
                this.init();
                this.iniciarEventos();
                this.loadValoresIniciales();
            },

            loadValoresIniciales:function()
            {
                Phx.vista.PagoTelfExcel.superclass.loadValoresIniciales.call(this);
                this.getComponente('id_pago_telefonia').setValue(this.id_pago_telefonia);
            },

            successSave:function(resp)
            {
                Phx.CP.loadingHide();
                Phx.CP.getPagina(this.idContenedorPadre).reload();
                this.panel.close();
            },

            conexionFailure:function(resp){
              var datos_respuesta = JSON.parse(resp.responseText);
              Phx.CP.loadingHide();
              this.panel.close();
              if (datos_respuesta.ROOT.error == true) {
                  Ext.Msg.show({
                    width:'100%',
                    height:'100%',
                   title:'<h1 style="color:red; font-size:15px;"><center><i class="fa fa-exclamation-circle" aria-hidden="true"></i> ALERTA</center></h1>',
                   msg: '<p style="font-size:14px;">'+datos_respuesta.ROOT.detalle.mensaje+'</p>',
                   buttons: Ext.Msg.OK,
                   fn: function () {
                      Phx.CP.getPagina(this.idContenedorPadre).reload();
                      this.panel.close();
                   },
                   scope:this
                });
                }
            },

            Atributos:[
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_pago_telefonia'
                    },
                    type:'Field',
                    form:true

                },
                {
                    config:{
                        name:'codigo',
                        fieldLabel:'Codigo Archivo',
                        allowBlank:false,
                        emptyText:'Codigo Archivo...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_gestion_comunicacion/control/PagoTelefonia/listarPlantillaArchivoExcel',
                            id: 'id_plantilla_archivo_excel',
                            root: 'datos',
                            sortInfo:{
                                field: 'codigo',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_plantilla_archivo_excel','nombre','codigo'],
                            remoteSort: true,
                            baseParams:{par_filtro:'codigo', vista:'vista', archivoPagTel: 'GPAGTELF'}
                        }),
                        valueField: 'codigo',
                        displayField: 'codigo',
                        hiddenName: 'codigo',
                        forceSelection:true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender:true,
                        mode:'remote',
                        pageSize:10,
                        queryDelay:1000,
                        listWidth:260,
                        resizable:true,
                        anchor:'90%',
                        tpl: new Ext.XTemplate([
                            '<tpl for=".">',
                            '<div class="x-combo-list-item">',
                            '<p><b>Nombre:</b> <span style="color: blue; font-weight: bold;">{nombre}</span></p>',
                            '<p><b>Codigo:</b> <span style="color: green; font-weight: bold;">{codigo}</span></p>',
                            '</div></tpl>'
                        ])
                    },
                    type:'ComboBox',
                    id_grupo:0,
                    grid:true,
                    form:true
                },
                {
                    config:{
                        fieldLabel: "Documento",
                        gwidth: 130,
                        inputType:'file',
                        name: 'archivo',
                        buttonText: '',
                        maxLength:150,
                        anchor:'100%'
                    },
                    type:'Field',
                    form:true
                }
            ],
            title:'Subir Archivo',
            fileUpload:true,
            ActSave:'../../sis_gestion_comunicacion/control/PagoTelefoniaDet/cargarArchivoPagTelfExcel '
        }
    )
</script>
