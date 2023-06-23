<?php

/* @var $this ControlcalidadalmacenController */
/* @var $model Controlcalidadalmacen */
$ancho = $model->idproducto!=null?22:32;
echo System::Search(array(
    'title' => 'Administración de Control Calidad',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admControlcalidadalmacen',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'codigodocumento',
                'header' => 'Nro. Doc.',
		'width' => 6,
		),
		array(
		'name' => 'fecha',
		'width' => 10,
		),
		array(
		//'name' => 'idtipodocumento',
		'name' => 'codigodoc',
                'value'=> '$data->codigodoc',
                'width' => $ancho,
		),
                array(
		'name' => 'recepcion',
		'width' => 15,
                'split' => false,
                'value' => '$data->recepcion',
		),
		array(
		'name' => 'idestado',
		'width' => 15,
                'split' => false,
                'value' => '($data->idestado==Estado::ESTADO_FINALIZADOCC?"<span style=\'color: white;\' class=\'label label-important\'>".$data->idestado0->nombre."</span>" : '
                          .'($data->idestado==Estado::EN_PROCESO?"<span style=\'color: white;\' class=\'label label-success\'>".$data->idestado0->nombre."</span>" : '
                          .'($data->idestado==Estado::ANULADO?"<span style=\'color: white;\' class=\'label label-info\'>".$data->idestado0->nombre."</span>" : '
                          .'($data->idestado==Estado::ESTADO_PENDIENTECC?"<span style=\'color: white;\' class=\'label label-warning\'>".$data->idestado0->nombre."</span>" :"<span style=\'color: white;\' class=\'label label-default\'>".$data->idestado0->nombre."</span>"))))',
		),
                $model->idproducto!=null?array(
                                        'header'=>'Cant. Prod.',
                                        'name' => 'cantproducto',
                                        'value' => '$data->cantproducto('.$model->idproducto.')',
                                        'split'=>false,    
                                        'background'=>'#fdffba',
                                        'align'=>'right',
                                        'width' => 7,
                                        'footer'=>'sum'):
                                     array(
                                        'header'=>' ',
                                        'name' => 'cantproducto',
                                        'split'=>false,
                                        'align'=>'right',
                                         'typeCol' => 'hidden',
                                        'width' => 0),
                array(
                'header' =>'Rec.',
                'name'=>'recuperada',
                'width'=> 3,
                'split' => false,
                'value' => '$data->recuperada==1?"<div class=\'confirmadoEnAlmacen\' ></div>":""',
                ),
                array(
		'name' => 'usuario',
		'width' => 8,
		),
                array('typeCol' => 'buttons',
                    'width' => 12,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => array(
                                    'view' =>array('icon' => 'icon-eye-open',
                                        'click' => 'function(){
                                            SGridView.selectRow(this);
                                            admControlcalidadalmacen.view();
                                            return false;
                                        }',
                                        ),
                                    'verificar' =>array('icon' => 'icon-thumbs-up',
                                        'click' => 'function(){
                                            SGridView.selectRow(this);
                                            admControlcalidadalmacen.verificar();
                                            return false;
                                        }',
                                        ),
                                    'recepcion' => array('label' => 'Recepcion',
                                        'icon' => 'icon-download-alt',
                                        'click' => 'function(){
                                            SGridView.selectRow(this);
                                            admControlcalidadalmacen.recepcionCC();
                                            return false;
                                        }',
                                        ),
                                    'baja' => array('label' => 'baja','icon' => 'icon-remove',
                                        'click' => 'function(){
                                            SGridView.selectRow(this);
                                            admControlcalidadalmacen.bajaCC();
                                            return false;
                                        }',
                                        ),
                                    'update' => array('label' => 'Modificar',
                                        'click' => 'function(){
                                            SGridView.selectRow(this);
                                            admControlcalidadalmacen.modificarCC();
                                            return false;
                                        }',
                                        ),
                                    'confirmar' => array('label' => 'confirmar',
                                        'icon' => 'icon-ok',
                                        'click' => 'function(){
                                            SGridView.selectRow(this);
                                            admControlcalidadalmacen.finalizarCC();
                                            return false;
                                        }',
                                        ),
//                                    'delete' => array('label' => 'Eliminar'),
                                    ),
		),
	),
    ))
));

