<?php
/* @var $this Controller */

$this->breadcrumbs=array(
	'Workshop'=>array('/workshop/workshop/admin'),
	'Categories',
);

$this->menu=array(
	array('label'=>'Manage Workshop','url'=>array('/workshop/workshop/admin')),
	array('label'=>'Manage Facilitator','url'=>array('/workshop/workshopFacilitator/admin')),
    array('label'=>'Planned Workshops'),
    array('label'=>'Manage','url'=>array('/workshop/workshopPlanned/admin')),
    array('label'=>'New','url'=>array('/workshop/workshopPlanned/create')),
);

?>

<h1>Manage Workshop Categories</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'workshop-cat-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'workshop_cat_id',
		array(
			'class' => 'bootstrap.widgets.TbEditableColumn',
			'name' => 'workshop_cat_name',
			'sortable'=>true,
			'editable' => array(
				'url' => $this->createUrl('update'),
				'placement' => 'bottom',
				//'inputclass' => 'span3'
			)
		),
		array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'template'=>'{delete}',
		),
	),
)); ?>

<?php $this->renderPartial('_form', array('model'=>$createModel)); ?>
