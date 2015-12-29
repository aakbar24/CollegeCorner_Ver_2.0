<?php
/* @var $this ProfileController */
/* @var $model Student */
/* @var $user User */
/* @var $form TbActiveForm */

?>
<div id="profile<?php echo $model->user_id?>" data-id="<?php echo $model->user_id?>">
<div class="page-header">
	<?php if(Yii::app()->user->id==$model->user_id):?>
	<h1>
		<?php echo Yii::t('view', 'profile.view_profile_title_lb');?> <small><?php echo Yii::t('view', 'student_lb');?></small>
	</h1>
	<?php else:?>
	<h2>
		<?php echo $model->user->first_name.' '.$model->user->last_name;?> <small><?php echo Yii::t('view', 'student_lb');?></small>
	</h2>
	<?php endif;?>
</div>

<fieldset>
<legend>
		<?php echo Yii::t('view', 'account_info_lb');?> 
		<?php echo (Yii::app()->user->id==$model->user_id?CHtml::link('<i class="icon-edit"></i>',array('/account/profile/editAccount')):'');?>
</legend>
	<?php 
	$this->widget('bootstrap.widgets.TbDetailView', array(
		'type'=>array('bordered','condensed'),
		'data'=>$model->user,
		    'attributes'=>array(
		    	'profile_image'=>array('label'=>$model->user->getAttributeLabel('profile_image'), 'type'=>'raw','value'=>CHtml::image($model->user->getProfileImageUrl()),'visible'=>Yii::app()->user->id==$model->user_id&&$model->user->profile_image!=''),
			    'username',
		    	'userGroup.user_group_name',
		    	'name'=>array('label'=>'Name','value'=>$model->user->first_name.' '.$model->user->last_name),
		    	'email'=>array('label'=>$model->user->getAttributeLabel('email'), 'type'=>'raw','value'=>CHtml::mailto($model->user->email,$model->user->email)),
		    ),
		));
	?>	

</fieldset>

<fieldset>
	<legend>
		<?php echo Yii::t('view', 'student_info_lb');?> 
		<?php echo (Yii::app()->user->id==$model->user_id?CHtml::link('<i class="icon-edit"></i>',array('/account/profile/editProfile'), array('title'=>'Edit Profile')):'');?>
	</legend>
	<?php 
	$this->widget('bootstrap.widgets.TbDetailView', array(
			'type'=>array('bordered','condensed'),
			'data'=>$model,
			'attributes'=>array(
					'college.college_name',
/*					'program.program_name',
					'program_code',*/
					'educationLevel.education_level_name',
					'major_name',
/*					'enrollment_date',*/
					 
			),
	));
	?>
	

</fieldset>
</div>
