<div class="row">
    <div class="column">
        <label style="font-size: 15px; font-family: sans-serif; color: black;">Añadir Requisito:</label>
    </div>
    <div class="column">
    <?php
    echo System::widgetSwitch
    (
        $model, 'requisito',
        array(
                'handleWidth' => 200,
                'onText' => 'NO',
                'offText'=>'SI',
                'onchange'=>'function(){Producto.mostrarRequisitos(false);}'
            )
    );
    ?>
    </div>
    <div class="column" style="width: 720px; text-align: right;">
        <label style="font-size: 15px; color: black;">Aumentar Columna
            <?php
                echo $form->checkBox($model, 'aumentarColumna', 
                    array(
                        'disabled' => true
                    ));
            ?>
        </label>
    </div>
</div>
<?php
    echo "<div id='".System::Id('divRequisitos')."' >";
        echo $this->renderPartial('_requisitoDetalle',
            array(
                'gridRequisito' => $gridRequisito,
                'model' => $model,
            ), true
        );
    echo "</div>";
?>