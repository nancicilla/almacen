<?php
/* @var $this ControlcalidadalmacenController */
/* @var $model Controlcalidadalmacen */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'codigodocumento')
)); ?>
    <div class="formWindow">
    
	<div style="position: absolute;top:33px; width: 95%; border-bottom:2px solid #59b8d1;background: #e5e5e5; ">
            <div style="width:80%;float: left; ">
                <strong>Documento:</strong><?php  echo $model->codigodoc;?>
            </div>
        </div>
        <div class="row" style="margin-top:10px;">
            <div class="column" style="float:left;">
		<?php echo $form->labelEx($model, 'descripcion'); ?>
                    <?php echo $form->textArea($model, 'descripcion', array('style' => 'width: 580px;height: 41px;',
                        'disabled'=>true,
                        )); ?>
            </div>
            <div class="column" style="float:right;">
                <?php echo $form->hiddenField($model, 'idestado'); ?>
                <?php echo $form->hiddenField($model, 'id'); ?>
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->textField($model,'estado',array('style' => '','disabled'=>true)); ?>
            </div>
	</div>
     <div class="row">
            <?php
            echo System::widgetTabs(array(
                'nameView' => 'Venta',
                'height' => 395,
                'tabs' => array(
                    'Productos' => array('id' => 'productos',
                        'content' => $this->renderPartial('_productosVerificar', array('model' => $model, 'productos' => $productos), true),
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
        'orderButtons'=>'save,rechazar,cancel',
        'buttons' => array(
            'rechazar'=>array('label'=>'Rechazar','icon'=>'remove','click'=>'Controlcalidadalmacen.rechazar();'),
            //'confirmar' => array('label'=>'Confirmar','icon'=>'icon-ok','float' => 'left','click'=>'Controlcalidadalmacen.confirmar();'),
            'print'=>array('icon'=>'print','label'=>'Reporte','width'=>80,'click'=>'Controlcalidadalmacen.imprimirReporte()'),
            )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
