<?php
/* @var $this CausaController */
/* @var $model Causa */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>50,'style' => 'text-transform: uppercase; width: 250px')); ?>
	</div>

               
        <div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php
                    //echo $form->textField($model,'descripcion',array('style' => 'text-transform: uppercase')); 
                    echo $form->textArea($model,'descripcion',array('style' => 'text-transform: uppercase; width: 250px; height: 100px;')); 
                ?>
	</div>
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Causa',
        'buttons' => array()
    ));
    ?> 

<?php $this->endWidget(); ?>

</div><!-- form -->
