<div  class="row">
    
    <?php
    echo SGridView::widget('TGridView', array(
        'id' => 'Producto',
        'dataProvider' => $productos,
        'buttonAdd' => true,
        'ableAddRow'=>true,
//        'defaultNumberRows'=>-1,
        'eventAfterEdition' => 'Ordentrabajo.verificarGrid();',
        //'eventBeforeDelete' => 'Orden.verificarEliminar()',
        'buttonText' => '+',
        'height' => 200,
        'columns' => array(
            array(
                'name' => 'id',
                'key' => true,
                'typeCol' => 'hidden',                
                //'searchIdName' => 'id'
            ),
            array(
                'name' => 'modificar',
                'value'=>'($data->seguimientoinsumo!=0)?1:0',
                'typeCol' => 'hidden',
                'valueDefault'=>'1',
            ),
            array(
                'name' => 'codigo',
                'searchUrl' => 'producto/BuscarCodigoProductoExcluidos(modificar==1)',
                'searchIdName' => 'codigo',
                'searchHeight' => 120,
                'searchWidth' => 650,
                'width' => 13,
                'header' => 'Código',
                'searchCopyCol' => 'id,nombre,cantidad=0.00000000,simbolo,saldoDisponible,ultimoppp',
                'value' => '($data->idproducto0->codigo == null) ? "" : $data->idproducto0->codigo',
             
            ),
            array(
                'name' => 'nombre',
                'searchUrl' => 'producto/BuscarNombreProductoExcluidosInsumos(modificar==1)' ,
                'searchIdName' => 'nombre',
                'searchHeight' => 120,
                'searchWidth' => 650,
                'width' => 45,
                'header' => 'Ingrediente',
                'searchCopyCol' => 'id,codigo,cantidad=0.00000000,simbolo,saldoDisponible',
                'value' => '($data->idproducto0->nombre == null) ? "" : $data->idproducto0->nombre',
           
            ),
            array(
                'name' => 'cantidadoriginalreceta',     
                'header' => 'cantidadoriginalreceta',
                'value' => '$data->cantidadoriginalreceta',
                'type' => 'number(10, 8)',
                'typeCol' => 'hidden',
                'align' => 'right',
            ),
            array(
                'name' => 'cantidad',
                'width' => 13,
                'value' => '$data->cantidad',
                'typeCol' => 'editable(modificar==1)',
                'type' => 'number(10, 4)',
                'align' => 'right',
            ),
            array(
                'name' => 'saldoDisponible',
                'header' => 'Disponible',
                'value' => '$data->idproducto0->saldo - $data->idproducto0->reserva',
                'type' => 'number(10, 8)',
                'typeCol' => 'hidden',
                'align' => 'right',
            ),
            array(
                'name' => 'simbolo',
                'width' => 5,
                'header' => 'Udd',
                'value' => '$data->idproducto0->idunidad0->simbolo',
                'typeCol' => 'uneditable',
            ),
            array(
                'header' => 'Costo Unitario',
                'name' => 'ultimoppp',
                'width' => 9,
                'value' => '$data->costounitario==null?$data->idproducto0->ultimoppp:$data->costounitario',
                'typeCol' => 'uneditable',
                'type' => 'number(10, 4)',
                'align' => 'right',
            ),
            array(
                'header' => 'Costo Total',
                'name' => 'costototal',
                'width' => 9,
                'value' => '$data->costounitario==null?$data->idproducto0->ultimoppp*$data->cantidad:$data->costounitario*$data->cantidad',
                'typeCol' => 'uneditable',
                'type' => 'number(10, 4)',
                'align' => 'right',
            ),
            array(
                'typeCol' => 'buttons',
                'width' => 5,
                'buttons' => array(),
            )
        ),
    ));
    ?>           
</div>