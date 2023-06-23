<?php
$nombreProducto = "";
?>
<div class="container">
    <div class="offset-12">
        <div id="content">
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                ));
                ?>
                <div class="formWindow"> 
                    <div class="row">                        
                        <?php echo $form->labelEx($model, 'id'); ?>
                        <?php
                        echo $form->dropDownList(
                                $model, 'id', CHtml::listData(Almacen::model()->findAll(array('order' => 'nombre')), 'idEncriptado', 'nombre'), array(
                            'empty' => '')
                        );
                        ?>    
                    </div>

                    <div class="row">                        
                        <?php echo $form->labelEx($model, 'origen'); ?>
                        <?php
                        echo $form->dropDownList(
                                $model, 'origen', CHtml::listData(Origen::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'), array(
                            'empty' => '')
                        );
                        ?>    
                    </div>

                    <div class="row">
                        <?php echo $form->label($model, 'Fecha desde'); ?>
                        <?php
                        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'fechaInicio',
                            'value' => $model->fechaInicio,
                            'language' => 'es',
                            'options' => array(
                                'showAnim' => 'slideDown',
                                'showButtonPanel' => true,
                                'changeMonth' => true,
                                'changeYear' => true,
                                'dateFormat' => 'dd-mm-yy',
                                'maxDate' => 'today',
                                'onClose' => 'js:function(selectedDate){'
                                . 'Almacen.validarFechaInicio(selectedDate);'
                                . '}'
                            ),
                                ), true)
                        ?>
                    </div>
                    <div class="row">
                        <?php echo $form->label($model, 'Fecha hasta'); ?>
                        <?php
                        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'fechaFin',
                            'value' => $model->fechaFin,
                            'language' => 'es',
                            'options' => array(
                                'showAnim' => 'slideDown',
                                'showButtonPanel' => true,
                                'changeMonth' => true,
                                'changeYear' => true,
                                'dateFormat' => 'dd-mm-yy',
                                'maxDate' => 'today',
                                'onClose' => 'js:function(selectedDate){'
                                . 'Almacen.validarFechaFin(selectedDate);'
                                . '}'
                            ),
                                ), true)
                        ?>
                    </div>
                    <div class="row">
                        <div class="column">
                            <?php echo $form->labelEx($model, 'Ver Detalle por Cuenta'); ?>
                        </div>
                        <div class="column">
                            <?php echo $form->checkBox($model, 'detalle'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <?php echo $form->hiddenField($model, 'idcuenta'); ?>
                        <?php echo $form->labelEx($model, 'Nº de cuenta'); ?>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'cuenta',
                            'source' => $this->createUrl("cuenta/Autocomplete"),
                            'options' => array(
                                'showAnim' => 'slideDown',
                                'delay' => '0',
                                'select' => "js:function(event, ui) {
                                    Almacen.setIdCuenta(ui.item.id);
                                    }"
                            ),
                            'htmlOptions' => array('disabled' => true, 'style' => 'width: 200px;'),
                        ));
                        ?>                        
                    </div>
                    <?php
                    echo System::Buttons(array(
                        'nameView' => 'Almacen',
                        'buttons' => array()
                    ));
                    ?> 
                    <?php $this->endWidget(); ?>
                </div><!-- form -->
            </div>
        </div>
    </div>
