<?php
/* @var $this CaracteristicasController */
/* @var $model Caracteristicas */
/* @var $form CActiveForm */
?>
<style>
    divbody{
    font-family: 'Times New Roman', Times, serif;
    font-size: 2rem;
    padding: 5rem;
}
ul{
    list-style-type: none;
}
.todos{
    cursor: pointer;
}
.todo::before{
    content: '';
    display: inline-block;
    margin-right: 0.5rem;
}
ul.toggler-target>li.todo{
    margin-right: 0.8rem;
    
}
ul.toggler-target > li.todo::before{
    padding-left: 20px;
}
/* toggler*/
.toggler::before{
    content: '\002B';
    display: inline-block !important;
    margin-right: 0.5rem;
    transition: tranform 0.3s ease-in-out;
}
.toggler.active::before{
   transform: rotate(90deg);
}
.toggler-target{
    display: none;

}
.toggler-target.active{
    display: block;
    margin-right: 0.8rem;

}
.guardar::before{
    content: '\1F4BE';
}
.eliminar::before{
    content: '\1F5D1';
}
select {
  width: 100px !important;
}
.imagen{
    color:green;
      font-style: italic;
}
</style>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'id')
)); ?>
    <div class="formWindow"> 
        <?php echo $form->hiddenField($model, 'id'); ?>
        <div class=""row>
             Nombre:<?php echo $form->textField($model, 'nombre', array( 'placeholder'=>'Escriba Nombre del Diseño', 'style' => 'text-transform: uppercase;width:200px;','readonly'=>true)); ?>
        
        </div>
        
        <div class="divbody" <?php echo 'id="'.System::Id('contenedor').'"';?>>
            <h3 style=";text-align: center">Lista de Caracteristicas</h3>
            <ul class="todos" id="todos">
                <?php
                 $cadena='';
                 for ($l=0;$l<count( $lista);$l++){
                     $cadenahijos='';
                     if($lista[$l]['idcaracteristicapadre']==$model->id){
                        $idpadre=$lista[$l]['id'];
                        if($lista[$l]['tipovalor']=='1')
                        { $cadena.='<li data-tipo="'.$lista[$l]['tipovalor'].'" data-nodo="si"><div class="toggler imagen">'.$lista[$l]['nombre'].'<span class="eliminar" onclick="Caracteristicas.eliminarNodo(this)">  </span></div><ul class="toggler-target">';
                              }else{
                             $cadena.='<li data-tipo="'.$lista[$l]['tipovalor'].'" data-nodo="si"><div class="toggler">'.$lista[$l]['nombre'].'<span class="eliminar" onclick="Caracteristicas.eliminarNodo(this)">  </span></div><ul class="toggler-target">';
                              
                        }
                        if($lista[$l]['canthijos']>0){
                            $l=$l+1;
                        for($l;$l<count( $lista);$l++){
                            if($lista[$l]['idcaracteristicapadre']==$idpadre){
                                if($lista[$l]['tipovalor']=='1'){
                                $cadenahijos.='<li data-tipo="'.$lista[$l]['tipovalor'].'" class="todo imagen" data-nodo="no">'.$lista[$l]['nombre'].'<span class="eliminar" onclick="Caracteristicas.eliminarNodo(this)"></span></li>';
                                }else{
                                   $cadenahijos.='<li data-tipo="'.$lista[$l]['tipovalor'].'" class="todo" data-nodo="no">'.$lista[$l]['nombre'].'<span class="eliminar" onclick="Caracteristicas.eliminarNodo(this)"></span></li>';
                                 
                                }
                            }else{
                                --$l;
                                break;
                            }
                              
                        }
                        --$l;
                        }
                        $cadenahijos.='<li class="todo"><input placeholder="escriba el nombre de la Caracteristica..."> <select><option value="0"> Texto  </option><option value="1"> Imagen </option> </select> <span class="guardar" onclick="Caracteristicas.crearNodoHermano(this)"></span></li>';
                           
                               $cadena.=  $cadenahijos.'</ul></li>';
                          }
                 }
                echo $cadena;
                 ?>
                
        <li> 
            <input id="i1" placeholder="escriba el nombre de la Caracteristica..."  > <select id="s1" > 
            <option value="0"> Texto</option>    
            <option value="1"> Imagen</option>
            </select>
            <span class="guardar" onclick="Caracteristicas.crearNodo(this)" ></span>
        </li>

    </ul>
    
	
        </div>
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Caracteristicas',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
