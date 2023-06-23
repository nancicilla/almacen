<?php
/* @var $this DevoluciontpvController */
/* @var $model Devoluciontpv */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admDevoluciontpv',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'numero'); ?>
		<?php echo $form->textField($model,'numero'); ?>
	</div>
        <div class="group" >
            <?php echo $form->labelEx($model, 'Fecha'); ?>
            <div class="row">             
                <?php echo $form->label($model, 'fechaDesde'); ?>
                <?php
                echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechaDesde',
                    'name' => 'fechaDesde',
                    'value' => $model->fechaDesde,
                    'language' => 'es',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'maxDate' => 'today',
                        'dateFormat' => 'dd-mm-yy',
                        'onClose' => 'js:function(selectedDate){'
                        . 'if (selectedDate===""){'
                        . '}'
                        . 'else{'
                        . 'if ($("#Traspasotpv_fechaHasta").datepicker("getDate")===null){'
                        . '$("#Traspasotpv_fechaHasta").datepicker("option", "maxDate",new Date());'
                        . '}'
                        . '}'
                        . '$("#Traspasotpv_fechaHasta").datepicker("option", "minDate",selectedDate);'
                        .'admTraspasotpv.search();'
                        . '}'
                    ),
                    'htmlOptions' => array(
                        'id' => 'Traspasotpv_fechaDesde',
                    ),
                        ), true);
                ?>

              <?php echo $form->label($model, 'fechaHasta'); ?>
              <?php
                    echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'fechaHasta',
                        'name' => 'fechaHasta',
                        'value' => $model->fechaHasta,
                        'language' => 'es',
                        // additional javascript options for the date picker plugin
                        'options' => array(
                            'showAnim' => 'slideDown',
                            'showButtonPanel' => true,
                            'changeMonth' => true,
                            'changeYear' => true,
                            'dateFormat' => 'dd-mm-yy',
                            'maxDate' => 'today',
                            'onClose' => 'js:function(selectedDate){'
                            . 'if (selectedDate===""){'
                            . '$("#Devoluciontpv_fechaDesde").datepicker("setDate", "");'
                            . '$("#Devoluciontpv_fechaDesde").datepicker("option", "maxDate", new Date());'
                            . '}'
                            . 'else{'
                            . 'if ($("#Devoluciontpv_fechaDesde").datepicker("getDate")===null){'
                            . '$("#Devoluciontpv_fechaDesde").datepicker("setDate", selectedDate);'
                            . '}'
                            . '$("#Devoluciontpv_fechaDesde").datepicker("option", "maxDate", selectedDate);'
                            . '}'
                            .'admDevoluciontpv.search();'
                            . '}'
                        ),
                        'htmlOptions' => array(
                            'id' => 'Devoluciontpv_fechaHasta',
                        ),
                            ), true);
            ?>
           </div>
        </div>
	<div class="row">
		<?php echo $form->label($model,'glosa'); ?>
		<?php echo $form->textField($model,'glosa'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idestado'); ?>
                <?php echo $form->dropDownList($model, 'idestado', CHtml::listData(
                        Estadotpv::model()->findAll(
                                array('order' => 'nombre','condition'=>'t.eliminado = false and t.id in ('.Estadotpv::DEVOLUCION.','.Estadotpv::BORRADOR.','.Estadotpv::RECEPCION.','.Estadotpv::FINALIZADO.','.Estadotpv::ANULADO.')')
                                ),'id', 'nombre'),array('empty' => ''));
                ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idalmacenorigen'); ?>
                <?php echo $form->dropDownList(
                            $model, 'idalmacenorigen', 
                            CHtml::listData(
                                Yii::app()->almacen->createCommand('select * from almacen where eliminado is false order by nombre')->queryAll(),
//                                    Almacen::model()
//                                ->findAll(
//                                        array(
//                                            'order' => 'nombre', 
//                                            'condition' => 't.eliminado is false and idalmacen is not null ')), 
                                        'id', 'nombre'),
                                        array(
                                             'disabled' => false,
                                            'empty' => ''
                                        )
                    );
		?>
	</div>
    
        <div class="row">
            <?php echo $form->labelEx($model, 'producto'); ?>   
            <?php echo $form->hiddenField($model, 'idproducto'); ?> 
            <?php
            
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'producto',
                'source' => $this->createUrl("devoluciontpv/AutocompleteProducto"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                        $('#Devoluciontpv_idproducto').val(ui.item.idproducto);
                        admDevoluciontpv.search();
                    }"
                ),
                ))
            ?>
        </div>
    
	<div class="row">
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('maxlength'=>30)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
