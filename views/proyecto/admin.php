<?php

/* @var $this ProyectoController */
/* @var $model Proyecto */

echo System::Search(array(
    'title' => 'Administración de Proyectos',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admProyecto',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 45,
		),
		
                array(
                'name'=>'fechainicio',
                'type' => 'date', 
                'value'=>'date ("d-m-Y",strtotime( $data->fechainicio))',
                'width'=> 10,
                ),
		array(
		'name' => 'fechafin',
                'value'=>' $data->fechafin!= null?  date ("d-m-Y",strtotime( $data->fechafin)):""',
                'width'=> 10,
		
		),
		array(
		'name' => 'itemensistema',
                'value'=>' $data->itemensistema==0? "No":"Si"',
                   
		'width' => 15,
		),
		/*
		array(
		'name' => 'enenvase',
		'width' => 30,
		),
		array(
		'name' => 'numero',
		'width' => 30,
		),
		array(
		'name' => 'usuario',
		'width' => 30,
		),
		*/
		/*   
                array(
                'name'=>'fecha',
                'type' => 'datetime', 
                'width'=> 30,
                ),    
		*/
                array('typeCol' => 'buttons',
                    'width' => 30,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                    'update' => array('label' => 'Modificar'),
                                       'asociarcaracteristicas' => array(
                                         
                    'click' => 'function () {SGridView.selectRow(this);'
                                         . ' admProyecto.Asociar(); return false;}',
                                           'icon' => 'list', 'label' => 'Registrar Informacion'),
                    'Imprimir' => array('url' => 'array("imprimirReporte","id"=>SeguridadModule::enc($data->getPrimaryKey()))', 'label' => 'Imprimir Reporte',
                        
                     'icon' => 'print', 'options' => array('target' => '_blank')),
                        
                                    'delete' => array('label' => 'Eliminar',
                                    'visible' => 'Proyecto::model()->MostrarEliminar(SeguridadModule::enc($data->getPrimaryKey())) ',
                                ),
                                    ),
		),
	),
    ))
));

