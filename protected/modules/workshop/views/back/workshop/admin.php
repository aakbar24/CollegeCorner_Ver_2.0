<?php
$this->breadcrumbs=array(
	'Workshops'
);

$this->menu=array(
	//array('label'=>'List Workshop','url'=>array('index')),
	array('label'=>'Create Workshop','url'=>array('create')),
	array('label'=>'Manage Category','url'=>array('/workshop/workshopCat/admin')),
	array('label'=>'Manage Facilitator','url'=>array('/workshop/workshopFacilitator/admin')),
    array('label'=>'Planned Workshops'),
    array('label'=>'Manage','url'=>array('/workshop/workshopPlanned/admin')),
    array('label'=>'New','url'=>array('/workshop/workshopPlanned/create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('workshop-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Workshops</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('workshop.views.common.workshop._search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'workshop-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        'title',
		array('filter'=>CHtml::listData(WorkshopCat::getAllCategories(), 'workshop_cat_id', 'workshop_cat_name'),'name'=>'workshop_cat_id','value'=>'$data->workshop_cat_name'),
		'start_date:date',
		'end_date:date',
			
		'start_time:time',
		'end_time:time',
		
		array(
				'name'=>'is_approved',
				'class'=>'bootstrap.widgets.TbToggleColumn',
				'toggleAction'=>'toggleApproved',
				'filter'=>array('1'=>'Yes','0'=>'No'),
				//'value'=>'Yii::app()->format->formatBoolean($data->isActive)',
		),
		array(
				'name'=>'is_active',
				'class'=>'bootstrap.widgets.TbToggleColumn',
				'toggleAction'=>'toggleActive',
				'filter'=>array('1'=>'Yes','0'=>'No'),
				//'value'=>'Yii::app()->format->formatBoolean($data->isActive)',
		),
        array(
            'name'=>'is_running',
            'class'=>'bootstrap.widgets.TbToggleColumn',
            'toggleAction'=>'toggleRunning',
            'filter'=>array('1'=>'Yes','0'=>'No'),
            'afterToggle'=>'function(success,data){ if (success) alert(data); }',
            //'value'=>'Yii::app()->format->formatBoolean($data->isActive)',
        ),
		
		/*
		'postal_code',
		'country_id',
		'phone',
		'ext',
		'start_date',
		'end_date',
		'start_time',
		'end_time',
		'website',
		'is_approved',
		'workshop_image',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'buttons'=>array('delete'=>array('visible'=>'$data->is_active==true'))
		),
	),
)); ?>
