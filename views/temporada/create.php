<?php

/* @var $this TemporadaController */
/* @var $model Temporada */

?>
<div class="container">
    <div class="offset-12">
        <div id="content">
            <?php $this->renderPartial('_form', 
                array(
                    'model' => $model,
                    'gridTemporadaproducto' => $gridTemporadaproducto,
                ));
            ?>
        </div>
    </div>
</div>
