<?php
/* @var $this ResumePostController */
/* @var $model PostResumeForm */
/* @var $form TbActiveForm */
?>

<div class="page-header">
	<h1>
		<?php echo Yii::t('view', 'resume_post_lb');?> <small>(<?php echo $model->getCountUserJobs()?> / <?php echo Yii::app()->params['maxResumeJobTitles']?> Posted)</small>
	</h1>
</div>

<p class="help-block">
	<?php echo Yii::t('view', 'form.field_required_hint');?>
</p>

<?php  $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'post-resume-form',
		'type'=>'horizontal',
		'enableAjaxValidation'=>false,
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<legend><?php echo Yii::t('view', 'resumePost.post_info_lb');?></legend>
	<?php echo $form->dropDownListRow($model, 'jobType',CHtml::listData(JobType::getAllTypes(),'job_type_id','job_type_name'),array('prompt'=>Yii::t('model', 'postResumeForm.jobType_empty'),));?>
	<?php echo $form->fileFieldRow($model, 'resumeFile');?>	<?php echo $form->fileFieldRow($model, 'portfolioFile');?>		<?php echo $form->dropDownListRow($model, 'ecwsCourse',CHtml::listData(EcwsCourse::getAllEcws(),'ECWS_id','ECWS_name'),array('prompt'=>Yii::t('model', 'postResumeForm.ecwsCourse_empty'),));?>
	<?php echo $form->tagitRow($model, 'skills',array(
			'options'=>array(
					'allowSpaces'=>true,
					),
			'class'=>'span9',
			'hint'=>Yii::t('model', 'postResumeForm.skills_hint'),
			));?>
</fieldset>

<fieldset>
	<legend><?php echo Yii::t('view', 'resumePost.job_info_lb');?></legend>
	<?php echo $form->dropDownListRow($model, 'jobCat',CHtml::listData(JobCat::getAllCategories(),'job_cat_id','job_cat_name'),
				array(
						'prompt'=>Yii::t('model', 'postResumeForm.jobCat_empty'),
						'ajax' => array(
								'type'=>'POST', //request type
								'url'=>$this->createUrl('resumePost/ajaxJobTitles'), //url to call.
								'update'=>'#jobTitles .controls', //selector to update
								'data'=>array('jobCat'=>'js:this.value'),
						),
						'class'=>'span9',
					)
			);?>
	
	<div id="jobTitles">
		<?php echo $form->checkBoxListRow($model, 'jobTitles', CHtml::listData(JobTitle::getTitlesByCategory($model->jobCat,Yii::app()->user->id),'job_title_id','job_title_name'));?>
	</div>
</fieldset>
<div class="form-actions">

	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>Yii::t('view', 'form.post_lb'),
	)); ?>
	
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'type'=>'link',
			'label'=>Yii::t('view', 'cancel_lb'),
			'url'=>$this->createUrl('index'),
			
	)); ?>
</div>

<?php $this->endWidget(); ?>

<?php 
$cs=Yii::app()->clientScript;

$cs->registerScript('jobTitleCheckboxes',

'jQuery("#jobTitles .controls").on("click","input[type=checkbox]",function(e){
	if(this.checked)
	{
		if(jQuery("#jobTitles .controls input:checked").length>'.(intval(Yii::app()->params['maxResumeJobTitles'])-$model->getCountUserJobs()).')
		{
			alert("'.sprintf(Yii::t('app', 'msg.alert.max_job_titles_exceed'),Yii::app()->params['maxResumeJobTitles'],$model->getCountUserJobs()).'");
			return false;
		}
	}
});', 
		CClientScript::POS_READY);
?>