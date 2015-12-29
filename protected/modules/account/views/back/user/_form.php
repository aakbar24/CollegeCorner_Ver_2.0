<?php /* @var $form TbActiveForm */?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->dropDownListRow($model,'is_notify', array('1'=>'Notify','0'=>'Not Notify'), array('class'=>'span5','maxlength'=>1)); ?>
	
	<?php echo $form->dropDownListRow($model,'is_active', array('1'=>'Active','0'=>'Inactive'), array('class'=>'span5','maxlength'=>1)); ?>

	<?php if(Yii::app()->user->isSuperAdmin()):?>
		<?php echo $form->dropDownListRow($model,'user_group_id',CHtml::listData(UserGroup::getAdminFilter(Yii::app()->user->user_group_id), 'user_group_id', 'user_group_name')); ?>
	<?php endif;?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
