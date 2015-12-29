<?php
/* @var $this AuthController */
/* @var $model User */
/* @var $form TbActiveForm */

?>

<div class="page-header">
	<h1>
		<?php echo Yii::t('view', 'auth.edit_account_title_lb');?>
	</h1>
</div>

<p class="help-block">
	<?php echo Yii::t('view', 'form.field_required_hint');?>
</p>

<?php  $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'edit-account-form',
		'type'=>'horizontal',
		'enableAjaxValidation'=>false,
));?>

<?php echo $form->errorSummary($model); ?>

	<?php if(Yii::app()->endName=='front'):?>
	<div class="control-group">
		<?php echo $form->labelEx($model->user, 'profile_image',array('class'=>'control-label'));?>
		<div class="controls">
			<?php $this->widget('bootstrap.widgets.TbUberUploadCropper',array(
					'model'=>$model->user,'attribute'=> 'profileImagePath',
					'existingFileAttribute'=>'profile_image','existingFileFolder'=>Yii::app()->baseUrl.'/files/images/avatars',
					'tagHtmlOptions'=>array('class'=>'span5'),
					'uploadFolder'=>Yii::app()->baseUrl.'/files/uploads/avatars',
					'uploadActionUrl'=>$this->createAbsoluteUrl('upload'),
					'cropActionUrl'=>$this->createAbsoluteUrl('crop'),
					'cropCoor'=>array(0,0,140,140),
			)
			);?>
		</div>
	</div>
	<?php endif;?>

	<?php echo $form->textFieldRow($model->user,'username',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model->user,'email',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model->user,'first_name',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model->user,'last_name',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->passwordFieldRow($model,'currentPassword',array('class'=>'span5')); ?>

	<?php echo $form->passwordFieldRow($model,'newPassword',array('class'=>'span5')); ?>
	<?php echo $form->passwordFieldRow($model,'confirmPassword',array('class'=>'span5')); ?>
	
	
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
			'visible'=>Yii::app()->endName=='front',
	)); ?>
</div>
<?php $this->endWidget(); ?>