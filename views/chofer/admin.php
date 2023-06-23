<?php

/* @var $this ChoferController */
/* @var $model Chofer */
echo System::Search(array(
    'title' => 'Administración de Choferes',
    'formSearch' => $this->renderPartial('_search', array('model' => $model,), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admChofer',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'nombre',
                'width' => 50,
            ),
            array(
                'name' => 'usuario',
                'width' => 20
            ),
            array(
                'name' => 'fecha',
                'type' => 'date',
                'width' => 20
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


