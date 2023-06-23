<?php

/* @var $this UnidadController */
/* @var $model Unidad */

echo System::Search(array(
    'title' => 'Administración de Unidades',
    'formSearch' => $this->renderPartial('_search', array('model' => $model,), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admUnidad',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'nombre',
                'width' => 25,
            ),
            array(
                'name' => 'simbolo',
                'width' => 10,
                'align'=>'center'),
            array(
                'name' => 'permitirdecimal',
                'width' => 15,
                'value'=>'$data->permitirdecimal?"SI":"NO"',
                'align'=>'center'),
            array(
                'name' => 'usuario',
                'width' => 20
            ),
            array(
                'name' => 'fecha',
                'type' => 'date',
                'width' => 20,
            ),
            array('typeCol' => 'buttons',
                'width' => 10,
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'buttons' => array(
                    'update' => array('label' => 'Modificar'),
                    'delete' => array('label' => 'Eliminar'),
                ),
            ),
        )
            )
    )
        )
);


