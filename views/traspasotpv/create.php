<?php

/* @var $this TraspasotpvController */
/* @var $model Traspasotpv */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_form', array(
                        'model'=>$model,
                        'gridSolicitudProducto' => $gridSolicitudProducto,
                        'almacenes' => $almacenes,
                    )); ?>
		</div>
	</div>
</div>
