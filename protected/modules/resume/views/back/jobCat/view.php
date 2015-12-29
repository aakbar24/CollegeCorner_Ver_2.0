<?php
$this->breadcrumbs=array(
	'Job Cats'=>array('index'),
	$model->job_cat_id,
);

$this->menu=array(
	array('label'=>'List JobCat','url'=>array('index')),
	array('label'=>'Create JobCat','url'=>array('create')),
	array('label'=>'Update JobCat','url'=>array('update','id'=>$model->job_cat_id)),
	array('label'=>'Delete JobCat','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->job_cat_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage JobCat','url'=>array('admin')),
);
?>

<h1>View JobCat #<?php echo $model->job_cat_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'job_cat_id',
		'job_cat_name',
	),
)); ?>
