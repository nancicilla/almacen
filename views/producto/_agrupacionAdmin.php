<?php

echo System::Search(array(
    'title' => 'Administración de Productos Agrupados',
    'formSearch' => $this->renderPartial('_agrupacionSearch', array('model' => $model,), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],    
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admAgrupacion',
        'dataProvider' => $model->searchAgrupacion(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'coduniversal',
                'width' => 12,
            ),
            array(
                'name' => 'codigo',
                'width' => 10,
            ),
            array(
                'name' => 'nombre',
                'width' => 36,
            ),
            array(
                'name' => 'idunidad',
                'width' => 4,
                'header' => 'Udd',
                'value' => '$data->idunidad0->simbolo',
            ),
            array(
                'name' => 'pesopromedio',
                'width' => 8,
                'align' => 'center',
            ),
            array(
                'name' => 'idalmacen',
                'width' => 9,
                'header' => 'Almacén',
                'value' => '$data->idalmacen0->nombre',
               
            ),
            array(
                'name' => 'usuario',
                'width' => 7,
            ),
            array(
                'name' => 'fecha',
                'type' => 'date',
                'width' => 9,
            ),
            array('typeCol' => 'buttons',
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'width' => 5,
                'buttons' => array(
                    'modificar' => array(
                        'label' => 'Modificar',
                        'icon' => 'icon-pencil',
                        'click' =>'                                                        
                        function(){
                            SGridView.selectRow(this);
                            admAgrupacion.AgrupacionProductoUpdate();
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
