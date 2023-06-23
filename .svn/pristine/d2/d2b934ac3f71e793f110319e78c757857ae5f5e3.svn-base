<?php
/* @var $this ReprocesoController */
/* @var $model Reproceso */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'focus' => array($model, 'idproducto')
    ));
    ?>
    <div class="formWindow">
        <div class="row">
            <div class="column">
                <?php
                echo $form->hiddenField($model, 'idproducto');
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
                                            Reproceso.setInformacionProducto(ui.item);
                                        }"
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 550px;text-transform: uppercase;',
                        'disabled' => $model->scenario == 'actualizaAgrupacion' ? true : false
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'descripcion'); ?>
            <?php echo $form->textArea($model, 'descripcion',array('style'=>'width:95%')); ?>
        </div>
        <div class="row">
            <?php
            echo $this->renderPartial('_productos', array(
                'form' => $form,
                'model' => $model,
                'gridProducto' => $gridProducto,
                    ), true
            );
            ?>
        </div>
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Reproceso',
        'buttons' => array()
    ));
    ?> 
    <?php $this->endWidget(); ?>

</div><!-- form -->
