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
                            . 'Ordentrabajo.validarFechaInicio(selectedDate);'
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
                            . 'Ordentrabajo.validarFechaFin(selectedDate);'
                            . '}'
                        ),
                            ), true)
                    ?>

                </div>

                    </div>
                </div>     
<?php
echo System::Buttons(array(
    'nameView' => 'Ordentrabajo',
    'buttons' => array()
        )
);
?> 
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>