<?php
$this->breadcrumbs=array(
	'Workshops',
);

$this->menu=array(
	array('label'=>'Create Workshop','url'=>array('create')),
	array('label'=>'Manage Workshop','url'=>array('admin')),
	array('label'=>'Manage Category','url'=>array('/workshop/workshopCat/admin')),
	array('label'=>'Manage Facilitator','url'=>array('/workshop/workshopFacilitator/admin')),
    array('label'=>'Planned Workshops'),
    array('label'=>'Manage','url'=>array('/workshop/workshopPlanned/admin')),
    array('label'=>'New','url'=>array('/workshop/workshopPlanned/create')),
);
?>

<h1>Workshops</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
