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
        
        <div class=""row>
             Nombre:<?php echo $form->textField($model, 'nombre', array( 'placeholder'=>'Escriba Nombre del Diseño', 'style' => 'text-transform: uppercase;width:200px;')); ?>
        
        </div>
        <div class="row">
            
             <div class="column" style="display:inline-block">
                 <input type="radio" id="html" name="paraenvase" value="1" > Diseño para Envase
        </div>
        <div class="column" style="display:inline-block">
          <input type="radio" id="css" name="paraenvase" value="0"> Diseño de Chocolate</div>
        
        </div>
        
        <hr style="border-buttom: 3px solid #f1f1f1">
        <div class="divbody" <?php echo 'id="'.System::Id('contenedor').'"';?>>
            <h3 style=";text-align: center">Lista de Caracteristicas</h3>
            <ul class="todos" id="todos">
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
