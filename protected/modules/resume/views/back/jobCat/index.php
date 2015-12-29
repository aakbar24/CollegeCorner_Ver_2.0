<?php
$this->breadcrumbs=array(
	'Job Cats',
);

$this->menu=array(
	array('label'=>'Create JobCat','url'=>array('create')),
	array('label'=>'Manage JobCat','url'=>array('admin')),
);
?>

<h1>Job Cats</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
