<?php

/* @var $this CaracteristicasController */
/* @var $model Caracteristicas */

echo System::Search(array(
    'title' => 'Administración de Caracteristicas',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admCaracteristicas',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
           
		array(
		'name' => 'nombre',
		'width' => 40,
		),
		
		array(
		'name' => 'paraenvase',
                'value'=>'$data->paraenvase==true?"Si":"No"',
		'width' => 20,
		),
                array(
		'name' => 'usuario',
		'width' => 10,
		),
		array(
		'name' => 'fecha',
		'width' => 10,
		'value'=>' date ("d-m-Y",strtotime( $data->fecha))',
		), 
		/*
		array(
		'name' => 'idcaracteristicapadre',
		'width' => 30,
		),
		array(
		'name' => 'usuario',
		'width' => 30,
		),
		*/
		/*   
                  
		*/
                array('typeCol' => 'buttons',
                    'width' => 20,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                    
                                     'actualizar' => array(
                                         'visible' => ' Caracteristicas::model()->MostrarActualizar(SeguridadModule::enc($data->getPrimaryKey())) ',
                                        
                    'click' => 'function () {SGridView.selectRow(this);'
                                         . ' admCaracteristicas.ActualizarCaracteristica(); return false;}', 'icon' => 'pencil', 'label' => 'Modificar'),
                        'delete' => array('label' => 'Eliminar','visible' => ' Caracteristicas::model()->MostrarActualizar(SeguridadModule::enc($data->getPrimaryKey())) ',
                                        ),
                                    ),
		),
	),
    ))
));

