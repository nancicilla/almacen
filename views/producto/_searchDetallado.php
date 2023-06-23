<?php
/* @var $this ProductoController */
/* @var $model Producto */
/* @var $form CActiveForm */

$nombreCodigo = "";
$nombreProducto = "";
$nombreClase = "";
$nombreFamilia = "";
?>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'admProductoDetallado'
    ));
    ?>

    <div class="row">
        <div class="column">
            <?php echo $form->label($model, 'incorrecto'); ?>
            <?php echo $form->checkBox($model,'incorrecto'); ?>
        </div>
        <div class="column">
            <?php echo $form->label($model, 'codigo'); ?>
            <?php echo $form->textField($model, 'codigo'); ?>
        </div>  
        <div class="column">
            <?php echo $form->label($model, 'nombre'); ?>
            <?php echo $form->textField($model, 'nombre', array('maxlength' => 100)); ?>
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
        
        <div class="column">
<?php echo $form->label($model, 'fecha'); ?>
            <?php
            echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'fecha',
                'name' => 'producto[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admProducto.search()}'
                ),
                'htmlOptions' => array(
                    'id' => 'Producto_fecha',
                ),
                    ), true)
            ?>

        </div>
    </div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->