<?php
/* @var $this TraspasoController */
/* @var $model Traspaso */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admTraspaso',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'numero'); ?>
		<?php echo $form->textField($model,'numero',array('class'=>'numeric')); ?>
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
                    . 'if ($("#Traspaso_fechaHasta").datepicker("getDate")===null){'
                    . '$("#Traspaso_fechaHasta").datepicker("option", "maxDate",new Date());'
                    . '}'
                    . '}'
                    . '$("#Traspaso_fechaHasta").datepicker("option", "minDate",selectedDate);'
                    .'admTraspaso.search();'
                    . '}'
                ),
                'htmlOptions' => array(
                    'id' => 'Traspaso_fechaDesde',
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
                        . '$("#Traspaso_fechaDesde").datepicker("setDate", "");'
                        . '$("#Traspaso_fechaDesde").datepicker("option", "maxDate", new Date());'
                        . '}'
                        . 'else{'
                        . 'if ($("#Traspaso_fechaDesde").datepicker("getDate")===null){'
                        . '$("#Traspaso_fechaDesde").datepicker("setDate", selectedDate);'
                        . '}'
                        . '$("#Traspaso_fechaDesde").datepicker("option", "maxDate", selectedDate);'
                        . '}'
                        .'admTraspaso.search();'
                        . '}'
                    ),
                    'htmlOptions' => array(
                        'id' => 'Traspaso_fechaHasta',
                    ),
                        ), true);
        ?>
       </div>
    </div> 
    
        <div class="row">
                <?php echo $form->label($model, 'tipo'); ?>
                <?php echo $form->dropDownList($model,'tipo',array("SALIDA"=>"SALIDA","DEVOLUCION"=>"DEVOLUCION"),array('style'=>'width:90px','empty'=>'')); 
                ?>    
        </div>
        <div class="row">
                <?php echo $form->label($model, 'estado'); ?>
                <?php echo $form->dropDownList($model,'estado',array("VIGENTE"=>"VIGENTE","ANULADO"=>"ANULADO"),array('style'=>'width:90px','empty'=>'')); 
                ?>    
        </div>

	<div class="row">
		<?php echo $form->label($model,'cliente'); ?>
		<?php echo $form->textField($model,'cliente',array('maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('maxlength'=>30)); ?>
	</div>
    
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
