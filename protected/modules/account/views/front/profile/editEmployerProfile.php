<?php
/* @var $this ProfileController */
/* @var $model Employer */
/* @var $form TbActiveForm */

?>

<div class="page-header">
	<h1>
		<?php echo Yii::t('view', 'profile.edit_profile_title_lb');?> <small><?php echo Yii::t('view', 'employer_lb');?></small>
	</h1>
</div>

<p class="help-block">
	<?php echo Yii::t('view', 'form.field_required_hint');?>
</p>


<?php  $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'employer-profile',
		'type'=>'horizontal',
		'enableAjaxValidation'=>false,
));?>

<?php echo $form->errorSummary($model); ?>

<div>
	
	<?php echo $form->textFieldRow($model, 'company_name');?>
	<?php echo $form->textAreaRow($model, 'address');?>
	<?php echo $form->textFieldRow($model, 'city');?>
	<?php echo $form->textFieldRow($model, 'province');?>
	<?php echo $form->textFieldRow($model, 'postal_code');?>
	<?php echo $form->dropDownListRow($model, 'country_id',CHtml::listData(Country::getAllCountries(),'country_id','country_name'),array('prompt'=>Yii::t('model', 'employer.country_id_empty')));?>
	<div class="control-group">
		<?php echo $form->labelEx($model, 'phone',array('class'=>'control-label')); ?>
		<div class="controls">
	
	<?php $this->widget('CMaskedTextField', array('model' => $model,'attribute' => 'phone','mask' => '(999) 999-9999',));?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model, 'ext');?>
	<?php echo $form->textFieldRow($model, 'website',array('type'=>'url'));?>

</div>

<div class="form-actions">

	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>Yii::t('view', 'form.save_lb'),
	)); ?>
	
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'type'=>'link',
			'label'=>Yii::t('view', 'cancel_lb'),
			'url'=>$this->createAbsoluteUrl('/profile/view'),
	)); ?>
</div>
<?php $this->endWidget(); ?>
