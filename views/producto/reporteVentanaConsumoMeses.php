<?php
/* @var $this OrdenController */
/* @var $model Orden */
/* @var $form CActiveForm */
?>
<div class="container">
    <div class="offset-12">
        <div style="padding: 5px;" id="content">
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm');
                ?>
                <div class="formWindow">
                    <div class="row">
                        <div class="row">
                            <?php echo $form->label($model,'codigo'); ?>
                            <?php
                               $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'codigo',
                                'source' => $this->createUrl("producto/AutocompleteProductoCodReporteConsumos"),
                                'options' => array(
                                    'showAnim' => 'slideDown',
                                    'delay' => '0',
                                    'select' => "js:function(event, ui) {                                        
                                        Producto.setInformacionProductoCodigoSearch(ui.item.id, ui.item.nombre, ui.item.codigo);
                                    }",
                                    'close'=>"js:function(ui) {



                                    }",
                                ),
                                'htmlOptions' => array('style' => 'width: 150px;'),
                            ))
                        ?>
                    </div>
                        <div class="row">			
                        <?php echo $form->labelEx($model, 'Producto'); ?>
                        <?php echo $form->hiddenField($model, 'id'); ?>
                        <?php
                               $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'nombre',
                                'source' => $this->createUrl("producto/AutocompleteProductoReporteConsumos"),
                                'options' => array(
                                    'showAnim' => 'slideDown',
                                    'delay' => '0',
                                    'select' => "js:function(event, ui) {                                        
                                        Producto.setInformacionProductoSearch(ui.item.id, ui.item.value, ui.item.codigo);
                                    }",
                                    'close'=>"js:function(ui) {



                                    }",
                                ),
                                'htmlOptions' => array('style' => 'width: 380px;'),
                            ))
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
                                    . 'Producto.validarFechaInicio(selectedDate);'
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
                                    . 'Producto.validarFechaFin(selectedDate);'
                                    . '}'
                                ),
                                    ), true)
                            ?>

                        </div>
                        <div id="descargarExcelDiv"></div>
                    </div>
                </div>     
<?php
echo System::Buttons(array(
    'nameView' => 'Producto',
    'orderButtons' => 'generar,print',
    'buttons' => array(
        'generar' => array(
                            'label' => 'Excel',
                            'icon' => 'download-alt',
                            'width' => '100',
                            'click' => 'Producto.excelConsumo();',
                        ),
    ),
)
);
?> 
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>