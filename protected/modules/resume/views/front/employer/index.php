<?php
/* @var $this EmployerController */
/* @var $model ViewStudentJobTitle */
/* @var $form TbActiveForm */

$cs=Yii::app()->clientScript;
$cs->registerCssFile($this->module->getAssetsUrl().'/resume.css');
$this->pageTitle=Yii::t('view', 'employer.view_resume.title_lb');
$this->sectionTitle=array('title'=>$this->pageTitle,'icon'=>'icon-eye-open');
?>

<div class="search-form">
	<?php $this->renderPartial('forms/_searchForm',array('model'=>$model));?>
</div>

<div id="alert-div"></div>
<?php 
$this->renderPartial('gridviews/_index',array('model'=>$model));

/*****************************A dialog for add/change the interview date****************************/
$postSaveInterviewDate=<<<EOD
$('#alert-div').html(res);
jQuery('#resume-grid-view').yiiGridView('update');
EOD;
$this->renderPartial('/common/_interviewDateDialog',array('postSaveInterviewDate'=>$postSaveInterviewDate));

/***************************  SCRIPT SECTION **************************/

$favActionUrl=Yii::app()->createAbsoluteUrl('resume/employerFav/fav');
$favAllActionUrl=Yii::app()->createAbsoluteUrl('resume/employerFav/favSelected');
$cs=Yii::app()->getClientScript();
$js=<<<EOD

$(document).on('click','.fav-resume',function(e){
	e.preventDefault();
	if (!$(this).hasClass('disabled')) {
	 	
		var url='{$favActionUrl}';
		var favStarHtml=' <i class="icon-star fav-highlight"></i>';
		var stuJobDataId=$(this).data('id');

		if (typeof stuJobDataId !== 'undefined') {
			var stuJobId=stuJobDataId;
		}else{
			var stuJobId=$(this).attr('href').substring($(this).attr('href').lastIndexOf('/')+1);
			var tooltip=$(this);
		}

		$.ajax({url:url,
				data:{stu_job_id:stuJobId},
				type:'get',
				success:function(res){
							$('#alert-div').html(res);
							jQuery('#resume-grid-view').yiiGridView('update');
						}
				});
	}
});

$(document).on('click','.interview-resume',function(e){
	e.preventDefault();
	var stuJobDataId=$(this).data('id');
	if (typeof stuJobDataId !== 'undefined') {
		var stuJobId=stuJobDataId;
	}else{
		var stuJobId=$(this).parent('div').attr('id').replace('resume-actions','');
	}
	if (typeof stuJobId !== 'undefined') {
		var stuJobIdInputHtml='<input name="stu_job_id[]" type="hidden" value="'+stuJobId+'"/>';
		$('#interview-date-modal #interview-resume-data').append(stuJobIdInputHtml);
		$('#interview-date-modal').modal('show');
	}
});

EOD;
$cs->registerScript(__FILE__.$this->id.$this->action->id, $js,CClientScript::POS_READY);

$cs->registerScript(__FILE__.'_Functions', <<<EOD
function submitFavResumes(values){
	var url='{$favAllActionUrl}';
	
	$(values).attr('name','stu_job_id[]');	
	
	var data=$(values).serialize();
	$.ajax({
		type: 'POST',
		url: url,
		data: data,
		success: function(data) {
				$('#alert-div').html(data);
				jQuery('#resume-grid-view').yiiGridView('update');
		},
	});
}
EOD
,CClientScript::POS_END);

