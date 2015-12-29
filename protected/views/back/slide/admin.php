<?php
$this->breadcrumbs = array(
    'Slides' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Slides', 'url' => array('index')),
    array('label' => 'Create Slide', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('slide-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Slides</h1>

<?php

$columns = array(
    'label',
    'caption',
    array(
        'name' => 'position',
        'value' => 'Formatter::formatOrdinal($row + 1)'
    ),
    array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
    ),);

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'htmlOptions' => array('class' => 'admin_slider_table'),
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'hideHeader' => true,
    'template' => "{items}",
    'columns' => array_merge(array(array('class' => 'bootstrap.widgets.TbImageColumn', 'imagePathExpression' => 'Slide::generateImagePath($data["slide_image"], $data["slide_id"])',
        'usePlaceKitten' => FALSE)), $columns),
));

?>

<?php /*$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'slide-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'slide_id',
		'slide_image',
		'label',
		'caption',
		'position',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); */
?>
