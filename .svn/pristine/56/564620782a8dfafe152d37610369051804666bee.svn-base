<?php
/* @var $this RangoalertasController */
/* @var $model Rangoalertas */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admRangoalertas',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'diainicio'); ?>
		<?php echo $form->textField($model,'diainicio'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'diafin'); ?>
		<?php echo $form->textField($model,'diafin'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'color'); ?>
		<?php echo $form->textField($model,'color',array('maxlength'=>6)); ?>
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
                'name' => 'rangoalertas[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admRangoalertas.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Rangoalertas_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
