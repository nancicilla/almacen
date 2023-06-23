<?php

/* @var $this VencimientoController */
/* @var $model Vencimiento */

echo System::Search(array(
    'title' => 'Administración de Vencimientos',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'buttons' => array(
        array('name' => 'print', 'icon' => 'print', 'widthLinks' => 100,
            'links' => array(
                array('icon' => 'print', 'url' => 'reporteProductoVencimiento', 'title' => 'Vencimiento'),
            )
        ),
    ),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admVencimiento',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'idcompra',
		'width' => 10,
                'typeCol' => 'hidden',
		),
		array(
		'name' => 'idproducto',
		'width' => 30,
                'typeCol' => 'hidden',
		),
                array(
		'name' => 'codigobarra',
		'width' => 10,
                'value' =>'$data->idproducto0->coduniversal',
		),
                array(
		'name' => 'codigo',
		'width' => 10,
                'value' =>'$data->idproducto0->codigo',
		),
                array(
                'header' => 'Producto',
		'name' => 'nombre',
		'width' => 25,
                'value' =>'$data->idproducto0->nombre',
		),
                array(
		'header' => 'Nro Compra',
                'name' => 'numero',
		'width' => 5,
                'value' => '$data->idcompra0->numero',
                'align' => 'center',
		),
                array(
                'header' => 'Nro Lote',    
		'name' => 'numerolote',
		'width' => 7,
                'align' => 'center',
		),
                array(
		'header' => 'Fecha Compra',
                'name' => 'fechacompra',
		'width' => 9,
                'value' => '$data->idcompra0->fecha',
                'type' => 'date',
                'align' => 'center',
		),
		array(
                'header' => 'Fecha Vencimiento',
		'name' => 'fechavencimiento',
		'width' => 9,
                'type' => 'date',
                'align' => 'center',
		),
		array(
                'header' => 'Cantidad Comprada',
		'name' => 'cantidad',
		'width' => 7,
                'align' => 'center',
		),
                array(
                'header' => 'Saldo Lote',
		'name' => 'saldo',
		'width' => 6,
                'align' => 'center',
                'value' => '$data->saldo',
//                'typeCol' => 'numeric(9,2)'
		),
                array(
                'header' => 'Nro de Dias',
		'name' => 'dias',
		'width' => 6,
                'value' => '$data->dias',
                'align' => 'center',
		),
                array(
                'header' => 'Control',
		'name' => 'color',
		'width' => 6,
                'split' => false,
                'value' => '"<span class=\'label \' style=\'width:93%;background-color: ".$data->color.";\'>&nbsp;</span>"',
		),
		/*
		array(
		'name' => 'usuario',
		'width' => 30,
		),
		array(
		'name' => 'idestado',
		'width' => 30,
		),
		array(
		'name' => 'observacion',
		'width' => 30,
		),
		*/
		/*   
                array(
                'name'=>'fecha',
                'type' => 'datetime', 
                'width'=> 30,
                ),
                array('typeCol' => 'buttons',
                    'width' => 10,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                    'update' => array('label' => 'Modificar'),
                                    'delete' => array('label' => 'Eliminar'),
                                    ),
		),*/
	),
    ))
));

