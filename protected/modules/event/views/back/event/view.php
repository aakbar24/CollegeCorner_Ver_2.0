<?php
$this->breadcrumbs=array(
	'Events'=>array('index'),
	$model->postItem->title,
);

$this->menu=array(
	array('label'=>'List Event','url'=>array('index')),
	array('label'=>'Create Event','url'=>array('create')),
	array('label'=>'Update Event','url'=>array('update','id'=>$model->event->post_item_id)),
	array('label'=>'Delete Event','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->event->post_item_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Event','url'=>array('admin')),
);
?>

<h1>View Event - <?php echo $model->postItem->title; ?></h1>

<fieldset>
<legend><?php echo Yii::t('view', 'event.event_info_lb')?></legend>
<?php 
$this->widget('bootstrap.widgets.TbBox', array(
		'title' => $model->postItem->title,
		'headerIcon' => 'icon-flag-checkered',
		'content' => $model->postItem->description
));
?>
</fieldset>

<div class="row-fluid">
<fieldset class="span6">
<legend><?php echo Yii::t('view', 'event.location_info_lb')?></legend>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model->event,
	'type'=>array('bordered'),
	'attributes'=>array(
		'post_item_id',
		'address',
		'city',
		'province',
		'postal_code',
		'country_id',
		'phone',
		'ext'=>array('visible'=>$model->event->ext!=''),
	),
)); ?>
</fieldset>

<fieldset class="span6">
<legend><?php echo Yii::t('view', 'event.datetime_info_lb')?></legend>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model->event,
	'type'=>array('bordered'),
	'attributes'=>array(
			'start_date:date',
			'end_date:date',
			'start_time:time',
			'end_time:time',
	),
)); ?>
</fieldset>
</div>
