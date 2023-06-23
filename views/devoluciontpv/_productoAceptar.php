<div class="row">
    <?php
    echo SGridView::widget('TGridView', array(
        'id' => 'gridDevolucionproducto',
        'dataProvider' => $gridDevolucionproducto,
        'buttonAdd' => true,
        'buttonText' => '+',
        'height' => 210,
        'eventAfterEdition' => 'Devolucion.verificarGrid();',
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
                'typeCol' => 'editable(solicitud==-1)',
                'width' => 13,
                'header' => 'Código de barra',
                'onKeyUp' => 'Devoluciontpv.BuscaCodigoBarra(this,event);show(k);return false;',
                'value' => '($data->coduniversal == null) ? "" : $data->coduniversal',
                'background' => Yii::app()->params['mainColor']['tpv']['light'],
            ),
            array(
                'name' => 'codigo',
                'typeCol' => 'editable',
                'width' => 13,
                'header' => 'Código',
                'searchUrl' => 'producto/BuscarProductoCodigo(solicitud==-1)',
                'searchHeight' => 160,
                'searchWidth' => 600,
                'nextFocus' => '[row]cantidaddevolucion',
                'searchCopyCol' => 'id,idproducto,codigobarra,nombre,idunidad,saldoDisponible',
                'value' => '($data->codigo == null) ? "" : $data->codigo',
                'background' => Yii::app()->params['mainColor']['tpv']['light'],
            ),
            array(
                'header' => 'Nombre',
                'name' => 'nombre',
                'searchUrl' => 'producto/BuscarProductoNombre(solicitud==-1)',
                'searchHeight' => 150,
                'searchWidth' => 600,
                'width' => 45,
                'background' => Yii::app()->params['mainColor']['tpv']['light'],
                'nextFocus' => '[row]cantidaddevolucion',
                'searchCopyCol' => 'id,idproducto,codigobarra,codigo,idunidad,saldoDisponible',
                'value' => '($data->nombre == null) ? "" : $data->nombre',
            ),/*
            array(
                'header' => 'Item',
                'name' => 'nombre',
                'searchUrl' => 'producto/BuscarProducto(solicitud==-1)',
                'searchHeight' => 150,
                'searchWidth' => 650,
                'width' => 66,
                'background' => Yii::app()->params['mainColor']['tpv']['light'],
                'searchCopyCol' => 'id,idproducto,idunidad,saldoDisponible',
                'value' => '($data->nombre == null) ? "" : $data->nombre',
            ),*/
            array(
                'header' => 'Udd',
                'name' => 'idunidad',
                'width' => 5,
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
                'header' => 'Cantidad Devuelta',
                'name' => 'cantidaddevolucion',
                'width' => 8,
                'align' => 'right',
                'type' => 'number(12,4)',
                'typeCol' => 'uneditable',
                'value' => '($data->cantidaddevolucion == null) ? "" : $data->cantidaddevolucion',
                'footer' => array('idfooter' => 'totalCantidadPedido', 'function' => 'sum'),
            ),
            array(
                'header' => 'Cantidad',
                'name' => 'cantidadrecibida',
                'width' => 8,
                'align' => 'right',
                'typeCol' => 'editable(conforme==0)',
                'type' => 'number(12,4)',
                'background' => Yii::app()->params['mainColor']['tpv']['light'],
                'value' => '($data->cantidadrecibida == null) ? $data->cantidaddevolucion : $data->cantidadrecibida',
                'footer' => array('idfooter' => 'totalCantidadPedido', 'function' => 'sum'),
            ),
            array(
                'name' => 'solicitud',
                'value'=>'$data->solicitud',
                'typeCol' => 'hidden',
                'valueDefault'=>'-1',
            ),
            array(
                'header' => 'Verificado',
                'name' => 'conforme',
                'value'=>'$data->conforme',
                'typeCol' => 'checkbox',
                'style' => array('text-align '=> 'center','font-weight' => 'bold'),
                'width' => 8,
                'click' => 'function(){
                            SGridView.selectRow(this);
                            Devoluciontpv.cantidadFocus();}'
            ),
//            array(
//                'typeCol' => 'buttons',
//                'width' => 3,
//                'buttons' => array()
//            )
        )
    ));
    ?>
</div>
