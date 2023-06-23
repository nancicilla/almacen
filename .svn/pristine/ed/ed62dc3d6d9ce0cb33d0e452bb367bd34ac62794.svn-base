<?php

/* @var $this RangoalertasController */
/* @var $model Rangoalertas */

echo System::Search(array(
    'title' => 'Administración de Rangoalertases',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admRangoalertas',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'descripcion',
		'width' => 30,
		),
		array(
		'name' => 'diainicio',
		'width' => 25,
		),
		array(
		'name' => 'diafin',
		'width' => 25,
                'value' =>'$data->diafin==0?"-":$data->diafin',    
		),
		array(
		'name' => 'color',
		'width' => 10,
                'split' => false,
                'value' => '"<span class=\'label \' style=\'width:93%;background-color: ".$data->color.";\'>".$data->color."</span>"',

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

