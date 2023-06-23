<div class="container">
    <div class="offset-12">
        <div id="content">
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                ));
                ?>
                <div class="formWindow">                   
                    <div class="row">
                        <?php echo $form->labelEx($model, 'idAlmacen'); ?>
                        <?php
                        echo $form->dropDownList(
                                $model, 'idAlmacen', CHtml::listData(Almacen::model()->findAll(array('order' => 'nombre')), 'idEncriptado', 'nombre')
                        );
                        ?>  
                    </div>
                    <?php
                    echo System::Buttons(array(
                        'nameView' => 'Inventario',
                        'buttons' => array()
                    ));
                    ?> 
                    <?php $this->endWidget(); ?>
                </div><!-- form -->
            </div>
        </div>
    </div>