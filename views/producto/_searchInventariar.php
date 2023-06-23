<?php
/* @var $this ProductoController */
/* @var $model Producto */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'admInventariar'
    ));
    ?>
    <div class="row">        
        <div class="column">
            <?php echo $form->labelEx($model, 'codigo'); ?>
            <?php echo $form->textField($model, 'codigo'); ?>
        </div>
        <div class="column">
            <?php echo $form->labelEx($model, 'nombre'); ?>
            <?php echo $form->textField($model, 'nombre'); ?>
        </div>
         <div class="column">
            <?php echo $form->labelEx($model, 'idunidad'); ?>	
            <?php echo $form->dropDownList(
                    $model, 'idunidad', CHtml::listData(Unidad::model()->findAll(array('order' => 'simbolo')), 'id', 'simbolo'), array('empty' => '')
            );
            ?>
        </div>
        <div class="column">
            <?php echo $form->label($model, 'idalmacen'); ?>
            <?php
            echo $form->dropDownList(
                    $model, 'idalmacen', CHtml::listData(Almacen::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'), array('empty' => '')
            );
            ?>
        </div> 
    </div>


    <?php $this->endWidget(); ?>
</div><!-- search-form -->
