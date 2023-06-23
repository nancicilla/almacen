<?php
/* @var $this PedidosController */
/* @var $model Pedidos */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'admVentaEntregadespacho',
    ));
    ?>
    <div class="row">
        <?php echo $form->label($model, 'numero'); ?>
        <?php echo $form->textField($model, 'numero'); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'nombrecliente'); ?>
        <?php echo $form->textField($model, 'nombrecliente'); ?>
    </div> 
    


    <?php $this->endWidget(); ?>

</div><!-- search-form -->
