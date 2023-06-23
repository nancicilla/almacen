<?php
/* @var $this OrdenController */
/* @var $model Orden */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'id')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'numero'); ?>
		<?php echo $form->textField($model,'numero'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'duracion'); ?>
		<?php echo $form->textField($model,'duracion',array('maxlength'=>12)); ?>
	</div>
        <div class="row">
            <?php echo $form->label($model, 'fechaplanificada'); ?>
            <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'=>$model, 
            'attribute'=>'fechaplanificada',
            'name' => 'orden[fechaplanificada]',
            'value' => $model->fechaplanificada,
            'language' => 'es',
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'slideDown',
                'showButtonPanel' => true,
                'changeMonth' => true,
                'changeYear' => true,
                'dateFormat' => 'dd-mm-yy',
                'maxDate' => 'today',
            ),
            'htmlOptions' => array(
                    'id' => 'Orden_fechaplanificada',
            ),
                ), true)  
                ?>
        </div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Orden',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
