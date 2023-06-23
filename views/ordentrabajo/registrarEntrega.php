<?php
/* @var $this OrdenController */
/* @var $model Orden */
/* @var $form CActiveForm */

/*
 * Esta funcion verifica si existe excendente en la entrega de una orden
 * si es true existe excedente
 * @return boolean
 */
?>

<style type="text/css">
    .ordenentregabsns {
        width:100%;
        background-color: white;
    }
    .ordenentregabsns .row{
        margin-left: 0px;
    }
    .ordenentregabsns .btcol-xs-4 {
        width: 25%;
        float: left;
    }
    .ordenentregabsns .btcol-xs-6 {
        width: 50%;
        float: left;
    }


    .ordenentregabsns .list-group {
        padding-left: 0px;

        margin:0px 5px 0px 5px;
    }
    .ordenentregabsns .list-group-item {
        position: relative;
        display: block;
        padding: 10px 15px;
        margin-bottom: -1px;
        background-color: #FFF;
        border: 1px solid #DDD;
    }
    .ordenentregabsns .list-group-horizontal .list-group-item {
        display: inline-block;
    }
    .ordenentregabsns .list-group-sinmargen-bt{
        margin-bottom: 5px;
        list-style: outside none none;
    }
    .ordenentregabsns .list-group-horizontal .list-group-item {
        margin-bottom: 0;
        margin-left:-4px;
        margin-right: 0;
    }
    .ordenentregabsns .list-group-horizontal .list-group-item:first-child {
        border-top-right-radius:0;
        border-bottom-left-radius:4px;
    }
    .ordenentregabsns .list-group-horizontal .list-group-item:last-child {
        border-top-right-radius:4px;
        border-bottom-left-radius:0;

    }
    .ordenentregabsns .list-group-horizontal .list-group-item .badge {
        margin-left:10px;
    }
    .ordenentregabsns .list-group.list-group-horizontal{
        margin-bottom:0px;
    }
    .ordenentregabsns .progress.progress-margin{
        margin-bottom:0px;
    }

    .ordenentregabsns .list-group-item > .badge {
        float: right;

    }


    /**/

    .ordenentregabsns .panel-info > .panel-heading {
        color: #FFF;
        background-color: #3A87AD;
        border-color: #3A87AD;
    }
    .ordenentregabsns .panel-heading {
        padding: 0px 5px;
        border-bottom: 1px solid transparent;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }
    .ordenentregabsns .panel {

        border: 1px solid transparent;
        border-radius: 4px;
        box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
    }
    .ordenentregabsns .panel-info {
        border-color: #3A87AD;
    }
    .ordenentregabsns .panel-body{

        padding: 15px;
    }

    .ordenentregabsns .progress-bar{
        float: left;
        text-align: center;
        color: white;
    }
    .ordenentregabsns .progress-bar-success {
        background-color: #5CB85C;
    }
    .ordenentregabsns .progress-bar-warning {
        background-color: #F0AD4E;
    }
    .progress-bar-danger {
        background-color: #D9534F;
    }


    .ordenentregabsns .input-group {
        position: relative;
        display: table;
        border-collapse: separate;
    }
    .ordenentregabsns .input-group .form-control:first-child, 
    .ordenentregabsns .input-group-addon:first-child, 
    .ordenentregabsns .input-group-btn:first-child > .btn, 
    .ordenentregabsns .input-group-btn:first-child > .btn-group > .btn, 
    .ordenentregabsns .input-group-btn:first-child > .dropdown-toggle, 
    .ordenentregabsns .input-group-btn:last-child > .btn-group:not(:last-child) > .btn, 
    .ordenentregabsns .input-group-btn:last-child > .btn:not(:last-child):not(.dropdown-toggle) {
        border-top-right-radius: 0px;
        border-bottom-right-radius: 0px;
        padding: 4px 0px;
    }
    .ordenentregabsns .input-group .form-control, 
    .ordenentregabsns .input-group-addon, 
    .ordenentregabsns .input-group-btn {
        display: table-cell;
    }
    .ordenentregabsns .input-group .form-control {
        position: relative;
        z-index: 2;
        float: left;
        width: 100%;
        margin-bottom: 0px;
    }
    .ordenentregabsns .form-control {
        display: block;
        width: 100%;
        height: 20px;
        padding: 6px 0px;
        font-size: 14px;
        line-height: 1.42857;
        color: #555;
        background-color: #FFF;
        background-image: none;
        border: 1px solid #CCC;
        border-radius: 4px;
        box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    }


    .ordenentregabsns .input-group-addon:last-child {
        border-left: 0px none;
    }
    .ordenentregabsns .input-group .form-control:last-child, 
    .ordenentregabsns .input-group-addon:last-child, 
    .ordenentregabsns .input-group-btn:first-child > .btn-group:not(:first-child) > .btn, 
    .ordenentregabsns .input-group-btn:first-child > .btn:not(:first-child), 
    .ordenentregabsns .input-group-btn:last-child > .btn, 
    .ordenentregabsns .input-group-btn:last-child > .btn-group > .btn, 
    .ordenentregabsns .input-group-btn:last-child > .dropdown-toggle {
        border-top-left-radius: 0px;
        border-bottom-left-radius: 0px;

    }
    .ordenentregabsns .input-group-addon {
        padding: 6px 12px;
        font-size: 14px;
        font-weight: 400;
        line-height: 1;
        color: #555;
        text-align: center;
        background-color: #EEE;
        border: 1px solid #CCC;
        border-radius: 4px;
    }
    .ordenentregabsns .input-group-addon, .input-group-btn {
        width: 1%;
        white-space: nowrap;
        vertical-align: middle;
    }
    /*.input-group .form-control, .input-group-addon, .input-group-btn {
        display: table-cell;
    }*/
    .ordenentregabsns #divbs .row{
        margin: 0;
    }
    .ordenentregabsns #divbs .textboxinput{
        margin: 0;
    }
