<?php
/* @var $this ProfileController */
/* @var $model Student */
/* @var $user User */
/* @var $form TbActiveForm */

?>

<div class="page-header">
	<h1>
		<?php echo Yii::t('view', 'profile.edit_profile_title_lb');?> <small><?php echo Yii::t('view', 'student_lb');?></small>
	</h1>
</div>

<p class="help-block">
	<?php echo Yii::t('view', 'form.field_required_hint');?>
</p>



<?php  $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'student-profile',
		'type'=>'horizontal',
		'enableAjaxValidation'=>false,
));?>

<?php echo $form->errorSummary($model); ?>

<div>
	
	<?php echo $form->dropDownListRow($model, 'college_id',CHtml::listData(College::model()->findAll(),'college_id','college_name'),
			array(
					'prompt'=>Yii::t('model', 'student.college_id_empty'),
					'ajax' => array(
							'type'=>'POST', //request type
							'url'=>$this->createUrl('register/ajaxCollegePrograms'), //url to call.
							'update'=>'#'.CHtml::activeId($model, 'program_id'), //selector to update
							'data'=>array('college'=>'js:this.value'),

					))
			);?><!--
	<?php echo $form->dropDownListRow($model, 'program_id',CHtml::listData(College::getProgramsByCollege($model->college_id),'program_id','program_name'),array('prompt'=>Yii::t('model', 'student.program_id_empty'),));?>
	<?php echo $form->textFieldRow($model, 'program_code');?>-->
	<?php echo $form->dropDownListRow($model, 'education_level_id',CHtml::listData(EducationLevel::model()->findAll(),'education_level_id','education_level_name'),array('prompt'=>Yii::t('model', 'student.education_level_id_empty')));?>
	<?php echo $form->textFieldRow($model, 'major_name');?><!--
	<?php echo $form->datepickerRow($model, 'enrollment_date',array('options'=>array('format'=>'yyyy-mm-dd')));?>-->

</div>

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
	)); ?>
</div>
<?php $this->endWidget(); ?>
