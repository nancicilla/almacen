<?php
/* @var $this VencimientoController */
/* @var $model Vencimiento */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admVencimiento',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'numerocompra'); ?>
		<?php echo $form->textField($model,'numerocompra'); ?>
	</div>
    
        <div class="row">
		<?php echo $form->label($model,'codigobarra'); ?>
		<?php echo $form->textField($model,'codigobarra'); ?>
	</div>

	<div class="row">
            <?php echo $form->label($model, 'codigoproducto'); ?>
            <?php echo $form->textField($model, 'codigoproducto'); ?>
	</div>

	<div class="group" >
          <?php echo $form->labelEx($model, 'FechaVencimiento'); ?>
           <div class="row">
		<?php echo $form->label($model, 'fechaDesde'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechaDesde',
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
//                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate){show(selectedDate);'
                                . 'var fechahasta=$("#"+admVencimiento.Id("fechaHasta"));'
                                . 'if (selectedDate!=""){'
                                . '    if (fechahasta.datepicker("getDate")===null){'
                                . '        fechahasta.datepicker("option", "maxDate",new Date());'
                                . '    }'
                                . '}'
                                . 'fechahasta.datepicker("option", "minDate",selectedDate);'
                                .'admVencimiento.search();'
                                . '}'

                ),
                'htmlOptions' => array(
                   
                ),
                    ), true)  
                    ?>
               <?php echo $form->label($model, 'fechaHasta'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechaHasta',
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
//                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) {
                        var fecha=$("#"+admVencimiento.Id("fechaDesde"));
                       if(selectedDate!="") fecha.datepicker("option", "maxDate",selectedDate);
                       else fecha.datepicker("option", "maxDate",new Date()); 
                       admVencimiento.search()}'

                ),
                'htmlOptions' => array(
                    
                ),
                    ), true)  
                    ?>

           </div>
        </div>   

	<div class="row">
		<?php echo $form->label($model,'numerolote'); ?>
		<?php echo $form->textField($model,'numerolote'); ?>
	</div>

        <div class="row">
		<?php echo $form->label($model,'control'); ?>
		<?php echo $form->dropDownList($model, 'control', CHtml::listData(Rangoalertas::model()->findAll(array('order' => 'diainicio')), 'color', 'color')) ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
