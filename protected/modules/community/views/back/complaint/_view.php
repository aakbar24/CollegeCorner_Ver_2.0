<?php
/* @var $this ComplaintController */
/* @var $data Complaint */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('post_item_id')); ?>:</b>
	<?php echo CHtml::encode($data->post_item_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reply_id')); ?>:</b>
	<?php echo CHtml::encode($data->reply_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reason')); ?>:</b>
	<?php echo CHtml::encode($data->reason); ?>
	<br />


</div>