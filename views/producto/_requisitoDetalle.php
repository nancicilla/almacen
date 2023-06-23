<?php
    if($model->requisito == 1)
        echo '<font style="color: red; font-size: 15px; font-weight: bold; left: 150px; top: 240px; position: absolute;">PRODUCTO SIN REQUISITOS....</font>';
    else
        echo SGridView::widget('TGridView', array(
            'id' => 'gridRequisito',
            'dataProvider' => $gridRequisito,
            'buttonAdd' => true,
            'buttonText' => '+',
            'height' => 230,
            'eventAfterEditionAutomatic' => true,
            'columns' => array(
                array(
                    'name' => 'id',
                    'key' => true,
                    'value' => '$data->idrequisito',
                    'typeCol' => 'hidden'
                ),
                array(
                    'header' => 'Requisito',
                    'name' => 'nombre',
                    'searchUrl' => 'producto/BuscarRequisito()',
                    'value' => '$data->idrequisito0->nombre',
                    'searchHeight' => 150,
                    'searchWidth' => 650,
                    'width' => $model->aumentarColumna == 'true'? 73 : 82,
                    'background' => Yii::app()->params['mainColor']['almacen']['light'],
                ),
                array(
                    'header' => $model->aumentarColumna == 'true'? 'Primera <br>Calidad(%)' : 'Parámetros de <br>Aceptación',
                    'name' => 'primera',
                    'width' => $model->aumentarColumna == 'true'? 12 : 15,
                    'align' => 'left',
                    'background' => Yii::app()->params['mainColor']['almacen']['light'],
                    'groupTitle' => $model->aumentarColumna == 'true'? array('hearder'=>'Parámetros de Aceptación','colspan'=>2) : array('hearder'=>'RECEPCIÓN','colspan'=>0),
                    'typeCol' => 'contenteditable',
                ),
                array(
                    'header' => 'Segunda <br>Calidad(%)',
                    'name' => 'segunda',
                    'width' => $model->aumentarColumna == 'true'? 12 : 0,
                    'align' => 'left',
                    'background' => Yii::app()->params['mainColor']['almacen']['light'],
                    'typeCol' => $model->aumentarColumna == 'true'? 'contenteditable' : 'hidden',// '($data->segunda == ""? "hidden" : "editable" )',
                ),
                array(
                    'typeCol' => 'buttons',
                    'width' => 3,
                    'buttons' => array('delete')
                )
            )
        ));
?>