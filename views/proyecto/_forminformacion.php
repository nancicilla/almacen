
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
         <div >
		             
		<?php echo $form->hiddenField($model,'nombre'); ?>
	</div>
<div  style=" overflow: scroll;height: 410px;" <?php echo 'id="'.System::Id('informacion').'"';?>>
 <?php
 $cantidad=count($lista);
 $cadena='';
 $idpadre=$model->idcaracteristica;
 for($i=0;$i< $cantidad;$i++){
    $cadenahijos='';
    if($lista[$i]['hijos']!='[]'){
        $hi=1;
    }else{
        $hi=0;
    }
    $cadena.='<div  id="accordion'.$i.'">        
            <div  id="p'.$i.'">
                <h5>
                    <a  data-toggle="collapse" data-target="#collapsep'.$i.'" aria-expanded="false" aria-controls="collapseOne">
                        '.$lista[$i]['nombre'].' 
                    </a>
                </h5>
            </div>

            <div data-hijo ="'.$hi.'" data-nombre="'.$lista[$i]['nombre'].'"  data-tipo="'.$lista[$i]['tipovalor'].'"  class="collapse" id="collapsep'.$i.'"  aria-labelledby="a" data-parent="#accordion'.$i.'">
                
               
             ';     
            // de momento no validaremos si se trata de una imagen o de un texto
 if($lista[$i]['hijos']!='[]'){
   // (inicio)tiene hijos     
    $hijos = json_decode($lista[$i]['hijos'], true);
     for($h=0;$h<count($hijos);$h++){
         $cadena.='<label>'.$hijos[$h]['nombre'].'</label><input data-eshijo="si" data-nombre="'.$hijos[$h]['nombre'].'"  style="width:450px" data-tipo="'.$hijos[$h]['tipovalor'].'" type="text" placeholder="Introdusca '.$hijos[$h]['nombre'].'" value="'.$hijos[$h]['valor'].'">';
         
     }
   // (fin) tiene hijos
 }else{
     // (inicio)no tiene hijos
      $cadena.='<input style="width:450px" data-eshijo="no" type="text" placeholder="Introdusca '.$lista[$i]['nombre'].'" value="'.$lista[$i]['valor'].'">';
        
     //(fin) no tiene hijos
 }
                      
                            



                $cadena.='  </div>
  </div>';
  }
  echo $cadena;
  ?>
 
 </div>
    </div>   
    <?php
    echo System::Buttons(array(
        'nameView' => 'Persona',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget();  ?>
</div><!-- form -->
