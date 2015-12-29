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

/************************A dialog that will hold the student profile html from the ajax request**********************************/
$this->renderPartial('/common/_profileDialog',array('ofPosition'=>'#resume-grid-view'));

$this->endContent();