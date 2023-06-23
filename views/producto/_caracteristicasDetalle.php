<?php
$columns = array(                
        array(
            'header' => 'Característica',
            'name' => 'nombrecaracteristica',
            'searchUrl' => 'caracteristica/generalBuscarPadre(mostrarAutocomplete=="")',
            'value' => '$data->nombrecaracteristica',            
            'searchIdName' => 'nombrecaracteristica',
            'searchCopyCol' => 'idcaracteristica,idhidden=2,tienehijo,nombresubcaracteristica=,idsubcaracteristica=,valor=',
            'searchHeight' => 100,
            'searchWidth' => 300,
            'width' => 30,            
            'typeCol' => 'uneditable',
        ),
        array(
            'name' => 'mostrarAutocomplete',
            'value' => '1',
            'typeCol' => 'hidden',
        ),
        array(
            'name' => 'idcaracteristica',
            'typeCol' => 'hidden',
            'value' => '$data->id == null? $data->idcaracteristica : $data->id ',
        ),
        array(
            'name' => 'idhidden',
            'typeCol' => 'hidden',
            'value' => '1',
        ),
        array(
            'name' => 'enviar',
            'key' => true,
            'typeCol' => 'hidden',
            'value' => $model->scenario == 'insert'? '1' : '',
        ),
        array(
            'name' => 'tienehijo',
            'typeCol' => 'hidden',
            'value' => '$data->idsubcaracteristica == null? "" : 1 ',
        ),
        array(
            'header' => 'SubCaracterística',
            'name' => 'nombresubcaracteristica',
            //'searchUrl' => 'caracteristica/generalBuscarHijo(tienehijo==1)',
            'searchUrl' => 'caracteristica/generalBuscarHijo(mostrarAutocomplete=="")',
            'value' => '$data->nombresubcaracteristica',
            'searchIdName' => 'nombresubcaracteristica',
            'searchCopyCol' => 'idsubcaracteristica',
            'searchHeight' => 100,
            'searchWidth' => 300,
            'width' => 20,
            //'validateUrl'=>'producto/validarsubcaracteristica',
            'validateMessage'=>'Debe seleccionar una subcaracteristica'
        ),
        array(
            'name' => 'idsubcaracteristica',
            'typeCol' => 'hidden',
            'value' => '$data->idsubcaracteristica',
        ),
        array(
            'header' => 'Descripción',
            'name' => 'valor',
            //'typeCol' => 'editable((tienehijo==1 && nombresubcaracteristica != "")||(tienehijo==0 && idcaracteristica!=null))',
            'width' => 50,
            'validateMessage'=>'Debe introducir un valor',
            'background' => '#EAADA0',
            'typeCol' => 'contenteditable',
//            'style' => array('text-transform' => 'uppercase')
        ),
        array(
            'name' => 'valorOculto',
            'value' => '$data->valor',
            'typeCol' => 'hidden',
        ),
       /*array('typeCol' => 'buttons',
             'width' => 4,
             'buttons' => array(
                 'agregar' => array('click' => 'function() {
                                    SGridView.selectRow(this);
                                    Producto.agregarfilaabajo();
                                    return false;
                                   }',
                                'label'=>'Agregar Nueva Fila Abajo',
                                'icon' => 'plus-sign'),                                      
                    //'delete'
                )
            )*/
       );

        $create = true;
        echo  SGridView::widget('TGridView', array(
                'id' => 'Productocaracteristica',
                'dataProvider' => $productoCaracteristica,
                'eventAfterEdition' => 'Producto.copiarInformacion();',
                'eventAfterEditionAutomatic' => true,
                'ableAddRow' => $create,
                //'buttonAdd' => $create,
                //'buttonText'=>'+',
                'specialCellEditionMode' => true,
                //'defaultNumberRows'=>10,
                'height' => 260,
                    'columns'=>$columns,
     ));
?>