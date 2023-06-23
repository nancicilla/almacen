<?php
    echo SGridView::widget('TGridView', array(
        'id' => 'ProductoStock',
        'dataProvider' => $productoStock,
        'buttonText' => '+',
        'height' => 410,
        'eventAfterEdition' => 'Producto.verificarGrid();',
        'eventAfterEditionAutomatic' => true,
        'columns' => array(
            array(
                'name' => 'id',
                'typeCol' => 'hidden',
                'key' => true,
            ),
            array(
                'name' => 'coduniversal',
                'width' => 10,
                //'type' => 'datetime',
                'typeCol' => 'uneditable',
                'align' => 'left',
                //'value' => '"<div style=\"color: ".(!empty($data->proveedor)? "blue" : "red").";\">".$data->coduniversal."</div>"',
            ),
            array(
                'name' => 'codigo',
                'width' => 10,
                'typeCol' => 'uneditable',
                'align' => 'left',
            ),
            array(
                'name' => 'nombre',
                'width' => 35,
                'align' => 'left',
                'split' => false,
                'typeCol' => 'uneditable',
                //'value' => '"<div style=\"color: ".($data->tieneproveedor == 1? "blue" : "red").";\">".$data->nombre."</div>"',
            ),
            array(
                'header' => 'Stock Minimo Redondeado',
                'name' => 'stockredondeado',
                'value' => ceil('$data->stockminimo'),
                'width' => 8,
                'typeCol' => 'uneditable',
                'align' => 'right',
                'type' => 'number', // le da el formato de número decimal
                'align' => 'right',//(9,4)
                //'footer'=>array('function'=>'sum','idfooter'=>'totalingreso'),
            ),
            array(
                'header' => 'Stock Minimo',
                'name' => 'stockminimo',
                'width' => 8,
                'typeCol' => 'uneditable',
                'align' => 'right',
                'type' => 'number', // le da el formato de número decimal
                'align' => 'right',//(9,4)
                //'footer'=>array('function'=>'sum','idfooter'=>'totalingreso'),
            ),
            array(
                'header' => 'Stock Minimo Ajustado',
                'name' => 'stockajustado',
                'width' => 8,
                'typeCol' => 'uneditable',
                'align' => 'right',
                'type' => 'number', // le da el formato de número decimal
                'align' => 'right',//(9,4)
                //'footer'=>array('function'=>'sum','idfooter'=>'totalingreso'),
            ),
            array(
                //'header' => 'Saldo',
                'name' => 'saldo',
                'width' => 7,
                'typeCol' => 'uneditable',
                'align' => 'right',
            ),
            array(
                //'header' => 'Saldo',
                'name' => 'tieneproveedor',
                'width' => 7,
                'typeCol' => 'hidden',
                'align' => 'right',
            ),
            array(
                //'header' => 'Saldo',
                'name' => 'proveedor',
                'width' => 14,
                //'typeCol' => 'hidden',
                'align' => 'right',
            ),
        )
    ));
?>