<?php
/* @var $this TipodocumentoController */
/* @var $model Tipodocumento */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>30,'style' => 'text-transform: uppercase; width: 262px')); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'idtipo'); ?>
            <?php
                echo $form->dropDownList(
                        $model, 'idtipo', CHtml::listData(Tipo::model()->findAll(), 'id', 'nombre'), array('style' => 'width: 270px'));
            ?>
	</div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Tipodocumento',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
