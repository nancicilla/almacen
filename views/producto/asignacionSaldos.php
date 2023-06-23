<?php

/* @var $this ProductoController */
/* @var $model Producto */

echo System::Search(array(
    'title' => 'Asignación de Consumos',
    'formSearch' => $this->renderPartial('_searchAsignacionsaldos', array('model' => $model,), true),
    'buttons' => array(
        array('name' => 'print', 'icon' => 'print', 'widthLinks' => 120,
            'links' => array(
                array('icon' => 'print', 'url' => 'reporteAsignacionConsumos', 'title' => 'Consumos'),
                array('icon' => 'print', 'url' => 'reporteAsignacionConsumosSolicitud', 'title' => 'Consumos Excel'),
            )
        ),
    ),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admAsignacionsaldos',
        'dataProvider' => $model->asignacionSaldos(),
//        'eventAfterEdition' => 'admAsignacionsaldos.cambiarSaldos()',
        'eventAfterEditionAutomatic'=>true,
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'codigo',
                'width' => 9,
            ),
            array(
                'name' => 'nombre',
                'width' => 25,
            ),
            array(
                'name' => 'idunidad',
                'value' => '$data->idunidad0->simbolo',
                'width' => 4,
            ),
            array(
                'width' => 8,
                'name' => 'idalmacen',
                'value' => '$data->idalmacen0->nombre',
            ),
            array(
                'width' => 10,
                'header' => 'Consumo Actual<br>(Prom. 3 meses)',
                'name' => 'consumoActual',
                'align' => 'right',
                'type' => 'number(10,2)', // le da el formato de número decimal                     
                'typeCol' => 'uneditable',
                'value' => '$data->consumoactual',
                ),
            array(
                'header' => 'Consumo Historico<br>(Gestión Pasada)',
                'width' => 10,
                'name' => 'consumoHistorico',
                'align' => 'right',
                'type' => 'number(10,2)', // le da el formato de número decimal                     
                'typeCol' => 'uneditable',
                'value' => '$data->consumohistorico',
            ),
            array(
                'width' => 10,
                'header' => 'Consumo Máximo<br>(Gestión Pasada)',
                'name' => 'consumoMaximo',
                'align' => 'right',
                'type' => 'number', // le da el formato de número decimal
                'typeCol' => 'uneditable',
                'value' => '$data->consumomaximo',
                //'background'=>'#F5D6CC'
            ),
            array(
                'width' => 7,
                'name' => 'saldo',
                'align' => 'right',
                'type' => 'number', // le da el formato de número decimal
            ),
            array(
                'width' => 7,
                'header' => 'Tiempo Repo.<br>(meses)',
                'name' => 'tiempoentrega',
                'align' => 'right',
                'value' => '$data->tiempoentrega/30',
                'type' => 'number(10,2)', // le da el formato de número decimal
            ),
            array(
                'width' => 10,
                'name' => 'puntopedido',
                'header'=> 'Tiempo duración<br>(meses)' ,
                //'value'=>'Producto::model()->verificaDuracionAsignacionConsumo($data)?"<div class=\'duracionAlerta\' >".(Producto::model()->getDuracionAsignacionConsumo($data))."</div>":round($data->saldo/$data->stockminimo,3)',
                //'value' =>'round($data->saldo/$data->consumohistorico,3)',
                'value'=>'Producto::model()->verificaDuracionAsignacionConsumo($data)?"<div class=\'duracionAlerta\' >".(Producto::model()->getDuracionAsignacionConsumo($data))."</div>":round($data->saldo/$data->consumohistorico,3)',
                'split'=>false,
                'align' => 'right',
                //'type' => 'number(10,3)',
            ),
            array(
                'name' => 'id',
                'typeCol' => 'hidden'
            ),
        ))
)));
