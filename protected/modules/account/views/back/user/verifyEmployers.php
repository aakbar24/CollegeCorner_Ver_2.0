<?php

/* @var $this UserController */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Verify Employers',
);

$this->menu=array(

    array('label'=>'Manage'),
    array('label'=>'Manage Users','url'=>array('admin')),
		array('label'=>'Admin Operations'),
	array('label'=>'List User','url'=>array('index')),
	array('label'=>'Create User','url'=>array('create'),'visible'=>Yii::app()->user->isSuperAdmin()),
	array('label'=>'Create College Admin','url'=>array('createCollegeAdmin')),

    array('label'=>'Verification'),
    $this->getStudentMenuItem(),
);

?>

<h1>Verify Employers</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'user-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
        array(
            'name' => 'company_name',
            'header' => 'Company'
        ),
        array(
            'name' => 'user.username',
            'header' => 'Username'
        ),
        array(
            'value' => '$data->user->first_name . " " . $data->user->last_name',
            'header' => 'Employer'
        ),
        array(
            'name' => 'user.date_created',
            'header' => 'Registered On'
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('nowrap' => 'nowrap'),
            'template' => '{view} {delete} | {sendActivation} {verify}',
            'buttons' => array(
            'sendActivation' => array(
                'label' => 'Send activation e-mail',
                'icon' => 'envelope',
                'url' => 'Yii::app()->createUrl("user/sendActivation", array("user_id"=>$data->user_id))'),

                'verify' => array(
                    'label' => 'Verify',
                    'icon' => 'thumbs-up',
                    'url' => 'Yii::app()->createUrl("user/verifyUser", array("user_id"=>$data->user_id))'
                    
                )
            )

		),
	),
)); ?>
