<?php
$this->breadcrumbs=array(
	'Events'=>array('index'),
	$model->postItem->title,
);

$isHistory=$model->event->isHistory();
?>

<h1><?php echo $model->postItem->title; ?> <small><?php if(!$model->event->isPublic()):?>
<span class="label label-warning"><?php echo $model->event->collegeName;?> students only</span>
<?php endif;?></small></h1>

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
		'countryName',
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

<?php $this->widget('bootstrap.widgets.TbButton',array(
		'label'=>Yii::t('view', 'signup_lb'),
		'type'=>'info',
		'size'=>'large',
		'buttonType'=>'submitLink',
		'htmlOptions'=>array('submit'=>array('signup','id'=>$model->event->post_item_id),),
		//'url'=>array('signup',array('id'=>$model->event->post_item_id)),//array('/event/event/signup','id'=>$model->postItem->post_item_id),
		'visible'=>!$alreadySignup && !$isHistory,
		));?>

<?php if($alreadySignup):?>
<span class="label label-success">You already signup for this event.</span>
<br/> 
<?php endif;?>
<?php if ($isHistory):?>
<span class="label label-info">This event is already past.</span>
<?php endif;?>
</fieldset>
</div>
