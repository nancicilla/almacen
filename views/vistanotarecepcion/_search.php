<?php
/* @var $this VistanotarecepcionController */
/* @var $model Vistanotarecepcion */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'admVistanotarecepcion',
    ));
    ?>
    <div class="row">
<?php echo $form->label($model, 'numero'); ?>
<?php echo $form->textField($model, 'numero'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'fecha'); ?>
        <?php
        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'fecha',
            'name' => 'vistanotarecepcion[fecha]',
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
                'onClose' => 'js:function(selectedDate) {admVistanotarecepcion.search()}'
            ),
            'htmlOptions' => array(
                'id' => 'Vistanotarecepcion_fecha',
            ),
                ), true)
        ?>

    </div>

    <div class="row">
<?php echo $form->label($model, 'tiporecepcion'); ?>
        <?php echo $form->textField($model, 'tiporecepcion', array('maxlength' => 15)); ?>
    </div>
    <div class="row">
<?php echo $form->label($model, 'cliente'); ?>
        <?php echo $form->textField($model, 'cliente', array('maxlength' => 50)); ?>
    </div>
    <div class="row">
<?php echo $form->label($model, 'almacen'); ?>
        <?php echo $form->textField($model, 'almacen', array('maxlength' => 50)); ?>
    </div>    
    <div class="row">
<?php echo $form->label($model, 'motivo'); ?>
    <?php echo $form->textField($model, 'motivo', array('maxlength' => 50)); ?>
    </div>  

<?php $this->endWidget(); ?>

</div><!-- search-form -->
