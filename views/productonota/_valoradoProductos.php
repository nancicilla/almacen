<?php
echo SGridView::widget('TGridView', array(
    'id' => 'Productos',
    'dataProvider' => $productos,
    'buttonText' => '+',
    'height' => 150,
    'eventAfterEdition' => System::getNameView().'.cargarValoradoProductoNota(1);',
    'eventAfterEditionAutomatic' => true,
    'columns' => array(
        array(
            'name' => 'id',
            'typeCol' => 'hidden',
        ),
        array(
            'name' => 'codigo',
            'header' => 'Código',
            'width' => 10,
            'typeCol' => 'uneditable',
            'align' => 'left',
        ),
        array(
            'name' => 'nombre',
            'width' => 55,
            'align' => 'left',
            'typeCol' => 'uneditable',
        ),
        array(
            'name' => 'reserva',
            'width' => 10,
            'typeCol' => 'uneditable',
            'align' => 'right',
        ),
        array(
            'name' => 'saldo',
            'width' => 10,
            'typeCol' => 'uneditable',
            'align' => 'right',
        ),
        array(
            'name' => 'saldoimporte',
            'width' => 10,
            'typeCol' => 'uneditable',
            'align' => 'right',
        ),
        array(
            'name' => 'unidad',
            'value' => '$data->idunidad0->simbolo',
            'width' => 5,
            'typeCol' => 'uneditable',
            'align' => 'center',
        ),
    )
));
?>