<div class="container">
    <div class="offset-12">
        <div id="content">
            <div class="form">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'focus'=>array($model, 'producto')
                )); ?>
                <div class="formWindow">
                    <div class="row">
                        <div class="column">
                            <?php 
                                echo $form->hiddenField($model, 'idproductogrupo');
                                echo $form->labelEx($model, 'producto');
                                
                                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'producto',
                                    'source' => $this->createUrl("producto/AutocompleteProductoPadre"),
                                    'options' => array(
                                        'showAnim' => 'slideDown',
                                        'delay' => '0',
                                        'minLength' => '2',
                                        'autoFocus' => 'true',
                                        'select' => "js:function(event, ui) {
                                            Agrupacion.setInformacionProductoPadre(ui.item);
                                        }"
                                    ),
                                    'htmlOptions' => array(
                                        'style' => 'width: 550px;text-transform: uppercase;',
                                        'disabled' => $model->scenario == 'actualizaAgrupacion'?  true : false
                                    ),
                                ));
                            ?>
                        </div>
                        <div class="column">
                            <?php 
                                echo $form->labelEx($model,'precio');
                                echo $form->textField($model,'precio', 
                                        array('maxlength'=>12,
                                              'style' => 'width: 70px;',
                                              'readonly' => 'readonly'
                                        ));
                            ?>
                        </div>
                        <div class="column">
                            <?php 
                                echo $form->labelEx($model,'pesopromedio');
                                echo $form->textField($model,'pesopromedio', 
                                        array('maxlength'=>12,
                                              'style' => 'width: 70px;',
//                                              'readonly' => 'readonly'
                                        ));
                            ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        <?php
                        echo $this->renderPartial('_agrupacionProductos',
                            array(
                                'form' => $form,
                                'model' => $model,
                                'gridAgrupacionproducto' => $gridAgrupacionproducto,
                            ), true
                        );
                        ?>
                    </div>
                </div>
                <?php
                echo System::Buttons(array(
                    'nameView' => 'Agrupacion',
                    'buttons' => array()
                ));
                ?> 
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>