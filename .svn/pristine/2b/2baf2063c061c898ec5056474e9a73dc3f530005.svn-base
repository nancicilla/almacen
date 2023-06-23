<?php
/* @var $this AlmacenController */
/* @var $model Almacen */
/* @var $form CActiveForm */
?>
<div class="container">
    <div class="offset-12">
        <div id="content">
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'focus' => array($model, 'fechaFin')
                ));
                ?>
                <div class="formWindow">
                    <div class="row">
                        <?php //echo $form->labelEx($model, 'id'); ?>
                        <?php //echo $form->dropDownList($model, 'id', CHtml::listData(Almacen::model()->findAll(array('condition' => 't.idalmacen is null')), 'id', 'nombre'), array('empty' => '')); ?>
                    </div>
                    <div class="row">
                        <?php echo $form->label($model, 'Fecha limite'); ?>
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
                                'dateFormat' => 'dd-mm-yy'
                            ),
                                ), true)
                        ?>
                    </div>
                </div>
                <?php
                echo System::Buttons(array(
                    'nameView' => 'Almacen',
                    'buttons' => array(
                        'generar' => array(
                            'label' => 'Generar excel',
                            'icon' => 'download-alt',
                            'click' => 'Almacen.generarExcelDiferenciasAlmacen()'
                        )
                    )
                ));
                ?> 
                <?php $this->endWidget(); ?>

            </div><!-- form -->
        </div>
    </div>
</div>
