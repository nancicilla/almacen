<?php
/* @var $this CaracteristicaController */
/* @var $model Caracteristica */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'admCaracteristica'
    ));
    ?>
    <div class="row">
        <?php echo $form->label($model, 'nombre'); ?>
        <?php echo $form->textField($model, 'nombre', array('maxlength' => 30)); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'idgenero'); ?>
        <?php
        echo $form->dropDownList(
                $model, 'idgenero', CHtml::listData(Genero::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'), array(
            'empty' => '')
        );
        ?>
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
            'name' => 'caracteristica[fecha]',
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
                'onClose' => 'js:function(selectedDate) {admCaracteristica.search()}'
            ),
            'htmlOptions' => array(
                'id' => 'Caracteristica_fecha',
            ),
                ), true)
        ?>

    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
