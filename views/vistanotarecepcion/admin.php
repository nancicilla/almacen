<?php

/* @var $this VistanotarecepcionController */
/* @var $model Vistanotarecepcion */

echo System::Search(array(
    'title' => 'Administración de Notas de Recepción',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admVistanotarecepcion',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array('name'=>'id',
                  'typeCol'=>'hidden',
                  'value'=>'SeguridadModule::enc((isset($data->gestionschema)?$data->gestionschema.".":"").$data->id)'),
            array(
                'name' => 'numero',
                'width' => 5,
            ),
            array(
                'name' => 'fecha',
                'type' => 'date',
                'width' => 8,
            ),
            array(
                'name' => 'tiporecepcion',
                'width' => 10,
            ),
            array(
                'name' => 'estado',
                'width' => 14,
            ),
            array(
                'name' => 'cliente',
                'width' => 22,
            ),
            array(
                'name' => 'almacen',
                'width' => 10,
            ),
            array(
                'name' => 'motivo',
                'width' => 19,
            ),
            array(
                'name' => 'usuario',
                'width' => 6,
            ),
            array('typeCol' => 'buttons',
                'width' => 6,
                'buttons' => array(
                    'Seguimiento' => array('click' => 'function() {SGridView.selectRow(this); admVistanotarecepcion.registrarseguimiento(); return false;}',
                        'icon' => 'icon-share-alt', 'label' => 'Registrar Seguimiento'),
                    'ControlAlmacens' =>
                    array('click' => 'function() {SGridView.selectRow(this); admVistanotarecepcion.controlAlmacen(); return false;}',
                        'icon' => 'ok',
                        'label' => 'Control Calidad',
                        'visible' => '$data->usuarioalmacen==null || $data->usuarioalmacen==""'),
                ),
            ),
        ),
    ))
));

