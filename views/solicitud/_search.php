<?php
/* @var $this SolicitudController */
/* @var $model Solicitud */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'admSolicitud'
    ));
    ?>
    <div class="row">
        <div class="column">
            <?php echo $form->label($model, 'numero'); ?>
            <?php echo $form->textField($model, 'numero', array('class' => 'numeric')); ?>
        </div>
        <div class="row">
        <div class="column">
            <?php echo $form->label($model, 'fechaInicio'); ?>
            <?php
            echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'fechaInicio',
                'name' => 'solicitud[fechaInicio]',
                'value' => $model->fechaInicio,
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
                    . '}'
                    . 'else{'
                    . 'if ($("#Solicitud_fechaFin").datepicker("getDate")===null){'
                    . '$("#Solicitud_fechaFin").datepicker("option", "maxDate",new Date());'
                    . '}'
                    . '}'
                    . '$("#Solicitud_fechaFin").datepicker("option", "minDate",selectedDate);'
                    . 'admSolicitud.search();' 
                    . '}'
                ),
                'htmlOptions' => array(
                    'id' => 'Solicitud_fechaInicio',
                ),
                    ), true)
            ?>
        </div>
        <div class="column">
            <?php echo $form->label($model, 'fechaFin'); ?>
            <?php
            echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'fechaFin',
                'name' => 'solicitud[fechaFin]',
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
                    . '$("#Solicitud_fechaInicio").datepicker("option", "maxDate", new Date());'
                    . '}'
                    . 'else{'
                    . 'if ($("#Solicitud_fechaInicio").datepicker("getDate")===null){'
                    . '}'
                    . '$("#Solicitud_fechaInicio").datepicker("option", "maxDate", selectedDate);'
                    . '}'
                    . 'admSolicitud.search();' 
                    . '}'
                ),
                'htmlOptions' => array(
                    'id' => 'Solicitud_fechaFin',
                ),
                    ), true)
            ?>
        </div>        
    </div>
        <div class="column">
            <?php echo $form->label($model, 'Estado'); ?>   
            <?php echo $form->dropDownList($model, 'idestado', CHtml::listData(Estado::model()->getEstadosCompra(), 'id', 'nombre'), array('empty' =>'')); ?>
        </div>
        <div class="column">
            <?php echo $form->label($model, 'descripcion'); ?>
            <?php echo $form->textField($model, 'descripcion'); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
