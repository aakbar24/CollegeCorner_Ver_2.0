<?php
/* @var $this PostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Post Items',
);

$this->menu=array(
	array('label'=>'Create PostItem', 'url'=>array('create')),
	array('label'=>'Manage PostItem', 'url'=>array('admin')),
);
?>

<h1>Post Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
