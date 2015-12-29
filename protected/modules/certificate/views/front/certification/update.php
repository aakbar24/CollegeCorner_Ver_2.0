<?php
$this->pageTitle='Update - '.$model->postItem->title;
$this->sectionTitle=array('title'=>$this->pageTitle,'icon'=>'icon-certificate','backLink'=>CHtml::link('<i class="icon-chevron-left"></i>',array('/certificate/certification/manage'),array('title'=>'back')));
?>

<?php echo $this->renderPartial('certificate.views.common.certification._form',array('model'=>$model)); ?>