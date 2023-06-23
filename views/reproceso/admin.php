<?php

/* @var $this ReprocesoController */
/* @var $model Reproceso */

echo System::Search(array(
    'title' => 'Administración de Grupos Reprocesos',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admReproceso',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
                'header' => 'Producto',
		'name' => 'idproducto',
                'value' => '"(".$data->idproducto0->codigo.") ".$data->idproducto0->nombre',
		'width' => 30,
		),
		array(
		'name' => 'descripcion',
		'width' => 30,
		),
		/*
		array(
		'name' => 'usuario',
		'width' => 30,
		),
		*/
		/*   
                array(
                'name'=>'fecha',
                'type' => 'datetime', 
                'width'=> 30,
                ),    
		*/
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

