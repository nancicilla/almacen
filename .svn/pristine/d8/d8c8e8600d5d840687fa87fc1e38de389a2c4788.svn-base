<?php
$nombreProducto = "";
?>
<div class="container">
    <div class="offset-12">
        <div id="content">
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'focus' => array($model, 'id')
                ));
                ?>
                <div class="formWindow">                   

                    <div class="row">
                        <?php echo $form->labelEx($model, 'id'); ?>
                        <?php
                        echo $form->dropDownList(
                                $model, 'id', CHtml::listData(Almacen::model()->findAll(array('order' => 'nombre')), 'idEncriptado', 'nombre'), array(
                            'empty' => '')
                        );
                        ?>    </div>

                </div>
                <div class="row">
                    <?php echo $form->label($model, 'Producto'); ?>
                    <?php echo $form->hiddenField($model, 'nombreCompletoProducto'); ?> 
                    <?php echo $form->hiddenField($model, 'idproducto'); ?>       
                    <?php
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'nombreProducto',
                        'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('producto/autocompleteLibroMayor') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                        idalmacen: $("#" + Almacen.Id("id")).val()
                                    },
                                    success: function (data) {
                                            response(data);
                                    }
                                })
                             }',
                        'options' => array(
                            'showAnim' => 'slideDown',
                            'delay' => '0',
                            'autoFocus' => 'true',
                            'focus' => "js:function(event, ui) {
                                          $('#'+Almacen.Id('idproducto')).val(ui.item.id);
                                          $('#'+Almacen.Id('nombreCompletoProducto')).val(ui.item.nombre);
                                        }",
                            'select' => "js:function(event, ui) {
                                          $('#'+Almacen.Id('idproducto')).val(ui.item.id);
                                          $('#'+Almacen.Id('nombreCompletoProducto')).val(ui.item.nombre);
                                          Almacen.productoSeleccionado=true;
                                        }"
                        ),
                        'htmlOptions' => array(
                            'style' => 'height:20px;',
                            'value' => $nombreProducto,
                        ),
                    ));
                    ?>
                </div>
                <div class="row">
                    <?php echo $form->label($model, 'fechaInicio'); ?>
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
                            . 'Almacen.validarFechaInicio(selectedDate);'
                            . '}'
                        ),
                            ), true)
                    ?>
                </div>
                <div class="row">
                    <?php echo $form->label($model, 'fechaFin'); ?>
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
                            . 'Almacen.validarFechaFin(selectedDate);'
                            . '}'
                        ),
                            ), true)
                    ?>

                </div>
                <?php
                echo System::Buttons(array(
                    'nameView' => 'Almacen',
                    'buttons' => array()
                ));
                ?> 
                <?php $this->endWidget(); ?>

            </div><!-- form -->
        </div>
    </div>
</div>