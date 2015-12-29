<?php
/* @var $this EmployerController */
/* @var $model ViewInterview*/

$cs=Yii::app()->clientScript;
$cs->registerCssFile($this->module->getAssetsUrl().'/resume.css');
$this->pageTitle=Yii::t('view', 'employer.view_interview_resume.title_lb');
$this->sectionTitle=array('title'=>$this->pageTitle,'icon'=>'icon-calendar');
?>

<div id="alert-div"></div>
<?php 
$this->renderPartial('_viewInterviewResumes',array('model'=>$model));

/*****************************A dialog for add/change the interview date****************************/
$interviewActionUrl=Yii::app()->createAbsoluteUrl('resume/employerInterview/update');
$postSaveInterviewDate=<<<EOD
$('#alert-div').html(res);
jQuery('#resume-grid-view').yiiGridView('update');
EOD;
$this->renderPartial('/common/_interviewDateDialog',array('postSaveInterviewDate'=>$postSaveInterviewDate,'interviewActionUrl'=>$interviewActionUrl));

$js=<<<EOD

$(document).on('click','.interview-resume',function(e){
	e.preventDefault();
	var stuJobDataId=$(this).data('id');
	if (typeof stuJobDataId !== 'undefined') {
		var stuJobId=stuJobDataId;
	}else{
		var stuJobId=$(this).parent('div').attr('id').replace('resume-actions','');
	}
	if (typeof stuJobId !== 'undefined') {
		var stuJobIdInputHtml='<input name="stu_job_id" type="hidden" value="'+stuJobId+'"/>';
		$('#interview-date-modal #interview-resume-data').append(stuJobIdInputHtml);
		$('#interview-date-modal').modal('show');
	}
});

$(document).on('click','.hire-resume',function(e){
	e.preventDefault();
	$('#resume-grid-view').yiiGridView('update',{url:$(this).attr('href'),type:'post',
		success:function(res){
					$('#alert-div').html(res);
					$('#resume-grid-view').yiiGridView('update');
				}
	});
	
});

EOD;
$cs->registerScript(__FILE__.$this->id.$this->action->id, $js,CClientScript::POS_READY);
