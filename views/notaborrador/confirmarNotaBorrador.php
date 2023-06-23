<?php
/* @var $this OrdenController */
/* @var $model Orden */
/* @var $form CActiveForm */
?>
<style>
    #dato { 
        font-family: arial;
        color: black;
        font-weight: bold;
    }
    
    #valores {
        color: black;
    }
    
    #pGlosa {
        left: 107px;
        position: absolute;
    }
</style>

<div class="container">
    
    
    <div class="offset-12">
        <div style="padding: 5px;" id="content">            
             <div class="form">
                <?php $form=$this->beginWidget('CActiveForm'); ?>
                    <div class="formWindow">
                        <div class="row">
                            <div class="column">
                                <?php 
                                    echo $form->hiddenField($model, 'id');
                                    echo '<font id="dato">'.'Nº: '.'</font>'.'<br>';
                                    echo '<font id="dato">'.'Orígen: '.'</font>'.'<br>';
                                    echo '<font id="dato">'.'Almacén: '.'</font>'.'<br>';
                                    echo '<font id="dato">'.'Documento: '.'</font>'.'<br>';
                                ?>
                            </div>
                            <div class="column">
                                <?php 
                                    echo '<p id="valores">'.$model->numero.'</p>';
                                    echo '<p id="valores">'.$origen->nombre.'</p>';
                                    echo '<p id="valores">'.$almacen->nombre.'</p>';
                                    echo '<p id="valores">'.$documento->nombre.'</p>';
                                ?>
                            </div>
                            
                            <div style="left: 370px; position: absolute;">
                                <div class="column">
                                    <?php
                                        echo '<font id="dato">'.'Fecha: '.'</font>'.'<br>';
                                        echo '<font id="dato">'.'Usuario: '.'</font>'.'<br>';
                                    ?>
                                </div>
                                <div class="column">
                                    <?php
                                        echo '<p id="valores">'.$model->fecha.'</p>';
                                        echo '<p id="valores">'.$model->usuario.'</p>';
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="column">
                                <?php
                                    echo '<font id="dato">'.'Glosa: '.'</font>'.'<br>';
                                ?>
                            </div>
                                <?php
                                    echo '<p id="pGlosa">'.$model->glosa.'</p>';
                                ?>
                        </div>

                        <div class="row">
                            <?php
                            echo SGridView::widget('TGridView', array(
                            'id' => 'Producto',
                            'dataProvider' => $productonotaborrador,
                            'buttonAdd' => false,
                            'eventAfterEdition' => 'Orden.validarCantidadDevolucion();',
                            'buttonText' => '+',
                            'height' => 177,
                            'columns' => array(
                                array(
                                    'name' => 'codigo',
                                    'value' => '$data->codigo',
                                    'typeCol' => 'uneditable',
                                    'width' => 12,
                                ),
                                array(
                                    'name' => 'nombre',
                                    'value' => '$data->nombre',
                                    'typeCol' => 'uneditable',
                                    'width' => 60,
                                ),
                                /*array(
                                    'name' => 'glosa',
                                    'typeCol' => 'uneditable',
                                    'width' => 40,
                                ),*/
                                array(
                                    'name' => 'ingreso',
                                    'typeCol' => 'uneditable',
                                    'width' => 12,
                                ),
                                array(
                                    'name' => 'salida',
                                    'typeCol' => 'uneditable',
                                    'width' => 12,
                                ),
                            ),
                        ));
                            ?>
                        </div>    
                     </div>
                    <?php
                        echo System::Buttons(
                            array(
                                'nameView' => 'Notaborrador',
                                'buttons' => array(
                                    'back' => array(
                                        'align' => 'right', 
                                        //'width' => '100px', 
                                        'label' => 'Salir', 
                                        'icon' => 'arrow-left',
                                        'click' => 'Notaborrador.closeWindow(this)',
                                    ),
                                )
                            )
                        );
                    ?>
                <?php $this->endWidget(); ?>
                
             </div><!-- form -->
        </div>
    </div>
</div>
