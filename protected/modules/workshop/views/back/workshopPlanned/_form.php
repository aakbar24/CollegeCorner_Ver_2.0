<?php /** @var $form TbActiveForm */
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'workshop-planned-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php
/** @var $model PlannedWorkshopForm */

echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model->postItem,'title',array('class'=>'span5')); ?>

    <?php echo $form->textAreaRow($model->postItem,'description',array('class'=>'span10')); ?>

    <?php echo $form->hiddenField($model,'form');?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->postItem->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
