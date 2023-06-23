<?php
/* @var $this RangoalertasController */
/* @var $model Rangoalertas */
/* @var $form CActiveForm */
?>

<div class="form col-xs-4">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'focus' => array($model, 'descripcion')
    ));
    ?>
    <div class="formWindow">

        <div class="row">
            <div class="column" style="width:95%">
                <?php echo $form->labelEx($model, 'descripcion'); ?>
                <?php echo $form->textArea($model, 'descripcion',array('style' => 'width:100%')); ?>
            </div>
        </div>
        <div class="row">
            <div class="column">
                <?php echo $form->labelEx($model, 'diainicio'); ?>
                <?php echo $form->textField($model, 'diainicio',array('class' => 'numeric')); ?>
            </div>

            <div class="column">
                <?php echo $form->labelEx($model, 'diafin'); ?>
                <?php echo $form->textField($model, 'diafin',array('class' => 'numeric')); ?>
            </div>
            <div class="column">
                <?php echo $form->labelEx($model, 'color'); ?>
                <?php
                // echo $form->textField($model,'color',array('maxlength'=>6,'style' => 'text-transform: uppercase')); 
                $this->widget('ext.yii-colorpicker.ColorPicker', array(
                    'model' => $model,
                    'attribute' => 'color',
                    'options' => array(// Optional
                        'pickerDefault' => "ccc", // Configuration Object for JS
                    ),
                ));
                ?>
            </div>
        </div>


    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->
