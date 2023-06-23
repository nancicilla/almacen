<?php
/* @var $this ClaseController */
/* @var $model Clase */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'codigo')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'codigo'); ?>
		<?php echo $form->textField($model,'codigo',array('maxlength'=>5,'style' => 'text-transform: uppercase')); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>50,'style' => 'text-transform: uppercase')); ?>
	</div>
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Clase',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
