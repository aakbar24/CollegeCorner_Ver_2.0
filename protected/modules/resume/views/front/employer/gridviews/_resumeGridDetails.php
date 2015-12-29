<?php
/* @var $this EmployerController */
/* @var $data ViewStudentTitle */

/* @var $widget TbListView */

$actionButtons=array(
		array('label'=>'Download Resume', 'buttonType'=>'submit','icon'=>'white download-alt','type'=>'primary','htmlOptions'=>array('class'=>'btn-block')),		//array('label'=>'Download Portfolio', 'buttonType'=>'button','icon'=>'white download-alt','type'=>'primary','htmlOptions'=>array('class'=>'btn-block')),		
		array('label'=>'Save to Favorite', 'buttonType'=>'button' , 'icon'=>'star','disabled'=>(($data->is_hired=='1')||isset($data->fav_employer_id)),'htmlOptions'=>array('class'=>'fav-resume btn-block','data-id'=>$data->stu_job_id)),
		array('label'=>'Add to Interview', 'buttonType'=>'button', 'icon'=>'calendar','disabled'=>(($data->is_hired=='1')||($data->is_student_hired==1)||(isset($data->expired)&&($data->expired==1))||isset($data->inte_employer_id)),'htmlOptions'=>array('class'=>'btn-block interview-resume','data-id'=>$data->stu_job_id))
);
$actionButtonsForPortfolio=array(		//array('label'=>'Download Resume', 'buttonType'=>'submit','icon'=>'white download-alt','type'=>'primary','htmlOptions'=>array('class'=>'btn-block')),		array('label'=>'Download Portfolio', 'buttonType'=>'submit','icon'=>'white download-alt','type'=>'primary','htmlOptions'=>array('class'=>'btn-block')));
?>
<div class="resume-details" id="resume-grid-details<?php echo $data->stu_job_id;?>">
	<div class="row-fluid">
		<div class="page-header">
			<h4>
				<?php echo Yii::t('view', 'employer.resume_grid_detail.job_title_apply_lb');?> <?php echo $data->job_title_name;?>
				<small>(<?php echo $data->job_type_name; ?>)
				</small>
				
				<?php if(isset($data->fav_employer_id)):?>
					<i class="icon-star fav-highlight"></i>
				<?php endif;?>
				
				<?php if(isset($data->inte_employer_id)):?>
					 <?php echo $data->getInterviewIcon();?>
				<?php endif;?>
				
				<?php if(isset($data->expired)&& $data->expired==1):?>
					 <i class="icon-warning-sign" title="Expired"></i>
				<?php endif;?>
				
				<?php if($data->is_student_hired==1):?>
					 <?php echo $data->getStudentHiredIcon();?>
				<?php endif;?>
			</h4>
		</div>
		<div class="span6">
			<dl class="dl-horizontal">
				
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
				<?php if(isset($data->inte_employer_id)):?>
				<dt>
					Interview Date
				</dt>
				<dd>
					<?php echo $data->employer_inte_date;?>
				</dd>
				<?php endif;?>
				
				<?php if(isset($data->date_hired)):?>
				<dt>
					Hired Date
				</dt>
				<dd>
					<?php echo $data->date_hired;?>
				</dd>
				<?php endif;?>
			</dl>

		</div>
		<div class="span5 pull-right well">
			<div class="row-fluid">
			
			<?php//generatePortfolioFileEmployerUrl(), generateResumeFileEmployerUrl()
			echo CHtml::beginForm($data->generateResumeFileEmployerUrl(),'POST',array('id'=>'download-resume-form1'));			//echo CHtml::beginForm($data->generateResumeFileEmployerUrl(),'POST',array('id'=>'download-resume-form1'));
			echo CHtml::hiddenField('student_id',$data->student_id);
			echo CHtml::hiddenField('stu_job_id',$data->stu_job_id);
			echo CHtml::hiddenField('first_name',$data->first_name);
			echo CHtml::hiddenField('last_name',$data->last_name);
				$this->widget('bootstrap.widgets.TbButtonGroup', array(
						'stacked'=>true,
						'htmlOptions'=>array('class'=>'span12'),
						'buttons'=>$actionButtons,
				));
			echo CHtml::endForm();						// for portfolio			echo CHtml::beginForm($data->generatePortfolioFileEmployerUrl(),'POST',array('id'=>'download-resume-form1'));			//echo CHtml::beginForm($data->generateResumeFileEmployerUrl(),'POST',array('id'=>'download-resume-form1'));			echo CHtml::hiddenField('student_id',$data->student_id);			echo CHtml::hiddenField('stu_job_id',$data->stu_job_id);			echo CHtml::hiddenField('first_name',$data->first_name);			echo CHtml::hiddenField('last_name',$data->last_name);				$this->widget('bootstrap.widgets.TbButtonGroup', array(						'stacked'=>true,						'htmlOptions'=>array('class'=>'span12'),						'buttons'=>$actionButtonsForPortfolio,				));			echo CHtml::endForm();
			?>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	
</div>
