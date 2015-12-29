<?php
$this->breadcrumbs=array(
	'Events'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Event','url'=>array('index')),
	array('label'=>'Create Event','url'=>array('create')),
);

$isAdminAccess=Yii::app()->user->isAdmin()||Yii::app()->user->isSuperAdmin();

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('event-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Events</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<div class="well well-small">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'event-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'post_item_id',
		array('name'=>'userId','visible'=>$isAdminAccess),
		'title',
		'start_date:date',
		'end_date:date',
		'start_time:time',
		'end_time:time',
		array(
				'name'=>'college_id',
				'header'=>'Signup Type',
				'value'=>'$data->getSignupType()',
				'filter'=>CHtml::listData(College::getAllCollege(),'college_id','college_name'),
				'type'=>'raw',
				'visible'=>$isAdminAccess,
		),
			
		array(
				'name'=>'college_id',
				'header'=>'Public Signup',
				'value'=>'Yii::app()->format->formatBoolean($data->isPublic())',
				'visible'=>yii::app()->user->isCollegeAdmin(),
		),
		
		array(
				'name'=>'is_active',
				'class'=>'bootstrap.widgets.TbToggleColumn',
				'toggleAction'=>'toggle',
				'filter'=>array('1'=>'Yes','0'=>'No'),
				//'value'=>'Yii::app()->format->formatBoolean($data->isActive)',
				'visible'=>$isAdminAccess
		),
		/* 'address',
		'city',
		'province',
		'postal_code',
		'country_id', */
		/*
		'phone',
		'ext',
		'start_date',
		'end_date',
		'start_time',
		'end_time',
		'event_image',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'buttons'=>array('delete'=>array('visible'=>'$data->is_active=="1"'))
		),
	),
)); ?>
