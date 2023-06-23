<?php
/* @var $this TraspasotpvController */
/* @var $model Traspasotpv */
/* @var $form CActiveForm */
$modelPuntoVenta = Puntoventa::model()->find();
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'numero')
)); 

    $showSwitch=$model->idestado== Estadotpv::BORRADOR || $model->idestado== Estadotpv::SOLICITUD || $model->idestado== Estadotpv::RESERVA;
//    echo $showSwitch;
?>
    <div class="formWindow">
        <div style="left:570px; cursor:pointer;  top:35px; width:260px; height:23px; <?php echo $showSwitch ? 'background:#ffffff;' : ''; ?>  padding:2px; padding-top: 0px;   position: absolute; ">
            <?php
            if ($showSwitch){
                echo $form->hiddenField($model, 'idestado');
                echo $form->hiddenField($model, 'estadoanterior');
                echo System::widgetSwitch($model, 'estado', array('handleWidth' => 260, 'onText' => 'BORRADOR', 'offText' => 'SOLICITUD',
                    'onchange' => 'function(){Traspasotpv.setEstado();}'));
            }else{
                echo '<div style="width:170px;border:2px solid #ffffff; font-weight:bold; height:19px; font-size:12px; float:right; background:#59b8d1; text-align:center">' . $model->idestado0->nombre . '</div>';
//                echo $form->hiddenField($model, 'esborrador', array('value' => $model->esborrador ? 1 : 0));
            }
            ?> 
        </div> 
	<div class="row">
            <div class="column">
                <?php echo $form->label($model, 'numero'); ?>
                <?php echo $form->textField($model, 'numero',array('class'=>'numeric',     'style' => "width: 70px;background: url('images/modules/venta/indicadorIzquierda.png') no-repeat right",'readonly'=>'readonly')); ?>
            </div>
            <div class="column">
                <?php
                    echo $form->labelEx($model, 'idalmacenorigen');
                    echo $form->hiddenField($model, 'disponible');
                    echo $form->hiddenField($model, 'idalmacen',array('value'=>$model->idalmacenorigen/*$modelPuntoVenta->idalmacen*/));
                    echo $form->hiddenField($model, 'idalmacenorigen',array('value'=>$model->idalmacenorigen/*$modelPuntoVenta->idalmacen*/));
                    echo $form->dropDownList(
                        $model, 'almacenorigen', 
                            CHtml::listData(Almacen::model()
                                ->findAll(
                                        array(
                                            'order' => 'nombre', 
                                            'condition' => 't.id = '.$model->idalmacenorigen/*$modelPuntoVenta->idalmacen*/)), 
                                        'id', 'nombre'),
                                        array(
                                            'disabled' => true
                                        )
                    );
                ?>
            </div>
            <div class="column">
                <?php
                    echo $form->labelEx($model, 'idalmacendestino');
                    echo $form->dropDownList(
                        $model, 'idalmacendestino', 
                            CHtml::listData(Almacen::model()
                                ->findAll(
                                        array(
                                            'order' => 'nombre', 
                                            'condition' => 't.idalmacen IS NULL')), 
                                        'id', 'nombre'),
                                        array(
                                            'disabled' => false,
                                            'empty' => '',
                                            'disabled' => $model->scenario == 'update'? true : false
                                        )
                    );
                ?>
            </div>
	</div>
        
        <div class="row">
            <?php 
                echo $form->labelEx($model, 'glosa');
                echo $form->textArea($model, 'glosa', 
                        array(
                            'style' => 'width: 98%; text-transform: uppercase;', 'rows' => 2,
                            'disabled' => $model->scenario == 'update'? true : false
                        ));
            ?>
	</div>
        <div style="left: 663px; top: 174px;  cursor:pointer; visibility: hidden; width:185px; height:20px155px;  background: #f4ed90; padding-left: 5px; position: absolute;border:1px solid #1d6fb8; border-bottom:none;">
            Disponible: <span style="font-weight: bold;" <?php echo 'id="' . System::Id('divSaldoDisponible') . '"'; ?>></span>
        </div>
        <?php
        echo System::widgetTabs(array(
            'nameView' => 'Solicitud',
            'height' => 295,
            'tabs' => array(
                'Productos' => array('id' => 'producto',
                    'content' => $this->renderPartial('_productoUpdate', array('model' => $model, 'form'=> $form, 'gridSolicitudProducto' => $gridSolicitudProducto), true),
                    'titleWidth' => 130,
                ),
            ),
        ));
        ?>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Traspaso',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
