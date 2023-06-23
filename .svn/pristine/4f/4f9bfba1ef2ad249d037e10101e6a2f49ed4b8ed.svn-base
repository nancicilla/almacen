<?php

/* @var $this CausaController */
/* @var $model Causa */

echo System::Search(array(
    'title' => 'Administración de Causas',
    'formSearch' => $this->renderPartial('_search', array('model' => $model,), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admCausa',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'nombre',
                'width' => 20),
            array(
                'name' => 'descripcion',
                'width' => 39),
            array(
                'name' => 'usuario',
                'width' => 10),
            array(
                'name' => 'fecha',
                'type' => 'date',
                'width' => 8
            ),
            array('typeCol' => 'buttons',
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'width' => 3,
                'buttons' => array(
                    'update' => array('label'=>'Modificar','url' => 'array("update","id"=>SeguridadModule::enc($data->getPrimaryKey()))'),
                ),
            ),
        ),
            )
    )
        )
);
