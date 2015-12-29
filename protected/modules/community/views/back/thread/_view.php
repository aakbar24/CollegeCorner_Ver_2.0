<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('post_item_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->post_item_id),array('view','id'=>$data->post_item_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('program_code')); ?>:</b>
	<?php echo CHtml::encode($data->program_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('college_id')); ?>:</b>
	<?php echo CHtml::encode($data->college_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('program_id')); ?>:</b>
	<?php echo CHtml::encode($data->program_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('semester_id')); ?>:</b>
	<?php echo CHtml::encode($data->semester_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('attachment')); ?>:</b>
	<?php echo CHtml::encode($data->attachment); ?>
	<br />


</div>