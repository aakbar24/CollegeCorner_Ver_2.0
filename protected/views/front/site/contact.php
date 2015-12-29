<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle=Yii::app()->name . ' - '.Yii::t('view', 'contact.contact_us_lb');
$this->breadcrumbs=array(
	Yii::t('nav', 'contact'),
);
?>

<div class="row-fluid">
<div class="span10 offset1">
<h1><?php echo Yii::t('view', 'contact.contact_us_lb');?></h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'alerts'=>array('contact'),
    )); ?>

<?php else: ?>

<p>
<?php echo Yii::t('view', 'contact.description_lb');?>
</p>
</div>
</div>

<hr/>

<div id="contact_form" class="form">

    <div class="row-fluid">
        <div class="span10 offset1">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'contact-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>



	<p class="note"><?php echo Yii::t('view', 'form.field_required_hint');?></p>

	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model,'name'); ?>

    <?php echo $form->textFieldRow($model,'email'); ?>

    <?php echo $form->textFieldRow($model,'subject',array('size'=>60,'maxlength'=>128)); ?>

    <?php echo $form->textAreaRow($model,'body',array('rows'=>6, 'class'=>'span8')); ?>

	<?php if(CCaptcha::checkRequirements()): ?>
		<?php echo $form->captchaRow($model,'verifyCode',array(
            'hint'=>Yii::t('model', 'contact.captcha_hint'),
        )); ?>
	<?php endif; ?>

        </div>
    </div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton',array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon' => 'icon-envelope-alt',
            'label'=>Yii::t('view', 'form.send_lb'),
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>

