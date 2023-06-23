<?php
/* @var $this ProyectoController */
/* @var $model Proyecto */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admProyecto',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fechainicio'); ?>
		<?php echo $form->textField($model,'fechainicio'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fechafin'); ?>
		<?php echo $form->textField($model,'fechafin'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'itemensistema'); ?>
		<?php echo $form->checkBox($model,'itemensistema'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'enenvase'); ?>
		<?php echo $form->checkBox($model,'enenvase'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'numero'); ?>
		<?php echo $form->textField($model,'numero'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('maxlength'=>30)); ?>
	</div>

        <div class="row">
		<?php echo $form->label($model, 'fecha'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fecha',
                'name' => 'proyecto[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admProyecto.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Proyecto_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
