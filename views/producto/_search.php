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
        'id' => 'admProducto'
    ));
    ?>

    <div class="row">

        <div class="column">
            <?php echo $form->label($model, 'codigo'); ?>
            <?php echo $form->textField($model, 'codigo', array('maxlength' => 12)); ?>
        </div>  
        <div class="column">
            <?php echo $form->label($model, 'coduniversal'); ?>
            <?php echo $form->textField($model, 'coduniversal', array('maxlength' => 13)); ?>
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
            <?php echo $form->label($model, 'idestadofichatecnica'); ?>
            <?php
            echo $form->dropDownList(
                    $model, 'idestadofichatecnica', CHtml::listData(Estadofichatecnica::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'), array('empty' => '')
            );
            ?>
        </div>
       <div class="column">               
                <?php echo $form->label($model, 'lineatabu'); 
                echo $form->dropDownList(
                    $model, 'lineatabu', array(1=>'SI',0=>'NO'), array('empty' => '')
            );
                ?>
        </div>
        <div class="column">
                <?php echo $form->label($model, 'admitedescuento'); 
                echo $form->dropDownList(
                    $model, 'admitedescuento', array('true'=>'SI','false'=>'NO'), array('empty' => '')
            );
                ?>
        </div>
        <div class="column">
            <?php
            echo $form->label($model, 'ventatpv');
            echo $form->dropDownList($model, 'ventatpv', array('true' => 'SI', 'false' => 'NO'), array('empty' => ''));
            ?>
        </div>
        <div class="column">
<?php echo $form->label($model, 'usuario'); ?>
            <?php echo $form->textField($model, 'usuario', array('maxlength' => 30)); ?>
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
