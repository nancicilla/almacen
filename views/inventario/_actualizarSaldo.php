<div class="container">
    <div class="offset-12">
        <div style="padding: 5px;" class="content">
            <div class="form">
                <?php $form=$this->beginWidget('CActiveForm'); ?>
                    <div class="formWindow">
                        <div class="row">
                            <?php
                                echo $form->hiddenField($model, 'id');
                            ?>
                        </div>
                        <fieldset>
                            <div class="row">
                                <?php echo $form->label($model, 'fechaHasta'); ?>
                                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model'=>$model, 
                                'attribute'=>'fechaHasta',
                                'value' => $model->fechaHasta,
                                'language' => 'es',
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'showAnim' => 'slideDown',
                                    'showButtonPanel' => true,
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'dateFormat' => 'dd-mm-yy',
                                    'maxDate' => 'today',
                                    'onClose' => 'js:function(selectedDate) {Inventario.periodo();}'
                                ),
                                'htmlOptions' => array(
                                    'size' => '10',
                                ),
                                    ), true)  
                                    ?>
                            </div>
                        </fieldset>    
                    </div> <!-- "formWindow" -->
                    <?php
                        echo System::Buttons(
                            array(
                                'nameView' => 'Inventario',
                            )
                        );
                    ?>
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>