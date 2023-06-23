<?php
/* @var $this SolicitudController */
/* @var $model Solicitud */

echo System::Search(array(
    'title' => 'Administración de Solicitudes de Compra',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'buttons' => array(
        array('name' => 'print', 'icon' => 'print', 'widthLinks' => 100,
            'links' => array(
                array('icon' => 'print', 'url' => 'reporteSolicitudLote', 'title' => 'Detalle'),
            )
        ),
    ),
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admSolicitud',
        'dataProvider' => $model->search(),
        'height' => 525,
        'columns' => array(
            array(
                'name' => 'numero',
                'width' => 5,
            ),
            array(
                'name' => 'fecha',
                'width' => 13,
                'type' => 'datetime'
            ),
            array(
                'name' => 'idestado',
                'value' => '($data->idestado == null) ? "" : Estado::model()->getEstadoCompra($data->idestado)',
                'width' => 10,
            ),
            array(
                'name' => 'descripcion',
                'width' => 55,
            ),
            array(
                'name' => 'solicitante',
                'width' => 10,
            ),
            array('typeCol' => 'buttons',
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'width' => 5,
                'buttons' => array(
                'imprimir' => array('icon' => 'print', 'url' => 'array("reporteSolicitudDetalle","id"=>SeguridadModule::enc($data->getPrimaryKey()))', 'options' => array("target" => "_blank")),
                )
            )
        ),
))));

