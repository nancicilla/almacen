<?php
/* @var $this AlmacenController */
/* @var $model Almacen */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admAlmacen'
)); ?>
	<div class="column">
		<?php echo $form->label($model,'codigo'); ?>
		<?php echo $form->textField($model,'codigo', array('class' => 'numeric')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>20)); ?>
	</div>
    
    	<div class="row">
		<?php echo $form->label($model,'idalmacen'); ?>
		<?php echo $form->dropDownList(
                    $model, 'idalmacen',                       
                        CHtml::listData(Almacen::model()->findAll(array('order'=>'codigo', 'condition' => "idalmacen ISNULL ")),
                                'id', 
                                'nombreCompleto'),
                         array(
        'empty'=>'')
                    ); ?>
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
                'name' => 'almacen[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admAlmacen.search()}'
                ),
                'htmlOptions' => array(
                    'id' => 'Almacen_fecha',
                ),
                    ), true)  
                    ?>

                    </div>


<?php $this->endWidget(); ?>

</div><!-- search-form -->
