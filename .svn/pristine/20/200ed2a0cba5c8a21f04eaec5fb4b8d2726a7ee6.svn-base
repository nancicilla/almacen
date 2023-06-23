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
        'id' => 'admPedidos',
    ));
    ?>
    <div class="row">
        <?php echo $form->label($model, 'numero'); ?>
        <?php echo $form->textField($model, 'numero'); ?>
    </div>
    <div class="row">             
        <?php echo $form->label($model, 'fechaInicio'); ?>
        <?php
        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'fechaInicio',
            'name' => 'fechaInicio',
            'value' => $model->fechaInicio,
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
                . 'if ($("#Pedidos_fechaFin").datepicker("getDate")===null){'
                . '$("#Pedidos_fechaFin").datepicker("option", "maxDate",new Date());'
                . '}'
                . '}'
                . '$("#Pedidos_fechaFin").datepicker("option", "minDate",selectedDate);'
                . 'admPedidos.search();'
                . '}'
            ),
            'htmlOptions' => array(
                'id' => 'Pedidos_fechaInicio',
            ),
                ), true)
        ?>


    </div>
    <div class="row">
        <?php echo $form->label($model, 'fechaFin'); ?>
        <?php
        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'fechaFin',
            'name' => 'fechaFin',
            'value' => $model->fechaFin,
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
                . '$("#Pedidos_fechaInicio").datepicker("setDate", "");'
                . '$("#Pedidos_fechaInicio").datepicker("option", "maxDate", new Date());'
                . '}'
                . 'else{'
                . 'if ($("#Pedidos_fechaInicio").datepicker("getDate")===null){'
                . '$("#Pedidos_fechaInicio").datepicker("setDate", selectedDate);'
                . '}'
                . '$("#Pedidos_fechaInicio").datepicker("option", "maxDate", selectedDate);'
                . '}'
                . 'admPedidos.search();'
                . '}'
            ),
            'htmlOptions' => array(
                'id' => 'Pedidos_fechaFin',
            ),
                ), true)
        ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'nombrecliente'); ?>
        <?php echo $form->textField($model, 'nombrecliente'); ?>
    </div> 
    <div class="row">
        <?php echo $form->label($model, 'usuario'); ?>
        <?php echo $form->textField($model, 'usuario'); ?>
    </div> 
    
    <div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->dropDownList($model,'nombre',array(
                        'ESPECIAL'=>'ESPECIAL',
                        'PREVENTA'=>'PREVENTA',
                        'PREVENTA EXPORTACION'=>'PREVENTA EXPORTACION',
                        'TRASPASO'=>'TRASPASO',
                        'TRASPASO REALIZADO'=>'TRASPASO REALIZADO',                   
                        'CONSIGNACION'=>'CONSIGNACION',                    
                        ),array('empty'=>'')); ?>
	
    </div>
    <div class="row">
                <?php echo $form->labelEx($model, 'producto'); ?>   
                <?php echo $form->hiddenField($model, 'idproducto'); ?> 
                <?php
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'producto',
                    'source' => $this->createUrl("pedidos/AutocompleteProducto"),
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'delay' => '0',
                        'select' => "js:function(event, ui) {
                                        admPedidos.set('idproducto',ui.item.idproducto);
                                        admPedidos.search();
                                    }"
                    ),
                    'htmlOptions' => array('value' => ($model->id != null && $model->nombrecliente != null) ? $model->idcliente0->nombre . ' (' . $model->nombrecliente . ')' : null,
                        'style' => "width:" . ($model->id != null ? 350 : 240) . "px;  background-repeat: no-repeat;background-position: right; ", 'readonly' => $model->id != null ? 'readonly' : ''),
                ))
                ?>
                
    </div>



    <?php $this->endWidget(); ?>

</div><!-- search-form -->
