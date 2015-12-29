<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'thread-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'post_item_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'program_code',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'college_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'program_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'semester_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'attachment',array('class'=>'span5','maxlength'=>100)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
