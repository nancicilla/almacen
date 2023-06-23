<font style="color: black; font-weight: bold;">PRODUCTO/S</font>
<?php
echo SGridView::widget('TGridView', array(
    'id' => 'gridProducto',
    'dataProvider' => $gridProducto,
    'eventAfterEditionAutomatic' => true,
    'buttonAdd' => true,
    'buttonText' => '+',
    'height' => 220,
    'columns' => array(
        array(
                'name' => 'id',
                'typeCol' => 'hidden'
            ),
        array(
            'name' => 'idproducto',
            'key' => true,
            'typeCol' => 'hidden',
        ),
        array(
            'header' => 'Código',
            'name' => 'codigo',
            'searchUrl' => 'producto/BuscarProductoCodigoNombreReproceso',
            'searchHeight' => 150,
            'searchWidth' => 650,
            'width' => 15,
            'background' => Yii::app()->params['mainColor']['almacen']['light'],
            'value' => '$data->idproducto0->codigo',
            'searchCopyCol' => 'idproducto,codigo,nombre,unidad,precio',
        ),
        array(
            'header' => 'Producto',
            'name' => 'nombre',
            'searchUrl' => 'producto/BuscarProductoCodigoNombreReproceso',
            'searchHeight' => 150,
            'searchWidth' => 650,
            'width' => 62,
            'background' => Yii::app()->params['mainColor']['almacen']['light'],
            'value' => '$data->idproducto0->nombre',
            'searchCopyCol' => 'idproducto,codigo,nombre,unidad,precio',
        ),
        array(
            'header' => 'Udd',
            'name' => 'unidad',
            'value' => '$data->idproducto0->idunidad0->simbolo',
            'width' => 10,
            'typeCol' => 'uneditable',
            'align' => 'center',
        ),
        array(
            'header' => 'Factor Equivalencia',
            'name' => 'factorequivalencia',
            'value' => '$data->factorequivalencia',
            'width' => 10,
            'type' => 'number(12, 4)',
//            'typeCol' => 'uneditable',
            'align' => 'center',
        ),
//        array(
//            'header' => 'P/U',
//            'name' => 'precio',
//            'width' => 10,
//            'typeCol' => 'uneditable',
//            'align' => 'right',
//            'type' => 'number(2)',
//            'value' => '$data->idproducto0->precio',
//        ),
        array(
            'typeCol' => 'buttons',
            'width' => 3,
            'buttons' => array('delete')
        )
    ),
));
?>