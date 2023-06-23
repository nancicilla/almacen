<div  class="row">
    <?php
    echo SGridView::widget('TGridView', array(
        'id' => 'Producto',
        'dataProvider' => $productos,
        'buttonAdd' => false,
//        'eventAfterEdition' => 'Orden.validarCantidadDevolucion();',
        'buttonText' => '+',
        'height' => 155,
        'columns' => array(
            array(
                'name' => 'id',
                'key' => true,
                //'width' => 7,
                'typeCol' => 'hidden',
            ),
            array(
                'name' => 'codigo',
                'width' => 10,
                'header' => 'Código',
                'value' => '($data->idproducto0->codigo == null) ? "" : $data->idproducto0->codigo',
                'typeCol' => 'uneditable',                
            ),
            array(
                'name' => 'nombre',
                'width' => 40,
                'header' => 'Ingrediente',
                'value' => '($data->idproducto0->nombre == null) ? "" : $data->idproducto0->nombre',
                'typeCol' => 'uneditable',
            ),
            array(
                'name' => 'cantidad',
                'width' => 10,
                'value' => '$data->cantidad',
                'type' => 'number(8)',
                'typeCol' => 'uneditable',
            ),           
            array(
                'name' => 'Devolver',
                'width' => 8,
//                'value' => '$data->devolucion',
                'type' => 'number(18,8)',
                'background' => '#8FC4DE'
            ),
            array(
                'name' => 'simbolo',
                'width' => 8,
                'header' => 'Unidad',
                'value' => '$data->idproducto0->idunidad0->simbolo',
                'typeCol' => 'uneditable',
            ),
            array(
                'name' => 'idproducto',
                'width' => 8,
                'value' => '$data->idproducto',
                'typeCol' => 'hidden',
            ),
        ),
    ));
    ?>           
</div>