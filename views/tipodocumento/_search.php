<?php
/* @var $this TipodocumentoController */
/* @var $model Tipodocumento */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admTipodocumento',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>30)); ?>
	</div>

	<div class="row">
            <?php echo $form->label($model,'idtipo'); ?>
            <?php
                echo $form->dropDownList(
                        $model, 
                        'idtipo',
                        CHtml::listData(Tipo::model()->findAll(), 'id', 'nombre'),
                        array('empty' => '') );
            ?>
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
            'name' => 'tipodocumento[fecha]',
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
                'onClose' => 'js:function(selectedDate) {admTipodocumento.search()}'
            ),
           /* 'htmlOptions' => array(
                'id' => 'Almacen_fecha',
            ),*/
                ), true)  
                ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
