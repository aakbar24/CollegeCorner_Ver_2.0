<?php
/* @var $this Controller */
/* @var $model ViewStudentTitle */
/* @var $form TbActiveForm */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'employer-search-form',
		'type'=>'search',
		'action'=>$this->createAbsoluteUrl('searchResumes'),
		//'htmlOptions'=>array('class'=>'well'),
	)); ?>
<div class="normal-search">

<div class="tagit-field" style="display:inline-block; line-height:normal;">
<?php
echo $form->tagitRow($model, 'skills',
		array('class'=>'input-medium', 'prepend'=>'<i class="icon-search"></i>',
				//this is the actual javascript options of tagit
				'options'=>array(
						'tagLimit'=>5,
						'placeholderText'=>'Search skills...',
						//remove the extra tag once limit exceeded
						'onTagLimitExceeded'=>'js:function(event,ui){
						$("#employer-search-form .tagit-new input").val("");
}',
				),'id'=>'search-resume-skills-txt'));
?>
</div>
<?php 
echo CHtml::hiddenField('empSearch',true);
echo $form->hiddenField($model, 'advanced',array('id'=>'emp-advanced-search'));
echo $form->hiddenField($model, 'pageSize');
?>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Go','type'=>'primary')); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'button', 'label'=>'Advance Options','htmlOptions'=>array('id'=>'btn-emp-adv-search'))); ?>

<p class="help-block">
	<b>Note:</b> Max 5, hit "comma" or "enter" for each skill
</p>
<p>

	<a href="http://www.centennialcollege.ca/employment/co-opresources" target="_blank">Click here for Co-op Leads...</a>

</p>

</div>
<div
	class="advance-search <?php echo ($model->advanced==true?'':'hide')?> well">
	<h4>Advanced Search Options</h4>
	<div class="search-control-row">
		<?php echo $form->dropDownList($model, 'job_cat_id',CHtml::listData(JobCat::getAllCategories(),'job_cat_id','job_cat_name'),
				array(
						'prompt'=>Yii::t('model', 'postResumeForm.jobCat_empty'),
						'id'=>'search-jobCat-dropdown',
						'ajax' => array(
								'type'=>'POST', //request type
								'url'=>$this->createUrl('employer/ajaxGetJobTitles'), //url to call.
								'update'=>'#'.CHtml::activeId($model, 'job_title_id'), //selector to update
								'data'=>array('jobCat'=>'js:this.value'),

						)
				)
			);?>
		<?php echo $form->dropDownList($model, 'job_type_id',CHtml::listData(JobType::getAllTypes(),'job_type_id','job_type_name'),array('prompt'=>Yii::t('model', 'postResumeForm.jobType_empty'),));?>
		<?php echo $form->dropDownList($model, 'college_id', CHtml::listData(College::getAllCollege(), 'college_name', 'college_name'),array('prompt'=>Yii::t('model', 'student.college_id_empty')));?>
		<?php echo $form->dropDownList($model, 'ECWS_id',CHtml::listData(EcwsCourse::getAllEcws(),'ECWS_id','ECWS_name'),array('prompt'=>Yii::t('model', 'postResumeForm.ecwsCourse_empty'),));?>
	</div>
	<div class="search-control-row">
		<?php echo $form->textField($model, 'first_name',array('placeholder'=>Yii::t('model', 'user.first_name')));?>
		<?php echo $form->textField($model, 'last_name',array('placeholder'=>Yii::t('model', 'user.last_name')));?>
		<?php echo $form->dropDownList($model, 'job_title_id', CHtml::listData(JobTitle::getAllTitlesByCategory($model->job_cat_id),'job_title_id','job_title_name'),
				array('prompt'=>Yii::t('model', 'viewStudentJobTitle.jobTitles_empty'))
 		);?>
 		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Go','type'=>'primary')); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'button', 'label'=>'Close','htmlOptions'=>array('id'=>'btn-close-emp-adv-search'))); ?>
	</div>

</div>
<?php $this->endWidget(); 

Yii::app()->clientScript->registerScript('employer-search-form-advance-btn', "

$(document).on('click','#employer-search-form #btn-emp-adv-search', function(e){
	if(!$('#employer-search-form .advance-search').toggle().is(':visible')){
		$('#employer-search-form .advance-search input, #employer-search-form .advance-search select').val('');
		$('#employer-search-form #emp-advanced-search').val(0);
	}else{
		$('#employer-search-form #emp-advanced-search').val(1);
	}
	return false;
});
		
$(document).on('click','#employer-search-form #btn-close-emp-adv-search', function(e){
	$('#employer-search-form .advance-search').hide();
	$('#employer-search-form .advance-search input, #employer-search-form .advance-search select').val('');
	$('#employer-search-form #emp-advanced-search').val(0);
	return false;
});
		",CClientScript::POS_READY);
?>

