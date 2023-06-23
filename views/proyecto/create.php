<?php

/* @var $this ProyectoController */
/* @var $model Proyecto */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_form', array('model'=>$model,'listapersonal'=>$listapersonal,'listaproveedores'=>$listaproveedores)); ?>                    
		</div>
	</div>
</div>
