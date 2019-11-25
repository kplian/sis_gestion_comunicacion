<?Php
/**
 *@package pXP
 *@file   PagosSinFacturasAsociadas.php
 *@author  YM
 *@date    15-11-2019
 *@description Archivo con la interfaz para generaci�n de reporte
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.ReporteTelecomunicaciones = Ext.extend(Phx.frmInterfaz, {
        Atributos : [
            {
                config:{
                    name:'id_gestion',
                    fieldLabel:'Gestión',
                    allowBlank:false,
                    emptyText:'Gestión...',
                    store: new Ext.data.JsonStore({
                        url: '../../sis_parametros/control/Gestion/listarGestion',
                        id: 'id_gestion',
                        root: 'datos',
                        sortInfo:{
                            field: 'gestion',
                            direction: 'DESC'
                        },
                        totalProperty: 'total',
                        fields: ['id_gestion','gestion','moneda','codigo_moneda'],
                        // turn on remote sorting
                        remoteSort: true,
                        baseParams:{par_filtro:'gestion'}
                    }),
                    valueField: 'id_gestion',
                    displayField: 'gestion',
                    hiddenName: 'id_gestion',
                    forceSelection:true,
                    typeAhead: false,
                    triggerAction: 'all',
                    lazyRender:true,
                    mode:'remote',
                    pageSize:10,
                    queryDelay:1000,
                    listWidth:250,
                    resizable:true,
                    width:250
                },
                type:'ComboBox',
                id_grupo:0,
                filters:{
                    pfiltro:'gestion',
                    type:'string'
                },
                grid:true,
                form:true
            },
            {
                config:{
                    name: 'tipo_facturacion',
                    fieldLabel: 'Tipo Facturacion',
                    allowBlank : false,
                    triggerAction : 'all',
                    lazyRender : true,
                    mode : 'local',
                    store : new Ext.data.ArrayStore({
                        fields : ['codigo', 'nombre'],
                        data : [['fijo', 'TELEFONIA FIJA'], ['celular', 'TELEFONIA MOVIL'], ['4g', 'SERVICIO 4G']]
                    }),
                    anchor : '35%',
                    valueField : 'codigo',
                    displayField : 'nombre',
                    gwidth:35,
                    /*renderer: function(value, p, record){
                        var aux;
                        switch (value) {
                            case 'corto_alcance':
                                aux = 'Corto Alcance';
                                break;
                            case 'mediano_alcance':
                                aux = 'Mediano Alcance';
                                break;
                            case 'largo_alcance':
                                aux = 'Largo Alcance';
                                break;
                            default:
                                aux = 'Otros';
                        }
                        return String.format('{0}', aux);
                    }*/
                },
                type:'ComboBox',
                //filters:{pfiltro:'tipflo.tipo_flota',type:'string'},
                id_grupo:1,
                bottom_filter: true,
                grid:true,
                form:true
            }],

        title : 'Generar Reporte',
        ActSave : '../../sis_gestion_comunicacion/control/Consumo/reporteCostosTelecomunicaciones',

        topBar : true,
        botones : false,
        labelSubmit : 'Imprimir',
        tooltipSubmit : '<b>Generar Reporte</b>',

        constructor : function(config) {
            Phx.vista.ReporteTelecomunicaciones.superclass.constructor.call(this, config);
            this.init();
            this.iniciarEventos();
        },

        iniciarEventos:function(){
            this.cmpFechaIni = this.getComponente('fecha_ini');
            this.cmpFechaFin = this.getComponente('fecha_fin');
            this.cmpProveedor = this.getComponente('id_proveedor');
            this.cmpContrato = this.getComponente('id_contrato');

            this.Cmp.id_proveedor.on('select',function(c,r,i) {

                this.Cmp.id_contrato.reset();
                this.Cmp.id_contrato.store.baseParams.pruebass = r.data.id_proveedor;
                this.Cmp.id_contrato.modificado = true;
            },this);
        },
        tipo : 'reporte',
        clsSubmit : 'bprint'

    })
</script>