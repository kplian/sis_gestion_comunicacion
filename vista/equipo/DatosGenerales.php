<?php
/**
 *@package pXP
 *@file gen-SistemaDist.php
 *@author  (ymedina)
 *@date 20-09-2021 10:22:05
 *@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.DatosGenerales = {
        require:'../../../sis_gestion_comunicacion/vista/numero_celular/AsignacionNumeroCelular.php',
        requireclase:'Phx.vista.AsignacionNumeroCelular',
        title:'Funcionarios',
        constructor: function(config) {
            Phx.vista.DatosGenerales.superclass.constructor.call(this,config);
        },
        bedit:false,
        bnew:false,
        bdel:false,
        bsave:false,
        tabsouth: [{
            url: '../../../sis_gestion_comunicacion/vista/equipo/EquipoAsignado.php',
            title: 'Detalle Equipos',
            height: '40%',
            cls: 'EquipoAsignado',
            params: { nombre_tabla: 'orga.tfuncionario', tabla_id: 'id_funcionario'}
        }],
        EnableSelect : function (n, extra) {
            var miExtra = {codigos_tipo_relacion:''};
            if (extra != null && typeof extra === 'object') {
                miExtra = Ext.apply(extra, miExtra)
            }
            Phx.vista.DatosGenerales.superclass.EnableSelect.call(this,n,miExtra);
        }
    };
</script>