<?php 
/* @var $this Controller */
/* @var $form TbActiveForm */
/* @var Yii::app()->user WebUser */
/* @var $model ViewStudentJobTitle */
$this->beginContent('//layouts/profile');
$cs=Yii::app()->clientScript;
$cs->registerCssFile($this->module->getAssetsUrl().'/resume.css');
?> 

<?php echo $content; 

/******* Bulk action download resume zip form *********/
echo CHtml::form(Yii::app()->createAbsoluteUrl('resume/file/downloadResumeZip'),'post',array('class'=>'hide','id'=>'download-zip-form'));
echo CHtml::tag('div',array('id'=>'download-zip','class'=>'hide'),true);
echo CHtml::endForm();

/************************A dialog that will hold the student profile html from the ajax request**********************************/
$this->renderPartial('/common/_profileDialog',array('ofPosition'=>'#resume-grid-view'));

$cs->registerScript(__FILE__.$this->id.'Functions', <<<EOD
function submitResumeDownloadZip(values){
	var downloadZipDiv=$('#download-zip-form #download-zip');
	appendStuJobIds(downloadZipDiv, values);
	$('#download-zip-form').submit();
	downloadZipDiv.html('');
}
		
function appendStuJobIds(valuescontainer, values){
	valuescontainer.html('');
	$(values).each(function(){
		var stuJobId=$(this).clone();
		stuJobId.attr('id','');
		stuJobId.attr('name','stu_job_id[]');
		valuescontainer.append(stuJobId);
	});
}

EOD
, CClientScript::POS_END);

$this->endContent();