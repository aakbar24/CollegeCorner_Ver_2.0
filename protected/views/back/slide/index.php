<?php
$this->breadcrumbs=array(
	'Slides',
);

$this->menu=array(
	array('label'=>'Create Slide','url'=>array('create')),
	array('label'=>'Manage Slides','url'=>array('admin')),
);
?>

<h1>All Slides</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
