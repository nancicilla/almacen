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
            $formProducto = $model->scenario==='recepcion'?'_productos_1':'_productos';
            $height = $model->scenario==='recepcion'? 375: 375;
            echo System::widgetTabs(array(
                'nameView' => 'Venta',
                'height' => $height,
                'tabs' => array(
                    'Productos' => array('id' => 'productos',
                        'content' => $this->renderPartial($formProducto, array('model' => $model, 'productos' => $productos), true),
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
        'orderButtons'=>'confirmar,save,pendiente,cancel',
        'buttons' => array(
            'pendiente'=>array('label'=>'Pendiente','icon'=>'download-alt','click'=>'Controlcalidadalmacen.pendiente();'),
            //'confirmar' => array('label'=>'Confirmar','icon'=>'icon-ok','float' => 'left','click'=>'Controlcalidadalmacen.confirmar();'),
            'print'=>array('icon'=>'print','label'=>'Reporte','width'=>80,'click'=>'Controlcalidadalmacen.imprimirReporte()'),
            )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
