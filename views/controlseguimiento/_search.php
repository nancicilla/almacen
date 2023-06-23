<?php
/* @var $this ControlseguimientoController */
/* @var $model Controlseguimiento */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'admControlseguimiento'
    ));
    ?>
    <div class="row">
        <div class="column">
            <?php echo $form->label($model, 'fecha'); ?>
            <?php
            echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'fecha',
                'name' => 'controlseguimiento[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admControlseguimiento.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Controlseguimiento_fecha',
                ),
                    ), true)
            ?>
        </div>
        <div class="column">
            <?php echo $form->label($model, 'producto'); ?>
            <?php echo $form->textField($model, 'producto'); ?>
        </div>
        <div class="column">
            <?php echo $form->label($model, 'comunicacion'); ?>
            <?php echo $form->dropDownList($model, 'comunicacion', CHtml::listData(Comunicacion::model()->findAll(), 'nombre', 'nombre'), array('empty' => '')); ?>
        </div>
        <div class="column">
            <?php echo $form->label($model, 'descripcion'); ?>
            <?php echo $form->textField($model, 'descripcion'); ?>
        </div>
        <div class="column">
            <?php echo $form->label($model, 'numero'); ?>
            <?php echo $form->textField($model, 'numero'); ?>
        </div>
        <div class="column">
            <?php echo $form->label($model, 'Nota'); ?>
            <?php echo $form->dropDownList($model, 'tabla', CHtml::listData(Controlseguimiento::model()->findAll(array('select' => 'distinct(t.tabla)')), 'tabla', 'tabla'), array('empty' =>'')); ?>
        </div>
        <div class="column">
            <?php echo $form->label($model, 'usuario'); ?>
            <?php echo $form->textField($model, 'usuario'); ?>
        </div>
        
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
