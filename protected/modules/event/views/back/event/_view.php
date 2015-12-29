
<?php $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
	'title' => CHtml::link(CHtml::encode($data->title),array('view','id'=>$data->post_item_id)),
	'headerIcon' => 'icon-calendar',
	// when displaying a table, if we include bootstra-widget-table class
	// the table will be 0-padding to the box
	//'htmlOptions' => array('class'=>'thumbnail')
));?>
<div class="view">

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('user_group_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_group_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('membership_level_id')); ?>:</b>
	<?php echo CHtml::encode($data->membership_level_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_notify')); ?>:</b>
	<?php echo CHtml::encode($data->is_notify); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode($data->is_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b>
	<?php echo CHtml::encode($data->date_created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_updated')); ?>:</b>
	<?php echo CHtml::encode($data->date_updated); ?>
	<br />

	*/ ?>

	
	<div class="span6">
	<?php 
	$this->widget('bootstrap.widgets.TbDetailView', array(
		'type'=>array('bordered','striped','condensed'),
		'data'=>$data,
		    'attributes'=>array(
		    		'start_date:date',
		    		'end_date:date',
		    		'start_time:time',
		    		'end_time:time',
		    ),
		));
	?></div>
	
	<div class="span6">
	<i class=" icon-quote-left"></i> 
	
	<?php echo (strlen($data->excerpt)==0)?'<h2 class="center-text">No Description</h2>':Yii::app()->format->excerpt($data->excerpt,35);?>
	
	<i class="icon-quote-right pull-right"></i>
	</div>
</div>

<?php $this->endWidget();?>
