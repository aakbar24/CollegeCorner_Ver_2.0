<?php
$this->breadcrumbs=array(
	'Certifications'=>array('index'),
	$model->postItem->post_item_id=>array('view','id'=>$model->postItem->post_item_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Certification','url'=>array('index')),
	array('label'=>'Create Certification','url'=>array('create')),
	array('label'=>'View Certification','url'=>array('view','id'=>$model->postItem->post_item_id)),
	array('label'=>'Manage Certification','url'=>array('admin')),
);
?>

<h1>Update Certification - <?php echo $model->postItem->title; ?></h1>
<?php echo $this->renderPartial('certificate.views.common.certification._form',array('model'=>$model)); ?>