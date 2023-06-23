<?php

/* @var $this ProductoController */
/* @var $model Producto */
echo System::Search(array(
    'title' => 'Costos',
    'formSearch' => $this->renderPartial('_searchAsignacion', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admAsignacionCostos',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
//        'eventAfterEdition' => 'admAsignacionCostos.cambiarCostos()',
        'columns' => array(
            array(
                'name' => 'idalmacen',
                'width' => 20,
                'typeCol' => 'uneditable',
                'value' => '$data->idalmacen0->nombre',
            ),
            array(
                'name' => 'codigo',
                'width' => 10,
                'typeCol' => 'uneditable'
            ),
            array(
                'name' => 'nombre',
                'width' =>45,
                'typeCol' => 'uneditable'
            ),
            array(
                'name' => 'idunidad',
                'value' => '$data->idunidad0->simbolo',
                'width' => 5
            ),
            array(
                'name' => 'costo',
                'width' => 10,
                'align' => 'right',
                'header' => 'Costo Unitario',
                'type' => 'number',
                'typeCol' => 'uneditable'
            ),
            array(
                'name' => 'ultimopppcopia',
                'typeCol' => 'hidden'
            ),
            array(
                'name' => 'id',
                'typeCol' => 'hidden'
            ),
        ),
))));
