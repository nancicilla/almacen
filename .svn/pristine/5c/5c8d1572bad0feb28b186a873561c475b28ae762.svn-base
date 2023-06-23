<?php
/* @var $this TraspasoController */
/* @var $model Traspaso */
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
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->textField($model,'estado',array('maxlength'=>50,'style' => 'text-transform: uppercase')); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'tipo'); ?>
		<?php echo $form->textField($model,'tipo',array('maxlength'=>10,'style' => 'text-transform: uppercase')); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'cliente'); ?>
		<?php echo $form->textField($model,'cliente',array('maxlength'=>50,'style' => 'text-transform: uppercase')); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'almacen'); ?>
		<?php echo $form->textField($model,'almacen',array('maxlength'=>50,'style' => 'text-transform: uppercase')); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'idalmacen'); ?>
		<?php echo $form->textField($model,'idalmacen'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'idpedido'); ?>
		<?php echo $form->textField($model,'idpedido'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'numeropedido'); ?>
		<?php echo $form->textField($model,'numeropedido'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'total'); ?>
		<?php echo $form->textField($model,'total',array('maxlength'=>12)); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'idmoneda'); ?>
		<?php echo $form->textField($model,'idmoneda'); ?>
	</div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Traspaso',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
