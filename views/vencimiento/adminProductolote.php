<?php

/* @var $this VencimientoController */
/* @var $model Vencimiento */

echo System::Search(array(
    'title' => 'Administración de Vencimientos',
    'formSearch' => $this->renderPartial('_searchProductolote', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admProductolote',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'id',
		'width' => 10,
                'typeCol' => 'hidden',
		),
                array(
                'header' => 'Código de Barra',
		'name' => 'coduniversal',
		'width' => 10,
		),
                array(
                'header' => 'Código',
		'name' => 'codigo',
		'width' => 10,
		),
                array(
                'header' => 'Producto',
		'name' => 'nombre',
		'width' => 25,
		),
                array(
                'header' => 'Saldo Lote',
		'name' => 'saldo',
		'width' => 6,
                'align' => 'center',
		),
                array('typeCol' => 'buttons',
                    'width' => 10,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                    //'update' => array('label' => 'Modificar'),
                                    'imprimir' => array('icon' => 'print', 'url' => 'array("reporteControlItem","id"=>SeguridadModule::enc($data->id))', 'options' => array("target" => "_blank")),
                                    'verVencimiento' => array(
                                        'label' => 'Ver Vencimientos',
                                        'icon' => 'eye-open',
                                        'click' =>'function(){
                                                SGridView.selectRow(this);
                                                admProductolote.verVencimiento();
                                                return false;
                                        }'),
                        ),
		),
	),
    ))
));

