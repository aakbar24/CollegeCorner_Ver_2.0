<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('job_title_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->job_title_id),array('view','id'=>$data->job_title_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('job_title_name')); ?>:</b>
	<?php echo CHtml::encode($data->job_title_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('job_cat_id')); ?>:</b>
	<?php echo CHtml::encode($data->job_cat_id); ?>
	<br />


</div>