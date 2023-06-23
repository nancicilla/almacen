<?php

/* @var $this FamiliaController */
/* @var $model Familia */
echo System::Search(array(
    'title' => 'Administración de Familias',
    'formSearch' => $this->renderPartial('_search', array('model' => $model,), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admFamilia',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'codigo',
                'width' => 10,
            ),
            array(
                'name' => 'nombre',
                'width' => 40),
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
        ),
            )
    )
        )
);


