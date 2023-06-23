<?php
/* @var $this OrdentrabajoController */
/* @var $model Ordentrabajo */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'numero')
)); ?>
    <div class="formWindow">
        <div class="row">
            <div class="column">
                    <?php echo $form->labelEx($model,'numero'); ?>
                    <?php echo $form->textField($model,'numero',array('class'=>'numeric', 'style' => "width: 100px;background: url('images/modules/venta/indicadorIzquierda.png') no-repeat right",'readonly'=>'readonly')); ?>
            </div>

            <div class="column">
                    <?php echo $form->labelEx($model,'producto'); ?>
                    <?php // echo $form->textField($model,'idproducto'); 
                            echo $form->hiddenField($model, 'idproducto');
                            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'producto',
                                'source' => $this->createUrl("ordentrabajo/autocompleteCodigoNombre"),
                                'options' => array(
                                    'showAnim' => 'slideDown',
                                    'delay' => '0',
                                    'select' => "js:function(event, ui) {
                                        $('#' + Ordentrabajo.Id('producto')).val(ui.item.value);
                                        $('#' + Ordentrabajo.Id('idproducto')).val(ui.item.id);
                                        Ordentrabajo.metodo();
                                    }",
                                ),
                                'htmlOptions' => array('style' => 'width: 460px;text-transform: uppercase;',
                                    'disabled' => $model->scenario == 'update' ? true : false),
                            ));
                    ?>
                
            </div>
            <div class="column">
                <?php echo $form->labelEx($model, 'cantidadproducir'); ?>
                <?php
                echo $form->textField($model, 'cantidadproducir', array('precision' => '10', 'style' => 'width: 90px'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="column">
                <?php echo $form->labelEx($model, 'responsable'); ?>
                <?php // echo $form->textField($model,'responsable'); 
                 $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'responsable',
                                'source' => $this->createUrl("ordentrabajo/autocompleteResponsable"),
                                'options' => array(
                                    'showAnim' => 'slideDown',
                                    'delay' => '0',
                                    'select' => "js:function(event, ui) {
                                        $('#' + Ordentrabajo.Id('responsable')).val(ui.item.value);
                                    }",
                                ),
                                'htmlOptions' => array('style' => 'width: 460px;text-transform: uppercase;',
                                    'disabled' => $model->scenario == 'update' ? true : false),
                            ));
//                    ?>
            </div>
            <div class="column">
                    <?php echo $form->labelEx($model, 'fechalimite'); ?>
                    <?php
                    echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'fechalimite',
                        'value' => $model->fechalimite,
                        'language' => 'es',
                        // additional javascript options for the date picker plugin
                        'options' => array(
                            'showAnim' => 'slideDown', //fold
                            'showButtonPanel' => true,
                            'changeMonth' => true,
                            'changeYear' => true,
                            'dateFormat' => 'dd-mm-yy',
                            'minDate' => 'today',
                        ),
                            ), true)
                    ?>
            </div>
        </div>
	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('style'=>'width:95%;')); ?>
	</div>
        <div style="left: 690px; top: 226px;  cursor:pointer; hidden: visible; width:185px; height:20px155px;  background: #f4ed90; padding-left: 5px; position: absolute;border:1px solid #1d6fb8; border-bottom:none;">
            Disponible: <span style="font-weight: bold;" <?php echo 'id="' . System::Id('divSaldoDisponible') . '"'; ?>></span>
        </div>
        <?php
        $ancho = 110;
        echo System::widgetTabs(array(
            'nameView' => 'Ordentrabajo',
            'height' => 240,
            'tabs' => array(
                'Insumos' => array('id' => 'insumos',
                    'content' => $this->renderPartial('_insumos', array('model' => $model, 'form' => $form, 'productos' => $productos,), true),
                    'titleWidth' => $ancho,
                ),
            ),
        ));
        ?>
	
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Ordentrabajo',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
