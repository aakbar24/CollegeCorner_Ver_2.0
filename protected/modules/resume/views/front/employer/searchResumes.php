<?php
/* @var $this ResumePostController */
/* @var $model ViewStudentJobTitle */
/* @var $form TbActiveForm */

$cs=Yii::app()->clientScript;
$cs->registerCssFile($this->module->getAssetsUrl().'/resume.css');
$this->pageTitle=Yii::t('view', 'employer.search_resumes.title_lb');
$this->sectionTitle=array('title'=>$this->pageTitle,'icon'=>'icon-search',);
?>

<div class="search-form">
	<?php $this->renderPartial('forms/_searchForm',array('model'=>$model));?>
</div>

<div class="row-fluid search-bulk-actions">
	<div class="span2">
		<div class="check-all-div">
		<?php echo CHtml::label(CHtml::checkBox('resume-items-all',false,array('id'=>'resume-items-all','class'=>'resume-item-checkbox-all')).' Check All <i class="icon-check"></i>','resume-items-all');?>
		</div>
	</div>
	<div class="span10">
		<div class="pull-right">
			
			<?php 
			$this->widget('bootstrap.widgets.TbButton',array(
					'label'=>'Download selected resumes',
					'buttonType'=>'button',
					'type'=>'primary',
					'icon'=>'white download-alt',
					'id'=>'btn-download-resumes-zip',
					'disabled'=>true,
					'size' => 'small',	));						// Bulk download for Portfolio						$this->widget('bootstrap.widgets.TbButton',array(					'label'=>'Download selected portfolios',					'buttonType'=>'button',					'type'=>'primary',					'icon'=>'white download-alt',					'id'=>'btn-download-portfolios-zip',					'disabled'=>true,					'size' => 'small',	));						
			?>
		</div>
	</div>
</div>
<?php 
$this->renderPartial('listviews/_viewResumes',array('model'=>$model));

/******* Bulk action download resume zip form *********/echo CHtml::beginForm(Yii::app()->createAbsoluteUrl('resume/file/downloadResumeZip'),'post',array('class'=>'hide','id'=>'download-zip-form'));echo CHtml::tag('div',array('id'=>'download-zip','class'=>'hide'),true);echo CHtml::endForm();// Bulk action download portfolio zip formecho CHtml::beginForm(Yii::app()->createAbsoluteUrl('resume/file/downloadPortfolioZip'),'post',array('class'=>'hide','id'=>'download-zip-form_portfolio'));echo CHtml::tag('div',array('id'=>'download-zip_portfolio','class'=>'hide'),true);echo CHtml::endForm();

/************************A dialog that will hold the student profile html from the ajax request**********************************/
$this->renderPartial('/common/_profileDialog',array('ofPosition'=>'#view-resumes'));

/*****************************A dialog for add the interview date****************************/
//temp container to hold ajax response of the selected resume interview
echo CHtml::tag('div',array('id'=>'temp-interview-postajax-holder','class'=>'hide'),true);

$postSaveInterviewDate=<<<EOD
var tempPostAjaxHolder=$('#temp-interview-postajax-holder');
tempPostAjaxHolder.html(res);
var interviewedResumes=tempPostAjaxHolder.find('input[name="interviewed-resumes"]').val();
var interviewedDate=tempPostAjaxHolder.find('input[name="interviewed-date"]').val();
if (typeof interviewedResumes !=='undefined' ) {
	interviewedResumes=interviewedResumes.split(',');
	if(typeof interviewedDate !=='undefined')
		var interviewDateHtml='<dt>Interview Date</dt><dd>'+interviewedDate+'</dd>';
	$(interviewedResumes).each(function(idx,value){
		var interviewIconHtml='<i class="icon-calendar"></i>';

		$('#resume'+value+'-alert-div').html(res);
		$('#resume-item-details'+value+' .interview-resume').addClass('disabled').attr('disabled',true);

		if(typeof interviewedDate !=='undefined'){
			$('#resume-item-details'+value+' h4').append(interviewIconHtml);
			$('#resume-item-details'+value+' .dl-horizontal').append(interviewDateHtml);
		}

	});
}
tempPostAjaxHolder.html('');
EOD;
$this->renderPartial('/common/_interviewDateDialog',array('postSaveInterviewDate'=>$postSaveInterviewDate));

