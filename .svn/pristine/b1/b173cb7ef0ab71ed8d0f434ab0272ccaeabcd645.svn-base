<?php
/* @var $this AlertaController */
/* @var $model Alerta */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admAlerta',
)); ?>
    
    <br>
        
       <div class="group" >
          <?php echo $form->labelEx($model, 'Fecha'); ?>
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
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) {admAlerta.search()}'

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
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) {admAlerta.search()}'

                ),
                'htmlOptions' => array(
                    
                ),
                    ), true)  
                    ?>

           </div>
        </div>   
        
	<div class="row">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion'); ?>
	</div>

	


   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
