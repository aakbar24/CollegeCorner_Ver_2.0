<?php
/* @var $this RegisterController */
/* @var $model EmployerRegisterForm */
/* @var $user User */
/* @var $form TbActiveForm */

?>
<div class="wedge">
<div>
	<h1>
		<?php echo Yii::t('view', 'registration_lb');?> <small><?php echo Yii::t('view', 'employer_lb');?></small>
	</h1>
</div>

<p class="help-block">
	<?php echo Yii::t('view', 'form.field_required_hint');?>
</p>



<?php  $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'user-form',
		'type'=>'horizontal',
		'enableAjaxValidation'=>false,
));?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<legend><?php echo Yii::t('view', 'account_info_lb');?></legend>
	<?php $this->renderPartial('application.modules.account.views.common.register._form',array('model'=>$model,'form'=>$form));?>
</fieldset>

<fieldset>
	<legend><?php echo Yii::t('view', 'employer_info_lb');?></legend>

	<?php echo $form->textFieldRow($model->employer, 'company_name');?>
	<?php echo $form->textAreaRow($model->employer, 'address');?>
	<?php echo $form->textFieldRow($model->employer, 'city');?>
	<?php echo $form->textFieldRow($model->employer, 'province');?>
	<?php echo $form->textFieldRow($model->employer, 'postal_code');?>
	<?php echo $form->dropDownListRow($model->employer, 'country_id',CHtml::listData(Country::getAllCountries(),'country_id','country_name'),array('prompt'=>Yii::t('model', 'employer.country_id_empty')));?>
	<div class="control-group">
		<?php echo $form->labelEx($model->employer, 'phone',array('class'=>'control-label')); ?>
		<div class="controls">
	
	<?php $this->widget('CMaskedTextField', array('model' => $model->employer,'attribute' => 'phone','mask' => '(999) 999-9999',));?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model->employer, 'ext');?>
	<?php echo $form->textFieldRow($model->employer, 'website',array('type'=>'url'));?>

</fieldset>

    <?php echo $form->checkBoxRow($model, 'consented');?>

<div class="form-actions">

	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>Yii::t('view', 'form.register_lb'),
	)); ?>
</div>
<?php $this->endWidget(); ?>
</div>
