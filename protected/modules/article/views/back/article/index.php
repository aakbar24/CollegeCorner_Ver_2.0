<?php
$this->breadcrumbs=array(
	'Article',
);

$this->menu=array(
	array('label'=>'Create Article','url'=>array('create')),
	array('label'=>'Manage Articles','url'=>array('admin')),
);
?>

<h1>Article Listing</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
