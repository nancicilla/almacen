<?php

/* @var $this PedidosController */
/* @var $model Pedidos */

echo System::Search(array(
    'title' => 'Administración de Entrega / Despacho de VENTAS',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admVentaEntregadespacho',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'documento',
                'value'=>'$data->tipodocumento." N° ".$data->numerodocumento',
                'width' => 15,
            ),
            array(
                'name' => 'tipotarea',
                'header'=>'Tipo tarea',
                'width' => 15,
            ),
             array(
                'name' => 'tarea',
                'header'=>'Accíon',
                'width' => 10,
            ),
            array(
                'name' => 'fecha',
                'type' => 'datetime',
                'width' => 10,
            ),
            array(
                'name' => 'nombrecliente',
                'header'=>'Cliente',
                'width' => 30,
            ),
            array(
                'name' => 'tipodocumento',
                'typeCol' => 'hidden',
            ),
            array(
                'name' => 'id',
                'typeCol' => 'hidden',
                'value'=>'SeguridadModule::enc((isset($data->gestionschema)?$data->gestionschema.".":"").$data->iddocumento)'
            ),
            array('typeCol' => 'buttons',
                'width' => 10,
                'buttons' => array(                    
                    'confirmar' => array(
                        'click' => 'function() '
                        . '{'
                         .'SGridView.selectRow(this);
                            admVentaEntregadespacho.entregaEnvio();
                            return false;}',
                        'icon' => 'ok',
                        'label' => 'Realizar  Entrega / Despacho'),
                ),
            ),
        ),
    ))
));

