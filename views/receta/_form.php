<?php
/* @var $this RecetaController */
/* @var $model Receta */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'focus' => array($model, 'recetaespecial')
    ));
    ?>
    <div class="formWindow">

        <div class="row">
            <div class="column">
                <?php echo $form->labelEx($model, 'idestadoreceta'); ?>
                <?php
                echo $form->dropDownList(
                        $model, 'idestadoreceta', CHtml::listData(FtblProduccionEstadoreceta::model()->findAll(array('order' => 'id')), 'id', 'nombre')
                );
                ?>
            </div>

            <div class="column">
                <?php echo $form->labelEx($model, 'costounitario'); ?>
                <?php echo $form->textField($model, 'costounitario', array('maxlength' => 12, 'style' => 'width:70px')); ?>
            </div>

            <div class="column">
                <?php echo $form->labelEx($model, 'totalproducido'); ?>
                <?php
                echo System::widgetSwitch($model, 'totalproducido', array('handleWidth' => 80, 'onText' => 'Si', 'offText' => 'No',
                    'onchange' => 'function(){}', 'orderInverse' => true));
                ?>
            </div>
        </div>

        <div class="row">
            <div class="column">
                <?php echo $form->labelEx($model, 'idalmacen', array('label' => 'Almacen')); ?>        
                <?php
                echo $form->dropDownList(
                        $model, 'idalmacen', CHtml::listData(
                                Almacen::model()->findAll(
                                        'general=false', array('order' => 'id')), 'id', 'nombre'
                        ), array('empty' => '', 'disabled' => $model->scenario == 'update' ? true : false)
                );
                ?>
            </div>
            <div class='column'>
                <?php echo $form->labelEx($model, 'producto'); ?>
                <?php echo $form->hiddenField($model, 'idproducto'); ?>
                <?php echo $form->hiddenField($model, 'productoValido'); ?>
                <?php
                        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'producto',
                            'source' => $this->createUrl("producto/autocompleteCodigoNombre"),
                            'options' => array(
                                'showAnim' => 'slideDown',
                                'delay' => '0',
                                'focus' => "js:function(event, ui) {                        

                            }",
                                'select' => "js:function(event, ui) {
                                Receta.set('idproducto',ui.item.id);
                                Receta.set('producto',ui.item.value);

                                Receta.gridSearchVars('Producto','&idproductoreceta='+Receta.get('idproducto')+'&idalmacen=' + $('#' + Receta.Id('idalmacen')).val());
                                var gridinsumos=Receta.getSGridView('Producto');
                                SGridView.setProperties('editable',true,gridinsumos.id);
                            }"
                            ),
                            'htmlOptions' => array('style' => 'width: 490px;text-transform: uppercase;', 'disabled' => $model->scenario == 'update' ? true : false),
                        ));
                ?>
            </div>
            <div style="" class="row">
                <?php echo $form->labelEx($model, 'descripción'); ?>
                <?php
                        echo $form->textArea(
                                $model, 'descripcion', array('rows' => 1, 'style' => 'text-transform: uppercase; width: 770px; height: 60px;')
                        );
                ?>
            </div>
            <?php
            echo System::widgetTabs(array(
                'nameView' => 'Receta',
                'height' => 190,
                'tabs' => array(
                    'Insumos' => array('id' => 'ingrediente',
                        'content' => $this->renderPartial('_producto', array('model' => $model, 'form' => $form, 'productos' => $productos), true),
                        'titleWidth' => 130,
                    ),
                ),
            ));
            ?>
        </div>

    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Receta',
        'buttons' => array()
    ));
    ?> 
    <?php $this->endWidget(); ?>

</div><!-- form -->
