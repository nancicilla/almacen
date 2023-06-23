<?php

/* @var $this AlmacenController */
/* @var $model Almacen */

echo System::Search(array(
    'title' => 'Administración de Almacenes',
    'formSearch' => $this->renderPartial('_search', array('model' => $model,), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admAlmacen',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'codigo',
                'width' => 8,
            ),
            array(
                'name' => 'nombre',
                'width' => 32),
            array(
                'name' => 'idalmacen',
                'value' => '($data->idalmacen == null) ? "" : $data->idalmacen0->nombre',
                'width' => 32),
            array(
                'name' => 'usuario',
                'width' => 10
            ),
            array(
                'name' => 'fecha',
                'type' => 'date',
                'width' => 8
            ),
            array('typeCol' => 'buttons',
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'width' => 10,
                'buttons' => array(
                    'update' => array('label' => 'Modificar'),
                    'delete' => array('label' => 'Eliminar'),
                )
            )
        ),
            )
    )
        )
);


