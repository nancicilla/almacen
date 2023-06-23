<?php
/* @var $this FamiliaController */
/* @var $model Familia */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'admFamilia'
    ));
    ?>
    <div class="row">
        <?php echo $form->label($model, 'codigo'); ?>
        <?php echo $form->textField($model, 'codigo', array('maxlength' => 3)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'nombre'); ?>
        <?php echo $form->textField($model, 'nombre', array('maxlength' => 30)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'usuario'); ?>
        <?php echo $form->textField($model, 'usuario', array('maxlength' => 30)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'fecha'); ?>
        <?php
        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'fecha',
            'name' => 'familia[fecha]',
            'value' => $model->fecha,
            'language' => 'es',
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'slideDown',
                'showButtonPanel' => true,
                'changeMonth' => true,
                'changeYear' => true,
                'dateFormat' => 'dd-mm-yy',
                'maxDate' => 'today',
                'onClose' => 'js:function(selectedDate) {admFamilia.search()}'

            ),
            'htmlOptions' => array(
                'id' => 'Familia_fecha',
            ),
                ), true)
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
