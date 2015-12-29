<?php
/* @var $this RegisterController */
/* @var $model RegisterForm */
/* @var $form TbActiveForm */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create College Admin',
);

$this->menu=array(
    array('label'=>'Admin Operations'),
    array('label'=>'List User','url'=>array('index')),
    array('label'=>'Create User','url'=>array('create'),'visible'=>Yii::app()->user->isSuperAdmin()),
    array('label'=>'Create College Admin','url'=>array('createCollegeAdmin')),

    array('label'=>'Verification'),
    $this->getEmployerMenuItem(),
    $this->getStudentMenuItem(),
);
?>

<h1>Create College Admin </h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'college-admin-form',
	'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model->user,'username',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model->user,'email',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model->user,'first_name',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model->user,'last_name',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->passwordFieldRow($model->user,'password',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->passwordFieldRow($model,'confirmPassword',array('class'=>'span5','maxlength'=>255)); ?>
	
	<?php echo $form->hiddenField($model->user,'user_group_id'); ?>
	
	<?php echo $form->hiddenField($model,'consented',array('value'=>'1')); ?>
	
	<?php echo $form->dropDownListRow($model->collegeAdmin, 'college_id',CHtml::listData(College::model()->findAll(),'college_id','college_name'),
			array(
					'prompt'=>Yii::t('model', 'student.college_id_empty'),
					)
			);?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Create',
		)); ?>
	</div>

<?php $this->endWidget(); ?>