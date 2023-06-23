<?php
/* @var $this InventarioController */
/* @var $model Inventario */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'admInventario'
    ));
    ?>
    <div class="row">
        <?php echo $form->label($model, 'numero'); ?>
        <?php echo $form->textField($model, 'numero'); ?>
    </div>

    <div class="row">             
        <?php echo $form->label($model, 'fechaInicioDel'); ?>
        <?php
        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'fechaInicioDel',
            'name' => 'inventario[fechaInicioDel]',
            'value' => $model->fechaInicioDel,
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
                . 'if ($("#Inventario_fechaInicioAl").datepicker("getDate")===null){'
                . '$("#Inventario_fechaInicioAl").datepicker("option", "maxDate",new Date());'
                . '}'
                . '}'
                . '$("#Inventario_fechaInicioAl").datepicker("option", "minDate",selectedDate);'
                . 'admInventario.search();'
                . '}',),
            'htmlOptions' => array(
                'id' => 'Inventario_fechaInicioDel',
            ),
                ), true)
        ?>

    </div>
    <div class="row">
        <?php echo $form->label($model, 'fechaInicioAl'); ?>
        <?php
        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'fechaInicioAl',
            'name' => 'inventario[fechaInicioAl]',
            'value' => $model->fechaInicioAl,
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
                . '$("#Inventario_fechaInicioDel").datepicker("option", "maxDate", new Date());'
                . '}'
                . 'else{'
                . 'if ($("#Inventario_fechaInicioDel").datepicker("getDate")===null){'
                . '}'
                . '$("#Inventario_fechaInicioDel").datepicker("option", "maxDate", selectedDate);'
                . '}'
                . 'admInventario.search();'
                . '}',
            ),
            'htmlOptions' => array(
                'id' => 'Inventario_fechaInicioAl',
            ),
                ), true)
        ?>       
    </div>  

    <div class="row">             
        <?php echo $form->label($model, 'fechaFinDel'); ?>
        <?php
        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'fechaFinDel',
            'name' => 'inventario[fechaFinDel]',
            'value' => $model->fechaFinDel,
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
                . 'if ($("#Inventario_fechaFinAl").datepicker("getDate")===null){'
                . '$("#Inventario_fechaFinAl").datepicker("option", "maxDate",new Date());'
                . '}'
                . '}'
                . '$("#Inventario_fechaFinAl").datepicker("option", "minDate",selectedDate);'
                . 'admInventario.search();'
                . '}',),
            'htmlOptions' => array(
                'id' => 'Inventario_fechaFinDel',
            ),
                ), true)
        ?>       
    </div>

    <div class="row">
        <?php echo $form->label($model, 'fechaFinAl'); ?>
        <?php
        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'fechaFinAl',
            'name' => 'inventario[fechaFinAl]',
            'value' => $model->fechaFinAl,
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
                . '$("#Inventario_fechaFinDel").datepicker("option", "maxDate", new Date());'
                . '}'
                . 'else{'
                . 'if ($("#Inventario_fechaFinDel").datepicker("getDate")===null){'
                . '}'
                . '$("#Inventario_fechaFinDel").datepicker("option", "maxDate", selectedDate);'
                . '}'
                . 'admInventario.search();'
                . '}',
            ),
            'htmlOptions' => array(
                'id' => 'Inventario_fechaFinAl',
            ),
                ), true)
        ?>       
    </div> 

    <div class="row">
        <?php echo $form->labelEx($model, 'idAlmacen'); ?>    
        <?php
        echo $form->dropDownList(
                $model, 'idAlmacen', CHtml::listData(Almacen::model()->findAll(array('order' => 'codigo')), 'id', 'nombreCompleto'), array('empty' => '')
        );
        ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'idestado'); ?>              
        <?php
        echo $form->dropDownList(
                $model, 'idestado', CHtml::listData(Estado::model()->findAll(array('order' => 'id')), 'id', 'nombre'), array('empty' => '')
        );
        ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'descripcion'); ?>
        <?php echo $form->textField($model, 'descripcion'); ?>
    </div>



    <div class="row">
        <?php echo $form->label($model, 'usuario'); ?>
        <?php echo $form->textField($model, 'usuario', array('maxlength' => 30)); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- search-form -->
