<?php

/* @var $this RecetaController */
/* @var $model Receta */

echo System::Search(array(
    'title' => 'Administración de Recetas',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admReceta',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		
		array(
                'name' => 'codigo',
                'width' => 10,
                'value' => '$data->idproducto0->codigo'
                ),
                array(
                'name' => 'nombre',
                'width' => 20,
                'value' => '$data->idproducto0->nombre'
                ),
                array(
		'name' => 'almacen',
		'width' => 10,
                    'value' => '$data->idproducto0->idalmacen0->nombre'
		),
                array(
		'name' => 'idestadoreceta',
		'width' => 10,
                    'value' => '$data->idestadoreceta0->nombre'
		),
		array(
		'name' => 'descripcion',
		'width' => 30,
		),
                array(
                'name' => 'fecha',
                'width' => 8,
                'value' => '$data->fecha',
                'type' => 'date'
                ),
                array(
                'name' => 'usuario',
                'width' => 7,
                'value' => '$data->usuario'
                ),
		/*
		array(
		'name' => 'cantidadproducir',
		'width' => 30,
		),
		array(
		'name' => 'costounitario',
		'width' => 30,
		),
		array(
		'name' => 'totalproducido',
		'width' => 30,
		),
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

