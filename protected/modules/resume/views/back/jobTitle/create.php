<?php
$this->breadcrumbs=array(
	'Job Titles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List JobTitle','url'=>array('index')),
	array('label'=>'Manage JobTitle','url'=>array('admin')),
);
?>

<h1>Create JobTitle</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>