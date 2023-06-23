<?php
/* @var $this ControlseguimientoController */
/* @var $model Controlseguimiento */

echo System::Search(array(
    'title' => 'Administración de Seguimiento',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => 525,
    'buttons' => array(
        array('name' => 'print', 'icon' => 'print', 'widthLinks' => 100,
            'links' => array(
                array('icon' => 'print', 'url' => 'seguimientoReporte', 'title' => 'Lista')
            )
        ),
    ),
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admControlseguimiento',
        'dataProvider' => $model->search(),
        'height' => 525,
        'columns' => array(
            array(
                'name' => 'fecha',
                'width' => 12,
                'type' => 'datetime'
            ),
            array(
                'name' => 'producto',
                'width' => 10
            ),
            array(
                'name' => 'comunicacion',
                'width' => 10
            ),
            array(
                'name' => 'descripcion',
                'width' => 40
            ),
            array(
                'name' => 'numero',
                'width' => 5
            ),
            array(
                'header' => 'Nota',
                'name' => 'tabla',
                'width' => 10
            ),
            array(
                'name' => 'usuario',
                'width' => 8
            ),
            array('typeCol' => 'buttons',
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'width' => 5,
                'buttons' => array(
                    'delete' => array('url' => 'array("delete","id" => SeguridadModule::enc($data->getPrimaryKey()))', 'label' => 'Eliminar'),
                )
            )
        ),
))));
?>