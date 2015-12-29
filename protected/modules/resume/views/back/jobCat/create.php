<?php
$this->breadcrumbs=array(
	'Job Cats'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List JobCat','url'=>array('index')),
	array('label'=>'Manage JobCat','url'=>array('admin')),
);
?>

<h1>Create JobCat</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>