<?php
$this->breadcrumbs=array(
	'Threads'=>array('index'),
	$model->post_item_id,
);

$this->menu=array(
	array('label'=>'List Thread','url'=>array('index')),
	array('label'=>'Create Thread','url'=>array('create')),
	array('label'=>'Update Thread','url'=>array('update','id'=>$model->post_item_id)),
	array('label'=>'Delete Thread','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->post_item_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Thread','url'=>array('admin')),
);
?>

<h1>View Thread #<?php echo $model->post_item_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'post_item_id',
		'program_code',
		'college_id',
		'program_id',
		'semester_id',
		'attachment',
	),
)); ?>
