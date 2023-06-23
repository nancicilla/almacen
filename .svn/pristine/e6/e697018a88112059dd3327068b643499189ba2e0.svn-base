<?php
/* @var $this VencimientoController */
/* @var $model Vencimiento */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'idcompra')
)); ?>
    <div class="formWindow">
        <div class="row">
            <div class="column">
                <?php
                echo '<font id="dato">' . 'Código de Barra: ' . '</font>' . '<br>';
                echo '<font id="dato">' . 'Código: ' . '</font>' . '<br>';
                echo '<font id="dato">' . 'Producto: ' . '</font>' . '<br>';
                echo '<font id="dato">' . 'Nro. Lote: ' . '</font>' . '<br>';
                ?>
            </div>
            <div class="column">
                <?php
                echo '<p id="valores">' . $model->idproducto0->coduniversal . '</p>';
                echo '<p id="valores">' . $model->idproducto0->codigo . '</p>';
                echo '<p id="valores">' . $model->idproducto0->nombre . '</p>';
                echo '<p id="valores">' . $model->numerolote . '</p>';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="column">
                    <?php echo $form->hiddenField($model,'idproducto'); ?>
                    <?php echo $form->labelEx($model,'fechavencimiento'); ?>
                    <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$model, 
                    'attribute'=>'fechavencimiento',
                    'language' => 'es',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'minDate' => 'today',
                    ),
                    'htmlOptions' => array(

                    ),
                        ), true)  
                        ?>
            </div>

            <div class="column">
                    <?php echo $form->labelEx($model,'cantidad'); ?>
                    <?php echo $form->textField($model,'cantidad',array('maxlength'=>12,'readonly'=>$model->cantidad>$model->saldo?'readonly':null)); ?>
            </div>
        </div>
	<div class="row">
		<?php echo $form->labelEx($model,'observacion'); ?>
		<?php echo $form->textArea($model,'observacion',array('style'=>'width: 95%')); ?>
	</div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Vencimiento',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
