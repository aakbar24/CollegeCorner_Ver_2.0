<?php

/* @var $this Controller */

/* @var $model ViewStudentJobTitle */

/* @var $form TbActiveForm */



$this->pageTitle=Yii::t('view', 'studentInterview.index.title_lb');

$this->sectionTitle=array('title'=>$this->pageTitle,'icon'=>'icon-calendar');

?>



<?php

if (isset($alertMsg))

	$this->renderPartial('/common/_alerts',array('type'=>$alertType,'msg'=>$alertMsg));

 

$this->renderPartial('gridviews/_index',array('model'=>$model));

$this->renderPartial('/common/_interviewCancelDialog',array('model'=>$interviewCancelForm));



Yii::app()->clientScript->registerScript(__FILE__, 

<<<EOD

function cancelInterview(actionElem){

	var actionElem=$(actionElem);

	openCancelInterviewDialog(actionElem.data('stu-job-id'),actionElem.data('from'),actionElem.data('to'));

}

EOD

,CClientScript::POS_END);

