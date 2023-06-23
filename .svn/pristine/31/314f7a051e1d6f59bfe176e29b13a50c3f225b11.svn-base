<?php
/* @var $this AlertaController */
/* @var $model Alerta */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'descripcion')
)); ?>
    <div class="formWindow">
    
	<div class="row" style=" background:#faf4a8; font-weight: bold;" >
		<?php echo $model->showHtmlTipo; ?>
            <div style="width:130px;float:right; font-size: 12px;"><?php echo System::dateFormat($model->fecha,'d-m-Y H:m:s'); ?></div>
	</div>
        
        <div class="row" >
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<div style="border: 2px solid #9dcad6; background: #767053; color:#ffffff; padding:3px; "><?php echo $model->descripcion; ?></div>
	</div>
        
        <div class="row" >
		<?php echo $form->labelEx($model,'Revisado'); ?>
		<div style="border: 2px solid #115da0; height:250px;padding-top: 5px; padding-left:10px;  overflow: scroll;"><?php echo $model->revisado; ?></div>
	</div>
        
	
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Alerta',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
