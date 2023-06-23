<?php
echo SGridView::widget('TGridView', array(
    'id' => 'Inventariarproductos',
    'dataProvider' => $productosinventariar,
    'buttonAdd' => true,
    'buttonText' => '+',
    'height' => 300,
    'columns' => array(
        array(
            'name' => 'id',
            'typeCol' => 'hidden',
            'key' => true
        ),
        array(
            'name' => 'codigo',
            'width' => 20,
            'typeCol' => 'uneditable'
        ),
        array(
            'name' => 'nombre',
            'width' => 60,
            'typeCol' => 'uneditable'
        ),
        array(
            'name' => 'idunidad',
            'value' => '$data->idunidad0->simbolo',
            'width' => 10,
            'align' => 'center'
        ),
        array(
            'name' => 'inventariar',
            'width' => 10,
            'align' => 'center',
            'typeCol' => 'checkbox',
            'click' => 'function () {
                SGridView.selectRow(this);
                Producto.Inventariar(this.checked);
            }'
        )
    ),
));
?>