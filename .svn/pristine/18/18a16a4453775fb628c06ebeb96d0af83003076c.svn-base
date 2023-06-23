<?php
/* @var $this ReprocesoController */
/* @var $model Reproceso */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admReproceso',
)); ?>

    <div class="row">
            <?php echo $form->labelEx($model, 'producto'); ?>   
            <?php echo $form->hiddenField($model, 'idproducto'); ?> 
            <?php
            
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'producto',
                'source' => $this->createUrl("reproceso/AutocompleteProducto"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                        $('#Reproceso_idproducto').val(ui.item.idproducto);
                        admReproceso.search();
                    }"
                ),
                ))
            ?>
        </div>
	<div class="row">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('maxlength'=>30)); ?>
	</div>

        <div class="row">
		<?php echo $form->label($model, 'fecha'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fecha',
                'name' => 'reproceso[fecha]',
                'value' => $model->fecha,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) {admReproceso.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Reproceso_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
