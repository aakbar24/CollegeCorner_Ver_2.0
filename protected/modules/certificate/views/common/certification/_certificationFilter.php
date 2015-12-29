<?php
/* @var $this Controller */
/* @var $model ViewStudentTitle */
/* @var $form TbActiveForm */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'certification-search-form',
		'type'=>'search',
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
		//'action'=>$this->createAbsoluteUrl('searchResumes'),
		//'htmlOptions'=>array('class'=>'well'),
	)); ?>
<div class="normal-search">
<?php echo $form->textFieldRow($model, 'title',array('placeholder'=>'Search title', 'prepend'=>'<i class="icon-search"></i>',));?> 
<?php echo $form->dropDownList($model, 'certification_cat_id',CHtml::listData(CertificationCat::getAllCertCats(),'certification_cat_id','certification_cat_name'),array('prompt'=>'Select a Category',));?>   
<?php echo $form->dropDownList($model, 'provider',CHtml::listData(Certification::getAllProviders(),'provider','provider'),array('prompt'=>'Select a provider',));?> 
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Search','type'=>'primary')); ?> 
<?php //$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'button', 'label'=>'Advance Options','htmlOptions'=>array('id'=>'btn-cert-adv-search'))); ?>

</div>

<?php $this->endWidget(); 
/* 
Yii::app()->clientScript->registerScript('certification-search-form-advance-btn', "

$(document).on('click','#certification-search-form #btn-cert-adv-search, #certification-search-form #btn-close-cert-adv-search', function(e){
	$('#certification-search-form .advance-search').toggle();
	return false;
});
		",CClientScript::POS_READY); */
?>

