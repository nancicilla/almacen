<?php
/*
 * _suplementario.php
 *
 * Version 0.$Rev: 270 $
 *
 * Creacion: 30/01/2015
 *
 * Ultima Actualizacion: $Date: 2015-10-15 12:18:10 -0400 (jue 15 de oct de 2015) $
 *
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 */
?>
<?php
echo SGridView::widget('TGridView', array(
    'id' => 'productoComplementario',
    'dataProvider' => $productoComplementario,
    'buttonAdd' => true,
    'buttonText' => '+',
    'height' => 260,
    'columns' => array(
        array('name' => 'codigo',
            'width' => 10,
            'header' => 'Código',
            'searchUrl' => 'producto/SearchProductoCodigo',
            'searchHeight' => 105,
            'searchWidth' => 600,
            'value' => '($data->idcomplementario0== null) ? "" : $data->idcomplementario0->codigo'
        ),
        array('name' => 'nombre',
            'searchUrl' => 'producto/SearchProductoNombre',
            'searchHeight' => 100,
            'searchWidth' => 600,
            'width' => 67,
            'header' => 'Producto',
            'value' => '($data->idcomplementario0== null) ? "" : $data->idcomplementario0->nombre'
        ),
        array('name' => 'almacen',
            'width' => 20,
            'header' => 'Almacén',
            'value' => '$data->idcomplementario0->idalmacen0->nombre',
            'typeCol' => 'uneditable',
        ),
        array('name' => 'idcomplementario',
            'searchIdName' => 'id',
            'key' => true,
            'typeCol' => 'hidden',
        ),
        array('typeCol' => 'buttons',
            'width' => 3,
            'buttons' => array('delete')
        ),
    ),
));
?>
</div>
