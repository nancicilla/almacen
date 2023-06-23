<?php

/* @var $this VistaordenpedidoController */
/* @var $model Vistaordenpedido */

echo System::Search(array(
    'title' => 'Ver Ordenes',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admVistaordenpedido',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'numero',
                'width' => 5,
            ),
            array(
                'name' => 'fecha',
                'value' => '$data->fecha',
                'type' => 'datetime',
                'width' => 15,
            ),
            array(
                'name' => 'ultimoEstado',
                'value' => '$data->idultimoestado0->nombre',
                'width' => 10,
            ),
            array(
                'name' => 'codigo',
                'value' => '$data->codigo',
                'width' => 10,
            ),
            array(
                'name' => 'producto',
                'value' => '$data->nombre',
                'width' => 32,
            ),
            array(
                'name' => 'cantidad',
                'value' => '$data->cantidadproducir',
                'width' => 7,
                'align' => 'right',
            ),
            array(
                'name' => 'idunidad',
                'value' => '$data->simbolo',
                'width' => 5,
            ),
            array(
                'name' => 'usuario',
                'value' => '$data->usuario',
                'width' => 8,
            ),
            array('typeCol' => 'buttons',
                'width' => 5,
                'buttons' => array(
//                    'registrarEntrega' => array(
//                        'visible' => Yii::app()->user->checkAccess('action_produccion_orden_registrarEntrega'),
//                        'label' => 'Registrar Entrega',
//                        'icon' => 'circle-arrow-up',
//                        //'visible' => 'Orden::model()->mostrarBotonRegistrarEntrega($data->ultimoestado)',
//                        'click' => 'function(){                                                            
//                                        SGridView.selectRow(this);
//                                        admOrden.registrarEntregaSub();
//                                        return false;
//                                    }',
//                        ),
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
                ),
            ),
        ),
    ))
));

