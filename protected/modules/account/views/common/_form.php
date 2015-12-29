<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

//$this->pageTitle=Yii::app()->name . ' - '.Yii::t('view', 'login.login_lb');

//$cs = Yii::app()->getClientScript();

//$cs->registerCssFile(Yii::app()->getModule('account')->getAssetsUrl() . '/account.css');
//include_once(Yii::app()->request->baseUrl.'protected/modules/account/models/forms/LoginForm.php');

include_once('/../../models/forms/LoginForm.php');
//include_once('LoginForm.php');
$isFrontEnd=Yii::app()->endName=='front';
$model=new LoginForm;

?>
<div class="offset3 span6 well well-large" id="auth-form">
	<div class="page-header">
		<h2 class="center-text"><?php echo $isFrontEnd?Yii::t('view', 'login.login_lb'):Yii::t('view', 'login.admin_login_lb');?></h2>
	</div>
	<div class="form">

		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id'=>'login-form_f',
				'type'=>'horizontal',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
						'validateOnSubmit'=>true,
				),
)); ?>
		<?php echo $form->errorSummary($model); ?>
		<div class="input-row">
			<?php echo $form->textFieldRow($model,'username',array('class'=>'input-block-level','placeholder'=>Yii::t('model', 'login.username'),)); ?>
		</div>

		<div class="input-row">
			<?php echo $form->passwordFieldRow($model,'password',array('class'=>'input-block-level','placeholder'=>Yii::t('model', 'login.password'),)); ?>
		</div>

		<div class="controls">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'size'=>'large',
					'label'=>Yii::t('view', 'login.login_lb'),
			));
			?>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'link',
					'url'=>Yii::app()->createAbsoluteUrl('account/auth/forgot'),
					'type'=>'link',
					'size'=>'normal',
					'label'=>Yii::t('view', 'login.forgot_password_lb'),
			));
			?>

		</div>
		<?php if($isFrontEnd):?>
			<br />
			<div id="signup-sec" class="center-text">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'link',
						'htmlOptions'=>array(
								'data-toggle'=>'modal',
								'data-target'=>'#signupModal',
						),
						'type'=>'link',
						'size'=>'normal',
						'label'=>Yii::t('view', 'login.signup_lb'),
				));?>
			</div>
		<?php endif;?>
		
		<br class="clearfix" />
		<?php $this->endWidget(); ?>

	</div>
	<!-- form -->
</div>