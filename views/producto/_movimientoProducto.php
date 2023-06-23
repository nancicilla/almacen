<div class="container">
    <div class="offset-12">
        <div style="padding: 5px;" id="content">
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                ));
                ?>
                <div class="formWindow">
                <div class="row">
                    <div class="column">
                        <?php
                        $model->nombre = $model->codigo.' ( '.$model->nombre.' )';
                        echo $form->hiddenField($model, 'nombre');
                        echo $form->hiddenField($model, 'id');
                        echo $form->label($model, 'fechaInicio');
                        ?>
                    </div>
                    <div class="column">
                        <?php
                        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'fechaInicio',
                            'language' => 'es',
                            // additional javascript options for the date picker plugin
                            'options' => array(
                                'showAnim' => 'slideDown',
                                'showButtonPanel' => true,
                                'changeMonth' => true,
                                'changeYear' => true,
                                'dateFormat' => 'dd-mm-yy',
                                'onClose' => 'js:function(selectedDate){'
                                . 'if (selectedDate===""){'
                                . 'Producto.cargarProductoNota();'
                                . '}'
                                . 'else{'
                                . 'Producto.cargarProductoNota();'
                                . '}'
                                . '}',
                            ),
                            'htmlOptions' => array(
                                'size' => '10',
                                'style' => 'width: 80px;'
                            ),
                                ), true);
                        ?>
                    </div>
                    <div class="column">
                        <?php
                        echo $form->label($model, 'fechaFin');
                        ?>
                    </div>
                    <div class="column">
                        <?php
                        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'fechaFin',
                            'language' => 'es',
                            // additional javascript options for the date picker plugin
                            'options' => array(
                                'showAnim' => 'slideDown',
                                'showButtonPanel' => true,
                                'changeMonth' => true,
                                'changeYear' => true,
                                'dateFormat' => 'dd-mm-yy',
                                'onClose' => 'js:function(selectedDate){'
                                . 'if (selectedDate===""){'
                                . 'Producto.cargarProductoNota();'
                                . '}'
                                . 'else{'
                                . 'Producto.cargarProductoNota();'
                                . '}'
                                . '}',
                            ),
                            'htmlOptions' => array(
                                'size' => '10',
                                'style' => 'width: 85px;'
                            ),
                                ), true);
                        ?>
                    </div>
                    <div class="column" style="width: 260px;">
                        <label style="color: #0986AF; font-size: 15px;">Saldo Actual: <?= $model->saldo ?></label>
                        <label style="color: #0986AF; font-size: 15px;">Saldo Importe: <?= $model->saldoimporte > 0? $model->saldoimporte : '0.00' ?></label>
                    </div>
                    <div class="column">
                        <label id="<?= System::Id('lblInformacionX')?>" style="color: #880707; font-size: 15px;"></label>
                        <label id="<?= System::Id('lblInformacion')?>" style="color: #880707; font-size: 15px;"></label>
                    </div>
                </div>

                <div style="left: 1078px; top: 320px; visibility: hidden; cursor:pointer; width:190px; height:20px155px;  background: #f4ed90; padding-left: 5px; position: absolute;border:1px solid #1d6fb8; border-bottom:none;">
                    Saldo Ant.: <span style="font-weight: bold;" <?php echo 'id="' . System::Id('divSumatoriaProductoNotaValorado') . '"'; ?>></span>
                </div>
                <div class="row">
                    <?php
                    echo "<div id='" . System::Id('divProductoNotaDetallado') . "'>";
                    echo $this->renderPartial('_valoradoProductonotaDetallado', array('form' => $form, 'productonota' => $productonota), true);
                    echo "</div>";
                    ?>
                </div>
                </div>
                <?php
                echo System::Buttons(array(
                    'nameView' => 'Producto',
                    'buttons' => array(
                        'salir' => array(
                            'align' => 'right',
                            'label' => 'Salir',
                            'icon' => 'arrow-left',
                            'click' => 'Producto.closeWindow()',
                        ),
                    )
                ));
                ?>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>