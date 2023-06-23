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
                     'focus'=>array($model,'almacen')));
                ?>
                <div class="formWindow">
                    <div class="row">
                        <div class="row">
                            <div class="column">
                                <div class="row">
                                    <div class="column">
                                        <?php echo $form->label($model, 'fechaInicio'); ?>
                                    </div>
                                    <div class="column">
                                        <?php
                                        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'model' => $model,
                                            'attribute' => 'fechaInicio',
                                            'value' => $model->fechaInicio,
                                            'language' => 'es',
                                            // additional javascript options for the date picker plugin
                                            'options' => array(
                                                'showAnim' => 'slideDown',
                                                'showButtonPanel' => true,
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                                'dateFormat' => 'dd-mm-yy',
                                                'maxDate' => 'today',
                                                'onClose' => 'js:function(selectedDate){'
                                                . 'Producto.validarFechaInicio(selectedDate);'
                                                . '}'
                                            ),
                                            'htmlOptions' => array(
                                                'size' => '10',
                                                'style' => 'width: 100px;',
                                            ),
                                                ), true)
                                        ?>
                                    </div>
                                    <div class="column">
                                        <?php echo $form->label($model, 'fechaFin'); ?>
                                    </div>
                                    <div class="column">
                                        <?php
                                        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'model' => $model,
                                            'attribute' => 'fechaFin',
                                            'value' => $model->fechaFin,
                                            'language' => 'es',
                                            // additional javascript options for the date picker plugin
                                            'options' => array(
                                                'showAnim' => 'slideDown',
                                                'showButtonPanel' => true,
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                                'dateFormat' => 'dd-mm-yy',
                                                'maxDate' => 'today',
                                                'onClose' => 'js:function(selectedDate){'
                                                . 'Producto.validarFechaFin(selectedDate);'
                                                . '}'
                                            ),
                                            'htmlOptions' => array(
                                                'size' => '10',
                                                'style' => 'width: 100px;',
                                            ),
                                                ), true)
                                        ?>
                                    </div>
                                    <div class="column" >
                                        <?php echo $form->label($model, 'almacen', array('label' => 'Almacen')); ?>
                                    </div>
                                    <div class="column">
                                        <?php
                                            echo $form->dropDownList(
                                                $model, 'almacen', CHtml::listData(
                                                        Almacen::model()->findAll(
                                                                array(
                                                                    'order' => 'id desc ',
                                                        )), 'id', 'nombre'
                                                ), array('style' => 'width: 100%;text-transform: uppercase;', 'empty' => '')
                                        );
                                        ?>
                                    </div>
                                    <div class="column" >
                                        <?php echo $form->label($model, 'tipomovimiento', array('label' => 'Tipo de Salidas')); ?>
                                    </div>
                                    <div class="column">
                                        <?php $widthSwitch = '125px; color: rgb(24, 37, 27);';
                                            echo System::widgetSwitchList($model, 'tipomovimiento', array(
                                                'list' => array(
                                                    array('value' => 0, 'label' => 'PRODUCCION', 'width' => $widthSwitch, 'tooltip' => 'SELECCIONA MOVIMIENTOS DE INGRESOS PARA EL CALCULO DE STOCK MINIMO'),
                                                    array('value' => 1, 'label' => 'VENTAS/TRASPASO', 'width' => $widthSwitch, 'tooltip' => 'SELECCIONA MOVIMIENTOS DE SALIDAS PARA EL CALCULO DE STOCK MINIMO'),
                                                )
                                            ));
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="column">
                                        <?php echo $form->label($model, 'grupoproducto', array('label' => 'Grupo de Productos')); ?>
                                    </div>
                                    <div class="column">
                                        <?php echo $form->dropDownList(
                                                $model, 'grupoproducto', array(1=>'Todos Los Productos',4=>'Producto Individual',2=>'Proveedor',3=>'Familia'), array('style' => 'width: 100%;text-transform: uppercase;')
                                        );
                                        ?>
                                    </div>
                                    <div <?php echo 'id="' . System::Id('divProveedor') . '"'; ?> >
                                        <div class="column">
                                                <?php echo $form->label($model, 'idproveedor', array('label' => 'Seleccione Proveedor')); ?>
                                        </div>
                                        <div class="column">
                                            <?php echo $form->hiddenField($model, 'idproveedor');
                                                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                                        'model' => $model,
                                                        'attribute' => 'proveedor',
                                                        'source' => $this->createUrl("producto/autocompleteProveedor"),
                                                        'options' => array(
                                                            'showAnim' => 'slideDown',
                                                            'delay' => '0',
                                                            'select' => "js:function(event, ui) {
                                                                 $('#' + Producto.Id('idproveedor')).val(ui.item.id);
                                                            }"
                                                        ),
                                                        'htmlOptions' => array(
                                                            'style' => 'width: 94%;text-transform: uppercase;'
                                                        ),
                                                    ));
                                                ?>
                                        </div>
                                    </div>
                                    <div <?php echo 'id="' . System::Id('divFamilia') . '"'; ?> >
                                        <div class="column">
                                            <?php
                                                echo $form->label($model, 'idfamilia', array('label' => 'Seleccione Familia')); ?>
                                        </div>
                                        <div class="column">
                                            <?php echo $form->hiddenField($model, 'idfamilia');
                                                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                                    'model' => $model,
                                                    'attribute' => 'familia',
                                                    'source' => $this->createUrl("familia/autocomplete"),
                                                    'options' => array(
                                                        'showAnim' => 'slideDown',
                                                        'delay' => '0',
                                                        'select' => "js:function(event, ui) {

                                                             $('#' + Producto.Id('idfamilia')).val(ui.item.id);
                                                        }"
                                                    ),
                                                    'htmlOptions' => array(
                                                        'style' => 'width: 94%;text-transform: uppercase;'
                                                    ),
                                                ));
                                            ?>
                                        </div>
                                    </div>
                                    <div <?php echo 'id="' . System::Id('divProducto') . '"'; ?> >
                                        <div class="column">
                                            <?php
                                                echo $form->label($model, 'idproductoindividual', array('label' => 'Seleccione Producto')); ?>
                                        </div>
                                        <div class="column">
                                            <?php echo $form->hiddenField($model, 'idproductoindividual');
                                                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                                    'model' => $model,
                                                    'attribute' => 'producto',
                                                    'source' => $this->createUrl("prodcuto/autocompleteProductoStock"),
                                                    'options' => array(
                                                        'showAnim' => 'slideDown',
                                                        'delay' => '0',
                                                        'select' => "js:function(event, ui) {
                                                             $('#' + Producto.Id('idproductoindividual')).val(ui.item.id);
                                                        }"
                                                    ),
                                                    'htmlOptions' => array(
                                                        'style' => 'width: 94%;text-transform: uppercase;'
                                                    ),
                                                ));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <br/>
                                <div class="row">
                                    <button id="btnBuscarProductos" type="button" 
                                            class="btn btn-warning" style='background: #D04526; color:#FFF;'>ESTIMAR</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            echo "<div id='" . System::Id('divProductoStock') . "'>";
                            echo $this->renderPartial('_productoStock', array('form' => $form, 'productoStock' => $productoStock), true);
                            echo "</div>";
                            ?>
                        </div>
                        
                        
                    </div>
                </div>     
                <?php
                echo System::Buttons(array(
                    'nameView' => 'Producto',
                    'orderButtons' => 'asignar,print,cancel',
                    'buttons' => array(
                        'asignar' => array(
                            'label' => 'Asignar Stocks',
                            'icon' => 'check',
                            'width' => '110',
                            'click' => 'Producto.asignarstockminimo();',
                        ),
                    )
                ));
                ?> 
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>