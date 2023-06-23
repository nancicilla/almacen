<?php
/* @var $this ProveedorController */
/* @var $model Proveedor */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'id')
)); ?>
    <div class="formWindow">
    
	
    
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>200,'style' => 'text-transform: uppercase')); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'nit'); ?>
		<?php echo $form->textField($model,'nit',array('maxlength'=>20,'style' => 'text-transform: uppercase')); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'direccion'); ?>
		<?php echo $form->textField($model,'direccion'); ?>
	</div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Proveedor',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
