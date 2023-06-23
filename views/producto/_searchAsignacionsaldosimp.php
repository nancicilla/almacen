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
        'id' => 'admAsignacionsaldosimp'
    ));
    ?>

    <div class="row">

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
<?php echo $form->labelEx($model, 'nombreFamilia'); ?>
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'nombreFamilia',
                'source' => $this->createUrl("familia/autocomplete"),
                // additional javascript options for the autocomplete plugin
                'options' => array(//        
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'autoFocus' => 'true',
                    'select' => "js:function(event, ui) {
                                          $('#Producto_nombreFamilia').val(ui.item.nombre);                                          
                                          admProducto.search();
                                }"
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;',
                    'value' => $nombreFamilia,
                ),
            ));
            ?>
        </div>
        <div class="column">
<?php echo $form->labelEx($model, 'nombreClase'); ?>
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'nombreClase',
                'source' => $this->createUrl("clase/autocomplete"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'autoFocus' => 'true',
                    'select' => "js:function(event, ui) {
                                          $('#Producto_nombreClase').val(ui.item.nombre);
                                          admProducto.search();
                                        }"
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;',
                    'value' => $nombreClase,
                ),
            ));
            ?>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <?php echo $form->label($model, 'valor'); ?>
            <?php echo $form->textField($model, 'valor', array('maxlength' => 3,'class'=>'numeric')); ?>
        </div>	
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
