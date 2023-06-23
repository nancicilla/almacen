<?php
/* @var $this FamiliaController */
/* @var $model Familia */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'focus'=>array($model,'codigo')
    ));
    ?>
    <div class="formWindow">
        <div class="row">
            <?php echo $form->labelEx($model, 'codigo'); ?>
            <?php echo $form->textField($model, 'codigo', array('maxlength' => 3, 'style' => 'text-transform: uppercase')); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'nombre'); ?>
            <?php echo $form->textField($model, 'nombre', array('maxlength' => 30, 'style' => 'text-transform: uppercase')); ?>
        </div>
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Familia',
        'buttons' => array()
    ));
    $this->endWidget();
    ?>   

</div>