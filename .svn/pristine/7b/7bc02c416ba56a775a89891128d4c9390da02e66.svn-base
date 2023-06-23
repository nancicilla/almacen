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
                            <?php echo $form->labelEx($model, 'almacén'); ?>
                        </div>
                        <div class="column">
                            <?php
                            
                            echo $form->dropDownList(
                                    $model, 'idalmacenValorado', CHtml::listData(
                                            Almacen::model()->findAll(
                                                    array(
                                                        'order' => 'nombre', /* 'condition' => 't.idalmacen IS NULL' */
                                            )), 'id', 'nombre'), array('empty' => '')
                            );
                            ?>
                        </div>
                        <div class="column">
                            <?php echo $form->labelEx($model, 'producto'); ?>
                            <?php echo $form->hiddenField($model, 'nameView'); ?>
                        </div>
                        <div class="column">
                            
                            <?php echo $form->textField($model, 'productoValorado'); ?>
                        </div>
                        <div class="column">
                            
                            <button id="btnBuscarProductosValorado" type="button" 
                                    class="btn btn-warning" style='background: #D04526; color:#FFF;'>BUSCAR</button>
                        </div>
                    </div>

                    <div class="row">
                        <?php
                        echo System::widgetTabs(array(
                            'nameView' => 'Kardex',
                            'height' => 150,
                            'tabs' => array(
                                'Items' => array(
                                    'id' => 'kardexValorado',
                                    'content' => $this->renderPartial('_valoradoProductos', array('productos' => $productos,'model'=>$model), true),
                                    'titleWidth' => 100,
                                    'active' => true
                                ),
                            )
                        ));
                        ?>
                    </div>

                    <div class="row">
                        <div class="column">
                            <?php
                            echo $form->label($model, 'fechaInicio');
                            ?>
                        </div>
                        <div class="column">
                            <?php
                            echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'attribute' => 'fechaInicio',
                                //'value' => $model->fechalimite,
                                'language' => 'es',
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'showAnim' => 'slideDown',
                                    'showButtonPanel' => true,
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'dateFormat' => 'dd-mm-yy',
                                    'onClose' => 'js:function(selectedDate){'
                                    . 'if (selectedDate!=""){'
                                    . $_GET['nameView'].'.cargarValoradoProductoNota();'
                                    . '}'
                                    . '}',
                                ),
                                'htmlOptions' => array(
                                    'size' => '10',
                                    'style' => 'width: 100px;',
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
                                //'value' => $model->fechalimite,
                                'language' => 'es',
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'showAnim' => 'slideDown',
                                    'showButtonPanel' => true,
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'dateFormat' => 'dd-mm-yy',
                                    'onClose' => 'js:function(selectedDate){'
                                    . 'if (selectedDate!=""){'
                                    . $_GET['nameView'].'.cargarValoradoProductoNota();'
                                    . '}'
                                    . '}',
                                ),
                                'htmlOptions' => array(
                                    'size' => '10',
                                    'style' => 'width: 100px;',
                                ),
                                    ), true);
                            ?>
                        </div>
                        <div class="column">
                            <?php echo $form->label($model, 'Origen'); ?>
                        </div>
                         <div class="column">
                            
                            <?php
                            echo $form->dropDownList( $model, 'idorigen', 
                                    CHtml::listData(
                                            Origen::model()->findAll(
                                                    array(
                                                        'order' => 'nombre', 
                                                        )), 'id', 'nombre'), array('empty' => 'TODOS'));
                            ?>
                        </div>
                        <div class="column">
                            <?php echo $form->label($model, 'Movimiento'); ?>          
                        </div>
                        <div class="column">
                            
                            <?php
                            echo $form->dropDownList($model, 'idtipomov', CHtml::listData(
                                            Tipo::model()->findAll(
                                                    array(
                                                        'order' => 'nombre',
                                                        'condition' => 't.id=1 or t.id=2')), 'id', 'nombre'), array('empty' => 'TODOS'));
                            ?>
                       
                        </div>
                    </div>

                    <div style="left: 1078px; top: 280px; visibility: hidden; cursor:pointer; width:190px; height:20px155px;  background: #f4ed90; padding-left: 5px; position: absolute;border:1px solid #1d6fb8; border-bottom:none;">
                        Saldo Ant.: <span style="font-weight: bold;" <?php echo 'id="' . System::Id('divSumatoriaProductoNotaValorado') . '"'; ?>></span>
                    </div>
                    <div class="row">
                        <?php
//                        echo $form->labelEx($model, 'producto nota');
                        echo "<div id='" . System::Id('divProductoNota') . "'>";
                        echo $this->renderPartial('_valoradoProductonota', array('form' => $form, 'productonota' => $productonota), true);
                        echo "</div>";
                        ?>
                    </div>
                </div>

                <?php
                echo System::Buttons(array(
                    'nameView' => 'Productonota',
                    'buttons' => array(
                        'back' => array(
                            'align' => 'right',
                            'label' => 'Salir',
                            'icon' => 'arrow-left',
                            'click' => $_GET['nameView'].'.closeWindow()',
                        ),
                        'imprimirKardexValoradoExcel' => array(
                            'click' => $_GET['nameView'].'.imprimirKardexValoradoExcel()',
                            'label' => 'Imprimir Excel',
                            'icon' => 'print',
                            'width' => 100,
                        ),
                        'imprimirKardexValorado' => array(
                            'click' => $_GET['nameView'].'.imprimirKardexValorado()',
                            'label' => 'Imprimir',
                            'icon' => 'print',
                            'width' => 75,
                        ),
                    )
                ));
                ?>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>