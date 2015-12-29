<?php
$this->breadcrumbs=array(
	'Workshop'=>array('/workshop/workshop/admin'),
	'Facilitators',
);

$this->menu=array(
	array('label'=>'Create Facilitator','url'=>array('create')),
	array('label'=>'Manage Workshop','url'=>array('/workshop/workshop/admin')),
	array('label'=>'Manage Category','url'=>array('/workshop/workshopCat/admin')),
    array('label'=>'Planned Workshops'),
    array('label'=>'Manage','url'=>array('/workshop/workshopPlanned/admin')),
    array('label'=>'New','url'=>array('/workshop/workshopPlanned/create')),
);

?>

<h1>Manage Workshop Facilitators</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'workshop-facilitator-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'workshop_facilitator_id',
		'first_name',
		'last_name',
		array(
				'name'=>'is_active',
				'class'=>'bootstrap.widgets.TbToggleColumn',
				'toggleAction'=>'toggleActive',
				'filter'=>array('1'=>'Yes','0'=>'No'),
				//'value'=>'Yii::app()->format->formatBoolean($data->isActive)',
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view} {update}'
		),
	),
)); ?>