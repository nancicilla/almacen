<?php
/* @var $this InventarioController */
/* @var $model Inventario */
/* @var $form CActiveForm */
?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array());
    $model->idAlmacen = $model->getIdAlmacen();
    ?>
    <div class="formWindow">
        <div class="row" style="margin-top: 2px;">
            <div class="column">
                <?php echo $form->labelEx($model, 'idAlmacen'); ?>              
                <?php
                echo $form->dropDownList(
                    $model, 'idAlmacen', CHtml::listData(Almacen::model()->findAll(array('order' => 'codigo')), 'id', 'nombreCompleto')
                    , array("disabled" => true)
                );
                ?>          
            </div>
            <div class="column">
                <?php echo $form->labelEx($model, 'descripcion'); ?>
                <?php echo $form->textField($model, 'descripcion', array('style' => 'text-transform: uppercase; width: 500px;', "disabled" => true)); ?>
            </div>
        </div>
        <div  class="row">
            <?php
            echo SGridView::widget('TGridView', array(
                'id' => 'productoInventario',
                'dataProvider' => $productoInventario,
                'eventAfterEdition' => 'Inventario.adicionarProductoInventario()',
                'height' => 300,
                'buttonAdd' => true,
                'buttonText' => '+',
                'columns' => array(
                    array(
                        'name' => 'bandera',
                        'value' => '1',
                        'typeCol' => 'hidden'
                    ),
                    array('name' => 'codigo',
                        'searchUrl' => 'producto/AutocompletarCodigo?idalmacen='.$model->idAlmacen.'(codigo=="")',
                        'searchCopyCol' => 'id,nombre,udd,bandera=0',
                        'searchHeight' => 100,
                        'searchWidth' => 540,
                        'width' => 15,
                        'value' => '$data->idproducto0->codigo',
                        'nextFocus' => 'codigo'
                    ),
                    array('name' => 'nombre',
                        'searchUrl' => 'producto/AutocompletarNombre?idalmacen='.$model->idAlmacen.'(nombre=="")',
                        'searchCopyCol' => 'id,codigo,udd,bandera=0',
                        'searchHeight' => 100,
                        'searchWidth' => 540,
                        'width' => 65,
                        'header' => 'Producto',
                        'value' => '$data->idproducto0->nombre',
                        'nextFocus' => 'nombre'
                    ),
                    array(
                        'name' => 'udd',
                        'typeCol' => 'uneditable',
                        'value' => '$data->idproducto0->idunidad0->simbolo',
                        'width' => 5,
                    ),
                    array('name' => 'id',
                        'value' => '$data->idproducto0->id',
                        'typeCol' => 'hidden',
                        'key' => true
                    ),
                    array(
                        'typeCol' => 'buttons',
                        'width' => 10,
                        'buttons' => array(
                            'delete' => array(
                                'label' => 'Opción para quitar el producto del inventario',
                                'click' => 'function() {
                                    SGridView.selectRow(this);
                                    Inventario.EliminarProductoInventario();
                                    return false;
                                }'
                            )
                        )
                    ),
                ),
            ));
            ?>           
        </div>

    </div>	

    <?php
    echo System::Buttons(array(
        'nameView' => 'Inventario',
        'buttons' => array()
    ));
    $this->endWidget();
    ?>

</div><!-- form -->
