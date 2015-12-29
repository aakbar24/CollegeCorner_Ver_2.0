<?php
$this->breadcrumbs=array(
    'Planned Workshops',
    'Create',
);

$this->menu=array(
    array('label'=>'Manage Workshops','url'=>array('/workshop/workshop/admin')),
    array('label'=>'Manage Category','url'=>array('/workshop/workshopCat/admin')),
    array('label'=>'Manage Facilitator','url'=>array('/workshop/workshopFacilitator/admin')),
    array('label'=>'Planned Workshops'),
    array('label'=>'Manage','url'=>array('/workshop/workshopPlanned/admin')),
    //array('label'=>'New Planned Workshop','url'=>array('/workshop/workshopPlanned/create')),
);
?>

<h1>Create Planned Workshop</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>