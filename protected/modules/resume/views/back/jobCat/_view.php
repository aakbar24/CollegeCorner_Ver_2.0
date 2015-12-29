<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('job_cat_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->job_cat_id),array('view','id'=>$data->job_cat_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('job_cat_name')); ?>:</b>
	<?php echo CHtml::encode($data->job_cat_name); ?>
	<br />


</div>