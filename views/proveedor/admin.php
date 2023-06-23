<?php

/* @var $this ProveedorController */
/* @var $model Proveedor */

echo System::Search(array(
    'title' => 'Administración de Proveedores',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admProveedor',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 30,
		),
		array(
		'name' => 'nit',
		'width' => 20,
		),
		array(
		'name' => 'direccion',
		'width' => 20,
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

