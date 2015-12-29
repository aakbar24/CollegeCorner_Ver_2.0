<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type'=>'horizontal',
	'method'=>'get',
)); 

$isAdmin=Yii::app()->user->isAdmin()||Yii::app()->user->isSuperAdmin();

?>

<fieldset>
	<legend><?php echo Yii::t('view', 'workshop.workshop_info_lb');?></legend>
	<?php echo $form->textFieldRow($model,'post_item_id',array('class'=>'span5')); ?>

	<?php echo $form->dropDownListRow($model,'workshop_cat_id',CHtml::listData(WorkshopCat::getAllCategories(), 'workshop_cat_id', 'workshop_cat_name'),array('prompt'=>'')); ?>

	<?php echo $form->dropDownListRow($model,'workshop_facilitator_id',CHtml::listData(WorkshopFacilitator::getAllFacilitators(), 'workshop_facilitator_id', 'name'),array('prompt'=>'')); ?>
	
	<?php echo $form->textFieldRow($model, 'title'); ?>
	
	<?php echo $form->textFieldRow($model,'website',array('class'=>'span6','maxlength'=>100)); ?>

	<?php echo $form->dropDownListRow($model,'is_approved',array('1'=>'Yes','0'=>'No')); ?>
	
	<?php if($isAdmin):?>
		<?php echo $form->dropDownListRow($model,'is_active',array('1'=>'Yes','0'=>'No')); ?>
	<?php endif;?>
</fieldset>

<div class="row-fluid">
<fieldset class="span6">
	<legend><?php echo Yii::t('view', 'workshop.location_info_lb');?></legend>
	<?php echo $form->textFieldRow($model,'address',array('class'=>'span12','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'city',array('class'=>'span12','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'province',array('class'=>'span12','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'postal_code',array('class'=>'span12','maxlength'=>7)); ?>

	<?php echo $form->dropDownListRow($model, 'country_id',CHtml::listData(Country::getAllCountries(),'country_id','country_name'),array('prompt'=>Yii::t('model', 'country_id_empty')));?>

	<?php echo $form->textFieldRow($model,'phone',array('class'=>'span12','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'ext',array('class'=>'span12','maxlength'=>5)); ?>
</fieldset>

<fieldset class="span6">
	<legend><?php echo Yii::t('view', 'workshop.datetime_info_lb');?></legend>

	<?php echo $form->datepickerRow($model,'start_date',array('class'=>'span12','prepend'=>'<i class="icon-calendar"></i>', 'options'=>array('format'=>'yyyy-mm-dd'))); ?>

	<?php echo $form->datepickerRow($model,'end_date',array('class'=>'span12','prepend'=>'<i class="icon-calendar"></i>', 'options'=>array('format'=>'yyyy-mm-dd'))); ?>
	

	<?php echo $form->textFieldRow($model,'start_time',array('class'=>'span12')); ?>

	<?php echo $form->textFieldRow($model,'end_time',array('class'=>'span12')); ?>

	<div class="clearfix"></div>
</fieldset>
</div>
<div class="clearfix"></div>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
