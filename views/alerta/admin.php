<?php

/* @var $this AlertaController */
/* @var $model Alerta */

echo System::Search(array(
    'title' => 'Administración de Alertas',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admAlerta',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
                array(
		'name' => 'tipo',
                'header'=>'Tipo',
		'width' => 27,
                'value'=>'$data->showHtmlTipo',
                'split'=>false
		),
                array(
		'name' => 'fecha',
		'width' => 10,
                'type'=>'date'
		),
		array(
		'name' => 'descripcion',
		'width' => 35,
                'split'=>false
		),
		array(
		'name' => 'finalizadousuario',
                'header'=>'Realizado acción',
		'width' => 20
		),
                array(
		'name' => 'function',
		'typeCol' => 'hidden',
                'value'=>'$data->function'
		),
                array(
		'name' => 'id',
		'typeCol' => 'hidden'
		),
                array('typeCol' => 'buttons',
                    'width' => 8,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                    'Realizar' => array('visible' => '($data->finalizadousuario=="")',
                                            'click' => 'function() {
                                               SGridView.selectRow(this);
                                               admAlerta.realizarAccion();
                                               return false;
                                            }',
                                            'label'=>'Realizar acción',    
                                            'icon' => 'ok'),
                                    'Marcar' => array('visible' => '((strpos($data->revusuarios,"'.Yii::app()->user->getName().',")===false)',
                                            'click' => 'function() {
                                               SGridView.selectRow(this);
                                               admAlerta.registerView();
                                               return false;
                                              }',
                                            'icon' => 'eye-open',
                                            'label'=>'Marcar como revisado'
                                        ),
                                     'ver' => array('label' => 'Ver','icon' => 'eye-open',
                                                   'click' => 'function(){SGridView.selectRow(this);admAlerta.view();return false;}',
                                        ), 
                                    ),
		),
	),
    ))
));

