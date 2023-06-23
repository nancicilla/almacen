<?php
/* @var $this ProductodesviacionController */
/* @var $model Productodesviacion */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admProductodesviacion',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'codigo'); ?>
		<?php echo $form->textField($model,'codigo',array('maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>100)); ?>
	</div>
    
     <div class="column">
            <?php echo $form->label($model, 'idalmacen'); ?>
            <?php
            echo $form->dropDownList(
                    $model, 'idalmacen', CHtml::listData(Almacen::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'), array('empty' => '')
            );
            ?>
        </div> 

<?php $this->endWidget(); ?>

</div><!-- search-form -->
