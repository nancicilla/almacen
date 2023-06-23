<?php

/* @var $this TipodocumentoController */
/* @var $model Tipodocumento */

echo System::Search(array(
    'title' => 'Administración de Tipo de Documentos',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admTipodocumento',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 30,
		),
                array(
		'name' => 'idtipo',
		'width' => 30,
                'value' => '$data->idtipo0->nombre',
		),
		array(
		'name' => 'usuario',
		'width' => 20,
		),
                array(
                    'name' => 'fecha',
                    'type' => 'date',
                    'width' => 10
                ),
                array('typeCol' => 'buttons',
                    'width' => 10,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                    'update' => array('label' => 'Modificar'),
                                    'delete' => array('label' => 'Eliminar'),
                                    ),
		),
	),
    ))
));

