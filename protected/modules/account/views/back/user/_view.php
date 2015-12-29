<li class="span6">
<?php $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
	'title' => CHtml::link(CHtml::encode($data->username),array('view','id'=>$data->user_id)),
	'headerIcon' => 'icon-user',
	// when displaying a table, if we include bootstra-widget-table class
	// the table will be 0-padding to the box
	'htmlOptions' => array('class'=>'thumbnail')
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

	<?php 
	$this->widget('bootstrap.widgets.TbDetailView', array(
		'type'=>array('bordered','striped','condensed'),
		'data'=>$data,
		    'attributes'=>array(
		    	'user_id',
		    	'userGroup.user_group_name',
		    	'name'=>array('label'=>'Name','value'=>$data->first_name.' '.$data->last_name),
		    	'email:email',
	    		'is_notify:boolean',
	    		'is_active:boolean',
	    		'date_created:dateTime',
	    		'date_updated:dateTime',
		    ),
		));
	?>
</div>

<?php $this->endWidget();?>
</li>