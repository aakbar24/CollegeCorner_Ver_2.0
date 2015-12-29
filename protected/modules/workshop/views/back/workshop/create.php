<?php
$this->breadcrumbs=array(
	'Workshops'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Workshop','url'=>array('index')),
	array('label'=>'Manage Workshop','url'=>array('admin')),
	array('label'=>'Manage Category','url'=>array('/workshop/workshopCat/admin')),
	array('label'=>'Manage Facilitator','url'=>array('/workshop/workshopFacilitator/admin')),
    array('label'=>'Planned Workshops'),
    array('label'=>'Manage','url'=>array('/workshop/workshopPlanned/admin')),
    array('label'=>'New','url'=>array('/workshop/workshopPlanned/create')),
);
?>

<h1>Create Workshop</h1>

<?php echo $this->renderPartial('workshop.views.common.workshop._form', array('model'=>$model)); ?>
