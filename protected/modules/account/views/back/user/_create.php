<?php
/* @var $this RegisterController */
/* @var $model RegisterForm */
/* @var $form TbActiveForm */

 ?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->textFieldRow($model->user,'username',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model->user,'email',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model->user,'first_name',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model->user,'last_name',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->passwordFieldRow($model->user,'password',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->passwordFieldRow($model,'confirmPassword',array('class'=>'span5','maxlength'=>255)); ?>
	
	<?php echo $form->dropDownListRow($model->user,'user_group_id',CHtml::listData(UserGroup::getSuperAdminFormDropdown(Yii::app()->user->user_group_id), 'user_group_id', 'user_group_name')); ?>
	
	<?php echo $form->hiddenField($model,'consented',array('value'=>'1')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Create',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
