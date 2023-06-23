<?php
    echo SGridView::widget('TGridView', array(
        'id' => 'ProductoStock',
        'dataProvider' => $productoStock,
        'buttonText' => '+',
        'height' => 410,
        'eventAfterEditionAutomatic' => true,
        'columns' => array(
            array(
                'name' => 'id',
                'typeCol' => 'hidden',
                'key' => true,
            ),
            array(
                'name' => 'codigo',
                'width' => 10,
                'typeCol' => 'uneditable',
                'align' => 'left',
            ),
            array(
                'name' => 'nombre',
                'width' => 26,
                'align' => 'left',
                'typeCol' => 'uneditable',
            ),
            array(
                'name' => 'unidad',
                'width' => 10,
                'typeCol' => 'uneditable',
                'align' => 'left',
            ),
            array(
                'header' => 'Consumo Historico',
                'name' => 'consumohistorico',
                'value' => ceil('$data->stockminimo'),
                'width' => 8,
                'typeCol' => 'uneditable',
                'align' => 'right',
                //'type' => 'number', // le da el formato de número decimal
                'align' => 'right',//(9,4)
                //'footer'=>array('function'=>'sum','idfooter'=>'totalingreso'),
            ),
            array(
                'header' => 'Consumo maximo',
                'name' => 'consumomaximo',
                'width' => 8,
                'typeCol' => 'uneditable',
                'align' => 'right',
                //'type' => 'number', // le da el formato de número decimal
                'align' => 'right',//(9,4)
                //'footer'=>array('function'=>'sum','idfooter'=>'totalingreso'),
            ),
            array(
                'header' => 'Cantidad Compra',
                'name' => 'cantidadcompra',
                'width' => 8,
                'typeCol' => 'uneditable',
                'align' => 'right',
                //'type' => 'number', // le da el formato de número decimal
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
                'header' => 'Stockminimo',
                'name' => 'stockminimo',
                'width' => 8,
                'typeCol' => 'uneditable',
                'align' => 'right',
                //'type' => 'number', // le da el formato de número decimal
                'align' => 'right',//(9,4)
                //'footer'=>array('function'=>'sum','idfooter'=>'totalingreso'),
            ),
            array(
                'header' => 'Tiempo duración<br>(meses)' ,
                'name' => 'tiempoduracion',
                'width' => 7,
                'split'=>false,
                'typeCol' => 'uneditable',
                'align' => 'right',
                'type' => 'number(10,2)',
            ),
            array(
                'header' => 'Solicitud Compra',
                'name' => 'solicitud',
                'value'=>'$data->solicitud',
                'typeCol' => 'checkbox',
//                'typeCol' => 'uneditable',
                'style' => array('text-align '=> 'center','font-weight' => 'bold'),
                'width' => 8,
            ),
        )
    ));
?>