<?php
/* @var $this OrdenController */
/* @var $model Orden */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admOrden',
)); ?>
	<div class="row">
        <?php echo $form->label($model,'numero'); ?>
        <?php echo $form->textField($model,'numero',array('class'=>'numeric')); ?>
    </div>
    <div class="row">
        
        <div class="row">
        <?php echo $form->label($model, 'fechaDel'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechaDel',
                
                'value' => $model->fechaDel,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate){admOrden.validarFechaInicio(selectedDate);}',

                ),
               
                    ), true)  
                    ?>

                    </div>
       <div class="row">
        <?php echo $form->label($model, 'fechaAl'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechaAl',
                'value' => $model->fechaAl,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate){admOrden.validarFechaFin(selectedDate);}'

                ),
               
                    ), true)  
                    ?>

                    </div>
        
    </div>
    
    <div class="row">
            <?php echo $form->labelEx($model,'Estado'); ?>
                <?php
                echo $form->dropDownList(
                $model,
                'idestado',
                CHtml::listData(
                        Estadoproduccion::model()->findAll(array('order' => 'id')),
                        'id',
                        'nombre'), 
                        array('empty' => '', 'style' => 'width: 200px;')
                );

            ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'codigo'); ?>
        <?php echo $form->textField($model,'codigo'); ?>
    </div>
    
    <div class="row">           
            <?php echo $form->labelEx($model, 'idproducto'); ?>
            <?php echo $form->hiddenField($model, 'idproducto'); ?>
            <?php
               $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'producto',
                    'source' => $this->createUrl("orden/AutocompleteProducto"),
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'delay' => '0',
                        'select' => "js:function(event, ui) {
                            
                            admOrden.setInformacionProductoSearch(ui.item.id, ui.item.value);
                        }",
                        'close'=>"js:function(ui) {
                            
                            admOrden.search();
                           
                        }",
                    ),
                    'htmlOptions' => array('style' => 'width: 200px;'),
                ))
            ?>
    </div>
     <div class="column">
            <?php echo $form->labelEx($model, 'idunidad'); ?>	
            <?php echo $form->dropDownList(
                    $model, 'idunidad', CHtml::listData(Unidad::model()->findAll(array('order' => 'simbolo')), 'id', 'simbolo'), array('empty' => '')
            );
            ?>
        </div>
    <div class="row">
        <?php echo $form->label($model,'descripcionOrdenReceta'); ?>
        <?php echo $form->textField($model,'descripcionOrdenReceta'); ?>
    </div>
        <div class="row">
        <?php echo $form->label($model,'usuario'); ?>
        <?php echo $form->textField($model,'usuario'); ?>
    </div>
     <div class="row">          
            <?php echo $form->labelEx($model, 'idingrediente'); ?>
            <?php echo $form->hiddenField($model, 'idingrediente'); ?>
            <?php
               $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'ingrediente',
                    'source' => $this->createUrl("orden/AutocompleteIngrediente"),
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'delay' => '0',
                        'select' => "js:function(event, ui) {
                            admOrden.setInformacionIngredienteSearch(ui.item.id, ui.item.value);
                        }",

                        'close'=>"js:function(ei) {
                            admOrden.search();
                           
                        }",
                    ),
                    'htmlOptions' => array('style' => 'width: 200px;'),
                ))
            ?>
    </div>
    

        
        <div class="row">
        <?php echo $form->label($model,'Cantidad Desde'); ?>
        <?php echo $form->textField($model,'cantidadDesde',array('class'=>'numeric')); ?>
    </div>
       <div class="row">
        <?php echo $form->label($model,'Cantidad Hasta'); ?>
        <?php echo $form->textField($model,'cantidadHasta',array('class'=>'numeric')); ?>
    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
