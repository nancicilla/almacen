<?php
/* @var $this ComunicacionController */
/* @var $model Comunicacion */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>50,'style' => 'text-transform: uppercase')); ?>
	</div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Comunicacion',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
