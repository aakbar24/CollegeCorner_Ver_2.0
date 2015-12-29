<?php
/* @var $this ResumePostController */
/* @var $data ViewStudentJobTitle */
/* @var $index integer */
/* @var $widget TbListView */
?>
<div class="resume-details">
<?php 
		'title'=>$data->job_title_name." ($data->job_type_name)",
		'headerIcon'=>'icon-file',
		'headerButtons'=>array(

				array('class'=>'bootstrap.widgets.TbButtonGroup',
						'buttons'=>array(
									
								array(
										'url'=>$data->generateResumeFileUrl(),
										'type'=>'primary',
										'label'=>Yii::t('view', 'download_lb'),
								),//+ ($data->generatePortfolioFileUrl()== null ?
								array(
								 array(
								 'url'=>$this->createUrl('editJob',array('jobTitle'=>$data->job_title_id)),
										'type'=>'warning',
										'label'=>Yii::t('view', 'form.edit_lb'),
								), */
								array(
										'buttonType'=>$data->is_hired?'button':'link',
										'url'=>$this->createUrl('deleteJob',array('stuJobID'=>$data->stu_job_id)),
										'type'=>'danger',
										'label'=>Yii::t('view', 'form.delete_lb'),
										'visible'=>count($data->interviewEmployers)==0,
										'htmlOptions'=>array('class'=>$data->is_hired?'disabled':'', 'onclick'=>'return confirm("Are you sure you want to delete this resume post?");'),
								),
								
								array(
										'url'=>Yii::app()->createAbsoluteUrl('resume/studentInterview/index'),
										'type'=>'success',
										'label'=>'# Interviews: '.count($data->interviewEmployers),
										'visible'=>count($data->interviewEmployers)>0,
										//'htmlOptions'=>array('class'=>$data->is_hired?'disabled':'', 'onclick'=>'return confirm("Are you sure you want to delete this resume post?");'),
								),
						//),
				),

		),
		));

<dl class="dl-horizontal">
	<dt>
		<?php echo $data->getAttributeLabel('job_cat_name');?>
	</dt>
	<dd>
		<?php echo $data->job_cat_name;?>
	</dd>
	<dt>
		<?php echo $data->getAttributeLabel('skills');?>
	</dt>
	<dd>
		<?php foreach ($data->getSkillsArray() as $skill):?>
					<span class="label label-info"><?php echo $skill;?> </span>
					<?php endforeach;?>
	</dd>

	<dt>
		<?php echo $data->getAttributeLabel('date_created');?>
	</dt>
	<dd>
		<?php echo $data->date_created;?>
	</dd>
	<dt>
		<?php echo $data->getAttributeLabel('expiry_date');?>
	</dt>
	<dd>
		<?php echo $data->expiry_date;?>
	</dd>
</dl>

<?php $this->endWidget();?>

</div>
