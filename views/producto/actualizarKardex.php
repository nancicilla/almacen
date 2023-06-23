<?php
/* @var $this ProductoController */
/* @var $model Producto */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'focus' => array($model, 'codigoAlmacen')));
    ?>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <div class="formWindow">
        <div id='actualizarKardexProductoAlmacenCantidad'>

        </div>
        <div id='actualizarKardexProductoAlmacenCantidadArbol'>

        </div>
        <div id='actualizarKardexProductoAlmacen'>

        </div>
    </div>   
    <?php
    echo System::Buttons(array(
        'nameView' => 'ActualizaKardexAlmacen',
        'buttons' => array()
    ));
    $this->endWidget();
    ?>
</div>


