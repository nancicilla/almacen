 <?php

echo SGridView::widget('TGridView', array(
        'id' => 'gridProveedores',
        'dataProvider' => $listaproveedores,       
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
                'header' => 'Proveedor',
                'name' => 'nombre',
                'searchUrl' => 'proveedor/BuscarProveedor',
                'searchCopyCol' => 'id',
                'searchHeight' => 100,
                'searchWidth' => 200,
                'value' => '$data->nombre == null? "" : $data->nombre',
                'width' => 20,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',
                
            ),
            
                   
                array(
                'width' => 4,
                'typeCol' => 'buttons',
                'buttons'=>array('delete'),
                
            ),

           
        ),
    ));

?>

