<?php
/* @var $this ProductoController */
/* @var $model Producto */
?>
<div class="container">
    <div class="offset-12">
        <div id="content">
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                     'focus'=>array($model,'almacen')));
                ?>
                <div class="formWindow">
                    <div class="row">
                        <div class="row">
                            
                            <div class="row">
                                <div class="column">
                                    <?php echo $form->label($model, 'fechaInicio'); ?>
                                </div>
                                <div class="column">
                                    <?php
                                    echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model' => $model,
                                        'attribute' => 'fechaInicio',
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
                                            . 'Producto.validarFechaInicio(selectedDate);'
                                            . '}'
                                        ),
                                        'htmlOptions' => array(
                                            'size' => '10',
                                            'style' => 'width: 100px;',
                                        ),
                                            ), true)
                                    ?>
                                </div>
                                <div class="column">
                                    <?php echo $form->label($model, 'fechaFin'); ?>
                                </div>
                                <div class="column">
                                    <?php
                                    echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model' => $model,
                                        'attribute' => 'fechaFin',
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
                                            . 'Producto.validarFechaFin(selectedDate);'
                                            . '}'
                                        ),
                                        'htmlOptions' => array(
                                            'size' => '10',
                                            'style' => 'width: 100px;',
                                        ),
                                            ), true)
                                    ?>
                                </div>
                                <div class="column" >
                                    <?php echo $form->label($model, 'almacen', array('label' => 'Almacen')); ?>
                                </div>
                                <div class="column">
                                    <?php
                                        echo $form->dropDownList(
                                            $model, 'almacen', CHtml::listData(
                                                    Almacen::model()->findAll(
                                                            array(
                                                                'order' => 'id desc ',
                                                    )), 'id', 'nombre'
                                            ), array('style' => 'width: 100%;text-transform: uppercase;', 'empty' => '')
                                    );
                                    ?>
                                </div>
                                <div class="column">

                                    <button id="btnBuscarProductosSolicitud" type="button" 
                                        class="btn btn-warning" style='background: #D04526; color:#FFF;'>ESTIMAR</button>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <?php
                            echo "<div id='" . System::Id('divProductoStocksolicitud') . "'>";
                            echo $this->renderPartial('_productoStocksolicitud', array('form' => $form, 'productoStock' => $productoStock), true);
                            echo "</div>";
                            ?>
                        </div>
                        
                        
                    </div>
                </div>     
                <?php
                echo System::Buttons(array(
                    'nameView' => 'Producto',
                    'orderButtons' => 'generar,cancel',
                    'buttons' => array(
                        'generar' => array(
                            'label' => 'Generar',
                            'icon' => 'check',
                            'width' => '110',
                            'click' => 'Producto.generarSolicitud();',
                        ),
                    )
                ));
                ?> 
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>