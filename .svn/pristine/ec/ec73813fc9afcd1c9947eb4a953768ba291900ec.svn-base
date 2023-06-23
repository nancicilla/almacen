<?php

/* @var $this ProductoController */
/* @var $model Producto */

echo System::Search(array(
    'title' => 'Asignación de Saldos y Saldos Importe',
    'formSearch' => $this->renderPartial('_searchAsignacionsaldosimp', array('model' => $model,), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admAsignacionsaldosimp',
        'dataProvider' => $model->asignacionSaldosImporte(),
        'eventAfterEdition' => 'admAsignacionsaldosimp.cambiarSaldos()',
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'width' => 15,
                'name' => 'idalmacen',
                'value' => '$data->idalmacen0->nombre',
            ),
            array(
                'name' => 'codigo',
                'width' => 15,
            ),
            array(
                'name' => 'nombre',
                'width' => 45,
            ),
            array(
                'name' => 'idunidad',
                'value' => '$data->idunidad0->simbolo',
                'width' => 5,
            ),
            array(
                'width' => 10,
                'name' => 'saldo',
                'align' => 'right',
                'type' => 'number', // le da el formato de número decimal                     
                'typeCol' => 'editable',
                'background'=>'#F5D6CC'
            ),
            array(
                'name' => 'saldocopia',
                'typeCol' => 'hidden',
                'value' => '$data->saldo',
                'type' => 'number'
            ),
            array(
                'width' => 10,
                'name' => 'saldoimporte',
                'align' => 'right',
                'type' => 'number', // le da el formato de número decimal
                'typeCol' => 'editable',
                'background'=>'#F5D6CC'
            ),
            array(
                'name' => 'saldoimportecopia',
                'typeCol' => 'hidden',
                'value' => '$data->saldoimporte',
                'type' => 'number'
            ),
            array(
                'name' => 'id',
                'typeCol' => 'hidden'
            ),
        ),
    )
)));
