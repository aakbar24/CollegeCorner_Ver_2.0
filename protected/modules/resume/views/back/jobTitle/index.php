<?php
$this->breadcrumbs=array(
	'Job Titles',
);

$this->menu=array(
	array('label'=>'Create JobTitle','url'=>array('create')),
	array('label'=>'Manage JobTitle','url'=>array('admin')),
);
?>

<h1>Job Titles</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
