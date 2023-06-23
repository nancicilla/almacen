<?php
$nombreProducto = "";
?>
<div class="container">
    <div class="offset-12">
        <div id="content">
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                ));
                ?>
                <div class="formWindow">                   

                    <div class="row">
                        <?php echo $form->labelEx($model, 'id'); ?>
                        <?php
                        echo $form->dropDownList(
                                $model, 'id', CHtml::listData(Almacen::model()->findAll(array('order' => 'nombre')), 'idEncriptado', 'nombre')
                        );
                        ?>    </div>
                    <div class="row">
                        <?php echo $form->label($model, 'fechaInicio'); ?>
                        <?php
                        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'fechaInicio',
                            'value' => $model->fechaInicio,
                            'language' => 'es',
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