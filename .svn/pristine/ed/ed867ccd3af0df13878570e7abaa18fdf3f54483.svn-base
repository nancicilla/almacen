<?php
/* @var $this TemporadaController */
/* @var $model Temporada */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
        <div class="row">
            <?php 
                echo $form->labelEx($model,'nombre');
                echo $form->textField($model, 'nombre', 
                array(
                    'maxlength' => 1000, 
                    'style' => ' width: 300px; text-transform: uppercase;',
                ));
            ?>
        </div>
        
        <div class="row">
            <?php
                echo $form->labelEx($model,'descripcion');
                echo $form->textArea($model, 'descripcion', 
                array(
                    'style' => 'width: 90%; text-transform: uppercase;', 'rows' => 2,
                ));
            ?>
        </div>
        
        <div class="row">
            <?php
                echo SGridView::widget('TGridView', array(
                    'id' => 'gridTemporadaproducto',
                    'dataProvider' => $gridTemporadaproducto,
                    'buttonAdd' => true,
                    'buttonText' => '+',
                    'height' => 280,
                    'eventAfterEdition' => 'Temporada.verificarHabilitacionVentaTPV();',
                    'eventAfterEditionAutomatic' => true,
                    'columns' => array(
                        array(
                            'name' => 'id',
                            'typeCol' => 'hidden'
                        ),
                        array(
                            'name' => 'idproducto',
                            'key' => true,
                            'typeCol' => 'hidden',
                        ),
                        array(
                            'name' => 'codigo',
                            'typeCol' => 'editable',
                            'width' => 13,
                            'header' => 'Código',
                            'searchUrl' => 'producto/Buscar_ProductoCodigo',
                            'searchHeight' => 160,
                            'searchWidth' => 600,
                            'nextFocus' => '[row]pedido',
                            'searchCopyCol' => 'idproducto,nombre,idunidad,ventatpvHidden',
                            'background' => Yii::app()->params['mainColor']['almacen']['light'],
                            'value' => '$data->idproducto0->codigo',
                        ),
                        array(
                            'header' => 'Nombre',
                            'name' => 'nombre',
                            'searchUrl' => 'producto/Buscar_ProductoCodigo',
                            'searchHeight' => 150,
                            'searchWidth' => 600,
                            'width' => 62,
                            'background' => Yii::app()->params['mainColor']['almacen']['light'],
                            'searchCopyCol' => 'idproducto,codigo,idunidad,ventatpvHidden,ventatpv',
                            'value' => '$data->idproducto0->nombre',
                        ),
                        array(
                            'header' => 'Udd',
                            'name' => 'idunidad',
                            'width' => 4,
                            'value' => '$data->idproducto0->idunidad0->simbolo',
                            'typeCol' => 'uneditable',
                            'align' => 'right',
                        ),
                        array(
                            'name' => 'pedido',
                            'width' => 8,
                            'align' => 'right',
                            'type' => 'number(23,2)',
                            'nextFocus' => '[row+1]pedido',
                            'background' => Yii::app()->params['mainColor']['almacen']['light'],
                            'typeCol' => 'editable'
                        ),
                        array(
                            'name' => 'ventatpvHidden',
                            'value' => '$data->idproducto0->ventatpv',
                            'typeCol' => 'hidden',
                        ),
                        array(
                            'header' => 'Venta en TPV',
                            'name' => 'ventatpv',
                            'typeCol' => 'checkbox',
                            'style' => array('text-align '=> 'center','font-weight' => 'bold'),
                            'width' => 10,
                            'value' => '$data->idproducto0->ventatpv',
                        ),
                        array(
                            'typeCol' => 'buttons',
                            'width' => 3,
                            'buttons' => array('delete')
                        )
                    )
                ));
            ?>
        </div>
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Temporada',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->