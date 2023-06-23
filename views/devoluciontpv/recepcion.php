<?php

/* @var $this DevoluciontpvController */
/* @var $model Devoluciontpv */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_formAceptar', array(
                                'model'=>$model,
                                'gridDevolucionproducto'=>$gridDevolucionproducto
                            )); ?>                    
		</div>
	</div>
</div>
