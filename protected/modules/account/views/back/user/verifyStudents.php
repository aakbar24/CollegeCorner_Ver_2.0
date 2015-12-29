<?php

/* @var $this UserController */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Verify Students',
);

$this->menu=array(
    array('label'=>'Manage'),
    array('label'=>'Manage Users','url'=>array('admin')),
		array('label'=>'Admin Operations'),
	array('label'=>'List User','url'=>array('index')),
	array('label'=>'Create User','url'=>array('create'),'visible'=>Yii::app()->user->isSuperAdmin()),
	array('label'=>'Create College Admin','url'=>array('createCollegeAdmin')),

    array('label'=>'Verification'),
    $this->getEmployerMenuItem()
);

?>

<h1>Verify Students</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'user-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
        array(
            'value' => '$data->user->first_name . " " . $data->user->last_name',
            'header' => 'Student'
        ),
        array(
            'name' => 'user.username',
            'header' => 'Username'
        ),
        array(
            'name' => 'user.date_created',
            'header' => 'Registered On'
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('nowrap' => 'nowrap'),
            'template' => '{view} {delete} | {verify}',
            'buttons' => array(
                'verify' => array(
                    'label' => 'Verify',
                    'icon' => 'thumbs-up',
                    'url' => 'Yii::app()->createUrl("user/verifyUser", array("user_id"=>$data->user_id))',
                )
            )

		),
	),
)); ?>
