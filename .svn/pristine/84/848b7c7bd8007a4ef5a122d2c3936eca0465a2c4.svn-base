<?php

/* @var $this ProductoController */
/* @var $model Producto */

echo System::Search(array(
    'title' => 'Inventariar Productos',
    'formSearch' => $this->renderPartial('_searchInventariar', array('model' => $model), true),
    'heightSearch' => 525,
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admInventariar',
        'dataProvider' => $model->inventariar(),
        'height' => 525,
        'columns' => array(            
            array(
                'name' => 'codigo',
                'width' => 10,
                'typeCol' => 'uneditable'
            ),
            array(
                'name' => 'nombre',
                'width' => 55,
                'typeCol' => 'uneditable'
            ),
            array(
                'name' => 'idunidad',
                'value' => '$data->idunidad0->simbolo',
                'width' => 5,
            ),
            array(
                'name' => 'idalmacen',
                'width' => 20,
                'typeCol' => 'uneditable',
                'value' => '$data->idalmacen0->nombre',
            ),
            array(
                'name' => 'inventariar',
                'width' => 10,
                'align' => 'center',
                'typeCol' => 'checkbox',
                'click' => 'function () {
                    SGridView.selectRow(this);
                    admInventariar.Inventariar(this.checked);
                }'
            )
        ),
))));
