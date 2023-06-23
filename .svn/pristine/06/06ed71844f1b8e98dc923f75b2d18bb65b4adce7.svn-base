<?php
/* @var $this ControlcalidadalmacenController */
/* @var $model Controlcalidadalmacen */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admControlcalidadalmacen',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'codigodocumento'); ?>
		<?php echo $form->textField($model,'codigodocumento',array('maxlength'=>50)); ?>
	</div>

        <div class="row">
		<?php echo $form->label($model,'idestado'); ?>
                <?php echo $form->dropDownList($model, 'idestado', CHtml::listData(
                        Estado::model()->findAll(
                                array('order' => 'nombre','condition'=>'t.eliminado = false and t.id in ('.Estado::ANULADO.','.Estado::ESTADO_PENDIENTERECEPCION.','.Estado::ESTADO_PENDIENTECC.','.Estado::ESTADO_FINALIZADOCC.','.Estado::EN_PROCESO.')')
                                ),'id', 'nombre'),array('empty' => ''));
                ?>
	</div>
        <div class="row">
            <?php echo $form->labelEx($model, 'producto'); ?>   
            <?php echo $form->hiddenField($model, 'idproducto'); ?> 
            <?php
            
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'producto',
                'source' => $this->createUrl("controlcalidadalmacen/AutocompleteProducto"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                        $('#Controlcalidadalmacen_idproducto').val(ui.item.idproducto);
                        admControlcalidadalmacen.search();
                    }"
                ),
                ))
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
                'name' => 'controlcalidadalmacen[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admControlcalidadalmacen.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Controlcalidadalmacen_fecha',
                ),
                    ), true)  
                    ?>

                    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
