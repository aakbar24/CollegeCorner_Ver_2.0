<?php
$this->breadcrumbs=array(
	'Certifications'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Certification','url'=>array('index')),
	array('label'=>'Manage Certification','url'=>array('admin')),
);
?>

<h1>Create Certification</h1>

<?php echo $this->renderPartial('certificate.views.common.certification._form', array('model'=>$model)); ?>