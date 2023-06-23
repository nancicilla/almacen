<?php
/* @var $this AlertaController */
/* @var $model Alerta */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
<h1>Ver Alerta</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'descripcion',
		'usuario',
		array(
			 'name' => 'fecha',
			 'value'=>Yii::app()->format->datetime(strtotime($model->fecha)),
		),
		'eliminado',
		'idalertatipo',
		'usuarios',
		'activadoaccion',
		'iddocumento',
	),
)); ?>		</div>
	</div>
</div>
