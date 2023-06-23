<?php
/* @var $this TraspasoController */
/* @var $model Traspaso */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
<h1>Ver Traspaso</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'numero',
		array(
			 'name' => 'fecha',
			 'value'=>Yii::app()->format->datetime(strtotime($model->fecha)),
		),
		'estado',
		'tipo',
		'cliente',
		'almacen',
		'idalmacen',
		'usuario',
		'idpedido',
		'eliminado',
		'numeropedido',
		'total',
		'idmoneda',
	),
)); ?>		</div>
	</div>
</div>
