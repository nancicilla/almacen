<?php
/* @var $this AlertaController */
/* @var $dataProvider CActiveDataProvider */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">

<h1>Alertas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
		</div>
	</div>
</div>
