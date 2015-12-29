<?php
$this->breadcrumbs=array(
	'Job Titles'=>array('index'),
	$model->job_title_id,
);

$this->menu=array(
	array('label'=>'List JobTitle','url'=>array('index')),
	array('label'=>'Create JobTitle','url'=>array('create')),
	array('label'=>'Update JobTitle','url'=>array('update','id'=>$model->job_title_id)),
	array('label'=>'Delete JobTitle','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->job_title_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage JobTitle','url'=>array('admin')),
);
?>

<h1>View JobTitle #<?php echo $model->job_title_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'job_title_id',
		'job_title_name',
		'job_cat_id',
	),
)); ?>
