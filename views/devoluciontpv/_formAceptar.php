<?php
/* @var $this DevoluciontpvController */
/* @var $model Devoluciontpv */
/* @var $form CActiveForm */
$modelPuntoVenta = Puntoventa::model()->find();
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'focus' => array($model, 'numero')
    ));
    ?>
    <div class="formWindow">
        <div style="left:570px; cursor:pointer;  top:35px; width:260px; height:23px; padding:2px; padding-top: 0px;   position: absolute; ">
            <?php
            echo '<div style="width:170px;border:2px solid #ffffff; font-weight:bold; height:19px; font-size:12px; float:right; background:#59b8d1; text-align:center">' . $model->idestado0->nombre . '</div>';
            ?>
        </div>
                <div class="row">
            <div class="column">
                <?php echo $form->label($model, 'numero'); ?>
                <?php echo $form->textField($model, 'numero', array('class' => 'numeric', 'style' => "width: 70px;background: url('images/modules/venta/indicadorIzquierda.png') no-repeat right", 'readonly' => 'readonly')); ?>
            </div>
            <div class="column">
                <?php
                    echo $form->hiddenField($model, 'disponible');
                    echo $form->hiddenField($model, 'idestado');
                echo $form->hiddenField($model, 'idalmacen', array('value' => $model->idalmacenorigen));
                echo $form->hiddenField($model, 'idalmacenorigen', array('value' => $model->idalmacenorigen));
                ?>
            </div>
            <div class="column">
                <?php
                echo $form->labelEx($model, 'idalmacendestino', array('label' => 'Almacen'));
                echo $form->dropDownList(
                        $model, 'idalmacendestino', 
                            CHtml::listData(Almacen::model()
                                ->findAll(
                                        array(
                                            'order' => 'nombre', 
                                            'condition' => 't.idalmacen IS NULL')), 
                                        'id', 'nombre'),
                                        array(
                                            'empty' => '',
                                            'disabled' => $model->scenario == 'confirmacion'? true : false
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
                            'style' => 'width: 98%; text-transform: uppercase;', 'rows' => 2,'disabled' => true,
                        ));
            ?>
	</div>
        <!--<div class="row">
            <?php //echo $form->labelEx($model, 'idtransaccion'); ?>
            <?php //echo $form->textField($model, 'idtransaccion'); ?>
        </div>-->
        <div style="left: 633px; top: 188px;  cursor:pointer; visibility: hidden; width:185px; height:20px155px;  background: #f4ed90; padding-left: 5px; position: absolute;border:1px solid #1d6fb8; border-bottom:none;">
            Disponible: <span style="font-weight: bold;" <?php echo 'id="' . System::Id('divSaldoDisponible') . '"'; ?>></span>
        </div>
        <?php
        echo System::widgetTabs(array(
            'nameView' => 'Solicitud',
            'height' => 270,
            'tabs' => array(
                'Productos' => array('id' => 'producto',
                    'content' => $this->renderPartial('_productoAceptar', array('model' => $model, 'form'=> $form, 'gridDevolucionproducto' => $gridDevolucionproducto), true),
                    'titleWidth' => 130,
                ),
            ),
        ));
        ?>
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Devoluciontpv',
        'buttons' => array(
            'save'=>array('label'=>'Aceptar','icon'=>'check')
        )
    ));
    ?>
    <?php $this->endWidget(); ?>

</div><!-- form -->
