<div class="row">
    <?php
    echo SGridView::widget('TGridView', array(
        'id' => 'gridInsumo',
        'dataProvider' => $insumos,
        'buttonAdd' => false,
        'height' => 300,
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
                'name' => 'codigo',
                'typeCol' => 'uneditable',
                'width' => 13,
                'header' => 'Código',
                'value' => '($data->codigo == null) ? "" : $data->codigo',
            ),
            array(
                'header' => 'Nombre',
                'name' => 'nombre',
                'width' => 44,
                'typeCol' => 'uneditable',
                'value' => '($data->nombre == null) ? "" : $data->nombre',
            ),
            array(
                'header' => 'Udd',
                'name' => 'simbolo',
                'width' => 7,
                'value' => '($data->simbolo == null) ? "" : $data->simbolo',
                'typeCol' => 'uneditable',
                'align' => 'right',
            ),
            array(
                'header' => 'Cantidad',
                'name' => 'cantidad',
                'width' => 10,
                'align' => 'right',
                'type' => 'number(10,4)',
                'typeCol' => 'hidden',
                'value' => '($data->cantidadreceta == null) ? "" : $data->cantidadreceta',
                'footer' => array('idfooter' => 'totalCantidad', 'function' => 'sum'),
            ),
            array(
                'header' => 'Cantidad<br> Recuperar',
                'name' => 'cantidadrecuperar',
                'width' => 10,
                'align' => 'right',
                'type' => 'number(10,4)',
                'typeCol' =>'uneditable',
                'value' => '($data->cantidad == null) ? "" : $data->cantidad',
                'footer' => array('idfooter' => 'totalCantidadPedido', 'function' => 'sum'),
            ),
            array(
                'header' => 'Recuperar',
                'name' => 'conforme',
                'value'=>'$data->conforme',
                'typeCol' => 'checkbox',
                'style' => array('text-align '=> 'center'),
                'width' => 8,
//                'click' => 'function(){
//                            SGridView.selectRow(this);
//                            Traspasotpv.cantidadFocus();}'
            ),
            array(
                'typeCol' => 'buttons',
                'width' => 3,
                'buttons' => array()
            )
        )
    ));
    ?>
</div>
<h5>Cant. Items
    <span class="badge" id="<?= System::Id('spanTotalItems') ?>" style="font-size: 18px; font-weight: bold; background: <?= Yii::app()->params['mainColor']['almacen']['light'] ?>; color: black;">0</span> 
</h5>