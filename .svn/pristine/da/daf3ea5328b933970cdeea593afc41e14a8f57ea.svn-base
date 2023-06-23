<?php
/* @var $this NotaController */
/* @var $model Nota */
/* @var $form CActiveForm */
?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'focus' => array($model, 'numero')
    ));
    ?>
    <div class="formWindow">
        <div class="row">
            <div class="column">
                <?php echo $form->labelEx($model, 'idorigen'); ?>
                <?php
                echo $form->dropDownList(
                        $model, 'idorigen', CHtml::listData(Origen::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'),
                        array('style' => 'width: 120px;'));
                ?>
            </div>
            <div class="column">
                <?php echo $form->labelEx($model, 'idalmacen'); ?>
                <?php
                echo $form->dropDownList(
                        $model, 'idalmacen', CHtml::listData(Almacen::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'),
                        array('style' => 'width: 190px;'));
                ?>
            </div>
            <div class="column">
                <?php echo $form->labelEx($model, 'idtipodocumento'); ?>
                <?php
                echo $form->dropDownList(
                        $model, 'idtipodocumento', CHtml::listData(
                                Tipodocumento::model()->findAll(
                                        array('order' => 'nombre',
                                            'condition' => "comun = true"
                                )), 'id', 'nombre')
                        , array('empty' => '','style' => 'width: 120px;'));
                ?>
            </div>

            <div class="column">
                <?php echo $form->labelEx($model, 'idcausa'); ?>
                <?php
                echo $form->dropDownList(
                        $model, 'idcausa', CHtml::listData(
                                Causa::model()->findAll(
                                        array('order' => 'nombre'
                                )), 'id', 'nombre')
                        , array('empty' => ''));
                ?>
            </div>            
            <div class="column">
                <?php echo $form->labelEx($model, 'iddetallenota'); ?> 
                <?php
                echo $form->dropDownList(
                        $model, 'iddetallenota', CHtml::listData(
                                Detallenota::model()->findAll(
                                        array('order' => 'detalle'
                                )), 'id', 'detalle')
                        , array('empty' => '', 'style' => 'text-transform: uppercase; width: 290px;'));
                ?>
            </div>
            <div class="column">
               
                  <?php echo $form->label($model, 'Baja'); ?>
                <?php echo $form->checkBox($model, 'detalle'); ?>  
                
            </div>
              <div class="column">
                <?php echo $form->label($model, 'Cambiar Costo'); ?>
                <?php echo $form->checkBox($model, 'costovariable'); ?>
            </div>    
            
        </div>

        <div style="left: 1068px; top: 81px; visibility: hidden; cursor:pointer;  width:130px; height:20px;  background: #f4ed90; padding-left: 5px; position: absolute;border:1px solid #1d6fb8; border-bottom:none;">
            Disp.: <span style="font-weight: bold;" <?php echo 'id="' . System::Id('divSaldo') . '"'; ?>></span>
        </div>

        <div  class="row">
            <?php
            $model->color = Yii::app()->params['mainColor']['almacen']['light'];
            echo $form->hiddenField($model, 'color');
            
            echo SGridView::widget('TGridView', array(
                'id' => 'Productonota',
                'dataProvider' => $productonota,
                'buttonAdd' => true,
                'eventAfterEdition' => 'Nota.verificarGridInsumos();',
                'buttonText' => '+',
                'height' => 260,
                'columns' => array(
                    array(
                        'name' => 'coduniversal',
                        'typeCol' => 'editable',
                        'width' => 13,
                        'header' => 'Código de barra',
                        'onKeyUp' => 'Nota.BuscaCodigoBarra(this,event);show(k);return false;',
                        'background' => Yii::app()->params['mainColor']['almacen']['light'],
                        'value' => '($data->idproducto0== null) ? "" : $data->idproducto0->coduniversal',
                    ),
                    array(
                        'header' => 'Código',
                        'name' => 'codigo',
                        'width' => 8,
                        'searchUrl' => 'nota/SearchProductoCodigo',
                        'value' => '',
                        'background'=>Yii::app()->params['mainColor']['almacen']['light'],
                        'searchHeight' => 105,
                        'searchWidth' => 600,
                        'value' => '($data->idproducto0== null) ? "" : $data->idproducto0->codigo',
                        'searchCopyCol' => 'nombre,saldo,disponible,idproducto,udd,costo,costoHidden,coduniversal',
                    ),
                    array(
                        'header' => 'Producto',
                        'name' => 'nombre',
                        'searchUrl' => 'nota/SearchProductoNombre',
                        'searchHeight' => 100,
                        'searchWidth' => 600,
                        'width' => 24,
                        'background'=>Yii::app()->params['mainColor']['almacen']['light'],
                        'value' => '($data->idproducto0== null) ? "" : $data->idproducto0->nombre',
                        'searchCopyCol' => 'codigo,saldo,disponible,idproducto,udd,costo,costoHidden,coduniversal',
                    ),
                    array(
                        'header' => 'Glosa',
                        'name' => 'glosa',
                        'background'=>Yii::app()->params['mainColor']['almacen']['light'],
                        'width' => 24,
                        'align' => 'left',
                        'style' => array('text-transform' => 'uppercase'),
                    ),                   
                    array(
                        'header' => 'UDD',
                        'name' => 'udd',
                        'typeCol' => 'uneditable',
                        'width' => 3,
                        'align' => 'right',
                    ),
                    array(
                        'name' => 'cantidad',
                        'width' => 9,
                        'align' => 'right',
                        'type' => 'number',
                        'background'=>Yii::app()->params['mainColor']['almacen']['light'],
                        'searchDefaulfValue' => '0.0000',
                        'validateUrl' => 'nota/validarCantidad',
                        'validateMessage' => 'Excede la cantidad disponible',
                        'footer'=>array('function'=>'sum'),
                    ),
                    array(
                        'name' => 'costo',
                        'width' => 6,
                        'align' => 'right',
                        'type' => 'number',
                        'typeCol' => 'editable(costovar==true)',
                        'value' => '($data->idproducto0== null) ? "" : $data->idproducto0->saldoimporte/$data->idproducto0->saldo',
                    ),
                    array(
                        'name' => 'costoHidden',
                        'type' => 'number(4)',
                        'typeCol' => 'hidden',
                    ),
                    array(
                        'name' => 'costovar',
                        'typeCol' => 'hidden',
                        'value' => 'true',
                    ),
                    array(
                        'name' => 'costototal',
                        'header' => 'Costo total',
                        'width' => 10,
                        'align' => 'right',
                        'type' => 'number',
                        'searchDefaulfValue' => '0.0000',
                        'footer'=>array('function'=>'sum'),
                    ),
                    array(
                        'name' => 'idproducto',
                        'searchIdName' => 'id',
                        'key' => true,
                        'typeCol' => 'hidden',
                    ),
                    array(
                        'name' => 'disponible',
                        'header' => 'Saldo',
                        'typeCol' => 'hidden',                       
                        'align' => 'right',
                        'type' => 'number',
                    ),
                    array(
                        'typeCol' => 'buttons',
                        'width' => 3,
                        'buttons' => array('delete')
                    ),
                ),
            ));
            ?>           
        </div>   
        <div class="row">            
                <?php echo $form->labelEx($model, 'glosa'); ?>
                <?php echo $form->textArea($model, 'glosa', array('rows' => 1, 'style' => 'text-transform: uppercase; width: 1180px;')); ?>
        </div>  
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Nota',
        'buttons' => array()
    ));
    ?> 
    <?php $this->endWidget(); ?>
</div><!-- form -->
