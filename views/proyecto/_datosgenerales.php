
<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>200,'style' => 'text-transform: uppercase')); ?>
	</div>
<div class="row">
        <?php echo $form->labelEx($model,'idcaracteristica'); ?>
        <?php echo $form->dropDownList($model,'idcaracteristica',CHtml::listData(Caracteristicas::model()->findAll('t.idcaracteristicapadre is null'),'id','nombre'),array('empty'=>'','data-v'=>'','disabled'=>($model->scenario=='update' )?true:false)); ?>
    </div>
    
	<div class="row">
            <div class="column">
            <?php                 
                echo $form->label($model, 'fechainicio');
                echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechainicio',                    
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                       
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;',
                       

                    ),
                    ), true);

            ?>
        </div>
        <div class="column">
            <?php                 
                echo $form->label($model, 'fechafin');
                echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechafin',                    
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                       
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;',
                        

                    ),
                    ), true);

            ?>
        </div>
        </div>
        <div class="row">    
	<div class="column">
		<?php echo $form->labelEx($model,'numero'); ?>
		<?php echo $form->numberField($model,'numero',array('min'=>'1')); ?>
	</div>
        <div class="column">
         <?php echo $form->labelEx($model,'itemensistema'); ?>
         <?php echo $form->checkBox($model,'itemensistema' ); ?>
           
         </div>
        </div>


