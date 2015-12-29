<?php 
$this->pageTitle='Update - '.$model->postItem->title;
$this->sectionTitle=array('title'=>$this->pageTitle,'icon'=>'icon-wrench','backLink'=>CHtml::link('<i class="icon-chevron-left"></i>',array('/workshop/workshop/manage'),array('title'=>'back')));
?>
<?php echo $this->renderPartial('workshop.views.common.workshop._form', array('model'=>$model)); ?>