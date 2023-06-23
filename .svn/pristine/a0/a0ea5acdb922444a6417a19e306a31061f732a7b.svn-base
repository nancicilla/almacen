<?php
/* @var $this ProductoController */
/* @var $model Producto */

echo System::Search(array(
    'title' => 'Administración de Productos',
    'formSearch' => $this->renderPartial('_searchDetallado', array('model' => $model,), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],    
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admProductoDetallado',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'codigo',
                'split' => false,
                'value' => '$data->movimiento > 0? "<div class=\'classErrorMovimientos\'>$data->codigo</div>" : $data->codigo ',                
                'width' => 10,
            ),
            array(
                'name' => 'nombre',
                'width' => 49,
            ),
            array(
                'name' => 'idunidad',
                'width' => 4,
                'header' => 'Udd',
                'value' => '$data->idunidad0->simbolo',
            ),
            array(
                'name' => 'idalmacen',
                'width' => 12,
                'header' => 'Almacén',
                'value' => '$data->idalmacen0->nombre',
            ),
            array(
                'name' => 'usuario',
                'width' => 10,
            ),
            array(
                'name' => 'fecha',
                'type' => 'date',
                'width' => 10,
            ),
            array('typeCol' => 'buttons',
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'width' => 5,
                'buttons' => array(
                    'OtrosGastos' => array(
                        'label' => 'Ver Movimientos',
                        'icon' => 'tasks',
                        'click' =>'                                                        
                        function(){
                            SGridView.selectRow(this);
                            admProductoDetallado.MovimientosProducto();
                            return false;
                        }',
                    ),
                ),
            ),
        ),
            )
    )
        )
);