/*************************************SCRIPT SCETION********************************************/
Yii::app()->clientScript->registerScript(__FILE__.'_Scripts', <<<EOD

$(document).on('click', 'input[type="checkbox"].resume-item-checkbox, #resume-items-all', function(e){

	if($(this).attr('id')==='resume-items-all'){
		if($(this).is(':checked')){
			$('input[type="checkbox"].resume-item-checkbox').attr('checked',true);
		}else{
			$('input[type="checkbox"].resume-item-checkbox').attr('checked',false);
		}
	}else{
		if(!$(this).is(':checked')){
			$('#resume-items-all').attr('checked',false);
		}
	}

	if($('input[type="checkbox"]:checked.resume-item-checkbox').length>=1){
		$('#btn-download-resumes-zip').removeClass('disabled').attr('disabled',false);		$('#btn-download-portfolios-zip').removeClass('disabled').attr('disabled',false);		
	}else{
		$('#btn-download-resumes-zip').addClass('disabled').attr('disabled',true);		$('#btn-download-portfolios-zip').addClass('disabled').attr('disabled',true);
	}
});

$(document).on('click','#btn-download-resumes-zip',function(e){

	var downloadZipDiv=$('#download-zip-form #download-zip');
	downloadZipDiv.html('');
	$('input[type="checkbox"]:checked.resume-item-checkbox').each(function(){
		var stuJobId=$(this).clone();
		stuJobId.attr('name','stu_job_id[]');
		downloadZipDiv.append(stuJobId);
	});

	$('#download-zip-form').submit();
	downloadZipDiv.html('');

	return false;
});/*fjdf*/$(document).on('click','#btn-download-portfolios-zip',function(e){	var downloadZipDiv=$('#download-zip-form_portfolio #download-zip_portfolio');	downloadZipDiv.html('');	$('input[type="checkbox"]:checked.resume-item-checkbox').each(function(){		var stuJobId=$(this).clone();		stuJobId.attr('name','stu_job_id[]');		downloadZipDiv.append(stuJobId);	});	$('#download-zip-form_portfolio').submit();	downloadZipDiv.html('');	return false;});

		
$(document).on('change','#view-resumes .page-size-dropdown', function(e){
		var attr=$(this).attr('name');

		var existingPageSize=$('input[name=\"'+attr+'\"]').length;

		if(existingPageSize<=0){
			var pageSize=$('<input/>',{type:'hidden',name:attr,value:$(this).val()});
			$('.search-form #employer-search-form').append(pageSize);
		}else{
			$('input[name=\"'+attr+'\"]').val($(this).val());
		}
		$('.search-form #employer-search-form').submit();
});

$(document).on('submit', '#employer-search-form',function(e){
		e.preventDefault();
		var data=$(this).serialize();
		$.fn.yiiListView.update('view-resumes',{data: data, success:function(res){afterListViewUpdate(res);}});
});
		
$(document).on('click','#view-resumes .pagination a', function(e){
		e.preventDefault();
		var data=$('#employer-search-form').serialize();
		var url=$(this).attr('href');
		var li=$(this).parent('li');
		if (!li.hasClass('disabled') && !li.hasClass('active')) {
			$.fn.yiiListView.update('view-resumes',{url:url, data: data, success:function(res){afterListViewUpdate(res);}});
		}
		
});
		
highlightSearchTags();
EOD
,
CClientScript::POS_READY);

Yii::app()->clientScript->registerScript(__FILE__.'_Functions', <<<EOD
function highlightSearchTags(){

	$.each($('#search-resume-skills-txt').tagit('assignedTags'),function(idx,val){
		var pattern=new RegExp(val,'i');
		$('#view-resumes .resume-details .resume-skills').each(function(key, obj){
			var skill=$(obj).text();
			if(pattern.test(skill)){
				$(obj).removeClass('label-info').addClass('label-warning');
			}
		});
	});
}

function afterListViewUpdate(res){
	$('#view-resumes').replaceWith(res);
	highlightSearchTags();
}
EOD
,CClientScript::POS_END);




