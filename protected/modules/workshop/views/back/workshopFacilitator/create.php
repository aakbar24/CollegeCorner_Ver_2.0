<?php
$this->breadcrumbs=array(
	'Workshop'=>array('/workshop/workshop/admin'),
	'Facilitators'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Facilitator','url'=>array('admin')),
	array('label'=>'Manage Workshop','url'=>array('/workshop/workshop/admin')),
	array('label'=>'Manage Category','url'=>array('/workshop/workshopCat/admin')),
    array('label'=>'Planned Workshops'),
    array('label'=>'Manage','url'=>array('/workshop/workshopPlanned/admin')),
    array('label'=>'New','url'=>array('/workshop/workshopPlanned/create')),
);
?>

<h1>Create Facilitator</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>