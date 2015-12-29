<?php
$this->breadcrumbs=array(
	'Certifications'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Certification','url'=>array('index')),
	array('label'=>'Create Certification','url'=>array('create')),
	array('label'=>'Manage Category','url'=>array('certificationCat/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('certification-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Certifications</h1>

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
	'id'=>'certification-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'post_item_id',
		'certification_cat_name',
		'title',
		'provider',
		array(
				'name'=>'is_active',
				'class'=>'bootstrap.widgets.TbToggleColumn',
				'toggleAction'=>'toggleActive',
				'filter'=>array('1'=>'Yes','0'=>'No'),
				//'value'=>'Yii::app()->format->formatBoolean($data->isActive)',
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'buttons'=>array('delete'=>array('visible'=>'$data->is_active==true'))
		),
	),
)); ?>
