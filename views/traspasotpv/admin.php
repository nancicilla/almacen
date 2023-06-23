<?php

/* @var $this TraspasotpvController */
/* @var $model Traspasotpv */

echo System::Search(array(
    'title' => 'Administración de Traspasos Punto de Venta',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admTraspasotpv',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
                'header' => 'Nro.',
                'name' => 'numero',
                'width' => 6,
            ),
            array(
                'name' => 'fecha',
                'type' => 'date',
                'width' => 8,
            ),
            array(
                'name' => 'glosa',
                'width' => $model->idproducto!=null?21:28,
            ),
            array(
                'header' => 'Estado',
                'name' => 'idestado',
                'split' => false,
                'value' => '$data->idestado == Estadotpv::RESERVA?"<span style=\'color: white;\' class=\'label label-warning\'>".$data->idestado0->nombre."</span>" : '
                        . '($data->idestado == Estadotpv::SOLICITUD?"<span style=\'color: white\' class=\'label label-info\'>".$data->idestado0->nombre."</span>" : '
                        . '($data->idestado == Estadotpv::TRASPASO?"<span style=\'color: white\' class=\'label label-success\'>".$data->idestado0->nombre."</span>" : '
                        . '($data->idestado == Estadotpv::FINALIZADO?"<span style=\'color: white\' class=\'classFinalizado\'>".$data->idestado0->nombre."</span>" : "<span style=\'color: white\' class=\'label label-default\'>".$data->idestado0->nombre."</span>")))',
                'width' => 10,
                'style' => array('text-align' => 'center')
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
//                                        'value' => '$data->cantproducto('.$model->idproducto.')',
                                        'split'=>false,    
//                                        'background'=>'#fdffba',
                                        'align'=>'right',
                                        'width' => 0),
            array(
                'name' => 'idalmacenorigen',
                'value' => '$data->origen',
                'width' => 13,
            ),
            array(
                'name' => 'idalmacendestino',
                'value' => '$data->idalmacendestino0->nombre',
                'width' => 19,
            ),
            array(
                'name' => 'usuario',
                'width' => 8,
            ),
            /*  array(
              'name' => 'idalmacen',
              'width' => 30,
              ),
             */
            /*
              array(
              'name'=>'fecha',
              'type' => 'datetime',
              'width'=> 30,
              ),
             */
            array('typeCol' => 'buttons',
                'width' => 8,
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'buttons' => array(
                    'Imprimir' => array(
                        'url' => 'array("reporteTraspaso","id"=>SeguridadModule::enc($data->getPrimaryKey()))',
                        'icon' => 'print', 'options' => array('target' => '_blank')
                        ),
                    /*'noReservar' => array(
                        'label' => 'Quitar Reserva Solicitud',
                        'icon' => 'icon-large icon-share',
                        'click' => 'function(){                                                            
                                                SGridView.selectRow(this);
                                                admTraspasotpv.quitarReserva();
                                                return false;
                                            }',
                    ),*/
                    'Recepcionar' => array(
                        'label' => 'Reservar Solicitud',
                        'icon' => 'icon-large icon-download-alt',
                        'click' => 'function(){                                                            
                                                SGridView.selectRow(this);
                                                admTraspasotpv.recepcionSolicitud();
                                                return false;
                                            }',
                    ),
                    'update' => array('label' => 'Modificar',
                        'click' => 'function(){                                                            
                                                SGridView.selectRow(this);
                                                admTraspasotpv.editarSolicitud();
                                                return false;
                                            }'),
                    'confirmar' => array(//'url' => 'array("confirmar","id"=>SeguridadModule::enc($data->getPrimaryKey()))',
                        'visible' => Yii::app()->user->checkAccess('action_almacen_traspasotpv_confirmar'),
                        'label' => 'Confirmar Traspaso',
                        'icon' => 'check',
                        'click' => 'function(){
                            SGridView.selectRow(this);
                            admTraspasotpv.confirmarSolicitud();
                            return false;
                        }',
                    ),
                    'delete' => array(
                        'visible' => Yii::app()->user->checkAccess('action_almacen_traspasotpv_anular'),
                        'label' => 'Anular Solicitud',
                        'click' => 'function(){                                                            
                                SGridView.selectRow(this);
                                admTraspasotpv.anularSolicitud();
                                return false;
                            }',
                        ),
                ),
            ),
	),
    ))
));

