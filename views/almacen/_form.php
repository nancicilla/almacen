<?php
/* @var $this AlmacenController */
/* @var $model Almacen */
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
        'focus' => array($model, 'codigo')
    ));
    ?>
    <div class="formWindow">

        <div class="row">
            <?php echo $form->labelEx($model, 'codigo'); ?>
            <?php echo $form->textField($model, 'codigo', array('class' => 'numeric', 'maxlength'=>2, 'disabled' => !Almacen::model()->isModificable($model->id) && $model->scenario == 'update' ? true : false)); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'nombre'); ?>
            <?php echo $form->textField($model, 'nombre', array('maxlength' => 50, 'style' => 'text-transform: uppercase')); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'idalmacen'); ?>
            <?php
            echo $form->dropDownList(
                    $model, 'idalmacen', CHtml::listData(Almacen::model()->findAll(array('order' => 'nombre', 'condition' => "idalmacen ISNULL " )), 'id', 'nombre'), array('empty' => '', 'disabled' => Almacen::model()->isModificable($model->id) || $model->isNewRecord ? false : true)
            );
            ?>
        </div>
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Almacen',
        'buttons' => array()
    ));
    ?> 
    <?php $this->endWidget(); ?>

</div><!-- form -->
