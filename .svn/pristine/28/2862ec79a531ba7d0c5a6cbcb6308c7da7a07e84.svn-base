<?php

/* @var $this CaracteristicaController */
/* @var $model Caracteristica */

echo System::Search(array(
    'title' => 'Administración de Características',
    'formSearch' => $this->renderPartial('_search', array('model' => $model,), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admCaracteristica',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'nombre',
                'width' => 30),
            array(
                'name' => 'idgenero',
                'value' => '$data->idgenero0->nombre',
                'width' => 10),
            array(
                'name' => 'idcaracteristica',
                'value' => '$data->idcaracteristica0->nombre',
                'width' => 30),
            array(
                'name' => 'usuario',
                'width' => 10),
            array(
                'name' => 'fecha',
                'type' => 'date',
                'width' => 15
            ),
            array('typeCol' => 'buttons',
                'width' => 5,
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'buttons' => array(
                    'update' => array('label' => 'Modificar'),
                    'delete' => array('label' => 'Eliminar')
                ),
            ),
        )
            )
    )
        )
);

