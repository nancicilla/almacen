<?php

/* @var $this InventarioController */
/* @var $model Inventario */
/* @var $form CActiveForm */
?>
<div class="container">
    <div class="offset-12">
        <div id="content">
            <div class="form">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'focus'=>array($model,'idAlmacen')
                ));
                if ($model->isNewRecord == false) {
                    $model->idAlmacen = $model->getIdAlmacen();
                }
                ?>
                <div class="formWindow">   
                    <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, '<h4>Información</h4>Para el inventario sólo se tomaran en cuenta los productos del almacén seleccionado y que además estén habilitados para inventariar desde la interfaz de "Selección de Productos"'); ?>
                    <div class="row">                        
                        <?php echo $form->labelEx($model, 'idAlmacen'); ?>              
                        <?php
                        echo $form->dropDownList(
                                $model, 'idAlmacen', CHtml::listData(Almacen::model()->findAll(array('order' => 'codigo')), 'id', 'nombreCompleto')
                                , array("disabled" => ($model->scenario == 'update') ? true : false,
//                            'onchange' => "Inventario.loadGrid()",
                            )
                        );
                        ?>          
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model, 'descripcion'); ?>
                        <?php echo $form->textField($model, 'descripcion', array('style' => 'text-transform: uppercase')); ?>
                    </div>
                    <div class="row">
                        <?php echo $form->labelEx($model, 'gestional'); ?>
                        <?php echo $form->checkBox($model, 'gestional'); ?>
                    </div>
                    <div class="row">
                        <?php echo $form->labelEx($model, 'verificar_saldo_negativo'); ?>
                        <?php echo $form->checkBox($model, 'verificar_saldo_negativo'); ?>
                    </div>
                </div>	

<?php
echo System::Buttons(array(
    'nameView' => 'Inventario',
    'buttons' => array()
));
$this->endWidget();
?>
            </div>
        </div>
    </div>
</div>
