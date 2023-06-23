<div class="row">
    <?php
    echo SGridView::widget('TGridView', array(
        'id' => 'ProductoLote',
        'dataProvider' => $productolote,
        'buttonAdd' => false,
        'buttonText' => '+',
        'height' => 177,
        'columns' => array(
            array(
                'name' => 'id',
                'typeCol' => 'hidden',
                'width' => 12,
            ),
            array(
                'name' => 'numerocompra',
                'value' => '$data->idcompra0->numero',
                'typeCol' => 'uneditable',
                'width' => 12,
            ),
            array(
                'name' => 'numerolote',
                'value' => '$data->numerolote',
                'typeCol' => 'uneditable',
                'width' => 12,
            ),
            array(
                'name' => 'fechacompra',
                'value' => '$data->idcompra0->fecha',
                'typeCol' => 'uneditable',
                'type' => 'date',
                'width' => 12,
                'align' => 'center',
            ),
            array(
                'name' => 'fechavencimiento',
                'typeCol' => 'uneditable',
                'width' => 12,
                'type' => 'date',
                'align' => 'center',
            ),
            array(
                'name' => 'cantidad',
                'typeCol' => 'uneditable',
                'width' => 12,
                'align' => 'right',
            ),
            array(
                'name' => 'saldo',
                'typeCol' => 'uneditable',
                'width' => 11,
                'value' => '$data->saldo',
                'align' => 'right',
            ),
            array(
                'name' => 'estado',
                'typeCol' => 'uneditable',
                'width' => 12,
                'value' => '$data->idestado0->nombre',
                'align' => 'center',
            ),
            array(
                'header' => 'Control',
                'name' => 'color',
                'width' => 8,
                'split' => false,
                'value' => '($data->idestado==Estado::ANULADO||$data->idestado==Estado::CERRADO)?"<span class=\'label \' style=\'width:93%;background-color: #111;\'>&nbsp;</span>":'
                . '"<span class=\'label \' style=\'width:93%;background-color: ".$data->color.";\'>&nbsp;</span>"',
            ),
            array('typeCol' => 'buttons',
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'width' => 8,
                'buttons' => array(
                    'editar' => array(
                        'visible' => '$data->idestado==Estado::VIGENTE?true:false',
                        'label' => 'Editar Lote',
                        'icon' => 'icon-pencil',
                        'click' => '                                                        
                                            function(){
                                                SGridView.selectRow(this);
                                                Vencimiento.editar();
                                                return false;
                                            }',
                    ),
                    'cerrar' => array(
                        'label' => 'Cerrar Lote',
                        'icon' => 'icon-lock',
                        'click' => '                                                        
                                            function(){
                                                SGridView.selectRow(this);
                                                Vencimiento.cerrar();
                                                return false;
                                            }',
                    ),
                    'anular' => array(
                        'label' => 'Anular Lote',
                        'icon' => 'icon-remove',
                        'click' => '                                                        
                                            function(){
                                                SGridView.selectRow(this);
                                                Vencimiento.anular();
                                                return false;
                                            }',
                    ),
                ),
            )
        ),
    ));
    ?>
</div>