<?php
/** @var $model PlannedWorkshopForm */
$this->breadcrumbs=array(
    'Planned Workshops',
    'View',
    $model->postItem->title,
);

$this->menu=array(
    array('label'=>'Manage Workshops','url'=>array('/workshop/workshop/admin')),
    array('label'=>'Manage Category','url'=>array('/workshop/workshopCat/admin')),
    array('label'=>'Manage Facilitator','url'=>array('/workshop/workshopFacilitator/admin')),
    array('label'=>'Planned Workshops'),
    array('label'=>'Manage','url'=>array('/workshop/workshopPlanned/admin')),
    array('label'=>'New','url'=>array('/workshop/workshopPlanned/create')),
    array('label'=>'Update','url'=>array('update','id'=>$model->postItem->post_item_id)),
    array('label'=>'Delete','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->postItem->post_item_id),'confirm'=>'Are you sure you want to delete this item?')),
);

?>

<h1><?php echo $model->postItem->title; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'postItem.title:text:Title',
        'postItem.description:text:Description',
        'postItem.date_created:datetime:Date Created'
	),
)); ?>
