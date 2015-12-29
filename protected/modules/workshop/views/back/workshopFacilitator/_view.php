<li class="span6">
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

	<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$data,
	'type'=>'bordered striped condensted',
	'attributes'=>array(
		array('name'=>'workshop_facilitator_id','type'=>'raw','value'=>CHtml::link(CHtml::encode($data->workshop_facilitator_id),array('view','id'=>$data->workshop_facilitator_id))),
		'first_name',
		'last_name',
	),
)); ?>
</div>

</li>