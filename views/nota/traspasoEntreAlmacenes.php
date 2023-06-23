<?php
/* @var $this OrdenController */
/* @var $model Orden */
/* @var $form CActiveForm */
?>
<div class="container">
    <div class="offset-12">
        <div style="padding: 5px;" id="content">
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm');
                ?>
                <div class="formWindow">
                    
                    <div class="row">
                        <div class="column">
                            <div class="row">
                                <?php echo $form->labelEx($model, 'idalmacenorigen'); ?>
                                <?php
                                echo $form->dropDownList(
                                        $model, 'idalmacenorigen', CHtml::listData(Almacen::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'));
                                ?>
                            </div> 
                            <div style="left: 420px; top: 86px; cursor:pointer;  width:170px; height:20px;  background: #f4ed90; padding-left: 5px; position: absolute;border:1px solid #1d6fb8; border-bottom:none;">
                                Disponible: <span style="font-weight: bold;" <?php echo 'id="' . System::Id('divSaldo') . '"'; ?>></span>
                            </div>
                            <div class="row">
                                <?php
                                echo SGridView::widget('TGridView', array(
                                    'id' => 'ProductosTraspasoOrigen',
                                    'dataProvider' => $productostraspasoorigen,
                                    'buttonAdd' => true,
                                    'eventAfterEdition' => 'TraspasoEntreAlmacenes.verificarGridInsumos();',
                                    'buttonText' => '+',
                                    'height' => 195,
                                    'width' => 580,
                                    'columns' => array(
                                        array('name' => 'idproducto',
                                            'searchIdName' => 'id',
                                            'key' => true,
                                            'typeCol' => 'hidden',
                                        ),
                                        array('name' => 'disponible',
                                            'typeCol' => 'hidden',
                                            'align' => 'right',
                                            'type' => 'number',
                                        ),
                                        array('name' => 'codigo',
                                            'width' => 15,
                                            'header' => 'Código',
                                            'searchUrl' => 'nota/SearchProductoCodigo_traspAlmac',
                                            'background'=>Yii::app()->params['mainColor']['almacen']['light'],
                                            'value' => '',
                                            'searchHeight' => 105,
                                            'searchWidth' => 600,
                                            'value' => $model->pedidoEspecial == true? '' : '($data->idproducto0== null) ? "" : $data->idproducto0->codigo',
                                            'searchCopyCol' => 'nombre,saldo,disponible,idproducto,costo,costoHidden,udd',
                                        ),
                                        array('name' => 'nombre',
                                            'searchUrl' => 'nota/SearchProductoNombre_traspAlmac',
                                            'background'=>Yii::app()->params['mainColor']['almacen']['light'],
                                            'searchHeight' => 100,
                                            'searchWidth' => 600,
                                            'width' => 50,
                                            'header' => 'Producto',
                                            'value' => $model->pedidoEspecial == true? '' : '($data->idproducto0== null) ? "" : $data->idproducto0->nombre',
                                            'searchCopyCol' => 'codigo,saldo,disponible,idproducto,costo,costoHidden,udd',
                                        ),
                                        array('name' => 'cantidad',
                                            'width' => 10,
                                            'align' => 'right',
                                            'value' => $model->pedidoEspecial == true? '$data->cantidad' : '',
                                            'type' => 'number',
                                            'background'=>Yii::app()->params['mainColor']['almacen']['light'],
                                            'searchDefaulfValue' => '0.0000',
                                            'validateUrl' => 'nota/validarCantidad',
                                            'validateMessage' => 'Excede la cantidad disponible',
                                        ),
                                        array(
                                            'name' => 'costo',
                                            'width' => 13,
                                            'align' => 'right',
                                            'type' => 'number(4)',
                                            'typeCol' => 'uneditable',
                                        ),
                                        array('name' => 'udd',
                                            'width' => 7,
                                            'header' => 'UDD',
                                            'typeCol' => 'uneditable',
                                            'align' => 'right',
                                        ),                              

                                       
                                        array('typeCol' => 'buttons',
                                            'width' => 5,
                                            'buttons' => array('delete')
                                        ),
                                    ),
                                ));
                                ?>           
                            </div>  
                        </div>
                                         
                        <div style="width:520px;" class="column">
                            <div class="row">
                                <?php echo $form->labelEx($model, 'idalmacendestino'); ?>
                                <?php
                                echo $form->dropDownList(
                                    $model, 'idalmacendestino', 
                                    CHtml::listData(Almacen::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'), 
                                    array('disabled' => $model->pedidoEspecial == true? true : false)
                                );
                                ?>
                            </div>
                            <div  class="row">
                                <?php
                                echo SGridView::widget('TGridView', array(
                                    'id' => 'ProductosTraspasoDestino',
                                    'dataProvider' => $productostraspasodestino,
                                    'buttonAdd' => $model->pedidoEspecial == true? false : true,
                                    'buttonText' => $model->pedidoEspecial == true? '' : '+',
                                    'height' => 195,
                                    'columns' => array(                                
                                        array('name' => 'idproducto',
                                            'searchIdName' => 'id',
                                            'key' => true,
                                            'typeCol' => 'hidden',
                                        ),
                                        array('name' => 'disponible',
                                            'typeCol' => 'hidden',
                                            'align' => 'right',
                                            'type' => 'number',
                                        ),
                                        array('name' => 'codigo',
                                            'width' => 15,
                                            'header' => 'Código',
                                            'searchUrl' => $model->pedidoEspecial == true? '' : 'nota/SearchProductoCodigo_traspAlmac',
                                            'background' => $model->pedidoEspecial == true? '' : Yii::app()->params['mainColor']['almacen']['light'],
                                            'typeCol' => $model->pedidoEspecial == true? 'uneditable' : 'editable',
                                            'searchHeight' => 105,
                                            'searchWidth' => 600,
                                            'value' => $model->pedidoEspecial == true? '$data->codigo' : '($data->idproducto0== null) ? "" : $data->idproducto0->codigo',
                                            'searchCopyCol' => 'nombre,saldo,disponible,idproducto,costo,costoHidden,udd',
                                        ),
                                        array('name' => 'nombre',
                                            'searchUrl' => $model->pedidoEspecial == true? '' : 'nota/SearchProductoNombre_traspAlmac',
                                            'background' => $model->pedidoEspecial == true? '' : Yii::app()->params['mainColor']['almacen']['light'],
                                            'typeCol' => $model->pedidoEspecial == true? 'uneditable' : 'editable',
                                            'searchHeight' => 100,
                                            'searchWidth' => 600,
                                            'width' => 60,
                                            'header' => 'Producto',
                                            'value' => $model->pedidoEspecial == true? '$data->nombre' : '($data->idproducto0== null) ? "" : $data->idproducto0->nombre',
                                            'searchCopyCol' => 'codigo,disponible,idproducto,costo,costoHidden,udd',
                                        ),
                                        array(
                                            'name' => 'costo',
                                            'width' => 13,
                                            'value' => $model->pedidoEspecial == true? '$data->costo' : '',
                                            'align' => 'right',
                                            'type' => 'number(4)',
                                            'background'=>Yii::app()->params['mainColor']['almacen']['light'],
                                        ),
                                        array(
                                            'name' => 'costoHidden',
                                            'type' => 'number(4)',
                                            'typeCol' => 'hidden',
                                        ),
                                        array('name' => 'udd',
                                            'width' => 7,
                                            'header' => 'UDD',
                                            'typeCol' => 'uneditable',
                                            'align' => 'right',
                                        ),     
                                        array('typeCol' => 'buttons',
                                            'width' => 5,
                                            'buttons' => $model->pedidoEspecial == true? '' : array('delete')
                                        ),
                                    ),
                                ));
                                ?>           
                            </div> 
                        </div>
                            
                        
                    </div>   
                    <div class="row">           
                            <?php echo $form->labelEx($model, 'glosa'); ?>
                            <?php echo $form->textArea($model, 'glosa', array('rows' => 1, 'style' => 'text-transform: uppercase; width: 650px;')); ?>
                    </div>
                </div>     
<?php
echo System::Buttons(array(
    'nameView' => 'TraspasoEntreAlmacenes',
    'buttons' => array(
    ),
)
);
?> 
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>