</style>
<div class="container">
    <div class="offset-12">
        <div style="padding: 5px;" id="content">     


            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm');
                ?>
                <div class="formWindow">
                    <div class="ordenentregabsns container">

                        <div id="divbs">
                            <div class="row">
                                <div style="padding-left: 0px;width: 12%;" class="btcol-xs-6">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <ul class="list-group list-group-sinmargen-bt">
                                                <li class="list-group-item">
                                                    <span class="badge"><?php echo $model->numero; ?></span>
                                                    Nº: 
                                                </li>                            
                                            </ul>
                                        </div>  
                                    </div>
                                </div>                               
                                <div style="width: 70%;" class="btcol-xs-6">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <ul class="list-group list-group-sinmargen-bt">
                                                <li style="padding: 10px;" class="list-group-item">
                                                    <span class="badge" style="font-size: 12px; "><?php
                                                        $descProdu = sprintf("(%s) %s [%s]", $model->idproducto0->codigo, $model->idproducto0->nombre,$model->idproducto0->idalmacen0->nombre);
                                                        echo $descProdu;
                                                        ?></span>
                                                    Producto:  
                                                </li>                                
                                            </ul>
                                        </div>  
                                    </div> 
                                </div>
                                 <div style="padding-left: 0px;width: 17%;" class="btcol-xs-6">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <ul class="list-group list-group-sinmargen-bt">
                                                <li class="list-group-item">
                                                    <span class="badge"><?php echo $model->cantidadproducir; ?></span>
                                                    Cant.: 
                                                </li>                            
                                            </ul>
                                        </div>  
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div style="padding-left: 0px; padding-right: 0px;" class="col-xs-12">
                                            <ul class="list-group list-group-sinmargen-bt">
                                                <li style="padding: 10px;" class="list-group-item">
                                                        <?php echo 'Observaciones: '; ?>
                                            <?php echo $model->descripcion; ?>
                                        </li>                                
                                    </ul>
                                </div>  
                            </div>  
                            <div class="row">
                                <div class="panel panel-info">
                                    <div style="padding: 0px 10px;" class="panel-heading">Nueva Entrega</div>
                                    <div style="padding-top: 0px; padding-bottom: 0px; padding-left: 5px;" class="panel-body">
                                        <span>Cantidad:</span>
                                        <ul class="list-group list-group-horizontal">
                                            <li style="padding: 4px;" class="list-group-item">                            
                                                <div class="input-group">                                                            
                                                    <?php echo $form->textField($model, 'cantidad', array('placeholder' => "Cantidad", 'class' => 'numeric form-control textboxinput', 'style' => 'padding-left:5px;')); ?>
                                                    <span class="input-group-addon" id="sizing-addon2"><?php echo $model->simbolo; ?></span>
                                                </div>
                                            </li>  
                                            <li style="padding: 4px;" class="list-group-item">                            
                                                <div class="input-group">                                                            
                                                    <?php 
                                                        echo $form->hiddenField($model, 'cantidadproducir');
                                                        echo $form->hiddenField($model, 'total');
                                                        echo $form->hiddenField($model, 'gastounitario');
                                                        echo $form->textField($model, 'costotrabajo', array('placeholder' => "Gasto Total(Bs)", 'class' => 'numeric form-control textboxinput', 'style' => 'padding-left:5px;width:100px;','readonly'=>'readonly'));
                                                    ?>
                                                    <span class="input-group-addon" id="sizing-addon2">Bs</span>
                                                </div>
                                            </li>  
                                            <li style="padding: 4px;" class="list-group-item">                            
                                                <div class="input-group">                                                            
                                                    <?php echo $form->textField($model, 'observacionentrega', array('placeholder' => "Observación de entrega", 'class' => 'form-control textboxinput', 'style' => 'text-transform: uppercase;padding-left:5px;width:250px;')); ?>
                                                    <span class="input-group-addon" id="sizing-addon2">Obs</span>
                                                </div>
                                            </li>                        
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>  

                    </div>
                </div>     
                <?php
                echo System::Buttons(array(
                    'nameView' => 'Orden',
                    'buttons' => array()
                        )
                );
                ?> 
                <?php $this->endWidget(); ?>

            </div><!-- form -->
        </div>
    </div>
</div>