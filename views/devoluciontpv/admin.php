<?php

/* @var $this DevoluciontpvController */
/* @var $model Devoluciontpv */

echo System::Search(array(
    'title' => 'Administración de Devoluciones',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admDevoluciontpv',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'header' => 'Nº',
                'name' => 'numero',
                'width' => 6,
            ),
            array(
//                'header' => 'Nº',
                'name' => 'fecha',
                'width' => 8,
                'type'=>'date'
            ),
            array(
                'name' => 'glosa',
                'width' => $model->idproducto!=null?21:28,
            ),
            array(
                'header' => 'Estado',
                'name' => 'idestado',
                'split' => false,
                'value' => '$data->idestado == Estadotpv::BORRADOR?"<span style=\'color: white;\' class=\'label label-default\'>".$data->idestado0->nombre."</span>" : '
                . '($data->idestado == Estadotpv::DEVOLUCION?"<span style=\'color: white\' class=\'label label-info\'>".$data->idestado0->nombre."</span>" : '
                . '($data->idestado == Estadotpv::RECEPCION?"<span style=\'color: white\' class=\'label label-success\'>".$data->idestado0->nombre."</span>" : '
                . '($data->idestado == Estadotpv::FINALIZADO?"<span style=\'color: white\' class=\'classFinalizado\'>".$data->idestado0->nombre."</span>" : "<span style=\'color: white\' class=\'label label-warning\'>".$data->idestado0->nombre."</span>")))',
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
                'header' => 'Almacén Origen',
                'name' => 'idalmacenorigen',
                'value' => '$data->origen',
                'width' => 13,
            ),
            array(
                'header' => 'Almacén Destino',
                'name' => 'idalmacendestino',
                'value' => '$data->idalmacendestino0->nombre',
                'width' => 13,
            ),
            array(
                'name' => 'usuario',
                'width' => 8,
            ),
            array('name' => 'ccicon',
                 'header'=>'Control Calidad',
                'width' => 6,
                'align'=>'center',
                'split'=>false,
                'value'=>'$data->iconControlcalidadFinalizado'
                
                ),
            /*
              array(
              'name' => 'idalmacen',
              'width' => 30,
              ),
              array(
              'name' => 'idtransaccion',
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
                'width' => 10,
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'buttons' => array(
                    'Imprimir' => array(
                        'url' => 'array("reporteDevolucion","id"=>SeguridadModule::enc($data->getPrimaryKey()))',
                        'icon' => 'print', 'options' => array('target' => '_blank')
                    ),
                    'update' => array('label' => 'Modificar', 'visible' => 'false'),
                    'Recepcionar' => array(
                        'label' => 'Recepcionar Devolucion',
                        'icon' => 'icon-large icon-download-alt',
                        'click' => 'function(){                                                            
                                                SGridView.selectRow(this);
                                                admDevoluciontpv.recepcionDevolucion();
                                                return false;
                                            }',
                    ),
//                    'confirmar' => array(
//                        'label' => 'Aceptar Devolucion',
//                        'icon' => 'check',
//                        'click' => 'function(){                                                            
//                                                SGridView.selectRow(this);
//                                                admDevoluciontpv.aceptarDevolucion();
//                                                return false;
//                                            }',
//                    ),
//                                    'delete' => array('label' => 'Eliminar'),
                ),
            ),
        ),
    ))
));

