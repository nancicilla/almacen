<div class="container">
    <div class="offset-12">
        <div id="content">
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array());
                ?>
                <div class="formWindow">

                    <div class="row">
                        <?php echo $form->labelEx($model, 'Nota Nº'); ?>
                        <?php echo $form->textField($model, 'numero', array('disabled' => true)); ?>
                    </div>    

                    <div class="row">
                        <?php echo $form->labelEx($model, 'cantidadcaja'); ?>
                        <?php echo $form->textField($model, 'cantidadcaja', array('class' => 'numeric')); ?>
                    </div>   

                    <div class="row">
                        <?php echo $form->labelEx($model, 'idchofer'); ?>
                        <?php
                        echo $form->dropDownList(
                                $model, 'idchofer', CHtml::listData(Chofer::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'), array('empty' => '')
                        );
                        ?>    </div>


                    <div class="row">
                        <?php echo $form->labelEx($model, 'descripcion'); ?>
                        <?php echo $form->textField($model, 'descripcion', array('style' => 'text-transform: uppercase')); ?>
                    </div>

                </div>
                <?php
                echo System::Buttons(array(
                    'nameView' => 'Nota',
                    'buttons' => array()
                ));
                ?> 
                <?php $this->endWidget(); ?>

            </div><!-- form -->
        </div>
    </div>
</div>