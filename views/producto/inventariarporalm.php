<?php
/* @var $this ProductoController */
/* @var $model Producto */
?>
<div class="container">
    <div class="offset-12">
        <div id="content">
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'focus' => array($model, 'codigo'),
                ));
                ?>
                <div class="formWindow">
                    <div class="row" style="margin-top: 0; background: #E1B1BA; border-radius: 3px;">
                        <div class="column">
                            <?php echo $form->labelEx($model, 'codigo'); ?>
                        </div>
                        <div class="column">
                            <?php
                            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'codigo',
                                'source' => $this->createUrl("producto/AutocompleteCodigo?idalmacen=".$model->idalmacen),
                                'options' => array(
                                    'showAnim' => 'slideDown',
                                    'delay' => '0',
                                    'select' => "js:function(event, ui) {
                                        Producto.cargarProductos(ui.item.value, 'codigo', ".$model->idalmacen.");
                                    }"
                                ),
                                'htmlOptions' => array('style' => 'width: 250px;'),
                            ));
                            ?>
                        </div>
                        <div class="column">
                            <?php echo $form->labelEx($model, 'nombre'); ?>
                        </div>
                        <div class="column">
                            <?php
                            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'nombre',
                                'source' => $this->createUrl("producto/AutocompleteNombre?idalmacen=".$model->idalmacen),
                                'options' => array(
                                    'showAnim' => 'slideDown',
                                    'delay' => '0',
                                    'select' => "js:function(event, ui) {
                                        Producto.cargarProductos(ui.item.value, 'nombre', ".$model->idalmacen.");
                                    }"
                                ),
                                'htmlOptions' => array('style' => 'width: 250px;'),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column">
                            <?php echo $form->labelEx($model, 'idalmacen'); ?>
                            <?php
                            echo $form->dropDownList(
                                $model, 'idalmacen', CHtml::listData(Almacen::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'), array('empty' => '')
                            );
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div <?php echo 'id="' . System::Id('productos') . '"'; ?>>
                            <?php echo $this->renderPartial('_productos', array('productosinventariar' => $productosinventariar), true); ?>
                        </div>
                    </div>
                    <div class="row" style="float: right">
                        <?php echo System::getButton(array('id' => 'seltodos', 'label' => 'Seleccionar Todos', 'key' => 'S', 'width' => '130', 'icon' => 'ok', 'click' => 'Producto.SeleccionarTodos('.$model->idalmacen.')')); ?>
                        <?php echo System::getButton(array('id' => 'quitarsel', 'label' => 'Quitar Seleccion', 'key' => 'Q', 'width' => '130', 'icon' => 'remove', 'click' => 'Producto.QuitarSeleccion('.$model->idalmacen.')')); ?>
                    </div>
                </div>
                <?php
                echo System::Buttons(array(
                    'nameView' => 'Producto',
                    'buttons' => array()
                ));
                $this->endWidget();
                ?>
            </div>
        </div>
    </div>
</div>