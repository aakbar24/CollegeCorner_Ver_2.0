<?php
/* @var $this AuthController */
/* @var $model ForgotPasswordForm */
/* @var $form TbActiveForm  */

$this->pageTitle=Yii::t('view', 'forgot.forgot_lb');

$cs = Yii::app()->getClientScript();

$cs->registerCssFile(Yii::app()->getModule('account')->getAssetsUrl() . '/account.css');
?>
<div class="offset3 span6 well well-large" id="auth-form">
	<div class="page-header">
		<h2 class="center-text"><?php echo $this->pageTitle; ?></h2>
	</div>
	<div class="form">

		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id'=>'forgot-form',
				'type'=>'horizontal',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
						'validateOnSubmit'=>true,
				),
)); ?>
		<?php echo $form->errorSummary($model); ?>
		<div class="input-row">
			<?php echo $form->textFieldRow($model,'email',array('class'=>'input-block-level','placeholder'=>Yii::t('model', 'forgot.email'),)); ?>
		</div>

		<?php if(CCaptcha::checkRequirements()): ?>
		<?php echo $form->captchaRow($model,'verifyCode',array(
			'placeholder'=>Yii::t('model', 'forgot.captcha'),
			'style'=>'margin-top:5px;',
            'hint'=>Yii::t('model', 'forgot.captcha_hint'),
        )); ?>
	<?php endif; ?>
		<div class="controls">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'warning',
					'size'=>'large',
					'label'=>Yii::t('view', 'form.reset_lb'),
			));
			?>
			
			<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'link',
					'type'=>'link',
					'url'=>$this->createUrl('auth/login'),
					'size'=>'large',
					'label'=>Yii::t('view', 'cancel_lb'),
			));
			?>
			
		</div>
		<br />
		

		<br class="clearfix" />
		<?php $this->endWidget(); ?>

	</div>
	<!-- form -->
</div>

