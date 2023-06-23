
<?php
/* @var $this ProyectoController */
/* @var $model Proyecto */
/* @var $form CActiveForm */
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    //'focus'=>array($model,'ci'),
    'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
     <div class="formWindow">
           
        <?php
           
            echo System::widgetTabs(array(
            'nameView' => 'Persona',
            'height' => 420,
            'tabs' => array(
                'Datos Generales' => array('id' => 'Datos',
                    'content' => $this->renderPartial('_datosgenerales',
                     array('model' => $model, 'form' => $form), true),
                    'titleWidth' => 120,
                    'active' => true,
                ),
                'Equipo de Trabajo' => array('id' => 'equipo',
                    'content' => $this->renderPartial('_equipo',
                            array('model' => $model,'listapersonal'=>$listapersonal,'form'=>$form), true),
                    'titleWidth' => 120, 'active' => true
                ),
                'Proveedor' => array('id' => 'proveedor',
                    'content' => $this->renderPartial('_proveedor', 
                            array('model'=>$model,'listaproveedores'=>$listaproveedores,'form'=>$form), true),
                    'titleWidth' => 120,
                ),
               
              
            ),
        ));
            
        ?> 
    </div>   
    <?php
    echo System::Buttons(array(
        'nameView' => 'Persona',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget();  ?>
</div><!-- form -->
