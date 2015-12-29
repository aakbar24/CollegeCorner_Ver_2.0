<?php
$this->breadcrumbs=array(
	'Planned Workshops',
	$model->postItem->title=>array('view','id'=>$model->postItem->post_item_id),
	'Update',
);

$this->menu=array(
    array('label'=>'Manage Workshops','url'=>array('/workshop/workshop/admin')),
    array('label'=>'Manage Category','url'=>array('/workshop/workshopCat/admin')),
    array('label'=>'Manage Facilitator','url'=>array('/workshop/workshopFacilitator/admin')),
    array('label'=>'Planned Workshops'),
    array('label'=>'Manage','url'=>array('/workshop/workshopPlanned/admin')),
    array('label'=>'New','url'=>array('/workshop/workshopPlanned/create')),
    //array('label'=>'Update','url'=>array('update','id'=>$model->postItem->post_item_id)),
    array('label'=>'Delete','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->postItem->post_item_id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>Update <?php echo $model->postItem->title; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>