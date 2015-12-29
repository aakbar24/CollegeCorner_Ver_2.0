<?php

/* @var $this UserController */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
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

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'user-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
    'rowCssClassExpression' => function($row, $data)
    {
        $class = "";
        if ($data['is_active'] == 0)
            $class .= ' inactive';
        if ($data['is_verified'] == 0)
            $class .= ' not_verified';
        return trim($class);
    },
	'columns'=>array(
		/*'user_id',*/
		'username',
		'email:email',
		'first_name',
		'last_name',
		
		array(
                'header'=>'Active',
				'name'=>'is_active',
				'filter'=>array('1'=>'Active','0'=>'In-Active'),
				'value'=>'Yii::app()->format->formatBoolean($data->is_active)',
		),
        array(
            'header'=>'Verified',
            'name'=>'is_verified',
            'filter'=>array('1'=>'Yes','0'=>'No'),
            'value'=>'Yii::app()->format->formatBoolean($data->is_verified)',
        ),
			
		array(
				'name'=>'user_group_id', 
				'filter'=>CHtml::listData(UserGroup::getAdminFilter(Yii::app()->user->user_group_id), 'user_group_id', 'user_group_name'),
				'value'=>'$data->userGroupName'
				),
		/*
		'profile_image',
		'user_group_id',
		'membership_level_id',
		'is_notify',
		'is_active',
		'date_created',
		'date_updated',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {update} {delete} {sendActivation}',
			'buttons'=>array('delete'=>array('visible'=>'$data->is_active'), 'sendActivation' => array(
                'label' => 'Send activation e-mail',
                'icon' => 'envelope',
                'url' => 'Yii::app()->createUrl("user/sendActivation", array("user_id"=>$data->user_id))'))
		),
	),
)); ?>
