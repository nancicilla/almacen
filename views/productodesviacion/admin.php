<?php

/* @var $this ProductodesviacionController */
/* @var $model Productodesviacion */

echo System::Search(array(
    'title' => 'Administración de Productodesviacions',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'buttons' => array(array('icon' => 'print', 'url' => 'reporteProductoDesviacionLote', 'title' => 'Lote'),
    ),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admProductodesviacion',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'codigo',
                'width' => 10,
            ),
            array(
                'name' => 'nombre',
                'width' => 40,
            ),
            array(
                'name' => 'inic',
                'width' => 10,
            ),
            array(
                'name' => 'actual',
                'width' => 10,
            ),
            array(
                'name' => 'ppp',
                'width' => 10,
            ),
            array(
                'name' => 'prom',
                'width' => 10,
                'type'=>'number(12,4)'
            ),
            array(
                'name' => 'variacion',
                'width' => 10,
            ),
        ),
    ))
));

