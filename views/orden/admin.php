<?php

/* @var $this OrdenController */
/* @var $model Orden */

echo System::Search(array(
    'title' => 'Administración de Ordenes',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'buttons' => array(
        array('name' => 'print', 'icon' => 'print', 'widthLinks' => 100,
            'links' => array(
                array('icon' => 'print', 'url' => 'reporteOrdenLote', 'title' => 'Orden en lote'),
            )
        )),
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admOrden',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'numero',
                'split' => false,
                'width' => 5,
            ),
            array(
                'name' => 'fecha',
                'value' => '$data->id0->fecha',
                'type' => 'datetime',
                'width' => 12,
            ),
            array(
                'name' => 'ultimoEstado',
                'value' => '$data->idultimoestado0->nombre',
                'width' => 10,
            ),
            array(
                'name' => 'codigo',
                'value' => '$data->id0->idproducto0->codigo',
                'width' => 11,
            ),
            array(
                'name' => 'producto',
                'value' => '$data->id0->idproducto0->nombre',
                'width' => 32,
            ),
            array(
                'name' => 'cantidad',
                'value' => '$data->id0->cantidadproducir',
                'width' => 7,
                'align' => 'right',
            ),
            array(
                'name' => 'idunidad',
                'value' => '$data->id0->idproducto0->idunidad0->simbolo',
                'width' => 4,
            ),
            array(
                'name' => 'usuario',
                'value' => '$data->id0->usuario',
                'width' => 6,
            ),
            array('typeCol' => 'buttons',
                'width' => 13,
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'buttons' => array(
                    'seguimiento' => array(
                        'label' => 'Seguimiento',
                        'icon' => 'share-alt',
                        'click' => '                                                        
					function(){  
						SGridView.selectRow(this);                                                            
						admOrden.seguimiento();
						return false;
					}',
                    ),
                    'registrarSalida' => array(
                        'visible' => Yii::app()->user->checkAccess('action_produccion_orden_registrarSalida'),
                        'label' => 'Registrar Insumo Adicional',
                        'icon' => 'icon-plus',
                        'click' => 'function() {
                            SGridView.selectRow(this);
                            admOrden.registrarInsumo();
                            return false;
                        }'
                    ),
                    'Imprimir' => array('url' => 'array("reporteOrden","id"=>SeguridadModule::enc($data->getPrimaryKey()))', 'icon' => 'print', 'options' => array('target' => '_blank')),
                    'Orden Simple' => array('url' => 'array("reporteOrdenSimple","id"=>SeguridadModule::enc($data->getPrimaryKey()))', 'icon' => 'print', 'options' => array('target' => '_blank')),
                    'registrarDevolucion' => array(
                        'visible' => Yii::app()->user->checkAccess('action_produccion_orden_registrarDevolucion'),
                        'label' => 'Registrar Devolución',
                        'icon' => 'share',
                        'click' => '                                                        
                    function(){                                                            
                        SGridView.selectRow(this);
                        admOrden.registrarDevolucion();
                        return false;
                    }',
                    ),
                    'registrarEntrega' => array(
                        'visible' => Yii::app()->user->checkAccess('action_produccion_orden_registrarEntrega'),
                        'label' => 'Registrar Entrega',
                        'icon' => 'circle-arrow-up',
                        //'visible' => 'Orden::model()->mostrarBotonRegistrarEntrega($data->ultimoestado)',
                        'click' => '                                                        
                    function(){                                                            
                        SGridView.selectRow(this);
                        admOrden.registrarEntrega();
                        return false;
                    }',
                    ),
                    'registrarResidual' => array(
                        'visible' => Yii::app()->user->checkAccess('action_produccion_orden_registrarResidual'),
                        'label' => 'Registrar Subproducto',
                        'icon' => 'icon-large icon-download-alt',
                        //'visible' => 'Orden::model()->mostrarBotonRegistrarEntrega($data->ultimoestado)',
                        'click' => '                                                        
                    function(){                                                            
                        SGridView.selectRow(this);
                        admOrden.registrarResidual();
                        return false;
                    }',
                    ),                    
                ),
            ),
        ))
)));

