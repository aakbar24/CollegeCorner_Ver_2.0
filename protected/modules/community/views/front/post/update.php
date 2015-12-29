<?php
/* @var $this PostController */
/* @var $model PostItem */

$this->breadcrumbs=array(
	'Post Items'=>array('index'),
	$model->title=>array('view','id'=>$model->post_item_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PostItem', 'url'=>array('index')),
	array('label'=>'Create PostItem', 'url'=>array('create')),
	array('label'=>'View PostItem', 'url'=>array('view', 'id'=>$model->post_item_id)),
	array('label'=>'Manage PostItem', 'url'=>array('admin')),
);
?>

<h1>Update PostItem <?php echo $model->post_item_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>