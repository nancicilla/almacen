<?php

/* @var $this PedidosController */
/* @var $model Pedidos */

echo System::Search(array(
    'title' => 'Pedidos especiales',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admPedidoespecial',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'numero',
                'width' => 7,
            ),
            array(
                'name' => 'fecha',
                'type' => 'datetime',
                'width' => 14,
            ),
            array(
                'name' => 'fechaentrega',
                'type' => 'datetime',
                'align'=>'center',
                'width' => 14,
                'split'=>false
            ),
            array(
                'name' => 'estado',
                'width' => 10,
                'split'=>false,
            ),
            array(
                'name' => 'nombrecliente',
                'width' => 50,
            ),
            array('typeCol' => 'buttons',
                'width' => 5,
                'buttons' => array(
//                    'generarTraspaso' => array(
//                        'click' => 'function() '
//                        . '{'
//                         .'SGridView.selectRow(this);
//                            admPedidoespecial.transpasoPedidoEspecial();
//                            return false;}',
//                        'icon' => 'ok',
//                        'label' => 'Generar Traspaso'
//                    ),
                    'confirmar' => array(
                        'click' => 'function() '
                        . '{'
                         .'SGridView.selectRow(this);
                            admPedidoespecial.transpasoPedidoEspecial();
                            return false;}',
                        'icon' => 'eye-open',
                        'label' => 'Generar Orden de Producción'
                    ),
                    'print' => array( 'click' => 'function() {
                                           SGridView.selectRow(this);
                                           admPedidoespecial.print();
                                           return false;
                                          }',
                                    'icon' => 'print'),
                ),
            ),
            
        ),
    ))
));
?>

