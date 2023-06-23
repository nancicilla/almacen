<?php
/* @var $this PersonalController */
/* @var $model Personal */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'id')
)); ?>
    <div class="formWindow">
    
	
    
	<div class="row">
		<?php echo $form->labelEx($model,'nombrecompleto'); ?>
		<?php echo $form->textField($model,'nombrecompleto',array('maxlength'=>150,'style' => 'text-transform: uppercase')); ?>
	</div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Personal',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
