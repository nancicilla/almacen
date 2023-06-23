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
        'id' => 'admPedidoespecial',
    ));
    ?>
    <div class="row">
        <?php echo $form->label($model, 'numero'); ?>
        <?php echo $form->textField($model, 'numero',array('class'=>'numeric')); ?>
    </div>
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
                    'onClose' => 'js:function(selectedDate){show(selectedDate);'
                                . 'var fechahasta=$("#"+admPedidoespecial.Id("fechaHasta"));'
                                . 'if (selectedDate!=""){'
                                . '    if (fechahasta.datepicker("getDate")===null){'
                                . '        fechahasta.datepicker("option", "maxDate",new Date());'
                                . '    }'
                                . '}'
                                . 'fechahasta.datepicker("option", "minDate",selectedDate);'
                                .'admPedidoespecial.search();'
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
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) {
                        var fecha=$("#"+admPedidoespecial.Id("fechaDesde"));
                       if(selectedDate!="") fecha.datepicker("option", "maxDate",selectedDate);
                       else fecha.datepicker("option", "maxDate",new Date()); 
                        admPedidoespecial.search()}'

                ),
                'htmlOptions' => array(
                    
                ),
                    ), true)  
                    ?>

           </div>
        </div>   
    
   
   <div class="group" >
          <?php echo $form->labelEx($model, 'FechaEntrega'); ?>
           <div class="row">
		<?php echo $form->label($model, 'fechaentregaDesde'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechaentregaDesde',
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate){show(selectedDate);'
                                . 'var fechahasta=$("#"+admPedidoespecial.Id("fechaentregaHasta"));'
                                . 'if (selectedDate!=""){'
                                . '    if (fechahasta.datepicker("getDate")===null){'
                                . '        fechahasta.datepicker("option", "maxDate",new Date());'
                                . '    }'
                                . '}'
                                . 'fechahasta.datepicker("option", "minDate",selectedDate);'
                                .'admPedidoespecial.search();'
                                . '}'

                ),
                'htmlOptions' => array(
                   
                ),
                    ), true)  
                    ?>
              
               <?php echo $form->label($model, 'fechaentregaHasta'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechaentregaHasta',
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) {
                        var fecha=$("#"+admPedidoespecial.Id("fechaentregaDesde"));
                       if(selectedDate!="") fecha.datepicker("option", "maxDate",selectedDate);
                       else fecha.datepicker("option", "maxDate",new Date()); 
                        admPedidoespecial.search()}'

                ),
                'htmlOptions' => array(
                    
                ),
                    ), true)  
                    ?>

           </div>
        </div>   
    <div class="row">
        <?php echo $form->label($model, 'nombrecliente'); ?>
        <?php echo $form->textField($model, 'nombrecliente'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model, 'producto'); ?>
        <?php echo $form->textField($model, 'producto'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
