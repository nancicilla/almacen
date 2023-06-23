<?php
/* @var $this CaracteristicaController */
/* @var $model Caracteristica */
/* @var $form CActiveForm */
?>

<?php
$condicionAdicional = '';
if (!$model->isNewRecord) {
    $condicionAdicional = 'and id<>' . $model->id;
}
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'focus'=>array($model,'nombre')
    ));
    ?>
    <div class="formWindow">

        <div class="row">
            <?php echo $form->labelEx($model, 'nombre'); ?>
            <?php echo $form->textField($model, 'nombre', array('maxlength' => 30)); ?>
        </div>

        <div class="row">
            <?php echo $form->hiddenField($model, 'idgenero');
            ?>
            <?php
            if ($model->idgenero == Genero::model()->GENEROGENERAL) {
                echo $form->labelEx($model, 'idcaracteristica');
                ?>
                <?php
                echo $form->dropDownList($model, 'idcaracteristica', CHtml::listData(Caracteristica::model()->findAll
                                        (array('order' => 'nombre',
                                    'condition' => "idcaracteristica ISNULL and idgenero=" . Genero::model()->GENEROGENERAL . " " . $condicionAdicional)), 'id', 'nombre'), array('empty' => '', 'disabled' => Caracteristica::model()->isPadre($model->id) && $model->scenario == 'update' ? true : false));
            } else {

                echo '</br></br>';
            }
            ?>
        </div> 
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Caracteristica',
        'buttons' => array()
    ));
    ?> 
    <?php $this->endWidget(); ?>

</div><!-- form -->
