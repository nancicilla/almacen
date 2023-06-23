<?php
/* @var $this UnidadController */
/* @var $model Unidad */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'simbolo')
)); ?>
    <div class="formWindow">
        <div class="row">
		<?php echo $form->labelEx($model,'simbolo'); ?>
		<?php echo $form->textField($model,'simbolo',array('maxlength'=>5)); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>30,'style' => 'text-transform: uppercase')); ?>
	</div>
        <div class="column" >
                <?php echo $form->labelEx($model, 'permitirdecimal'); ?>
                <div style="margin-right:20px ">
                    <?php
                    echo System::widgetSwitch($model, 'permitirdecimal', array('handleWidth' => 80, 'onText' => 'Si', 'offText' => 'No',
                        'onchange' => 'function(){}', 'orderInverse' => true));
                    ?>  
                </div>      
            </div> 
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Unidad',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
