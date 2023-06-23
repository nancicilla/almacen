<?php

/* @var $this InventarioController */
/* @var $model Inventario */

echo System::Search(array(
    'title' => 'Administración de Inventarios',
    'formSearch' => $this->renderPartial('_search', array('model' => $model,), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admInventario',
//        'eventRowCondition'=> 'false',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(                
                'name' => 'numero',
                'width' => 5),
            array(
                'header' => 'F. Inicio',
                'name' => 'fechainicio',
                'type' => 'date',
                'width' => 8),
            array(
                'header' => 'F. Fin',
                'name' => 'fechafin',
                'type' => 'date',
                'width' => 8),
            array(
                'name' => 'idAlmacen',
                'width' => 21,
                'value' => '$data->inventarios->nombre'
            ),
            array(
                'name' => 'idestado',
                'header' => 'Estado',
                'width' => 10,
                'value' => '$data->idestado0->nombre'),
            array(
                'name' => 'descripcion',
                'width' => 28,
            ),
            array('typeCol' => 'buttons',
                'width' => 20,
                'buttons' => array(
                    'imprimir' => array('icon' => 'print'
                        , 'url' => 'array("reporteInventario","id"=>SeguridadModule::enc($data->getPrimaryKey()))', 'options' => array("target" => "_blank")),
                    'imprimirValorado' => array('icon' => 'tag',
                        'label'=>'Valorado', 
                        'url' => 'array("reporteInventarioValorado","id"=>SeguridadModule::enc($data->getPrimaryKey()))', 'options' => array("target" => "_blank")),
                    'imprimirValoradoPrecio' => array('icon' => 'tag',
                        'label'=>'ValoradoPrecio', 
                        'url' => 'array("reporteInventarioValoradoPrecioVenta","id"=>SeguridadModule::enc($data->getPrimaryKey()))', 'options' => array("target" => "_blank")),
                    'imprimirExcel' => array('icon' => 'download-alt',
                        //'visible' => 'Estado::model()->esEstadoInicio($data->idestado)',
                        'label'=>'DescargarExcel', 
                        'url' => 'array("reporteInventarioExcelPrecioVenta","id"=>SeguridadModule::enc($data->getPrimaryKey()))'),
                    'update' => array(
                        'label' => 'Modificar',
                        'visible' => 'Estado::model()->esEstadoInicio($data->idestado)'
                    ),
                    'anular' => array(
                        'url' => 'array("anular","id"=>SeguridadModule::enc($data->getPrimaryKey()))',
                        'icon' => 'remove',
                        'visible' => 'Estado::model()->esEstadoInicio($data->idestado)',
                        'click' => 'function(){
                            SGridView.selectRow(this); 
                            var href = $(this).attr("href");
                            bootbox.confirm("Éste es un proceso irreversible! ¿Está seguro que desea anular el inventario?",
                                function(confirmed){
                                    if (confirmed){
                                        $.ajax({
                                            type: "post",
                                            url: href,         
                                            success: function(data) {
                                                if ($.trim(data)){
                                                    bootbox.alert(data);
                                                }
                                                admInventario.search();
                                            }
                                        });
                                    }
                                }
                            ); 
                        return false;}',
                    ),
                    'cerrar' => array(
                        'label' => 'Cerrar inventario',
                        'icon' => 'lock',
                        'visible' => 'Estado::model()->esEstadoInicio($data->idestado)',
                        'url' => 'array("cerrar","id"=>SeguridadModule::enc($data->getPrimaryKey()))',
                        'click' => 'function(){
                            SGridView.selectRow(this); 
                            var href = $(this).attr("href");
                            bootbox.confirm("¿Está seguro que desea cerrar el inventario?",
                                function(confirmed){
                                    if (confirmed){
                                        $.ajax({
                                            type: "post",
                                            url: href,         
                                            success: function(data) {
                                                if ($.trim(data)){
                                                    bootbox.alert(data);
                                                }
                                                admInventario.search();
                                            }
                                        });
                                    }
                                }
                            ); 
                        return false;}',
                    ),
                    'reabrir' => array(
                        'label' => 'Reabrir Inventario',
                        'icon' => 'repeat', 'visible' => 'Estado::model()->esEstadoCerrado($data->idestado)',
                        'visible' => 'Estado::model()->esEstadoCerrado($data->idestado)',
                        'url' => 'array("reabrir","id"=>SeguridadModule::enc($data->getPrimaryKey()))',
                        'click' => 'function(){
                            SGridView.selectRow(this); 
                            var href = $(this).attr("href");
                            bootbox.confirm("¿Está seguro que desea reabrir el inventario?",
                                function(confirmed){
                                    if (confirmed){
                                        $.ajax({
                                            type: "post",
                                            url: href,         
                                            success: function(data) {
                                                if ($.trim(data)){
                                                    bootbox.alert(data);
                                                }
                                                admInventario.search();
                                            }
                                        });
                                    }
                                }
                            ); 
                        return false;}',
                    ),
                    'confirmar' => array(
                        'label' => 'Confirmar Diferencias',
                        'icon' => 'check',
                        'visible' => 'Estado::model()->esEstadoCerrado($data->idestado) && '.Yii::app()->user->checkAccess('action_almacen_inventario_confirmar').'==1',
                        'url' => 'array("confirmar","id"=>SeguridadModule::enc($data->getPrimaryKey()))',
                        'click' => 'function(){
                            SGridView.selectRow(this); 
                            var href = $(this).attr("href");
                            bootbox.confirm("Éste es un proceso irreversible! ¿Esta seguro que desea confirmar las diferencias de inventario?",
                                function(confirmed){
                                    if (confirmed){
                                        $.ajax({
                                            type: "post",
                                            url: href,         
                                            success: function(data) {
                                                if ($.trim(data)){
                                                    bootbox.alert(data);
                                                }
                                                admInventario.search();
                                            }
                                        });
                                    }
                                }
                            ); 
                        return false;}',
                    ),
                    'editar' => array(
                        'label' => 'Editar Inventario',
                        'icon' => 'icon-wrench',
                        'visible' => 'Estado::model()->esEstadoInicio($data->idestado)',
                        'click' => 'function() {
                            SGridView.selectRow(this);
                            admInventario.editar();
                            return false;
                        }'
                    ),
                    'actualizarSaldo' => array(
                        'label' => 'Actualizar Inventario',
                        'icon' => 'refresh',
                        'visible' => 'Estado::model()->esEstadoInicio($data->idestado)',
                        'click' => 'function() {
                            SGridView.selectRow(this);
                            admInventario.actualizar();
                            return false;
                        }'
                    )
                ),
            ),
        ),
            )
    )
        )
);

