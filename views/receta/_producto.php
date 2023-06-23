<div  class="row">
    <?php
    echo SGridView::widget('TGridView', array(
        'id' => 'Producto',
        'dataProvider' => $productos,
        'buttonAdd' => true,
        'defaultNumberRows'=>-1,
        'buttonText' => '+',
//        'eventAfterEdition'=>'Receta.verificaCoeficiente()',
        'eventAfterEditionAutomatic'=>true,
        'height' => 165,
        'columns' => array(
            array(
                'name' => 'id',// 'idproducto',
                'typeCol' => 'hidden',
                'value' => '($data->id == null) ? "" : $data->id',                
            ),
            array(
                'name' => 'idproducto',
                'typeCol' => 'hidden',
                'key' => true,
                'value' => '($data->idproducto == null) ? "" : $data->idproducto',                
                //'searchIdName' => 'id'
            ),
            array(
                'name' => 'codigo',
                'searchUrl' => 'producto/BuscarCodigoProductoExcluidos',
                'searchIdName' => 'codigo',
                'searchHeight' => 120,
                'searchWidth' => 450,
                'width' => 12,
                'header' => 'Código',
                'searchCopyCol' => 'nombreproducto,cantidad=0.00000000,simbolo,entero,idproducto',
                'value' => '($data->idproducto0->codigo == null) ? "" : $data->idproducto0->codigo',
                'nextFocus'=>'[row]cantidad'
                //'value' => '($data->idproducto0 == null) ? "" : $data->idproducto0->codigo'
            ),
            array(
                'name' => 'nombreproducto',
                'searchUrl' => 'producto/BuscarNombreProductoExcluidos',
                'searchIdName' => 'nombre',
                'searchHeight' => 120,
                'searchWidth' => 450,
                'width' => 37,
                'header' => 'Nombre',
                'searchCopyCol' => 'codigo,cantidad=0.00000000,simbolo,entero,idproducto',
                'value' => '($data->idproducto0->nombre == null) ? "" : $data->idproducto0->nombre'
            ),
            array(
                'name' => 'cantidad',
                'header'=>'Cant.',
                'width' => 15,
                'type' => 'number(10, 8)',
                'align' => 'right',
                'nextFocus'=>'[row+1]codigo:[row+1]cantidad',
            ),
            array(
                'name' => 'simbolo',
                'width' => 4,
                'header' => 'Udd',
                'value' => '($data->idproducto0->idunidad0->simbolo == null) ? "" : $data->idproducto0->idunidad0->simbolo',
                'typeCol' => 'uneditable',
                'align' => 'left',
            ),
            array(
                'typeCol' => 'buttons',
                'width' => 4,
                'buttons' => array('delete')
            )
        ),
    ));
    ?>           
</div>