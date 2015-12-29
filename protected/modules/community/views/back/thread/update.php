<?php
$this->breadcrumbs=array(
	'Threads'=>array('index'),
	$model->post_item_id=>array('view','id'=>$model->post_item_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Thread','url'=>array('index')),
	array('label'=>'Create Thread','url'=>array('create')),
	array('label'=>'View Thread','url'=>array('view','id'=>$model->post_item_id)),
	array('label'=>'Manage Thread','url'=>array('admin')),
);
?>

<h1>Update Thread <?php echo $model->post_item_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>