<?php

/* @var $this TemporadaController */
/* @var $model Temporada */

echo System::Search(array(
    'title' => 'Administración de Productos Temporadas',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admTemporada',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'nombre',
                'width' => 30,
            ),
            array(
                'name' => 'descripcion',
                'width' => 40,
            ),
            array(
                'name' => 'usuario',
                'width' => 15,
            ),
            array(
                'name'=>'fecha',
                'type' => 'date', 
                'width'=> 10,
            ),
            array('typeCol' => 'buttons',
                'width' => 5,
                'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                'buttons' => array(
                    'update' => array('label' => 'Modificar'),
//                    'delete' => array('label' => 'Eliminar'),
                ),
            ),
	),
    ))
));
