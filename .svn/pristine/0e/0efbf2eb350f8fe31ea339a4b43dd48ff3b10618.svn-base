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
                                    echo '<font id="dato">'.'Código de Barra: '.'</font>'.'<br>';
                                    echo '<font id="dato">'.'Código: '.'</font>'.'<br>';
                                    echo '<font id="dato">'.'Producto: '.'</font>'.'<br>';
                                    echo '<font id="dato">'.'Stock: '.'</font>'.'<br>';
                                ?>
                            </div>
                            <div class="column">
                                <?php 
                                    echo '<p id="valores">'.$model->coduniversal.'</p>';
                                    echo '<p id="valores">'.$model->codigo.'</p>';
                                    echo '<p id="valores">'.$model->nombre.'</p>';
                                    echo '<p id="valores">'.$model->saldo.'</p>';
                                ?>
                            </div>
                        </div>

                        <div class="row" <?php echo 'id="' . System::Id('divLotes') . '"'; ?>>
                           <?php
                            echo $this->renderPartial('_productolote', array(
                                'productolote' => $productolote,
                                    ), true
                            );
                            ?>
                        </div>    
                    </div>
                 
                    <?php
                        echo System::Buttons(
                            array(
                                'nameView' => 'Vencimiento',
                                'buttons' => array(
                                    'back' => array(
                                        'align' => 'right', 
                                        //'width' => '100px', 
                                        'label' => 'Salir', 
                                        'icon' => 'arrow-left',
                                        'click' => 'Vencimiento.closeWindow(this)',
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
