<div class="row">
    <?php
    echo SGridView::widget('TGridView', array(
        'id' => 'gridProducto',
        'dataProvider' => $productos,
        'buttonAdd' => true,
        'buttonText' => '+',
        'height' => 310,
//        'eventAfterEdition' => 'Devolucion.verificarGrid();',
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
                'typeCol' => 'uneditable',
                'width' => 13,
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
                'searchUrl' => 'producto/BuscaProductoNombre(solicitud==-1)',
                'searchHeight' => 150,
                'searchWidth' => 600,
                'width' => 40,
                'nextFocus' => '[row]cantidad',
                'searchCopyCol' => 'id,idproducto,codigobarra,codigo,idunidad,saldoDisponible',
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
                'header' => 'Cantidad<br> Devolucion',
                'name' => 'cantidaddevolucion',
                'width' => 10,
                'align' => 'right',
                'type' => 'number(12,4)',
                'typeCol' =>'uneditable',
                'value' => '($data->cantidaddevolucion == null) ? "" : $data->cantidaddevolucion',
                'footer' => array('idfooter' => 'totalCantidadPedido', 'function' => 'sum'),
            ),
            array('name'=>'obs',
                   'header'=>'Observación',
                   'typeCol'=>'contenteditable',
                   'width'=>20,
                   'style'=>array('border-right-color'=>'#f2820a'),
                   'backgroundHeader'=>'#7a8fa1',
                   'value'=>'$data->obs'
            ),
            /*array(
                'name' => 'solicitud',
                'value'=>'$data->solicitud',
                'typeCol' => 'hidden',
                'valueDefault'=>'-1',
            ),*/
//            array('name'=>'cantidadrecepcion',
//                'header'=>'Cantidad<br> Recepcion',  
//                'typeCol'=>'editable',
//                'width'=>10,  
//                'align'=>'right',
//                'type'=>'number(2)',
////                'groupTitle'=>array('hearder'=>'CONTROL CALIDAD','colspan'=>$model->faseRegistro==2?5:4,'backgroundHeader'=>'#7a8fa1'),  
//                // 'background'=>$model->faseRegistro==2?'#f0ffcc':null,
//                'backgroundHeader'=>'#7a8fa1',
//                'value'=>'$data->cantidadregistrada',
//                'background' => Yii::app()->params['mainColor']['almacen']['light'],
//            ), 
            array(
                'typeCol' => 'buttons',
                'width' => 3,
                'buttons' => array(
//                    'Recuperar' => array(
//					'label' => 'Recuperar',
//					'icon' => 'icon-trash',
//					'click' =>'                                                        
//					function(){  
//						SGridView.selectRow(this);                                                            
//						Controlcalidadalmacen.recuperarProducto();
//						return false;
//					}',
//					),
                    )
            )
        )
    ));
    ?>
</div>
<h5>Cant. Items
    <span class="badge" id="<?= System::Id('spanTotalItems') ?>" style="font-size: 18px; font-weight: bold; background: <?= Yii::app()->params['mainColor']['almacen']['light'] ?>; color: black;">0</span> 
</h5>