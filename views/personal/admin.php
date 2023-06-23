<?php

/* @var $this PersonalController */
/* @var $model Personal */

echo System::Search(array(
    'title' => 'Administración de Personal',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admPersonal',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombrecompleto',
		'width' => 30,
		),
                array(
		'name' => 'fecha',
		'width' => 10,
		'value'=>' date ("d-m-Y",strtotime( $data->fecha))',
		), 
		array(
		'name' => 'usuario',
		'width' => 10,
		),
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

