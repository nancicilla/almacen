<?php
/* @var $this ControlcalidadalmacenController */
/* @var $model Controlcalidadalmacen */
/* @var $form CActiveForm */
?>
<div class="container">
	<div class="offset-12">
		<div id="content">
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'cantidad')
)); ?>
    <div class="formWindow">
        <div style="position: absolute;top:35px; width: 95%; border-bottom:2px solid #59b8d1;background: #e5e5e5; ">
            <div style="width:70%;float: left; ">
                <strong>Producto:</strong><?php  echo $model->codigonombre;?>
            </div>
            <div style="width:30%;float: right; ">
            <strong>Cantidad:</strong>
            <?php echo $form->textField($model,'cantidad',array('style'=>'width:70px')); ?>
        </div>
        </div>
        <div class="row">
            <div class="column">
                <?php echo $form->hiddenField($model, 'idcontrolcalidadproducto'); ?>
                <?php echo $form->hiddenField($model, 'id'); ?>
            </div>
	</div>
        
    <div class="row" style="margin-top:15px;">
            <?php echo $form->labelEx($model,'descripcion'); ?>
            <?php echo $form->textArea($model,'descripcion',array('style'=>'width:95%')); ?>
    </div>
     <div class="row">
            <?php
            echo System::widgetTabs(array(
                'nameView' => 'ControlCalidad',
                'height' => 330,
                'tabs' => array(
                    'Insumos' => array('id' => 'productos',
                        'content' => $this->renderPartial('_insumo', array('model' => $model, 'insumos' => $insumos), true),
                        'titleWidth' => 100,
                    ),
                ),
            ));
            ?>
        </div>
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Controlcalidadalmacen',
        'orderButtons'=>'save,cancel',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
		</div>
	</div>
</div>
