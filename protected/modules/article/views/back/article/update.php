<?php
$this->breadcrumbs=array(
	'Articles'=>array('index'),
	$model->postItem->post_item_id=>array('view','id'=>$model->postItem->post_item_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Articles','url'=>array('index')),
	array('label'=>'Create Article','url'=>array('create')),
	array('label'=>'View Article','url'=>array('view','id'=>$model->postItem->post_item_id)),
	array('label'=>'Manage Articles','url'=>array('admin')),
);
?>

<h1>Update Article <?php echo $model->postItem->post_item_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>