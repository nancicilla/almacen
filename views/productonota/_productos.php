<?php
echo SGridView::widget('TGridView', array(
    'id' => 'Productos',
    'dataProvider' => $productos,
    'buttonText' => '+',
    'height' => 150,
    'eventAfterEdition' => System::getNameView().'.cargarProductoNota(1);',
    'eventAfterEditionAutomatic' => true,
    'columns' => array(
        array(
            'name' => 'id',
            'typeCol' => 'hidden',
        ),
        array(
            'name' => 'codigo',
            'header' => 'Código',
            'width' => 8,
            'typeCol' => 'uneditable',
            'align' => 'left',
        ),
        array(
            'name' => 'nombre',
            'width' => 70,
            'align' => 'left',
            'typeCol' => 'uneditable',
        ),
        array(
            'name' => 'reserva',
            'width' => 7,
            'typeCol' => 'uneditable',
            'align' => 'right',
        ),
        array(
            'name' => 'saldo',
            'width' => 7,
            'typeCol' => 'uneditable',
            'align' => 'right',
        ),
        array(
            'name' => 'unidad',
            'value' => '$data->idunidad0->simbolo',
            'width' => 6,
            'typeCol' => 'uneditable',
            'align' => 'center',
        ),
    )
));
?>