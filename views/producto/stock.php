<?php
/* @var $this ProductoController */
/* @var $model Producto */

echo System::Search(array(
    'title' => 'Stock de Productos',
    'formSearch' => $this->renderPartial('_searchStock', array('model' => $model,), true),
    'buttons' => array(
        array('name' => 'print', 'icon' => 'print', 'widthLinks' => 100,
            'links' => array(
                array('icon' => 'print', 'url' => 'reporteProductoStock', 'title' => 'Stock PDF'),
                array('icon' => 'print', 'url' => 'reporteProductoStockExcel', 'title' => 'Stock EXCEL')
            )
        )
    ),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admStock',
        'dataProvider' => $model->searchStock(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'codigo',
                'width' => 10,
            ),
            array(
                'name' => 'nombre',
                'width' => 26,
            ),
            array(
                'name' => 'idunidad',
                'value' => '$data->idunidad0->simbolo',
                'width' => 5,
            ),
            array(
                'width' => 12,
                'name' => 'idalmacen',
                'value' => '$data->idalmacen0->nombre',
            ),            
            array(
                'width' => 15,
                'name' => 'saldo',
                'align' => 'right', 'type' => 'number', // le da el formato de número decimal
            ),
            array(
                'name' => 'reserva',
                'width' => 15,
                'align' => 'right', 'type' => 'number', // le da el formato de número decimal
            ),
            array(
                'name' => 'disponible',
                'width' => 15,
                'value' => '$data->saldo-$data->reserva',
                'align' => 'right', 'type' => 'number',
            ),
            array('typeCol' => 'buttons',
                'width' => 2,
                'buttons' => array(                    
                    'solicitar' => array(                       
                        'click' => 'function() '
                        . '{'
                         .'SGridView.selectRow(this);
                            admStock.registrarSolicitud();
                            return false;}',
                        'icon' => 'shopping-cart'),
                ),
            ),
        ),
            )
)));
?>
