<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->username,
);

$this->menu=array(
    array('label'=>'Manage'),
    array('label'=>'Manage Users','url'=>array('admin')),
	array('label'=>'Admin Operations'),
	array('label'=>'List User','url'=>array('index')),
	array('label'=>'Create User','url'=>array('create'),'visible'=>Yii::app()->user->isSuperAdmin()),
	array('label'=>'Create College Admin','url'=>array('createCollegeAdmin')),
	array('label'=>'Update User','url'=>array('update','id'=>$model->user_id)),
	array('label'=>'Delete User','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User','url'=>array('admin')),

    array('label'=>'Verification'),
    $this->getEmployerMenuItem(),
    $this->getStudentMenuItem(),
);
?>

<h1>View User - <?php echo $model->username; ?></h1>


<fieldset>
<legend>
		<?php echo Yii::t('view', 'account_info_lb');?> 
		</legend>
	<?php 
	$this->widget('bootstrap.widgets.TbDetailView', array(
		'type'=>array('bordered','striped'),
		'data'=>$model,
		    'attributes'=>array(
		    	'user_id',
		    	'profile_image'=>array('label'=>$model->getAttributeLabel('profile_image'), 'type'=>'raw','value'=>CHtml::image($model->getProfileImageUrl()), 'visible'=>$model->profile_image!=''),
			    'username',
		    	'userGroup.user_group_name',
		    	'name'=>array('label'=>'Name','value'=>$model->first_name.' '.$model->last_name),
		    	'email:email',
	    		'is_notify:boolean',
	    		'is_active:boolean',
	    		'date_created:dateTime',
	    		'date_updated:dateTime',
		    ),
		));
	?>	

</fieldset>
