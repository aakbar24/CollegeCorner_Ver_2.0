<?php
/** @var $model WorkshopFacilitator */
$this->breadcrumbs=array(
	'Workshop'=>array('/workshop/workshop/admin'),
	'Facilitators'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Create Facilitator','url'=>array('create')),
	array('label'=>'Update Facilitator','url'=>array('update','id'=>$model->workshop_facilitator_id)),
	array('label'=>'Delete Facilitator','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->workshop_facilitator_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Facilitator','url'=>array('admin')),
	array('label'=>'Manage Workshop','url'=>array('/workshop/workshop/admin')),
	array('label'=>'Manage Category','url'=>array('/workshop/workshopCat/admin')),
    array('label'=>'Planned Workshops'),
    array('label'=>'Manage','url'=>array('/workshop/workshopPlanned/admin')),
    array('label'=>'New','url'=>array('/workshop/workshopPlanned/create')),
);
?>

<h1>View Facilitator - <?php echo $model->name; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'type'=>'bordered striped',
	'attributes'=>array(
		'workshop_facilitator_id',
		'first_name',
		'last_name',
		'biography:ntext',
		'is_active:boolean',
        array(
            'name'=>'image',
            'type'=>'raw',
            'value'=>CHtml::image($model->getImageUrl(), $model->name)
    ),)
)); ?>
