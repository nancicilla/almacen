<?php
/* @var $this DetallenotaController */
/* @var $model Detallenota */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admDetallenota',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'detalle'); ?>
		<?php echo $form->textField($model,'detalle',array('maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('maxlength'=>35)); ?>
	</div>

        <div class="row">
		<?php echo $form->label($model, 'fecha'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fecha',
                'name' => 'detallenota[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admDetallenota.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Detallenota_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
