<?php
/* @var $this NotaborradorController */
/* @var $model Notaborrador */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'admNotaborrador'
    ));
    ?> 

     <div class="row">
        <?php echo $form->label($model, 'norden'); ?>
        <?php echo $form->textField($model, 'norden'); ?>
    </div>
    <div class="row">
		<?php echo $form->label($model,'idalmacen'); ?>
		<?php echo $form->dropDownList(
                    $model, 'idalmacen',                       
                        CHtml::listData(Almacen::model()->findAll(array('order'=>'codigo', 'condition' => "idalmacen ISNULL ")),
                                'id', 
                                'nombreCompleto'),
                         array(
        'empty'=>'')
                    ); ?>
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
                . '$("#Notaborrador_fechaFin").datepicker("setDate", "");'
                . '}'
                . 'else{'
                . 'if ($("#Notaborrador_fechaFin").datepicker("getDate")===null){'
                . '$("#Notaborrador_fechaFin").datepicker("setDate", selectedDate);'
                . '$("#Notaborrador_fechaFin").datepicker("option", "maxDate",new Date());'
                . '}'
                . '}'
                . '$("#Notaborrador_fechaFin").datepicker("option", "minDate",selectedDate);'
                . 'admNotaborrador.search();'
                . '}',),
            'htmlOptions' => array(
                'id' => 'Notaborrador_fechaInicio',
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
            'name' => 'notaborrador[fechaFin]',
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
                . '$("#Notaborrador_fechaInicio").datepicker("setDate", "");'
                . '$("#Notaborrador_fechaInicio").datepicker("option", "maxDate", new Date());'
                . '}'
                . 'else{'
                . 'if ($("#Notaborrador_fechaInicio").datepicker("getDate")===null){'
                . '$("#Notaborrador_fechaInicio").datepicker("setDate", selectedDate);'
                . '}'
                . '$("#Notaborrador_fechaInicio").datepicker("option", "maxDate", selectedDate);'
                . '}'
                . 'admNotaborrador.search();'
                . '}',
            ),
            'htmlOptions' => array(
                'id' => 'Notaborrador_fechaFin',
            ),
                ), true)
        ?>       
    </div> 
    <div class="row">
        <?php echo $form->labelEx($model, 'idorigen'); ?>
        <?php
        echo $form->dropDownList(
                $model, 'idorigen', CHtml::listData(Origen::model()->findAll(), 'id', 'nombre'), array('empty' => '')
        );
        ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'idtipo'); ?>
        <?php
        echo $form->dropDownList(
                $model, 'idtipo', CHtml::listData(Tipo::model()->findAll(), 'id', 'nombre'), array('empty' => '')
        );
        ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model, 'idtipodocumento'); ?>
        <?php
        echo $form->dropDownList(
            $model, 'idtipodocumento', 
            CHtml::listData(Tipodocumento::model()->findAll(), 'id', 'nombre'), array('empty' => '')
        );
        ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'glosa'); ?>
        <?php echo $form->textField($model, 'glosa', array('rows' => 6, 'cols' => 50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'usuario'); ?>
        <?php echo $form->textField($model, 'usuario', array('maxlength' => 30)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
