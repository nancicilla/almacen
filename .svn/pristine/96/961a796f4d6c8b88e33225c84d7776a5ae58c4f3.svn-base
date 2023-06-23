<?php

/* @var $this DetallenotaController */
/* @var $model Detallenota */

echo System::Search(array(
    'title' => 'Administración de Detalle de Notas',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admDetallenota',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'detalle',
		'width' => 60,
		),
		array(
		'name' => 'usuario',
		'width' => 10,
		),		  
                array(
                'name'=>'fecha',
                'type' => 'date', 
                'width'=> 10,
                ),   
                array('typeCol' => 'buttons',
                    'width' => 10,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                    'update' => array('label' => 'Modificar'),
                                    ),
		),
	),
    ))
));

