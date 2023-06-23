<?php
/* @var $this DetallenotaController */
/* @var $model Detallenota */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'detalle')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'detalle'); ?>
		<?php echo $form->textArea($model,'detalle',array('rows' => 2, 'style' => 'text-transform: uppercase; width: 400px;')); ?>
        </div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Detallenota',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
