 <?php

echo SGridView::widget('TGridView', array(
        'id' => 'gridEquipo',
        'dataProvider' => $listapersonal,       
         'buttonAdd' => true,
        'buttonText' => '+',        
        'height' => 260,
        'eventAfterEditionAutomatic' => true,
        'specialCellEditionMode' => false,
        'columns' => array(           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
            ),
             array(
                'header' => 'Nombre Completo',
                'name' => 'nombrecompleto',
                'searchUrl' => 'personal/BuscarPersonal',
                'searchCopyCol' => 'id',
                'searchHeight' => 100,
                'searchWidth' => 200,
                'value' => '$data->nombrecompleto == null? "" : $data->nombrecompleto',
                'width' => 20,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',
                
            ),
            
             array(
                    'header'=>'Seleccionar Encargado',
                    'name' => 'esencargado',
                    'width' => 10,
                    'typeCol' => 'checkbox',

                    ),
             
             
                array(
                'width' => 4,
                'typeCol' => 'buttons',
                'buttons'=>array('delete'),
                
            ),

           
        ),
    ));

?>
