<?php
$this->breadcrumbs=array(
	'Threads',
);

$this->menu=array(
	array('label'=>'Create Thread','url'=>array('create')),
	array('label'=>'Manage Thread','url'=>array('admin')),
);
?>

<h1>Threads</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
