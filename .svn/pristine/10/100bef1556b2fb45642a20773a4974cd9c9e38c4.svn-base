<div class="row">
    <?php
    $buttons = $model->idestado == Estado::ESTADO_PENDIENTECC? array(
                        'Recuperar' => array(
					'label' => 'Recuperado',
					'icon' => 'icon-refresh',
					'click' =>'                                                        
					function(){  
						SGridView.selectRow(this);                                                            
						Controlcalidadalmacen.recuperarProducto();
						return false;
					}',
					),
                ):array(
                        'Editar' => array(
					'label' => 'Modificar',
					'icon' => 'icon-pencil',
					'click' =>'                                                        
					function(){  
						SGridView.selectRow(this);                                                            
						Controlcalidadalmacen.editarRecuperarProducto();
						return false;
					}',
					),
                );
            
    echo SGridView::widget('TGridView', array(
        'id' => 'gridProducto',
        'dataProvider' => $productos,
        'buttonAdd' => false,
        'buttonText' => '+',
        'height' => 330,
        'eventAfterEdition' => 'Controlcalidadalmacen.verificaGrid();',
        'eventAfterEditionAutomatic' => true,
        'columns' => array(
            array(
                'name' => 'id',
                'typeCol' => 'hidden'
            ),
            array(
                'name' => 'idproducto',
                'key' => true,
                'value' => '($data->idproducto == null) ? "" : $data->idproducto',
                'typeCol' => 'hidden'
            ),
            array(
                'name' => 'codigobarra',
                'typeCol' => 'hidden',
                'width' => 11,
                'header' => 'Cód. de barra',
                'value' => '($data->coduniversal == null) ? "" : $data->coduniversal',
            ),
            array(
                'name' => 'codigo',
                'typeCol' => 'editable',
                'width' => 10,
                'header' => 'Código',
                'value' => '($data->codigo == null) ? "" : $data->codigo',
            ),
            array(
                'header' => 'Nombre',
                'name' => 'nombre',
                'width' => 21,
                'value' => '($data->nombre == null) ? "" : $data->nombre',
            ),
            array(
                'header' => 'Udd',
                'name' => 'idunidad',
                'width' => 7,
                'value' => '($data->idunidad == null) ? "" : $data->idunidad',
                'typeCol' => 'uneditable',
                'align' => 'right',
            ),
            array(
                'name' => 'saldoDisponible',
                'header' => 'Disponible',
                'type' => 'number(10, 8)',
                'typeCol' => 'hidden',
                'align' => 'right',
            ),
            array(
                'header' => 'Cant.<br> Dev.',
                'name' => 'cantidaddevolucion',
                'width' => 8,
                'align' => 'right',
                'type' => 'number(12,4)',
                'typeCol' =>'uneditable',
                'value' => '($data->cantidaddevolucion == null) ? "" : $data->cantidaddevolucion',
                'footer' => array('idfooter' => 'totalCantidadPedido', 'function' => 'sum'),
            ),
            array('name'=>'cantidadaceptada',
                'header'=>'Cant.<br> Aceptada',  
                'typeCol'=>'editable',
                'width'=>8,  
                'align'=>'right',
                'type'=>'number(12,4)',
                'groupTitle'=>array('hearder'=>'CONTROL CALIDAD','colspan'=>3,'backgroundHeader'=>'#7a8fa1'),  
                'backgroundHeader'=>'#7a8fa1',
                'value'=>'$data->cantidadaceptada',
                'valueDefault'=>'0',
                'background' => Yii::app()->params['mainColor']['almacen']['light'],
            ),
            array('name'=>'cantidadbaja',
                'header'=>'Cant.<br> Baja',  
                'typeCol'=>'editable',
                'width'=>8,  
                'align'=>'right',
                'type'=>'number(12,4)',
                'backgroundHeader'=>'#7a8fa1',
                'value'=>'$data->cantidadbaja',
                'valueDefault'=>'0',
                'background' => Yii::app()->params['mainColor']['almacen']['light'],
            ),
            array('name'=>'observacion',
                'header'=>'Observación',  
                'typeCol'=>'contenteditable',
                'width'=>24,
                'style'=>array('border-right-color'=>'#f2820a'),
                'backgroundHeader'=>'#7a8fa1',                                
                'value'=>'$data->observacion'
            ),
            array('name'=>'cantidadrecepcion',
                'header'=>'Cant.<br> Recep.',  
                'typeCol'=>'editable',
                'width'=>8,  
                'align'=>'right',
                'type'=>'number(12,4)',
                'value'=>'$data->cantidadregistrada',
                'background' => Yii::app()->params['mainColor']['almacen']['light'],
            ),
             array(
                'header' =>'Rec.',
                'name'=>'recuperada',
                'width'=> 3,
                'split' => false,
                 'typeCol'=>'uneditable',
                'value' => '($data->idrecuperacion==-1?"<div class=\'iconAnnul\' ></div>":'
                          .'($data->idrecuperacion!=null?"<div class=\'confirmadoEnAlmacen\' ></div>":""))',
                ),
            $model->scenario=='view'?
            array(
                'typeCol' => 'buttons',
                'width' => 3,
                'buttons' => array(
                        'Recuperar' => array(
					'label' => 'Ver Recuperado',
					'icon' => 'icon-eye-open',
					'click' =>'                                                        
					function(){  
						SGridView.selectRow(this);                                                            
						Controlcalidadalmacen.verRecuperarProducto();
						return false;
					}',
					),
                )
            )
            :($model->scenario=='finalizar'?array(
                'typeCol' => 'buttons',
                'width' => 3,
                'buttons' => array(
                        'Recuperar' => array(
					'label' => 'Recuperar',
					'icon' => 'icon-refresh',
					'click' =>'                                                        
					function(){  
						SGridView.selectRow(this);                                                            
						Controlcalidadalmacen.editarRecuperarProducto();
						return false;
					}',
					),
                )
            ):array(
                'typeCol' => 'buttons',
                'width' => 3,
                'buttons' => $buttons
            )
                )
        )
    ));
    ?>
</div>
