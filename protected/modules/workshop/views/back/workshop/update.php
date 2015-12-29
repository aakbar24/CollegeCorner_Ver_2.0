<?php
$this->breadcrumbs=array(
	'Workshops'=>array('admin'),
	$model->postItem->title=>array('view','id'=>$model->postItem->post_item_id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Workshop','url'=>array('index')),
	array('label'=>'Create Workshop','url'=>array('create')),
	array('label'=>'View Workshop','url'=>array('view','id'=>$model->postItem->post_item_id)),
	array('label'=>'Manage Workshop','url'=>array('admin')),
	array('label'=>'Manage Category','url'=>array('/workshop/workshopCat/admin')),
	array('label'=>'Manage Facilitator','url'=>array('/workshop/workshopFacilitator/admin')),
    array('label'=>'Planned Workshops'),
    array('label'=>'Manage','url'=>array('/workshop/workshopPlanned/admin')),
    array('label'=>'New','url'=>array('/workshop/workshopPlanned/create')),
);
?>

<h1>Update Workshop - <?php echo $model->postItem->title; ?></h1>

<?php echo $this->renderPartial('workshop.views.common.workshop._form',array('model'=>$model)); ?>